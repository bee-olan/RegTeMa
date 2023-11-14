<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\DrevMatkas\Redaktors;

use App\Annotation\Guid;

//use  App\Model\Adminka\UseCase\Matkas\DrevMatka\Edit;
use App\Model\Adminka\UseCase\DrevMatkas\DrevMatka\Archive;
use App\Model\Adminka\UseCase\DrevMatkas\DrevMatka\Reinstate;

use App\Model\Adminka\Entity\DrevMatkas\DrevMatka;
use App\ReadModel\Adminka\DrevMatkas\CommentDrevFetcher;
use App\ReadModel\Adminka\Matkas\ChildMatka\CommentFetcher;
use App\Model\Comment\UseCase\Comment;
//use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatka;

//use App\Security\Voter\Adminka\Matkas\PlemMatkaAccess;
use App\Controller\ErrorHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/proekts/pasekas/drevmatkas/{plemmatka_id}/redaktors", name="app.proekts.pasekas.drevmatkas.redaktors")
 * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
 */
class RedaktorController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("/show", name=".show", requirements={"id"=Guid::PATTERN})
     * @param Request $request
     * @param DrevMatka $plemmatka
     * @param CommentDrevFetcher $comments
     * @param Comment\AddSezon\Handler $commentHandler
     * @return Response
     */
    public function show(Request $request,
                         DrevMatka $plemmatka,
                         CommentDrevFetcher $comments,
                         Comment\AddSezon\Handler $commentHandler
    ): Response
    {

        $commentCommand = new Comment\AddSezon\Command(
            $this->getUser()->getId(),
            DrevMatka::class,
            $plemmatka->getId()->getValue()
        );

        $commentForm = $this->createForm(Comment\AddSezon\Form::class, $commentCommand);
//        dd("stop");
        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            try {
                $commentHandler->handle($commentCommand);
                return $this->redirectToRoute('app.proekts.pasekas.drevmatkas.redaktors.show', ['plemmatka_id' => $plemmatka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }
//        dd($comments->allForDrevMatka($plemmatka->getId()->getValue()));

        return $this->render('app/proekts/pasekas/drevmatkas/redaktors/show.html.twig', [
            'plemmatka' => $plemmatka,
            'uchastniks' => $plemmatka->getUchasdrevs(),
            'comments' => $comments->allForDrevMatka($plemmatka->getId()->getValue()),
            'commentForm' => $commentForm->createView(),

        ]);
    }

//    /**
//     * @Route("/edit", name=".edit")
//     * @param DrevMatka $plemmatka
//     * @param Request $request
//     * @param Edit\Handler $handler
//     * @return Response
//     */
//    public function edit(DrevMatka $plemmatka, Request $request, Edit\Handler $handler): Response
//    {
////        $this->denyAccessUnlessGranted(PlemMatkaAccess::EDIT, $plemmatka);
//
//        $command = Edit\Command::fromPlemMatka($plemmatka);
//
//        $form = $this->createForm(Edit\Form::class, $command);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            try {
//                $handler->handle($command);
//                return $this->redirectToRoute('app.proekts.pasekas.matkas.plemmatkas.redaktorss.show', ['plemmatka_id' => $plemmatka->getId()]);
//            } catch (\DomainException $e) {
//                $this->errors->handle($e);
//                $this->addFlash('error', $e->getMessage());
//            }
//        }
//
//        return $this->render('app/proekts/pasekas/matkas/plemmatkas/redaktorss/edit.html.twig', [
//            'plemmatka' => $plemmatka,
//            'form' => $form->createView(),
//        ]);
//    }

    /**
     * @Route("/archive", name=".archive", methods={"POST"})
     * @param DrevMatka $plemmatka
     * @param Request $request
     * @param Archive\Handler $handler
     * @return Response
     */
    public function archive(DrevMatka $plemmatka, Request $request, Archive\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('archive', $request->request->get('token'))) {
            return $this->redirectToRoute('app.proekts.pasekas.drevmatkas.redaktors.show', ['id' => $plemmatka->getId()]);
        }

//         $this->denyAccessUnlessGranted(DrevMatkaAccess::EDIT, plemmatka);

        $command = new Archive\Command($plemmatka->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('app.proekts.pasekas.drevmatkas.redaktors.show', ['plemmatka_id' => $plemmatka->getId()]);
    }

    /**
     * @Route("/reinstate", name=".reinstate", methods={"POST"})
     * @param DrevMatka $plemmatka
     * @param Request $request
     * @param Reinstate\Handler $handler
     * @return Response
     */
    public function reinstate(DrevMatka $plemmatka, Request $request, Reinstate\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('reinstate', $request->request->get('token'))) {
            return $this->redirectToRoute('app.proekts.pasekas.drevmatkas.redaktors.show', ['plemmatka_id' => $plemmatka->getId()]);
        }

//        $this->denyAccessUnlessGranted(DrevMatkaAccess::EDIT, $plemmatka);

        $command = new Reinstate\Command($plemmatka->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('app.proekts.pasekas.drevmatkas.redaktors.show', ['plemmatka_id' => $plemmatka->getId()]);
    }


}