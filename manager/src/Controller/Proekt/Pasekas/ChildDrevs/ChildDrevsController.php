<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\ChildDrevs;

use App\Model\Adminka\Entity\DrevMatkas\ChildDrevs\ChildDrev;
use App\Model\Adminka\UseCase\DrevMatkas\ChildDrev\Edit;
use App\Model\Adminka\UseCase\DrevMatkas\ChildDrev\Executor;

use App\Model\Adminka\UseCase\DrevMatkas\ChildDrev\Plan;

use App\ReadModel\Proekt\Pasekas\ChildDrev\Side\Filter;
use App\ReadModel\Proekt\Pasekas\ChildMatka\Side\ChildSideFetcher;

use App\Controller\ErrorHandler;
use App\Security\Voter\Adminka\Matkas\ChildMatkaAccess;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("app/proekts/pasekas/childdrevs", name="app.proekts.pasekas.childdrevs")
 * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
 */
class ChildDrevsController extends AbstractController
{
    private const PER_PAGE = 50;

    private $errors;

    public function __construct( ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("", name="")
     * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
     * @param Request $request
     * @param ChildSideFetcher $childmatkas
     * @return Response
     */
    public function index(Request $request, ChildSideFetcher $childmatkas): Response
    {


         if ($this->isGranted('ROLE_ADMINKA_MANAGE_PLEMMATKAS')) {
             $filter = Filter\Filter::alll();
         } else {
            $filter = Filter\Filter::alll()->forUchastie($this->getUser()->getId());
        }

        $form = $this->createForm(Filter\Form::class, $filter);
        $form->handleRequest($request);

        $pagination = $childmatkas->alll(
            $filter,
            $request->query->getInt('page', 1),
            self::PER_PAGE,
            $request->query->get('sort'),
            $request->query->get('direction')
        );

        return $this->render('app/proekts/pasekas/childdrevs/index.html.twig', [
            'proba' => 'проба',
            'plemmatka' => null,
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }

//    /**
//     * @Route("/create", name=".create")
//     * @param PlemMatka $plemmatka
//     * @param PlemSideFetcher $plemSideFetcher
//     * @param Request $request
//     * @param Create\Handler $handler
//     * @return Response
//     */
//    public function create( PlemMatka $plemmatka, Request $request, Create\Handler $handler): Response
//    {
////        $this->denyAccessUnlessGranted(ChildMatkaAccess::MANAGE, $childmatka);
//
//
//        $command = new Create\Command(
//            $plemmatka->getId()->getValue(),
//            $this->getUser()->getId()
//        );
//
//        if ($parent = $request->query->get('parent')) {
//            $command->parent = $parent;
//        }
//        $command->name = "hhh";
//        $form = $this->createForm(Create\Form::class, $command);
//        $form->handleRequest($request);
////dd($plemmatka);
//        if ($form->isSubmitted() && $form->isValid()) {
//            try {
//                $handler->handle($command);
//                return $this->redirectToRoute('proekt.pasekas.childdrevs');
//            } catch (\DomainException $e) {
//                $this->errors->handle($e);
//                $this->addFlash('error', $e->getMessage());
//            }
//        }
//
//        return $this->render('proekt/pasekas/childdrevs/create.html.twig', [
//            'plemmatka' => $plemmatka,
//            'form' => $form->createView(),
//        ]);
//    }

    /**
     * @Route("/{id}/edit", name=".edit")
     * @param ChildDrev $childmatka
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(ChildDrev $childmatka, Request $request, Edit\Handler $handler): Response
    {
//        $this->denyAccessUnlessGranted(ChildDrevAccess::MANAGE, $childmatka);

        $command = Edit\Command::fromChildDrev($this->getUser()->getId(), $childmatka);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('app.proekts.pasekas.childdrevs.show', ['id' => $childmatka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/proekt/pasekas/childdrevs/edit.html.twig', [
            'plemmatka' => $childmatka->getPlemMatka(),
            'childmatka' => $childmatka,
            'form' => $form->createView(),
        ]);
    }

//   /**
//     * @Route("/{id}/move", name=".move")
//     * @param ChildDrev $childmatka
//     * @param Request $request
//     * @param Move\Handler $handler
//     * @return Response
//     */
//    public function move(ChildDrev $childmatka, Request $request, Move\Handler $handler): Response
//    {
//        // $this->denyAccessUnlessGranted(ChildDrevAccess::MANAGE, $childmatka);
//
//        $command = Move\Command::fromChildDrev($this->getUser()->getId(), $childmatka);
//
//        $form = $this->createForm(Move\Form::class, $command);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            try {
//                $handler->handle($command);
//                return $this->redirectToRoute('proekt.pasekas.childdrevs.show', ['id' => $childmatka->getId()]);
//            } catch (\DomainException $e) {
//                $this->errors->handle($e);
//                $this->addFlash('error', $e->getMessage());
//            }
//        }
//
//        return $this->render('proekt/pasekas/childdrevs/move.html.twig', [
//            'plemmatka' => $childmatka->getPlemMatka(),
//            'childmatka' => $childmatka,
//            'form' => $form->createView(),
//        ]);
//    }


}


