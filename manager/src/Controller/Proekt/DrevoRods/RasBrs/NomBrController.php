<?php

declare(strict_types=1);

namespace App\Controller\Proekt\DrevoRods\RasBrs;

use App\Annotation\Guid;

use App\Model\Drevos\UseCase\Rass\LiniBrs\VetkaBrs\NomerBrs\Reinstate;
use App\Model\Drevos\UseCase\Rass\LiniBrs\VetkaBrs\NomerBrs\Archive;

use App\Controller\ErrorHandler;
use App\Model\Drevos\Entity\Rass\LiniBr\VetkaBr\NomerBr\NomerBr;
use App\Model\Drevos\Entity\Rass\LiniBr\VetkaBr\VetkaBr;
use App\ReadModel\Drevos\Rass\LiniBrs\VetkaBrs\NomerBrs\NomerBrFetcher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/proekts/drevorods/rasbrs/linibrs/vetbrs/{vetka_id}/nomers", name="app.proekts.drevorods.rasbrs.linibrs.vetbrs.nomers")
 * @ParamConverter("vetka", options={"id" = "vetka_id"})
 */
class NomBrController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }


    /**
     * @Route("", name="")
     * @param VetkaBr $vetka
     * @param NomerBrFetcher $nomers
     * @return Response
     */
    public function index( VetkaBr $vetka, NomerBrFetcher $nomers): Response
    {
        // $this->denyAccessUnlessGranted(LiniaAccess::MANAGE_MEMBERS, $vetka);

        return $this->render('app/proekts/drevorods/rasbrs/linibrs/vetbrs/nomers/index.html.twig', [
            'vetka' => $vetka,
            'linia' => $vetka->getLinia(),
            'rasa' => $vetka->getLinia()->getRasa(),
            'nomers' => $nomers->allOfVetkaBr($vetka->getId()->getValue()),
        ]);
    }

    

    /**
     * @Route("/plemnom", name=".plemnom")
     * @param VetkaBr $vetka
     * @param NomerBrFetcher $nomers
     * @return Response
     */
    public function plemnom(VetkaBr $vetka, NomerBrFetcher $nomers): Response
    {
//dd($nomers->allOfLinia($vetka->getId()->getValue()));
        return $this->render('app/proekts/drevorods/rasbrs/linibrs/vetbrs/nomers/plemnom.html.twig', [
            'vetka' => $vetka,
            'linia' => $vetka->getLinia(),
            'rasa' => $vetka->getLinia()->getRasa(),
            'nomers' => $nomers->allOfVetkaBr($vetka->getId()->getValue()),
        ]);
    }

    /**
     * @Route("/{id}/archive", name=".archive", methods={"POST"})
     * @param VetkaBr $vetka
     * @param NomerBr $nomer
     * @param Request $request
     * @param Archive\Handler $handler
     * @return Response
     */
    public function archive(VetkaBr $vetka, NomerBr $nomer, Request $request, Archive\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('archive', $request->request->get('token'))) {
            return $this->redirectToRoute('app.proekts.drevorods.rasbrs.linibrs.vetbrs.nomers.plemnom', ['vetka_id' => $vetka->getId()->getValue()]);
        }

//        $this->denyAccessUnlessGranted(NomBrAccess::EDIT, $nomer);

        $command = new Archive\Command($nomer->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('app.proekts.drevorods.rasbrs.linibrs.vetbrs.nomers.plemnom', ['vetka_id' => $vetka->getId()->getValue()]);
    }

    /**
     * @Route("/{id}/reinstate", name=".reinstate", methods={"POST"})
     * @param VetkaBr $vetka
     * @param NomerBr $nomer
     * @param Request $request
     * @param Reinstate\Handler $handler
     * @return Response
     */
    public function reinstate( Request $request, VetkaBr $vetka, NomerBr $nomer, Reinstate\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('reinstate', $request->request->get('token'))) {
            return $this->redirectToRoute('app.proekts.drevorods.rasbrs.linibrs.vetbrs.nomers.plemnom', ['vetka_id' => $vetka->getId()->getValue()]);
        }
//        $this->denyAccessUnlessGranted(NomerBrAccess::EDIT, $nomer);
//dd($nomer);

        $command = new Reinstate\Command($nomer->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('app.proekts.drevorods.rasbrs.linibrs.vetbrs.nomers.plemnom', ['vetka_id' => $vetka->getId()->getValue()]);
    }



}
