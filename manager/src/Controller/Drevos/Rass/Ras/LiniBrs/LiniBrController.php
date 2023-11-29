<?php

declare(strict_types=1);

namespace App\Controller\Drevos\Rass\Ras\LiniBrs;

use App\Annotation\Guid;

use App\Model\Drevos\UseCase\Rass\LiniBrs\Create;
use App\Model\Drevos\UseCase\Rass\LiniBrs\Edit;
use App\Model\Drevos\UseCase\Rass\LiniBrs\Remove;
use App\Model\Drevos\Entity\Rass\LiniBr\Id ;
use App\Controller\ErrorHandler;
use App\Model\Drevos\Entity\Rass\Ras;
use App\ReadModel\Drevos\Rass\LiniBrs\LiniBrFetcher;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/drevos/rass/{id}/linibrs", name="drevos.rass.linibrs")
 */
class LiniBrController extends AbstractController
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
     * @param LiniBrFetcher $linias
     * @return Response
     */
    public function index( Ras $rasa, Request $request,  LiniBrFetcher $linias): Response
    {
        //$this->denyAccessUnlessGranted(MateriAccess::MANAGE_MEMBERS, $materi);
//dd($linias->allOfRas($rasa->getId()->getValue()));
        return $this->render('app/drevos/rass/linibrs/index.html.twig', [
            'rasa' => $rasa,
            'linias' => $linias->allOfRas($rasa->getId()->getValue()),
        ]);
    }

    /**
     * @Route("/plemmatka", name=".plemmatka")
     * @param Ras $rasa
     * @param Request $request
     * @param LiniBrFetcher $linias
     * @return Response
     */
    public function plemmatka( Ras $rasa, Request $request,  LiniBrFetcher $linias ): Response
    {
//        dd( $linias->allOfRas($rasa->getId()->getValue()));

        return $this->render('app/drevos/rass/linibrs/plemmatka.html.twig', [
            'rasa' => $rasa,
            'linias' => $linias->allOfRas($rasa->getId()->getValue()),
        ]);
    }

    /**
     * @Route("/create", name=".create")
     * @param Ras $rasa
	 * @param LiniBrFetcher $linias
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(Ras $rasa, LiniBrFetcher $linias, Request $request, Create\Handler $handler): Response
   {
       $maxSort = $linias->getMaxSortLiniBr($rasa->getId()->getValue()) + 1;

       $command = Create\Command::fromRas($rasa, $maxSort);// заполнение  значениями из Ras

        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);
//dd($command);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('drevos.rass.linibrs', ['id' => $rasa->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }
        return $this->render('app/drevos/rass/linibrs/create.html.twig', [
            'rasa' => $rasa,
            'form' => $form->createView(),
//            'name' => $command->title,
        ]);
   }

    /**
     * @Route("/{linia_id}/edit", name=".edit")
     * @param Ras $rasa
     * @param string $linia_id
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(Request $request,Ras $rasa, string $linia_id,  Edit\Handler $handler): Response
    {
        //$this->denyAccessUnlessGranted(MateriAccess::MANAGE_MEMBERS, $materi);

        $linia = $rasa->getLinia(new Id($linia_id));

        $command = Edit\Command::fromLiniBr($rasa, $linia);


        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
//                $command->title = $rasa->getName();
//                $command->title = $command->title."_".$command->name;
//                 dd($command->title);
                $handler->handle($command);
                return $this->redirectToRoute('drevos.rass.linibrs.show',
                    [ 'id' => $rasa->getId()]);
//									['id' => $rasa->getId(), 'linia_id' => $linia_id]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/drevos/rass/linibrs/edit.html.twig', [
            'rasa' => $rasa,
            'linia' => $linia,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{linia_id}/delete", name=".delete", methods={"POST"})
     * @param Ras $rasa
     * @param string $linia_id
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(Ras $rasa, string $linia_id, Request $request, Remove\Handler $handler): Response
    {
        //$this->denyAccessUnlessGranted(MateriAccess::MANAGE_MEMBERS, $materi);

        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('drevos.rass.linibrs', ['id' => $rasa->getId()]);
        }

        $linia = $rasa->getLinia(new Id($linia_id));

        $command = new Remove\Command($rasa->getId()->getValue(), $linia->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('drevos.rass.linibrs',
					['id' => $rasa->getId()]);
    }
//, requirements={"linia_id"=Guid::PATTERN}
    /**
     * @Route("/show", name=".show")
     * @param Ras $rasa
     * @return Response
     */
    public function show(Ras $rasa): Response
    {
        return $this->redirectToRoute('drevos.rass.linibrs',
				['id' => $rasa->getId()]);
    }
}
