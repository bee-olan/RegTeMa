<?php

declare(strict_types=1);

namespace App\Controller\Paseka\Pchelowods;

use App\Annotation\Guid;
use App\Model\User\Entity\User\User;
use App\Model\Paseka\Entity\Pchelowods\Pchelowod\Pchelowod;
use App\Model\Paseka\UseCase\Pchelowods\Pchelowod\Archive;
use App\Model\Paseka\UseCase\Pchelowods\Pchelowod\Edit;
use App\Model\Paseka\UseCase\Pchelowods\Pchelowod\Reinstate;
use App\Model\Paseka\UseCase\Pchelowods\Pchelowod\Create;
use App\Model\Paseka\UseCase\Pchelowods\Pchelowod\Move;
use App\ReadModel\Paseka\Pchelowods\Pchelowod\Filter;
use App\ReadModel\Paseka\Pchelowods\Pchelowod\PchelowodFetcher;
use App\ReadModel\Paseka\Projects\Project\DepartmentFetcher;
use App\Controller\ErrorHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/paseka/pchelowods", name="paseka.pchelowods")
 * @IsGranted("ROLE_WORK_MANAGE_MEMBERS")
 */
class PchelowodsController extends AbstractController
{
    // private const PER_PAGE = 20;

    // private $errors;

    // public function __construct(ErrorHandler $errors)
    // {
    //     $this->errors = $errors;
    // }

    // /**
    //  * @Route("", name="")
    //  * @param Request $request
    //  * @param PchelowodFetcher $fetcher
    //  * @return Response
    //  */
    // public function index(Request $request, PchelowodFetcher $fetcher): Response
    // {
    //     $filter = new Filter\Filter();

    //     $form = $this->createForm(Filter\Form::class, $filter);
    //     $form->handleRequest($request);

    //     $pagination = $fetcher->all(
    //         $filter,
    //         $request->query->getInt('page', 1),
    //         self::PER_PAGE,
    //         $request->query->get('sort', 'name'),
    //         $request->query->get('direction', 'asc')
    //     );

    //     return $this->render('app/paseka/pchelowods/index.html.twig', [
    //         'pagination' => $pagination,
    //         'form' => $form->createView(),
    //     ]);
    // }

    // /**
    //  * @Route("/create/{id}", name=".create")
    //  * @param User $user
    //  * @param Request $request
    //  * @param PchelowodFetcher $pchelowods
    //  * @param Create\Handler $handler
    //  * @return Response
    //  */
    // public function create(User $user, Request $request, PchelowodFetcher $pchelowods, Create\Handler $handler): Response
    // {
    //     if ($pchelowods->exists($user->getId()->getValue())) {
    //         $this->addFlash('error', 'Pchelowod already exists.');
    //         return $this->redirectToRoute('users.show', ['id' => $user->getId()]);
    //     }

    //     $command = new Create\Command($user->getId()->getValue());
    //     $command->firstName = $user->getName()->getFirst();
    //     $command->lastName = $user->getName()->getLast();
    //     $command->email = $user->getEmail() ? $user->getEmail()->getValue() : null;

    //     $form = $this->createForm(Create\Form::class, $command);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         try {
    //             $handler->handle($command);
    //             return $this->redirectToRoute('paseka.pchelowods.show', ['id' => $user->getId()]);
    //         } catch (\DomainException $e) {
    //             $this->errors->handle($e);
    //             $this->addFlash('error', $e->getMessage());
    //         }
    //     }

    //     return $this->render('app/paseka/pchelowods/create.html.twig', [
    //         'form' => $form->createView(),
    //     ]);
    // }

    // /**
    //  * @Route("/{id}/edit", name=".edit")
    //  * @param Pchelowod $pchelowod
    //  * @param Request $request
    //  * @param Edit\Handler $handler
    //  * @return Response
    //  */
    // public function edit(Pchelowod $pchelowod, Request $request, Edit\Handler $handler): Response
    // {
    //     $command = Edit\Command::fromMember($pchelowod);

    //     $form = $this->createForm(Edit\Form::class, $command);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         try {
    //             $handler->handle($command);
    //             return $this->redirectToRoute('paseka.pchelowods.show', ['id' => $pchelowod->getId()]);
    //         } catch (\DomainException $e) {
    //             $this->errors->handle($e);
    //             $this->addFlash('error', $e->getMessage());
    //         }
    //     }

    //     return $this->render('app/paseka/pchelowods/edit.html.twig', [
    //         'pchelowod' => $pchelowod,
    //         'form' => $form->createView(),
    //     ]);
    // }

    // /**
    //  * @Route("/{id}/move", name=".move")
    //  * @param Pchelowod $pchelowod
    //  * @param Request $request
    //  * @param Move\Handler $handler
    //  * @return Response
    //  */
    // public function move(Pchelowod $pchelowod, Request $request, Move\Handler $handler): Response
    // {
    //     $command = Move\Command::fromMember($pchelowod);

    //     $form = $this->createForm(Move\Form::class, $command);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         try {
    //             $handler->handle($command);
    //             return $this->redirectToRoute('paseka.pchelowods.show', ['id' => $pchelowod->getId()]);
    //         } catch (\DomainException $e) {
    //             $this->errors->handle($e);
    //             $this->addFlash('error', $e->getMessage());
    //         }
    //     }

    //     return $this->render('app/paseka/pchelowods/move.html.twig', [
    //         'pchelowod' => $pchelowod,
    //         'form' => $form->createView(),
    //     ]);
    // }

    // /**
    //  * @Route("/{id}/archive", name=".archive", methods={"POST"})
    //  * @param Pchelowod $pchelowod
    //  * @param Request $request
    //  * @param Archive\Handler $handler
    //  * @return Response
    //  */
    // public function archive(Pchelowod $pchelowod, Request $request, Archive\Handler $handler): Response
    // {
    //     if (!$this->isCsrfTokenValid('archive', $request->request->get('token'))) {
    //         return $this->redirectToRoute('paseka.pchelowods.show', ['id' => $pchelowod->getId()]);
    //     }

    //     $command = new Archive\Command($pchelowod->getId()->getValue());

    //     try {
    //         $handler->handle($command);
    //     } catch (\DomainException $e) {
    //         $this->errors->handle($e);
    //         $this->addFlash('error', $e->getMessage());
    //     }

    //     return $this->redirectToRoute('paseka.pchelowods.show', ['id' => $pchelowod->getId()]);
    // }

    // /**
    //  * @Route("/{id}/reinstate", name=".reinstate", methods={"POST"})
    //  * @param Pchelowod $pchelowod
    //  * @param Request $request
    //  * @param Reinstate\Handler $handler
    //  * @return Response
    //  */
    // public function reinstate(Pchelowod $pchelowod, Request $request, Reinstate\Handler $handler): Response
    // {
    //     if (!$this->isCsrfTokenValid('reinstate', $request->request->get('token'))) {
    //         return $this->redirectToRoute('paseka.pchelowods.show', ['id' => $pchelowod->getId()]);
    //     }

    //     if ($pchelowod->getId()->getValue() === $this->getUser()->getId()) {
    //         $this->addFlash('error', 'Unable to reinstate yourself.');
    //         return $this->redirectToRoute('paseka.pchelowods.show', ['id' => $pchelowod->getId()]);
    //     }

    //     $command = new Reinstate\Command($pchelowod->getId()->getValue());

    //     try {
    //         $handler->handle($command);
    //     } catch (\DomainException $e) {
    //         $this->errors->handle($e);
    //         $this->addFlash('error', $e->getMessage());
    //     }

    //     return $this->redirectToRoute('paseka.pchelowods.show', ['id' => $pchelowod->getId()]);
    // }

    // /**
    //  * @Route("/{id}", name=".show", requirements={"id"=Guid::PATTERN})
    //  * @param Pchelowod $pchelowod
    //  * @param DepartmentFetcher $fetcher
    //  * @return Response
    //  */
    // public function show(Pchelowod $pchelowod, DepartmentFetcher $fetcher): Response
    // {
    //     $departments = $fetcher->allOfMember($pchelowod->getId()->getValue());

    //     return $this->render('app/paseka/pchelowods/show.html.twig', compact('pchelowod', 'departments'));
    // }
}
