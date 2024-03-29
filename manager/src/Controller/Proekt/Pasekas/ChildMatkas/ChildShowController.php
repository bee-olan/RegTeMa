<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\ChildMatkas;

use App\Model\Comment\UseCase\Comment;

use App\Model\Adminka\UseCase\Matkas\ChildMatka\Executor;
use App\Model\Adminka\UseCase\Matkas\ChildMatka\Plan;
use App\Model\Adminka\UseCase\Matkas\ChildMatka\Priority;
use App\Model\Adminka\UseCase\Matkas\ChildMatka\Status;
use App\Model\Adminka\UseCase\Matkas\ChildMatka\Type;
use App\Model\Adminka\Entity\Matkas\ChildMatka\ChildMatka;
use App\ReadModel\Adminka\Matkas\Actions\ActionFetcher;
use App\ReadModel\Adminka\Matkas\ChildMatka\ChildMatkaFetcher;
use App\ReadModel\Adminka\Matkas\ChildMatka\CommentFetcher;
use App\ReadModel\Adminka\Matkas\PlemMatka\DepartmentFetcher;
use App\ReadModel\Adminka\Uchasties\Uchastie\UchastieFetcher;

use App\Controller\ErrorHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("proekt/pasekas/childmatkas", name="proekt.pasekas.childmatkas")
 * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
 */
class ChildShowController extends AbstractController
{
    private const PER_PAGE = 50;

    private $errors;

    public function __construct( ErrorHandler $errors)
    {
        $this->errors = $errors;
    }


    /**
     * @Route("/{id}", name=".show", requirements={"id"="\d+"}))
     * @param ChildMatka $childmatka
     * @param Request $request
     * @param UchastieFetcher $uchasties
     * @param ChildMatkaFetcher $childmatkas
     * @param CommentFetcher $comments
     * @param ActionFetcher $actions,
     * @param DepartmentFetcher $departmentFetchers,
     * @param Status\Handler $statusHandler
     * @param Type\Handler $typeHandler
     * @param Priority\Handler $priorityHandler
     * @param Comment\Create\Handler $commentHandler
     * @return Response
     */
    public function show(
        ChildMatka $childmatka,
        Request $request,
        UchastieFetcher $uchasties,
        ChildMatkaFetcher $childmatkas,
        CommentFetcher $comments,
        ActionFetcher $actions,
        DepartmentFetcher $departmentFetchers,
        Status\Handler $statusHandler,
        Type\Handler $typeHandler,
        Priority\Handler $priorityHandler,
        Comment\Create\Handler $commentHandler
    ): Response
    {
      //  $this->denyAccessUnlessGranted(TaskAccess::VIEW, $task);

        if (!$uchastie = $uchasties->find($this->getUser()->getId())) {
            throw $this->createAccessDeniedException();
        }
        $departmentFetcher = $departmentFetchers->listOfPlemMatka($childmatka->getPlemMatka()->getId()->getValue());


        $statusCommand = Status\Command::fromChildMatka($this->getUser()->getId(), $childmatka);
        $statusForm = $this->createForm(Status\Form::class, $statusCommand);
        $statusForm->handleRequest($request);
        if ($statusForm->isSubmitted() && $statusForm->isValid()) {
            try {
                $statusHandler->handle($statusCommand);
                return $this->redirectToRoute('proekt.pasekas.childmatkas.show', ['id' => $childmatka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }


        $typeCommand = Type\Command::fromChildMatka($this->getUser()->getId(), $childmatka);
        $typeForm = $this->createForm(Type\Form::class, $typeCommand);
        $typeForm->handleRequest($request);
        if ($typeForm->isSubmitted() && $typeForm->isValid()) {
            try {
                $typeHandler->handle($typeCommand);
                return $this->redirectToRoute('proekt.pasekas.childmatkas.show',
                                                    ['id' => $childmatka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        $priorityCommand = Priority\Command::fromChildMatka($this->getUser()->getId(), $childmatka);
        $priorityForm = $this->createForm(Priority\Form::class, $priorityCommand);
        $priorityForm->handleRequest($request);
        if ($priorityForm->isSubmitted() && $priorityForm->isValid()) {
            try {
                $priorityHandler->handle($priorityCommand);
                return $this->redirectToRoute('proekt.pasekas.childmatkas.show', ['id' => $childmatka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        $commentCommand = new Comment\Create\Command(
            $this->getUser()->getId(),
            ChildMatka::class,
            (string)$childmatka->getId()->getValue()
        );

        $commentForm = $this->createForm(Comment\Create\Form::class, $commentCommand);
        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            try {
                $commentHandler->handle($commentCommand);
                return $this->redirectToRoute('proekt.pasekas.childmatkas.show', ['id' => $childmatka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }
// dd($childmatkas->childrenOf($childmatka->getId()->getValue()));
        return $this->render('proekt/pasekas/childmatkas/show.html.twig', [
            'plemmatka' => $childmatka->getPlemMatka(),
            'korotkoName' => $childmatka->getPlemMatka()->getKorotkoName() ,
            'childmatka' => $childmatka,
            'uchastie' => $uchastie,
            'children' => $childmatkas->childrenOf($childmatka->getId()->getValue()),
            'comments' => $comments->allForChildMatka($childmatka->getId()->getValue()),
            'actions' => $actions->allForChildMatka($childmatka->getId()->getValue()),
            'statusForm' => $statusForm->createView(),
            'typeForm' => $typeForm->createView(),
            'priorityForm' => $priorityForm->createView(),
            'commentForm' => $commentForm->createView(),
            'departId' => $childmatka->idDepart($departmentFetcher)
        ]);
    }

}
