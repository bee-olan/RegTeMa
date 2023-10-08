<?php

declare(strict_types=1);

namespace App\Controller\Drevos\Rass\Ras\Rods;

use App\Annotation\Guid;

use App\Model\Drevos\UseCase\Rass\Rods\Create;
use App\Model\Drevos\UseCase\Rass\Rods\Edit;
use App\Model\Drevos\UseCase\Rass\Rods\Remove;
use App\Model\Drevos\Entity\Rass\Rods\Id;

use App\Controller\ErrorHandler;
use App\Model\Drevos\Entity\Rass\Ras;
use App\ReadModel\Drevos\Rass\Rods\RodFetcher;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/drevos/rass/{id}/rods", name="drevos.rass.rods")
 */
class RodController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }


    /**
     * @Route("", name="")
     * @param Ras $rasa
     * @param Request $request
     * @param RodFetcher $rodos
     * @return Response
     */
    public function index( Ras $rasa, Request $request,  RodFetcher $rodos): Response
    {
        //$this->denyAccessUnlessGranted(MateriAccess::MANAGE_MEMBERS, $materi);
//dd($rodos->allOfRas($rasa->getId()->getValue()));
        return $this->render('app/drevos/rass/rods/index.html.twig', [
            'rasa' => $rasa,
            'rodos' => $rodos->allOfRasa($rasa->getId()->getValue()),
        ]);
    }


    /**
     * @Route("/create", name=".create")
     * @param Ras $rasa
	 * @param RodFetcher $rodos
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(Ras $rasa, RodFetcher $rodos, Request $request, Create\Handler $handler): Response
   {
       $maxSort = $rodos->getMaxSortRodo($rasa->getId()->getValue()) + 1;

       $command = Create\Command::fromRasa($rasa, $maxSort);// заполнение  значениями из Ras

        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('drevos.rass.rods.show', ['id' => $rasa->getId(), 'rodo_id' => $command->id ]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }
//       return $this->redirectToRoute('drevos.rass.rods.linias.create', ['id' => $rodId]);


        return $this->render('app/drevos/rass/rods/create.html.twig', [
            'rasa' => $rasa,
            'form' => $form->createView(),

        ]);
   }

    /**
     * @Route("/{rodo_id}/edit", name=".edit")
     * @param Ras $rasa
     * @param string $rodo_id
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(Request $request,Ras $rasa, string $rodo_id,  Edit\Handler $handler): Response
    {
        //$this->denyAccessUnlessGranted(MateriAccess::MANAGE_MEMBERS, $materi);

        $rodo = $rasa->getRodo(new Id($rodo_id));


        $command = Edit\Command::fromRodo($rasa, $rodo);


        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {

                $handler->handle($command);
                return $this->redirectToRoute('drevos.rass.rods.show', [ 'id' => $rodo_id]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/drevos/rass/rods/edit.html.twig', [
            'rasa' => $rasa,
            'rodo' => $rodo,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{rodo_id}/delete", name=".delete", methods={"POST"})
     * @param Ras $rasa
     * @param string $rodo_id
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(Ras $rasa, string $rodo_id, Request $request, Remove\Handler $handler): Response
    {
        //$this->denyAccessUnlessGranted(MateriAccess::MANAGE_MEMBERS, $materi);

        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('drevos.rass.rods', ['id' => $rasa->getId()]);
        }

        $rodo = $rasa->getRodo(new Id($rodo_id));

        $command = new Remove\Command($rasa->getId()->getValue(), $rodo->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('drevos.rass.rods',
					['id' => $rasa->getId()]);
    }

    /**
     * @Route("/{rodo_id}", name=".show", requirements={"rodo_id"=Guid::PATTERN})
     * @param string $rodo_id
     * @param Request $request
     * @param Ras $rasa
     * @return Response
     */
    public function show(Request $request,Ras $rasa, string $rodo_id): Response
    {
        $rodo = $rasa->getRodo(new Id($rodo_id));
        return $this->render('app/drevos/rass/rods/show.html.twig', [
            'rodo' => $rodo,
            'stran' => $rodo->getStrana(),
            'rasa' => $rodo->getRasa(),

        ]);
    }
}
