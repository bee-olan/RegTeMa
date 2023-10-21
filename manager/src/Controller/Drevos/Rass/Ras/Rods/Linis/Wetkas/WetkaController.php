<?php

declare(strict_types=1);

namespace App\Controller\Drevos\Rass\Ras\Rods\Linis\Wetkas;

use App\Annotation\Guid;

use App\Model\Drevos\Entity\Rass\Rods\Linis\Lini;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\Id;
use App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\Create;
use App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\Edit;
use App\Model\Drevos\UseCase\Rass\Rods\Linis\Wetkas\Remove;

//use App\Security\Voter\Adminka\Rasas\MateriAccess;
use App\Controller\ErrorHandler;
use App\ReadModel\Drevos\Rass\Rods\Linis\Wetkas\WetkaFetcher;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/drevos/rass/rods/linis/{id}/wetkas", name="drevos.rass.rods.linis.wetkas")
 */
class WetkaController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }


    /**
     * @Route("", name="")
     * @param Lini $linia
     * @param Request $request
     * @param WetkaFetcher $wetkas
     * @return Response
     */
    public function index( Request $request, Lini $linia,  WetkaFetcher $wetkas): Response
    {
        $rodo = $linia->getRodo();
        return $this->render('app/drevos/rass/rods/linis/wetkas/index.html.twig', [
            'linia' => $linia,
            'rodo' => $rodo,
            'rasa' => $rodo->getRasa()->getTitle(),
            'stran' => $rodo->getStrana(),
            'wetkas' => $wetkas->allOfLinia($linia->getId()->getValue()),
        ]);
    }


    /**
     * @Route("/create", name=".create")
     * @param Lini $linia
	 * @param WetkaFetcher $wetkas
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(Lini $linia, WetkaFetcher $wetkas, Request $request, Create\Handler $handler): Response
   {
//       dd($linia);
       $maxSort = $wetkas->getMaxSortWetka($linia->getId()->getValue()) + 1;

       $command = Create\Command::fromLinia($linia, $maxSort);// заполнение  значениями из Rasa

        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('drevos.rass.rods.linis.wetkas.show', ['id' => $linia->getId(), 'wetka_id'=>$command->id ]);

            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }
        $rodo = $linia->getRodo();

        return $this->render('app/drevos/rass/rods/linis/wetkas/create.html.twig', [
            'linia' => $linia,
            'rodo' => $rodo,
            'rasa' => $rodo->getRasa()->getTitle(),
            'stran' => $rodo->getStrana(),
            'form' => $form->createView(),
            'wetkas' => $linia->getWetkas(),
        ]);
   }

    /**
     * @Route("/{wetka_id}/edit", name=".edit")
     * @param Lini $linia
     * @param string $wetka_id
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(Request $request, Lini $linia, string $wetka_id,  Edit\Handler $handler): Response
    {
        //$this->denyAccessUnlessGranted(MateriAccess::MANAGE_MEMBERS, $materi);

        $wetka = $linia->getWetka(new Id($wetka_id));

        $command = Edit\Command::fromLinia($linia, $wetka);


        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('drevos.rass.rods.linis.wetkas.show',	['id' => $linia->getId(), 'wetka_id' => $wetka_id]);


            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/drevos/rass/rods/linis/wetkas/edit.html.twig', [
            'wetka' => $wetka,
            'linia' => $linia,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{wetka_id}/delete", name=".delete", methods={"POST"})
     * @param Lini $linia
     * @param string $wetka_id
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(Lini $linia, string $wetka_id, Request $request, Remove\Handler $handler): Response
    {
        //$this->denyAccessUnlessGranted(MateriAccess::MANAGE_MEMBERS, $materi);

        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('drevos.rass.rods.linis.wetkas', ['id' => $linia->getId()]);
        }

        $wetka = $linia->getWetka(new Id($wetka_id));

        $command = new Remove\Command($linia->getId()->getValue(), $wetka->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('drevos.rass.rods.linis.wetkas',
					['id' => $linia->getId()]);
    }

    /**
     * @Route("/show/{wetka_id}", name=".show", requirements={"wetka_id"=Guid::PATTERN})
     * @param string $wetka_id
     * @param Request $request
     * @param Lini $linia
     * @return Response
     */
    public function show(Request $request, Lini $linia, string $wetka_id): Response
    {
        $wetka  = $linia->getWetka(new Id($wetka_id));
        $rodo = $linia->getRodo();
        return $this->render('app/drevos/rass/rods/linis/wetkas/show.html.twig', [
            'wetka' => $wetka,
            'rodo' => $rodo,
            'linia'=>$linia,
            'stran' => $rodo->getStrana(),
            'rasa' => $rodo->getRasa(),

        ]);
    }
}