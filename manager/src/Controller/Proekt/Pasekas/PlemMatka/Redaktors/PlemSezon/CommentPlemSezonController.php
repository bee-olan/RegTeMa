<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\PlemMatka\Redaktors\PlemSezon;

use App\Controller\ErrorHandler;
use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatka;
use App\Model\Comment\Entity\Comment\Comment;
use App\Model\Comment\UseCase\Comment\Edit;
use App\Model\Comment\UseCase\Comment\Remove;


use App\Security\Voter\Comment\CommentAccess;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/proekt/pasekas/matkas/plemmatkas/redaktorss/{plemmatka_id}/comment", name="proekt.pasekas.matkas.plemmatkas.redaktorss.comment")
 * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
 */
class CommentPlemSezonController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("/{id}/edit", name=".edit")
     * @param PlemMatka $plemmatka
     * @param Comment $comment
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(Request $request, Comment $comment, PlemMatka $plemmatka, Edit\Handler $handler): Response
    {
//       dd($plemmatka->getOblasts());
//        dd($oblast->getPlemMatka()->getName());
//        $this->denyAccessUnlessGranted(OblastAccess::VIEW, $oblast);
        $this->checkCommentIsForPlem($plemmatka, $comment);
        $this->denyAccessUnlessGranted(CommentAccess::MANAGE, $comment);

        $command = Edit\Command::fromComment($comment);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('proekt.pasekas.matkas.plemmatkas.redaktorss.show', ['plemmatka_id' => $plemmatka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('proekt/pasekas/matkas/plemmatkas/redaktorss/comment/edit.html.twig', [
            'plemmatka' => $plemmatka,
//            'oblast' => $plemmatka->getOblasts(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name=".delete", methods={"POST"})
     * @param PlemMatka $plemmatka
     * @param Comment $comment
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(PlemMatka $plemmatka, Comment $comment, Request $request, Remove\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('delete-comment', $request->request->get('token'))) {
            return $this->redirectToRoute('proekt.pasekas.matkas.plemmatkas.redaktorss.show', ['plemmatka_id' => $plemmatka->getId()]);
        }

//        $this->denyAccessUnlessGranted(OblastAccess::VIEW, $oblast);
        $this->checkCommentIsForPlem($plemmatka, $comment);
        $this->denyAccessUnlessGranted(CommentAccess::MANAGE, $comment);

        $command = new Remove\Command($comment->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('proekt.pasekas.matkas.plemmatkas.redaktorss', ['plemmatka_id' => $plemmatka->getId()]);
    }

    private function checkCommentIsForPlem(PlemMatka $plemmatka, Comment $comment): void
    {
        if (!(
            $comment->getEntity()->getType() === PlemMatka::class &&
            $comment->getEntity()->getId() === $plemmatka->getId()->getValue()
        )) {
            throw $this->createNotFoundException();
        }
    }
}
