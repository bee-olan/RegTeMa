<?php

declare(strict_types=1);

namespace App\Controller\Drevos\Rass\Ras\LiniBrs\VetkaBrs\NomerBrs;

use App\Annotation\Guid;
use App\Model\Drevos\Entity\Rass\LiniBr\VetkaBr\NomerBr\Id;
//use App\Model\Adminka\Entity\Rasas\Linias\Linia;

use App\Model\Drevos\Entity\Rass\LiniBr\VetkaBr\VetkaBr;
use App\Model\Drevos\UseCase\Rass\LiniBrs\VetkaBrs\NomerBrs\Create;
use App\Model\Drevos\UseCase\Rass\LiniBrs\VetkaBrs\NomerBrs\Edit;
use App\Model\Drevos\UseCase\Rass\LiniBrs\VetkaBrs\NomerBrs\Remove;

//use App\ReadModel\Adminka\Rasas\Linias\Nomers\NomerBrFetcher;
//use App\Security\Voter\Adminka\Materis\Linia\LiniaAccess;
use App\Controller\ErrorHandler;
use App\ReadModel\Drevos\Rass\LiniBrs\VetkaBrs\NomerBrs\NomerBrFetcher;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/drevos/rass/linibrs/vetbrs/{vetka_id}/nombrs", name="drevos.rass.linibrs.vetbrs.nombrs")
 * @ParamConverter("vetka", options={"id" = "vetka_id"})
 */
class NomerBrController extends AbstractController
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
    public function index(VetkaBr $vetka, NomerBrFetcher $nomers): Response
    {

        return $this->render('app/drevos/rass/linibrs/vetbrs/nombrs/index.html.twig', [
            'vetka' => $vetka,
            'linia' => $vetka->getLinia(),
            'rasa' => $vetka->getLinia()->getRasa(),
            'nomers' => $nomers->allOfVetkaBr($vetka->getId()->getValue()),
//            'no' => "нет!!!!",
        ]);
    }

    /**
     * @Route("/plemmatka", name=".plemmatka")
     * @param VetkaBr $vetka
     * @param NomerBrFetcher $nomers
     * @return Response
     */
    public function plemmatka(VetkaBr $vetka, NomerBrFetcher $nomers): Response
    {

        return $this->render('app/drevos/rass/linibrs/vetbrs/nombrs/plemmatka.html.twig', [
            'vetka' => $vetka,
            'nomers' => $nomers->allOfVetkaBr($vetka->getId()->getValue()),
        ]);
    }

    /**
     * @Route("/create", name=".create")
     * @param VetkaBr $vetka
     * @param NomerBrFetcher $nomers
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create( Create\Handler $handler, VetkaBr $vetka,  NomerBrFetcher $nomers, Request $request): Response
    {

        $maxSort = $nomers->getMaxSortNom($vetka->getId()->getValue()) + 1;

        $command = Create\Command::fromVetBr($vetka, $maxSort);// заполнение  значениями из


        $form = $this->createForm(Create\Form::class, $command);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('drevos.rass.linibrs.vetbrs.nombrs', ['vetka_id' => $vetka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }
        return $this->render('app/drevos/rass/linibrs/vetbrs/nombrs/create.html.twig', [
            'vetka' => $vetka,
            'linia' => $vetka->getLinia(),
            'rasa' => $vetka->getLinia()->getRasa(),
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/{id}/edit", name=".edit")
     * @param VetkaBr $vetka
     * @param string $id
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(VetkaBr $vetka, string $id, Request $request, Edit\Handler $handler): Response
    {
        // $this->denyAccessUnlessGranted(VetkaBrAccess::MANAGE_MEMBERS, $vetka);

         $nomer = $vetka->getNomerBr(new Id($id));

		$command = Edit\Command::fromNomer($vetka, $nomer);
        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('drevos.rass.linibrs.vetbrs.nombrs.show',
											['vetka_id' => $vetka->getId(), 'id' => $id]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/drevos/rass/linibrs/vetbrs/nombrs/edit.html.twig', [
            'vetka' => $vetka,
            'linia' => $vetka->getLinia(),
            'rasa' => $vetka->getLinia()->getRasa(),
            'nomer' => $nomer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name=".delete", methods={"POST"})
     * @param VetkaBr $vetka
     * @param string $id
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(VetkaBr $vetka, string $id, Request $request, Remove\Handler $handler): Response
    {
        //$this->denyAccessUnlessGranted(MateriAccess::MANAGE_MEMBERS, $materi);

        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('drevos.rass.linibrs.vetbrs.nombrs', ['vetka_id' => $vetka->getId()]);
        }
//        dd($id);
        $nomer= $vetka->getNomerBr(new Id($id));

        $command = new Remove\Command($vetka->getId()->getValue(), $nomer->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

            return $this->redirectToRoute('drevos.rass.linibrs.vetbrs.nombrs',
					['vetka_id' => $vetka->getId()]);
    }

 
	/**
    * @Route("/{id}", name=".show", requirements={"id"=Guid::PATTERN}))
    * @param VetkaBr $vetka
    * @return Response
    */
    public function show(VetkaBr $vetka): Response
    {
        return $this->redirectToRoute('drevos.rass.linibrs.vetbrs.nombrs',
				['vetka_id' => $vetka->getId()]);
    }
}
