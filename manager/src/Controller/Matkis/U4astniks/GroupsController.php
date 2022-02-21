<?php

declare(strict_types=1);

namespace App\Controller\Matkis\U4astniks;

use App\Model\Matkis\Entity\U4astniks\Group\Group;
use App\Model\Matkis\UseCase\U4astniks\Group\Create;
use App\Model\Matkis\UseCase\U4astniks\Group\Edit;
use App\Model\Matkis\UseCase\U4astniks\Group\Remove;
use App\ReadModel\Matkis\U4astniks\GroupFetcher;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/matkis/u4astniks/groups", name="matkis.u4astniks.groups")
 * @IsGranted("ROLE_WORK_MANAGE_MEMBERS")
 */
class GroupsController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("", name="")
     * @param GroupFetcher $fetcher
     * @return Response
     */
    public function index(GroupFetcher $fetcher): Response
    {
        $groups = $fetcher->all();

        return $this->render('app/matkis/u4astniks/groups/index.html.twig', compact('groups'));
    }

    /**
     * @Route("/create", name=".create")
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(Request $request, Create\Handler $handler): Response
    {
        $command = new Create\Command();

        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('matkis.u4astniks.groups');
            } catch (\DomainException $e) {
                $this->logger->error($e->getMessage(), ['exception' => $e]);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/matkis/u4astniks/groups/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name=".edit")
     * @param Group $group
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(Group $group, Request $request, Edit\Handler $handler): Response
    {
        $command = Edit\Command::fromGroup($group);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('matkis.u4astniks.groups.show', ['id' => $group->getId()]);
            } catch (\DomainException $e) {
                $this->logger->error($e->getMessage(), ['exception' => $e]);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/matkis/u4astniks/groups/edit.html.twig', [
            'group' => $group,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name=".delete", methods={"POST"})
     * @param Group $group
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(Group $group, Request $request, Remove\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('matkis.u4astniks.groups.show', ['id' => $group->getId()]);
        }

        $command = new Remove\Command($group->getId()->getValue());

        try {
            $handler->handle($command);
            return $this->redirectToRoute('matkis.u4astniks.groups');
        } catch (\DomainException $e) {
            $this->logger->error($e->getMessage(), ['exception' => $e]);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('matkis.u4astniks.groups.show', ['id' => $group->getId()]);
    }

    /**
     * @Route("/{id}", name=".show")
     * @return Response
     */
    public function show(): Response
    {
        return $this->redirectToRoute('matkis.u4astniks.groups');
    }
}
