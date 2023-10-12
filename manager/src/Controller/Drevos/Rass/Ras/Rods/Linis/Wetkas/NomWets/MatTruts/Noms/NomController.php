<?php

declare(strict_types=1);

namespace App\Controller\Drevos\Rass\Ras\Rods\Linis\Wetkas\NomWets\MatTruts\Noms;

use App\Annotation\Guid;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\MatTrut;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Noms\Id;

use App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Noms\Create;
use App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Noms\Edit;
use App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Noms\Remove;

//use App\Security\Voter\Adminka\Rasas\MateriAccess;
use App\Controller\ErrorHandler;
use App\ReadModel\Drevos\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Noms\NomFetcher;

use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/drevos/rass/rods/linis/wetkas/nomwets/mattruts/{id}/noms", name="drevos.rass.rods.linis.wetkas.nomwets.mattruts.noms")
 */
class NomController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }


    /**
     * @Route("", name="")
     * @param MatTrut $mattrut
     * @param Request $request
     * @param NomFetcher $noms
     * @return Response
     */
    public function index( Request $request, MatTrut $mattrut,  NomFetcher $noms): Response
    {
        $nomwet = $mattrut->getNomwet();
        $wetka = $nomwet->getWetka();
        $linia = $wetka->getLinia();
        $rodo =  $linia->getRodo();
        return $this->render('app/drevos/rass/rods/linis/wetkas/nomwets/mattruts/noms/index.html.twig', [
            'wetka' => $wetka,
            'nomwet'=> $nomwet,
            'mattrut' => $mattrut,
            'linia' => $linia,
            'rodo' => $rodo,
            'stran' => $rodo->getStrana(),
            'rasa' => $rodo->getRasa()->getName(),
            'noms' => $noms->allOfMatTrut($mattrut->getId()->getValue()),
        ]);
    }


    /**
     * @Route("/create", name=".create")
     * @param MatTrut $mattrut
	 * @param NomFetcher $noms
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create( Request $request, MatTrut $mattrut, NomFetcher $noms, Create\Handler $handler): Response
   {

       $maxSort = $noms->getMaxSortNom($mattrut->getId()->getValue()) + 1;

       $command = Create\Command::fromMatTrut($mattrut, $maxSort);// заполнение  значениями из Rasa

        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('drevos.rass.rods.linis.wetkas.nomwets.mattruts.noms.show', ['id' => $mattrut->getId(),'nom_id'=>$command->id ]);

            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }
//        dd($mattrut->getNomwet());
       $nomwet = $mattrut->getNomwet();
       $wetka = $nomwet->getWetka();
        $linia = $wetka->getLinia();
        $rodo =  $linia->getRodo();

        return $this->render('app/drevos/rass/rods/linis/wetkas/nomwets/mattruts/noms/create.html.twig', [
            'mattrut' => $mattrut,
            'wetka' => $wetka,
            'nomwet ' =>  $nomwet ,
            'linia' => $linia,
            'rodo' => $rodo,
            'stran' => $rodo->getStrana(),
            'rasa' => $rodo->getRasa(),
            'form' => $form->createView(),
        ]);
   }

    /**
     * @Route("/{nom_id}/edit", name=".edit")
     * @param MatTrut $mattrut
     * @param string $nom_id
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(Request $request,MatTrut $mattrut, string $nom_id,  Edit\Handler $handler): Response
    {
        //$this->denyAccessUnlessGranted(MateriAccess::MANAGE_MEMBERS, $materi);

        $nom = $mattrut->getNom(new Id($nom_id));

        $command = Edit\Command::fromMatTrut($mattrut, $nom);


        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('drevos.rass.rods.linis.wetkas.nomwets.mattruts.noms.show',	['id' => $mattrut->getId(), 'nom_id' => $nom_id]);


            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/drevos/rass/rods/linis/wetkas/nomwets/mattruts/noms/edit.html.twig', [
            'nom' => $nom,
            'mattrut' => $mattrut,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{nom_id}/delete", name=".delete", methods={"POST"})
     * @param MatTrut $mattrut
     * @param string $nom_id
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(MatTrut $mattrut, string $nom_id, Request $request, Remove\Handler $handler): Response
    {
        //$this->denyAccessUnlessGranted(MateriAccess::MANAGE_MEMBERS, $materi);

        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('drevos.rass.rods.linis.wetkas.nomwets.mattruts.noms', ['id' => $mattrut->getId()]);
        }

        $nom = $mattrut->getNom(new Id($nom_id));

        $command = new Remove\Command($mattrut->getId()->getValue(), $nom->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('drevos.rass.rods.linis.wetkas.nomwets.mattruts.noms',
					['id' => $mattrut->getId()]);
    }

    /**
     * @Route("/show/{nom_id}", name=".show", requirements={"nom_id"=Guid::PATTERN})
     * @param string $nom_id
     * @param Request $request
     * @param MatTrut $mattrut
     * @return Response
     */
    public function show(Request $request, MatTrut $mattrut, string $nom_id): Response
    {
        $nomer = $mattrut->getNom(new Id($nom_id));
        $nomwet = $mattrut->getNomwet();
        $wetka = $nomwet->getWetka();
        $linia = $wetka->getLinia();
        $rodo = $linia->getRodo();

        return $this->render('app/drevos/rass/rods/linis/wetkas/nomwets/mattruts/noms/show.html.twig', [
            'nom' => $nomer,
            'mattrut' => $mattrut,
            ' nomwet ' =>  $nomwet ,
            'wetka' => $wetka,
            'rodo' => $rodo,
            'linia'=>$linia,
            'stran' => $rodo->getStrana(),
            'rasa' => $rodo->getRasa(),

        ]);
    }
}

