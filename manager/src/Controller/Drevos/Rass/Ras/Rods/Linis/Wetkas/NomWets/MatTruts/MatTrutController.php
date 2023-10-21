<?php

declare(strict_types=1);

namespace App\Controller\Drevos\Rass\Ras\Rods\Linis\Wetkas\NomWets\MatTruts;

use App\Annotation\Guid;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Id;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\NomWet;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\Wetka;
use App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Create;
use App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Edit;
use App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Remove;

//use App\Security\Voter\Adminka\Rasas\MateriAccess;
use App\Controller\ErrorHandler;
use App\ReadModel\Drevos\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\MatTrutFetcher;


use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/drevos/rass/rods/linis/wetkas/nomwets/{id}/mattruts", name="drevos.rass.rods.linis.wetkas.nomwets.mattruts")
 */
class MatTrutController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }


    /**
     * @Route("", name="")
     * @param NomWet $nomwet
     * @param Request $request
     * @param MatTrutFetcher $mattruts
     * @return Response
     */
    public function index( Request $request, NomWet $nomwet,  MatTrutFetcher $mattruts): Response
    {
        $wetka = $nomwet->getWetka();
        $linia = $wetka->getLinia();
        $rodo =  $linia->getRodo();
        return $this->render('app/drevos/rass/rods/linis/wetkas/nomwets/mattruts/index.html.twig', [
            'wetka' => $wetka,
            'nomwet' => $nomwet,
            'linia' => $linia,
            'rodo' => $rodo,
            'stran' => $rodo->getStrana(),
            'rasa' => $rodo->getRasa()->getName(),
            'mattruts' => $mattruts->allOfNomWet($nomwet->getId()->getValue()),
        ]);
    }


    /**
     * @Route("/create", name=".create")
     * @param NomWet $nomwet
	 * @param MatTrutFetcher $mattruts
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(NomWet $nomwet, MatTrutFetcher $mattruts, Request $request, Create\Handler $handler): Response
   {

       $maxSort = $mattruts->getMaxSortTrut($nomwet->getId()->getValue()) + 1;

       $command = Create\Command::fromNomWet($nomwet, $maxSort);// заполнение  значениями из Rasa

        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('drevos.rass.rods.linis.wetkas.nomwets.mattruts.show', ['id' => $nomwet->getId(),'mattrut_id'=>$command->id ]);

            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }
        $wetka = $nomwet->getWetka();
        $linia = $wetka->getLinia();
        $rodo =  $linia->getRodo();

        return $this->render('app/drevos/rass/rods/linis/wetkas/nomwets/mattruts/create.html.twig', [
            'nomwet' => $nomwet,
            'wetka' => $wetka,
            'linia' => $linia,
            'rodo' => $rodo,
            'stran' => $rodo->getStrana(),
            'rasa' => $rodo->getRasa(),
            'form' => $form->createView(),
            'mattruts' => $nomwet->getMatTruts(),
        ]);
   }

    /**
     * @Route("/{mattrut_id}/edit", name=".edit")
     * @param NomWet $nomwet
     * @param string $mattrut_id
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(Request $request,NomWet $nomwet, string $mattrut_id,  Edit\Handler $handler): Response
    {
        //$this->denyAccessUnlessGranted(MateriAccess::MANAGE_MEMBERS, $materi);

        $nom = $nomwet->getMatTrut(new Id($mattrut_id));

        $command = Edit\Command::fromNomWet($nomwet, $nom);


        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('drevos.rass.rods.linis.wetkas.nomwets.mattruts.show',	['id' => $nomwet->getId(), 'mattrut_id' => $mattrut_id]);


            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/drevos/rass/rods/linis/wetkas/nomwets/mattruts/edit.html.twig', [
            'nom' => $nom,
            'nomwet' => $nomwet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{mattrut_id}/delete", name=".delete", methods={"POST"})
     * @param NomWet $nomwet
     * @param string $mattrut_id
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(NomWet $nomwet, string $mattrut_id, Request $request, Remove\Handler $handler): Response
    {
        //$this->denyAccessUnlessGranted(MateriAccess::MANAGE_MEMBERS, $materi);

        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('drevos.rass.rods.linis.wetkas.nomwets.mattruts', ['id' => $nomwet->getId()]);
        }

        $nom = $nomwet->getMatTrut(new Id($mattrut_id));

        $command = new Remove\Command($nomwet->getId()->getValue(), $nom->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('drevos.rass.rods.linis.wetkas.nomwets.mattruts',
					['id' => $nomwet->getId()]);
    }

    /**
     * @Route("/show/{mattrut_id}", name=".show", requirements={"mattrut_id"=Guid::PATTERN})
     * @param string $mattrut_id
     * @param Request $request
     * @param NomWet $nomwet
     * @return Response
     */
    public function show(Request $request, NomWet $nomwet, string $mattrut_id): Response
    {
        $mattrut = $nomwet->getMatTrut(new Id($mattrut_id));
        $nomwet = $mattrut->getNomwet();
        $wetka = $nomwet->getWetka();
        $linia = $wetka->getLinia();
        $rodo = $linia->getRodo();

        return $this->render('app/drevos/rass/rods/linis/wetkas/nomwets/mattruts/show.html.twig', [
            'mattrut' => $mattrut,
            'nomwet' => $nomwet,
            'wetka' => $wetka,
            'rodo' => $rodo,
            'linia'=>$linia,
            'stran' => $rodo->getStrana(),
            'rasa' => $rodo->getRasa(),

        ]);
    }
}

