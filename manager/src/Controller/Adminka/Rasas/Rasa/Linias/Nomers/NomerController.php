<?php

declare(strict_types=1);

namespace App\Controller\Adminka\Rasas\Rasa\Linias\Nomers;

use App\Annotation\Guid;
use App\Model\Adminka\Entity\Rasas\Linias\Nomers\Id;
use App\Model\Adminka\Entity\Rasas\Linias\Linia;
use App\Model\Adminka\Entity\Rasas\Linias\Nomers\Nomer;

use App\Model\Adminka\UseCase\Rasas\Linias\Nomers\Create;
use App\Model\Adminka\UseCase\Rasas\Linias\Nomers\Edit;
use App\Model\Adminka\UseCase\Rasas\Linias\Nomers\Remove;

use App\ReadModel\Adminka\Rasas\Linias\Nomers\NomerFetcher;
//use App\Security\Voter\Adminka\Materis\Linia\LiniaAccess;
use App\Controller\ErrorHandler;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/adminka/rasas/linias/{linia_id}/nomers", name="adminka.rasas.linias.nomers")
 * @ParamConverter("linia", options={"id" = "linia_id"})
 */
class NomerController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


    /**
     * @Route("", name="")
     * @param Linia $linia
     * @param NomerFetcher $nomers
     * @return Response
     */
    public function index(Linia $linia, NomerFetcher $nomers): Response
    {

        // $this->denyAccessUnlessGranted(LiniaAccess::MANAGE_MEMBERS, $linia);
//dd( $nomers->allOfLinia($linia->getId()->getValue()));
        return $this->render('app/adminka/rasas/linias/nomers/index.html.twig', [
            'linia' => $linia,
            'nomers' => $nomers->allOfLinia($linia->getId()->getValue()),
        ]);
    }

    /**
     * @Route("/plemmatka", name=".plemmatka")
     * @param Linia $linia
     * @param NomerFetcher $nomers
     * @return Response
     */
    public function plemmatka(Linia $linia, NomerFetcher $nomers): Response
    {

        return $this->render('app/adminka/rasas/linias/nomers/plemmatka.html.twig', [
            'linia' => $linia,
            'nomers' => $nomers->allOfLinia($linia->getId()->getValue()),
        ]);
    }

    /**
     * @Route("/create", name=".create")
     * @param Linia $linia
     * @param NomerFetcher $nomers
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create( Create\Handler $handler, Linia $linia,  NomerFetcher $nomers, Request $request): Response
    {
        $rasa =
        $maxSort = $nomers->getMaxSortNomer($linia->getId()->getValue()) + 1;

        $command = Create\Command::fromLinia($linia, $maxSort);// заполнение  значениями из


        $form = $this->createForm(Create\Form::class, $command);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('adminka.rasas.linias.nomers', ['linia_id' => $linia->getId()]);
            } catch (\DomainException $e) {
                $this->logger->warning($e->getMessage(), ['exception' => $e]);
                $this->addFlash('error', $e->getMessage());
            }
        }
        return $this->render('app/adminka/rasas/linias/nomers/create.html.twig', [
            'linia' => $linia,
            'form' => $form->createView(),
            'name' => $command->title,
        ]);
    }

    /**
     * @Route("/{id}/edit", name=".edit")
     * @param Linia $linia
     * @param string $id
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(Linia $linia, string $id, Request $request, Edit\Handler $handler): Response
    {
        // $this->denyAccessUnlessGranted(LiniaAccess::MANAGE_MEMBERS, $linia);

         $nomer = $linia->getNomer(new Id($id));

		$command = Edit\Command::fromNomer($linia, $nomer);
        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
				$command->title = "????????";
                $handler->handle($command);
                return $this->redirectToRoute('adminka.rasas.linias.nomers.show',
											['linia_id' => $linia->getId(), 'id' => $id]);
            } catch (\DomainException $e) {
                $this->logger->warning($e->getMessage(), ['exception' => $e]);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/adminka/rasas/linias/nomers/edit.html.twig', [
            'linia' => $linia,
            'nomer' => $nomer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name=".delete", methods={"POST"})
     * @param Linia $linia
     * @param string $id
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(Linia $linia, string $id, Request $request, Remove\Handler $handler): Response
    {
        //$this->denyAccessUnlessGranted(MateriAccess::MANAGE_MEMBERS, $materi);

        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('adminka.rasas.linias.nomers', ['linia_id' => $linia->getId()]);
        }

        $nomer= $linia->getNomer(new Id($id));

        $command = new Remove\Command($linia->getId()->getValue(), $nomer->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->logger->warning($e->getMessage(), ['exception' => $e]);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('adminka.rasas.linias.nomers',
					['linia_id' => $linia->getId()]);
    }

    // /**
    //  * @Route("/{id}", name=".show", requirements={"id"=Guid::PATTERN}))
    //  * @param Nomer $nomer
    //  * @return Response
    //  */
    // public function show(Nomer $nomer): Response
    // {
    //     return $this->redirectToRoute('Adminka.materis.rasas.linia.nomer', ['nomer_id' => $nomer->getId()]);
    // }

	 /**
     * @Route("/{id}", name=".show", requirements={"id"=Guid::PATTERN}))
     * @param Linia $linia
     * @return Response
     */
    public function show(Linia $linia): Response
    {
        return $this->redirectToRoute('adminka.rasas.linias.nomers',
				['linia_id' => $linia->getId()]);
    }
}
