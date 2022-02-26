<?php

declare(strict_types=1);

namespace App\Controller\Paseka\Pchelowods;

use App\Model\Paseka\Entity\Pchelowods\Group\Group;
use App\Model\Paseka\UseCase\Pchelowods\Group\Create;
use App\Model\Paseka\UseCase\Pchelowods\Group\Edit;
use App\Model\Paseka\UseCase\Pchelowods\Group\Remove;
use App\ReadModel\Paseka\Pchelowods\GroupFetcher;
use App\Controller\ErrorHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/paseka/pchelowods/groups", name="paseka.pchelowods.groups")
 * @IsGranted("ROLE_WORK_MANAGE_MEMBERS")
 */
class GroupsController extends AbstractController
{
    // private $errors;

    // public function __construct(ErrorHandler $errors)
    // {
    //     $this->errors = $errors;
    // }

    // /**
    //  * @Route("", name="")
    //  * @param GroupFetcher $fetcher
    //  * @return Response
    //  */
    // public function index(GroupFetcher $fetcher): Response
    // {
    //     $groups = $fetcher->all();

    //     return $this->render('app/paseka/pchelowods/groups/index.html.twig', compact('groups'));
    // }

    // /**
    //  * @Route("/create", name=".create")
    //  * @param Request $request
    //  * @param Create\Handler $handler
    //  * @return Response
    //  */
    // public function create(Request $request, Create\Handler $handler): Response
    // {
    //     $command = new Create\Command();

    //     $form = $this->createForm(Create\Form::class, $command);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         try {
    //             $handler->handle($command);
    //             return $this->redirectToRoute('paseka.pchelowods.groups');
    //         } catch (\DomainException $e) {
    //             $this->errors->handle($e);
    //             $this->addFlash('error', $e->getMessage());
    //         }
    //     }

    //     return $this->render('app/paseka/pchelowods/groups/create.html.twig', [
    //         'form' => $form->createView(),
    //     ]);
    // }

    // /**
    //  * @Route("/{id}/edit", name=".edit")
    //  * @param Group $group
    //  * @param Request $request
    //  * @param Edit\Handler $handler
    //  * @return Response
    //  */
    // public function edit(Group $group, Request $request, Edit\Handler $handler): Response
    // {
    //     $command = Edit\Command::fromGroup($group);

    //     $form = $this->createForm(Edit\Form::class, $command);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         try {
    //             $handler->handle($command);
    //             return $this->redirectToRoute('paseka.pchelowods.groups.show', ['id' => $group->getId()]);
    //         } catch (\DomainException $e) {
    //             $this->errors->handle($e);
    //             $this->addFlash('error', $e->getMessage());
    //         }
    //     }

    //     return $this->render('app/paseka/pchelowods/groups/edit.html.twig', [
    //         'group' => $group,
    //         'form' => $form->createView(),
    //     ]);
    // }

    // /**
    //  * @Route("/{id}/delete", name=".delete", methods={"POST"})
    //  * @param Group $group
    //  * @param Request $request
    //  * @param Remove\Handler $handler
    //  * @return Response
    //  */
    // public function delete(Group $group, Request $request, Remove\Handler $handler): Response
    // {
    //     if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
    //         return $this->redirectToRoute('paseka.pchelowods.groups.show', ['id' => $group->getId()]);
    //     }

    //     $command = new Remove\Command($group->getId()->getValue());

    //     try {
    //         $handler->handle($command);
    //         return $this->redirectToRoute('paseka.pchelowods.groups');
    //     } catch (\DomainException $e) {
    //         $this->errors->handle($e);
    //         $this->addFlash('error', $e->getMessage());
    //     }

    //     return $this->redirectToRoute('paseka.pchelowods.groups.show', ['id' => $group->getId()]);
    // }

    // /**
    //  * @Route("/{id}", name=".show")
    //  * @return Response
    //  */
    // public function show(): Response
    // {
    //     return $this->redirectToRoute('paseka.pchelowods.groups');
    // }
}
