<?php

declare(strict_types=1);

namespace App\Controller\Matkis\U4astniks;

use App\Annotation\Guid;
use App\Model\User\Entity\User\User;
use App\Model\Matkis\Entity\U4astniks\U4astnik\U4astnik;
use App\Model\Matkis\UseCase\U4astniks\U4astnik\Archive;
use App\Model\Matkis\UseCase\U4astniks\U4astnik\Edit;
use App\Model\Matkis\UseCase\U4astniks\U4astnik\Reinstate;
use App\Model\Matkis\UseCase\U4astniks\U4astnik\Create;
use App\Model\Matkis\UseCase\U4astniks\U4astnik\Move;
use App\ReadModel\Matkis\U4astniks\U4astnik\Filter;
use App\ReadModel\Matkis\U4astniks\U4astnik\U4astnikFetcher;
use App\ReadModel\Matkis\Projects\Project\DepartmentFetcher;
use App\Controller\ErrorHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/matkis/u4astniks", name="matkis.u4astniks")
 * @IsGranted("ROLE_WORK_MANAGE_MEMBERS")
 */
class U4astniksController extends AbstractController
{
    private const PER_PAGE = 20;

    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("", name="")
     * @param Request $request
     * @param U4astnikFetcher $fetcher
     * @return Response
     */
    public function index(Request $request, U4astnikFetcher $fetcher): Response
    {
        $filter = new Filter\Filter();

        $form = $this->createForm(Filter\Form::class, $filter);
        $form->handleRequest($request);

        $pagination = $fetcher->all(
            $filter,
            $request->query->getInt('page', 1),
            self::PER_PAGE,
            $request->query->get('sort', 'name'),
            $request->query->get('direction', 'asc')
        );

        return $this->render('app/matkis/u4astniks/index.html.twig', [
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/create/{id}", name=".create")
     * @param User $user
     * @param Request $request
     * @param U4astnikFetcher $u4astniks
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(User $user, Request $request, U4astnikFetcher $u4astniks, Create\Handler $handler): Response
    {
        if ($u4astniks->exists($user->getId()->getValue())) {
            $this->addFlash('error', 'U4astnik already exists.');
            return $this->redirectToRoute('users.show', ['id' => $user->getId()]);
        }

        $command = new Create\Command($user->getId()->getValue());
        $command->firstName = $user->getName()->getFirst();
        $command->lastName = $user->getName()->getLast();
        $command->email = $user->getEmail() ? $user->getEmail()->getValue() : null;

        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('matkis.u4astniks.show', ['id' => $user->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/matkis/u4astniks/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name=".edit")
     * @param U4astnik $u4astnik
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(  Request $request, Edit\Handler $handler): Response
    {
        // $command = Edit\Command::fromU4astnik($u4astnik);

        // $form = $this->createForm(Edit\Form::class, $command);
        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     try {
        //         $handler->handle($command);
        //         // return $this->redirectToRoute('matkis.u4astniks.show', ['id' => $u4astnik->getId()]);
        //         return $this->redirectToRoute('matkis.u4astniks');
        //     } catch (\DomainException $e) {
        //         $this->errors->handle($e);
        //         $this->addFlash('error', $e->getMessage());
        //     }
        // }

        return $this->render('app/matkis/u4astniks/edit.html.twig', [
            // 'u4astnik' => $u4astnik,
            // 'form' => $form->createView(),
        ]);
    }

    // /**
    //  * @Route("/{id}/move", name=".move")
    //  * @param U4astnik $u4astnik
    //  * @param Request $request
    //  * @param Move\Handler $handler
    //  * @return Response
    //  */
    // public function move(U4astnik $u4astnik, Request $request, Move\Handler $handler): Response
    // {
    //     $command = Move\Command::fromU4astnik($u4astnik);

    //     $form = $this->createForm(Move\Form::class, $command);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         try {
    //             $handler->handle($command);
    //             return $this->redirectToRoute('matkis.u4astniks.show', ['id' => $u4astnik->getId()]);
    //         } catch (\DomainException $e) {
    //             $this->errors->handle($e);
    //             $this->addFlash('error', $e->getMessage());
    //         }
    //     }

    //     return $this->render('app/matkis/u4astniks/move.html.twig', [
    //         'u4astnik' => $u4astnik,
    //         'form' => $form->createView(),
    //     ]);
    // }

    // /**
    //  * @Route("/{id}/archive", name=".archive", methods={"POST"})
    //  * @param U4astnik $u4astnik
    //  * @param Request $request
    //  * @param Archive\Handler $handler
    //  * @return Response
    //  */
    // public function archive(U4astnik $u4astnik, Request $request, Archive\Handler $handler): Response
    // {
    //     if (!$this->isCsrfTokenValid('archive', $request->request->get('token'))) {
    //         return $this->redirectToRoute('matkis.u4astniks.show', ['id' => $u4astnik->getId()]);
    //     }

    //     $command = new Archive\Command($u4astnik->getId()->getValue());

    //     try {
    //         $handler->handle($command);
    //     } catch (\DomainException $e) {
    //         $this->errors->handle($e);
    //         $this->addFlash('error', $e->getMessage());
    //     }

    //     return $this->redirectToRoute('matkis.u4astniks.show', ['id' => $u4astnik->getId()]);
    // }

    // /**
    //  * @Route("/{id}/reinstate", name=".reinstate", methods={"POST"})
    //  * @param U4astnik $u4astnik
    //  * @param Request $request
    //  * @param Reinstate\Handler $handler
    //  * @return Response
    //  */
    // public function reinstate(U4astnik $u4astnik, Request $request, Reinstate\Handler $handler): Response
    // {
    //     if (!$this->isCsrfTokenValid('reinstate', $request->request->get('token'))) {
    //         return $this->redirectToRoute('matkis.u4astniks.show', ['id' => $u4astnik->getId()]);
    //     }

    //     if ($u4astnik->getId()->getValue() === $this->getUser()->getId()) {
    //         $this->addFlash('error', 'Unable to reinstate yourself.');
    //         return $this->redirectToRoute('matkis.u4astniks.show', ['id' => $u4astnik->getId()]);
    //     }

    //     $command = new Reinstate\Command($u4astnik->getId()->getValue());

    //     try {
    //         $handler->handle($command);
    //     } catch (\DomainException $e) {
    //         $this->errors->handle($e);
    //         $this->addFlash('error', $e->getMessage());
    //     }

    //     return $this->redirectToRoute('matkis.u4astniks.show', ['id' => $u4astnik->getId()]);
    // }

    // /**
    //  * @Route("/{id}", name=".show", requirements={"id"=Guid::PATTERN})
    //  * @param U4astnik $u4astnik
    //  * @param DepartmentFetcher $fetcher
    //  * @return Response
    //  */
    // public function show(U4astnik $u4astnik, DepartmentFetcher $fetcher): Response
    // {
    //     $departments = $fetcher->allOfMember($u4astnik->getId()->getValue());

    //     return $this->render('app/matkis/u4astniks/show.html.twig', compact('u4astnik', 'departments'));
    // }


    // /**
    //  * @Route("/{id}", name=".show", requirements={"id"=Guid::PATTERN})
    //  * @param U4astnik $u4astnik
    //  * @return Response
    //  */
    // public function show(U4astnik $u4astnik): Response
    // {
    //     // $departments = $fetcher->allOfMember($u4astnik->getId()->getValue());

    //     return $this->render('app/matkis/u4astniks/show.html.twig', compact('u4astnik'));
    // }
}
