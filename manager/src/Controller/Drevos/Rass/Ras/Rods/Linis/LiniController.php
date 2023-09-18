<?php

declare(strict_types=1);

namespace App\Controller\Drevos\Rass\Ras\Rods\Linis;

use App\Annotation\Guid;

use App\Model\Drevos\Entity\Strans\StranRepository;
use App\Model\Drevos\UseCase\Rass\Rods\Linis\Create;
use App\Model\Drevos\UseCase\Rass\Rods\Linis\Edit;
use App\Model\Drevos\UseCase\Rass\Rods\Linis\Remove;

//use App\Security\Voter\Adminka\Rasas\MateriAccess;
use App\Controller\ErrorHandler;
use App\Model\Drevos\Entity\Rass\Rods\Rod;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Id;
use App\ReadModel\Drevos\Rass\Rods\Linis\LiniFetcher;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/drevos/rass/rods/{id}linis", name="drevos.rass.rods.linis")
 */
class LiniController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }


    /**
     * @Route("", name="")
     * @param Rod $rodo
     * @param Request $request
     * @param LiniFetcher $linias
     * @return Response
     */
    public function index( Request $request, Rod $rodo,  LiniFetcher $linias): Response
    {

        return $this->render('app/drevos/rass/rods/linis/index.html.twig', [
            'rodo' => $rodo,
            'stran' => $rodo->getStrana(),
            'rasa' => $rodo->getRasa()->getName(),
            'linias' => $linias->allOfRodo($rodo->getId()->getValue()),
        ]);
    }


    /**
     * @Route("/create", name=".create")
     * @param Rod $rodo
	 * @param LiniFetcher $linias
     * @param StranRepository  $stranRepo
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(Request $request, Rod $rodo, LiniFetcher $linias, StranRepository  $stranRepo, Create\Handler $handler): Response
   {

       $maxSort = $linias->getMaxSortLinia($rodo->getId()->getValue()) + 1;

       $command = Create\Command::fromRodo($rodo, $maxSort);// заполнение  значениями из Rasa

        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('drevos.rass.rods.linis.show', ['id' => $rodo->getId(), 'linia_id' => $command->id ]);

            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }
//        dd("что-то  не так");
        return $this->render('app/drevos/rass/rods/linis/create.html.twig', [
            'rodo' => $rodo,
            'rasa' => $rodo->getRasa()->getTitle(),
            'stran' => $rodo->getStrana(),
            'form' => $form->createView(),

        ]);
   }

    /**
     * @Route("/{linia_id}/edit", name=".edit")
     * @param Rod $rodo
     * @param string $linia_id
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(Request $request,Rod $rodo, string $linia_id,  Edit\Handler $handler): Response
    {
        //$this->denyAccessUnlessGranted(MateriAccess::MANAGE_MEMBERS, $materi);

        $linia = $rodo->getLinia(new Id($linia_id));

        $command = Edit\Command::fromLinia($rodo, $linia);


        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('drevos.rass.rods.linis.show',	['id' => $rodo->getId(), 'linia_id' => $linia_id]);


            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/drevos/rass/rods/linis/edit.html.twig', [
            'rodo' => $rodo,
            'linia' => $linia,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{linia_id}/delete", name=".delete", methods={"POST"})
     * @param Rod $rodo
     * @param string $linia_id
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(Rod $rodo, string $linia_id, Request $request, Remove\Handler $handler): Response
    {
        //$this->denyAccessUnlessGranted(MateriAccess::MANAGE_MEMBERS, $materi);

        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('drevos.rass.rods.linis', ['id' => $rodo->getId()]);
        }

        $linia = $rodo->getLinia(new Id($linia_id));

        $command = new Remove\Command($rodo->getId()->getValue(), $linia->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('drevos.rass.rods.linis',
					['id' => $rodo->getId()]);
    }

    /**
     * @Route("/show/{linia_id}", name=".show", requirements={"linia_id"=Guid::PATTERN})
     * @param string $linia_id
     * @param Request $request
     * @param Rod $rodo
     * @return Response
     */
    public function show(Request $request,Rod $rodo,string $linia_id): Response
    {
        $linia = $rodo->getLinia(new Id($linia_id));

        return $this->render('app/drevos/rass/rods/linis/show.html.twig', [
            'rodo' => $rodo,
             'linia'=>$linia,
            'stran' => $rodo->getStrana(),
            'rasa' => $rodo->getRasa(),

        ]);
    }
}
