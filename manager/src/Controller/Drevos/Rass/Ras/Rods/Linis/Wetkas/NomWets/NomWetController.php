<?php

declare(strict_types=1);

namespace App\Controller\Drevos\Rass\Ras\Rods\Linis\Wetkas\NomWets;

use App\Annotation\Guid;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\Id;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\Wetka;
use App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\Create;
use App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\Edit;
use App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\NomWets\Remove;

//use App\Security\Voter\Adminka\Rasas\MateriAccess;
use App\Controller\ErrorHandler;
use App\ReadModel\Drevos\Rass\Rods\Linis\Wetkas\NomWets\NomWetFetcher;
use App\ReadModel\Drevos\Rass\Rods\Linis\Wetkas\WetkaFetcher;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/drevos/rass/rods/linis/wetkas/{id}/nomwets", name="drevos.rass.rods.linis.wetkas.nomwets")
 */
class NomWetController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }


    /**
     * @Route("", name="")
     * @param Wetka $wetka
     * @param Request $request
     * @param NomWetFetcher $nomwets
     * @return Response
     */
    public function index( Request $request, Wetka $wetka,  NomWetFetcher $nomwets): Response
    {
        $linia = $wetka->getLinia();
        $rodo =  $linia->getRodo();
        return $this->render('app/drevos/rass/rods/linis/wetkas/nomwets/index.html.twig', [
            'wetka' => $wetka,
            'linia' => $linia,
            'rodo' => $rodo,
            'stran' => $rodo->getStrana(),
            'rasa' => $rodo->getRasa()->getName(),
            'nomwets' => $nomwets->allOfWetka($wetka->getId()->getValue()),
        ]);
    }


    /**
     * @Route("/create", name=".create")
     * @param Wetka $wetka
	 * @param NomWetFetcher $nomwets
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(Wetka $wetka, NomWetFetcher $nomwets, Request $request, Create\Handler $handler): Response
   {
//       dd($linia);
       $maxSort = $nomwets->getMaxSortNomWet($wetka->getId()->getValue()) + 1;

       $command = Create\Command::fromWetka($wetka, $maxSort);// заполнение  значениями из Rasa

        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('drevos.rass.rods.linis.wetkas.nomwets.show', ['id' => $wetka->getId(), 'nomwet_id'=>$command->id]);

            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }
        $linia = $wetka->getLinia();
        $rodo =  $linia->getRodo();

        return $this->render('app/drevos/rass/rods/linis/wetkas/nomwets/create.html.twig', [
            'linia' => $linia,
            'wetka' => $wetka,
            'rodo' => $rodo,
            'stran' => $rodo->getStrana(),
            'rasa' => $rodo->getRasa()->getName(),
            'form' => $form->createView(),
            'nomwets' => $wetka->getNomWets(),
        ]);
   }

    /**
     * @Route("/{nomwet_id}/edit", name=".edit")
     * @param Wetka $wetka
     * @param string $nomwet_id
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(Request $request,Wetka $wetka, string $nomwet_id,  Edit\Handler $handler): Response
    {
        //$this->denyAccessUnlessGranted(MateriAccess::MANAGE_MEMBERS, $materi);

        $nomwet = $wetka->getNomWet(new Id($nomwet_id));

        $command = Edit\Command::fromWetka($wetka, $nomwet);


        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('drevos.rass.rods.linis.wetkas.nomwets.show',	['id' => $wetka->getId(), 'nomwet_id' => $nomwet_id]);


            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/drevos/rass/rods/linis/wetkas/nomwets/edit.html.twig', [
            'nomwet' => $nomwet,
            'wetka' => $wetka,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{nomwet_id}/delete", name=".delete", methods={"POST"})
     * @param Wetka $wetka
     * @param string $nomwet_id
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(Wetka $wetka, string $nomwet_id, Request $request, Remove\Handler $handler): Response
    {
        //$this->denyAccessUnlessGranted(MateriAccess::MANAGE_MEMBERS, $materi);

        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('drevos.rass.rods.linis.wetkas.nomwets', ['id' => $wetka->getId()]);
        }

        $nomwet = $wetka->getNomWet(new Id($nomwet_id));

        $command = new Remove\Command($wetka->getId()->getValue(), $nomwet->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('drevos.rass.rods.linis.wetkas.nomwets',
					['id' => $wetka->getId()]);
    }

    /**
     * @Route("/show/{nomwet_id}", name=".show", requirements={"nomwet_id"=Guid::PATTERN})
     * @param string $nomwet_id
     * @param Request $request
     * @param Wetka $wetka
     * @return Response
     */
    public function show(Request $request, Wetka $wetka, string $nomwet_id): Response
    {
        $nomwet = $wetka->getNomWet(new Id($nomwet_id));
        $wetka = $nomwet->getWetka();
        $linia = $wetka->getLinia();
        $rodo = $linia->getRodo();

        return $this->render('app/drevos/rass/rods/linis/wetkas/nomwets/show.html.twig', [
            'nomwet' => $nomwet,
            'wetka' => $wetka,
            'rodo' => $rodo,
            'linia'=>$linia,
            'stran' => $rodo->getStrana(),
            'rasa' => $rodo->getRasa(),

        ]);
    }
}
