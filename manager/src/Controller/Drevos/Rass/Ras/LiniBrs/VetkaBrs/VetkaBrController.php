<?php

declare(strict_types=1);

namespace App\Controller\Drevos\Rass\Ras\LiniBrs\VetkaBrs;

use App\Annotation\Guid;

use App\Model\Drevos\Entity\Rass\LiniBr\LiniBr;
use App\Model\Drevos\UseCase\Rass\LiniBrs\VetkaBrs\Create;
use App\Model\Drevos\UseCase\Rass\LiniBrs\VetkaBrs\Edit;
use App\Model\Drevos\UseCase\Rass\LiniBrs\VetkaBrs\Remove;
use App\Model\Drevos\Entity\Rass\LiniBr\VetkaBr\Id ;
use App\Controller\ErrorHandler;
//use App\Model\Drevos\Entity\Rass\Ras;
//use App\ReadModel\Drevos\Rass\LiniBrs\LiniBrFetcher;
use App\ReadModel\Drevos\Rass\LiniBrs\VetkaBrs\VetkaBrFetcher;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/drevos/rass/linibrs/{id}/vetbrs", name="drevos.rass.linibrs.vetbrs")
 */
class VetkaBrController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }


    /**
     * @Route("", name="")
     * @param LiniBr $linia
     * @param Request $request
     * @param VetkaBrFetcher $vetkas
     * @return Response
     */
    public function index( LiniBr $linia, Request $request,  VetkaBrFetcher $vetkas): Response
    {
        //$this->denyAccessUnlessGranted(MateriAccess::MANAGE_MEMBERS, $materi);
//dd($vetkas->allOfLiniBr($linia->getId()->getValue()));

        return $this->render('app/drevos/rass/linibrs/vetbrs/index.html.twig', [
            'rasa' => $linia->getRasa(),
            'linia' => $linia,
            'vetkas' => $vetkas->allOfLiniBr($linia->getId()->getValue()),
        ]);
    }

    /**
     * @Route("/plemmatka", name=".plemmatka")
     * @param LiniBr $linia
     * @param Request $request
     * @param VetkaBrFetcher $vetkas
     * @return Response
     */
    public function plemmatka( LiniBr $linia, Request $request,  VetkaBrFetcher $vetkas ): Response
    {
//        dd( $vetkas->allOfLiniBr($linia->getId()->getValue()));

        return $this->render('app/drevos/rass/linibrs/vetbrs/plemmatka.html.twig', [
            'linia' => $linia,
            'vetkas' => $vetkas->allOfLiniBr($linia->getId()->getValue()),
        ]);
    }

    /**
     * @Route("/create", name=".create")
     * @param LiniBr $linia
	 * @param VetkaBrFetcher $vetkas
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(LiniBr $linia, VetkaBrFetcher $vetkas, Request $request, Create\Handler $handler): Response
   {
       $maxSort = $vetkas->getMaxSortVet($linia->getId()->getValue()) + 1;

       $command = Create\Command::fromLiniBr($linia, $maxSort);// заполнение  значениями из LiniBr

        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);
//dd($command);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('drevos.rass.linibrs.vetbrs', ['id' => $linia->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }
        return $this->render('app/drevos/rass/linibrs/vetbrs/create.html.twig', [
            'linia' => $linia,
            'form' => $form->createView(),
//            'name' => $command->title,
        ]);
   }

    /**
     * @Route("/{vetka_id}/edit", name=".edit")
     * @param LiniBr $linia
     * @param string $vetka_id
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(Request $request, LiniBr $linia, string $vetka_id,  Edit\Handler $handler): Response
    {
        //$this->denyAccessUnlessGranted(MateriAccess::MANAGE_MEMBERS, $materi);

        $vetka = $linia->getVetka(new Id($vetka_id));

        $command = Edit\Command::fromVetBr($linia, $vetka);


        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
//                $command->title = $linia->getName();
//                $command->title = $command->title."_".$command->name;
//                 dd($command->title);
                $handler->handle($command);
                return $this->redirectToRoute('drevos.rass.linibrs.vetbrs.show',
                    [ 'id' => $linia->getId()]);
//									['id' => $linia->getId(), 'vetka_id' => $vetka_id]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/drevos/rass/linibrs/vetbrs/edit.html.twig', [
            'linia' => $linia,
            'vetka' => $vetka,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{vetka_id}/delete", name=".delete", methods={"POST"})
     * @param LiniBr $linia
     * @param string $vetka_id
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(LiniBr $linia, string $vetka_id, Request $request, Remove\Handler $handler): Response
    {
        //$this->denyAccessUnlessGranted(MateriAccess::MANAGE_MEMBERS, $materi);

        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('drevos.rass.linibrs.vetbrs', ['id' => $linia->getId()]);
        }

        $vetka = $linia->getVetka(new Id($vetka_id));

        $command = new Remove\Command($linia->getId()->getValue(), $vetka->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('drevos.rass.linibrs.vetbrs',
					['id' => $linia->getId()]);
    }
//, requirements={"vetka_id"=Guid::PATTERN}
    /**
     * @Route("/show", name=".show")
     * @param LiniBr $linia
     * @return Response
     */
    public function show(LiniBr $linia): Response
    {
        return $this->redirectToRoute('drevos.rass.linibrs.vetbrs',
				['id' => $linia->getId()]);
    }
}
