<?php

declare(strict_types=1);

namespace App\Controller\Drevos\Rass\Ras\Rods\Linis\Wetkas\NomWets\Noms;

use App\Annotation\Guid;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\Noms\Id;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\NomWet;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\Wetka;
use App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\Noms\Create;
use App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\Noms\Edit;
use App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\Noms\Remove;

//use App\Security\Voter\Adminka\Rasas\MateriAccess;
use App\Controller\ErrorHandler;
use App\ReadModel\Drevos\Rass\Rods\Linis\Wetkas\NomWets\Noms\NomFetcher;

use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/drevos/rass/rods/linis/wetkas/nomwets/{id}/noms", name="drevos.rass.rods.linis.wetkas.nomwets.noms")
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
     * @param NomWet $nomwet
     * @param Request $request
     * @param NomFetcher $noms
     * @return Response
     */
    public function index( Request $request, NomWet $nomwet,  NomFetcher $noms): Response
    {
        $wetka = $nomwet->getWetka();
        $linia = $wetka->getLinia();
        $rodo =  $linia->getRodo();
        return $this->render('app/drevos/rass/rods/linis/wetkas/nomwets/noms/index.html.twig', [
            'wetka' => $wetka,
            'nomwet' => $nomwet,
            'linia' => $linia,
            'rodo' => $rodo,
            'stran' => $rodo->getStrana(),
            'rasa' => $rodo->getRasa()->getName(),
            'noms' => $noms->allOfNomWet($nomwet->getId()->getValue()),
        ]);
    }


    /**
     * @Route("/create", name=".create")
     * @param NomWet $nomwet
	 * @param NomFetcher $noms
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(NomWet $nomwet, NomFetcher $noms, Request $request, Create\Handler $handler): Response
   {

       $maxSort = $noms->getMaxSortNom($nomwet->getId()->getValue()) + 1;

       $command = Create\Command::fromNomWet($nomwet, $maxSort);// заполнение  значениями из Rasa

        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('drevos.rass.rods.linis.wetkas.nomwets.noms.show', ['id' => $nomwet->getId(),'nom_id'=>$command->id ]);

            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }
        $wetka = $nomwet->getWetka();
        $linia = $wetka->getLinia();
        $rodo =  $linia->getRodo();

        return $this->render('app/drevos/rass/rods/linis/wetkas/nomwets/noms/create.html.twig', [
            'nomwet' => $nomwet,
            'wetka' => $wetka,
            'linia' => $linia,
            'rodo' => $rodo,
            'stran' => $rodo->getStrana(),
            'rasa' => $rodo->getRasa(),
            'form' => $form->createView(),
        ]);
   }

    /**
     * @Route("/{nom_id}/edit", name=".edit")
     * @param NomWet $nomwet
     * @param string $nom_id
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(Request $request,NomWet $nomwet, string $nom_id,  Edit\Handler $handler): Response
    {
        //$this->denyAccessUnlessGranted(MateriAccess::MANAGE_MEMBERS, $materi);

        $nom = $nomwet->getNom(new Id($nom_id));

        $command = Edit\Command::fromNomWet($nomwet, $nom);


        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('drevos.rass.rods.linis.wetkas.nomwets.noms.show',	['id' => $nomwet->getId(), 'nom_id' => $nom_id]);


            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/drevos/rass/rods/linis/wetkas/nomwets/noms/edit.html.twig', [
            'nom' => $nom,
            'nomwet' => $nomwet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{nom_id}/delete", name=".delete", methods={"POST"})
     * @param NomWet $nomwet
     * @param string $nom_id
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(NomWet $nomwet, string $nom_id, Request $request, Remove\Handler $handler): Response
    {
        //$this->denyAccessUnlessGranted(MateriAccess::MANAGE_MEMBERS, $materi);

        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('drevos.rass.rods.linis.wetkas.nomwets.noms', ['id' => $nomwet->getId()]);
        }

        $nom = $nomwet->getNom(new Id($nom_id));

        $command = new Remove\Command($nomwet->getId()->getValue(), $nom->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('drevos.rass.rods.linis.wetkas.nomwets.noms',
					['id' => $nomwet->getId()]);
    }

    /**
     * @Route("/show/{nom_id}", name=".show", requirements={"nom_id"=Guid::PATTERN})
     * @param string $nom_id
     * @param Request $request
     * @param NomWet $nomwet
     * @return Response
     */
    public function show(Request $request, NomWet $nomwet, string $nom_id): Response
    {
        $nomer = $nomwet->getNom(new Id($nom_id));
        $nomwet = $nomer->getNomwet();
        $wetka = $nomwet->getWetka();
        $linia = $wetka->getLinia();
        $rodo = $linia->getRodo();

        return $this->render('app/drevos/rass/rods/linis/wetkas/nomwets/noms/show.html.twig', [
            'nom' => $nomer,
            'nomwet' => $nomwet,
            'wetka' => $wetka,
            'rodo' => $rodo,
            'linia'=>$linia,
            'stran' => $rodo->getStrana(),
            'rasa' => $rodo->getRasa(),

        ]);
    }
}

