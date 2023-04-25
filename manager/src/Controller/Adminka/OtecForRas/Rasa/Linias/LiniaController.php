<?php

declare(strict_types=1);

namespace App\Controller\Adminka\OtecForRas\Rasa\Linias;

use App\Annotation\Guid;
use App\Model\Adminka\Entity\OtecForRas\Linias\Id;
//use App\Model\Adminka\Entity\OtecForRas\Rasa;
use App\Model\Adminka\Entity\Rasas\Rasa;
use App\Model\Adminka\UseCase\OtecForRas\Linias\Create;
use App\Model\Adminka\UseCase\OtecForRas\Linias\Edit;
use App\Model\Adminka\UseCase\OtecForRas\Linias\Remove;
use App\ReadModel\Adminka\OtecForRas\Linias\LiniaFetcher;
//use App\Security\Voter\Adminka\Rasas\MateriAccess;
use App\Controller\ErrorHandler;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/adminka/otec-for-ras/{id}/linias", name="adminka.otec-for-ras.linias")
 */
class LiniaController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


    /**
     * @Route("", name="")
     * @param Rasa $rasa
     * @param Request $request
     * @param LiniaFetcher $linias
     * @return Response
     */
    public function index( Rasa $rasa, Request $request,  LiniaFetcher $linias): Response
    {
        //$this->denyAccessUnlessGranted(MateriAccess::MANAGE_MEMBERS, $materi);

        return $this->render('app/adminka/otec-for-ras/linias/index.html.twig', [
            'rasa' => $rasa,
            'linias' => $linias->allOfRasa($rasa->getId()->getValue()),
        ]);
    }


    /**
     * @Route("/create", name=".create")
     * @param Rasa $rasa
	 * @param LiniaFetcher $linias
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(Rasa $rasa, LiniaFetcher $linias, Request $request, Create\Handler $handler): Response
   {
//       $maxSort = $linias->getMaxSortLinia($rasa->getId()->getValue()) + 1;

       $command = Create\Command::fromRasa($rasa, $maxSort);// заполнение  значениями из Rasa

        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);
//dd($command);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('adminka.otec-for-ras.linias', ['id' => $rasa->getId()]);
            } catch (\DomainException $e) {
                $this->logger->warning($e->getMessage(), ['exception' => $e]);
                $this->addFlash('error', $e->getMessage());
            }
        }
        return $this->render('app/adminka/otec-for-ras/linias/create.html.twig', [
            'rasa' => $rasa,
            'form' => $form->createView(),
            'name' => $command->title,
        ]);
   }

    /**
     * @Route("/{linia_id}/edit", name=".edit")
     * @param Rasa $rasa
     * @param string $linia_id
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(Rasa $rasa, string $linia_id, Request $request, Edit\Handler $handler): Response
    {
        //$this->denyAccessUnlessGranted(MateriAccess::MANAGE_MEMBERS, $materi);

        $linia = $rasa->getLinia(new Id($linia_id));

        $command = Edit\Command::fromLinia($rasa, $linia);


        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $command->title = $rasa->getName();
                $command->title = $command->title."_".$command->name;
//                 dd($command->title);
                $handler->handle($command);
                return $this->redirectToRoute('adminka.otec-for-ras.linias.show',
									['id' => $rasa->getId(), 'linia_id' => $linia_id]);
            } catch (\DomainException $e) {
                $this->logger->warning($e->getMessage(), ['exception' => $e]);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/adminka/otec-for-ras/linias/edit.html.twig', [
            'rasa' => $rasa,
            'linia' => $linia,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{linia_id}/delete", name=".delete", methods={"POST"})
     * @param Rasa $rasa
     * @param string $linia_id
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(Rasa $rasa, string $linia_id, Request $request, Remove\Handler $handler): Response
    {
        //$this->denyAccessUnlessGranted(MateriAccess::MANAGE_MEMBERS, $materi);

        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('adminka.otec-for-ras.linias', ['id' => $rasa->getId()]);
        }

        $linia = $rasa->getLinia(new Id($linia_id));

        $command = new Remove\Command($rasa->getId()->getValue(), $linia->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->logger->warning($e->getMessage(), ['exception' => $e]);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('adminka.otec-for-ras.linias',
					['id' => $rasa->getId()]);
    }

    /**
     * @Route("/{linia_id}", name=".show", requirements={"linia_id"=Guid::PATTERN})
     * @param Rasa $rasa
     * @return Response
     */
    public function show(Rasa $rasa): Response
    {
        return $this->redirectToRoute('adminka.otec-for-ras.linias',
				['id' => $rasa->getId()]);
    }
}
