<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\DrevMatkas\ChildDrev;

use App\Annotation\Guid;

use App\Model\Adminka\Entity\DrevMatkas\DrevMatka\DrevMatka;

use App\Model\Adminka\Entity\DrevMatkas\DrevMatka\SezonDrev\Id;
use App\Model\Adminka\UseCase\DrevMatkas\ChildDrev\Create;

use App\ReadModel\Adminka\DrevMatkas\ChildDrevs\ChildDrevFetcher;
use App\ReadModel\Adminka\DrevMatkas\ChildDrevs\Filter;

use App\Controller\ErrorHandler;
use App\ReadModel\Proekt\Pasekas\PlemMatka\Side\PlemSideFetcher;
use App\Security\Voter\Adminka\Matkas\PlemMatkaAccess;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("app/proekts/pasekas/drevmatkas/{plemmatka_id}/childdrev", name="app.proekts.pasekas.drevmatkas.childdrev")
 * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
 */
class ChildDrevController extends AbstractController
{
    private const PER_PAGE = 50;

    private $childmatkas;
    private $errors;

    public function __construct(ChildDrevFetcher $childmatkas, ErrorHandler $errors)
    {
        $this->childmatkas = $childmatkas;
        $this->errors = $errors;
    }
// страничка конкретной  задачи
    /**
     * @Route("", name="")
     * @param DrevMatka $plemmatka
     * @param Request $request
     * @return Response
     */
    public function index(DrevMatka $plemmatka, Request $request): Response
    {
//        $this->denyAccessUnlessGranted(DrevMatkaAccess::VIEW, $plemmatka);

        $filter = Filter\Filter::forDrevMatka($plemmatka->getId()->getValue()) ;

        $form = $this->createForm(Filter\Form::class, $filter);

        $form->handleRequest($request);


        $pagination = $this->childmatkas->all(
            $filter,
            $request->query->getInt('page', 1),
            self::PER_PAGE,
            $request->query->get('sort', 't.date'),
            $request->query->get('direction', 'desc')
        );

        return $this->render('app/proekts/pasekas/childdrevs/index.html.twig', [
            'plemmatka' => $plemmatka,
            'sezons' => $plemmatka->getSezondrevs(),
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }
///////////////////////////////////////
    /**
     * @Route("/me", name=".me")
     * @param DrevMatka $plemmatka
     * @param Request $request
     * @return Response
     */
    public function me(DrevMatka $plemmatka, Request $request): Response
    {
//        $this->denyAccessUnlessGranted(DrevMatkaAccess::VIEW, $plemmatka);

        $filter = Filter\Filter::forDrevMatka($plemmatka->getId()->getValue());

        $form = $this->createForm(Filter\Form::class, $filter, [
            'action' => $this->generateUrl('app.proekts.paekas.drevmatkas.childdrev', ['plemmatka_id' => $plemmatka->getId()]),
        ]);
        $form = $this->createForm(Filter\Form::class, $filter);
        $form->handleRequest($request);

        $pagination = $this->childmatkas->all(
            $filter->forExecutor($this->getUser()->getId()) ,
            $request->query->getInt('page', 1),
            self::PER_PAGE,
            $request->query->get('sort', 't.date'),
            $request->query->get('direction', 'desc')
        );

        return $this->render('app/proekts/pasekas/childdrevs/index.html.twig', [
            'plemmatka' => $plemmatka,
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/own", name=".own")
     * @param DrevMatka $plemmatka
     * @param Request $request
     * @return Response
     */
    public function own(DrevMatka $plemmatka, Request $request): Response
    {
//        $this->denyAccessUnlessGranted(DrevMatkaAccess::VIEW, $plemmatka);

        $filter = Filter\Filter::forDrevMatka($plemmatka->getId()->getValue());

        $form = $this->createForm(Filter\Form::class, $filter, [
        'action' => $this->generateUrl('app.proekts.paekas.matkas.plemmatkas.childmatkas', ['plemmatka_id' => $plemmatka->getId()]),
        ]);

        $form->handleRequest($request);

        $pagination = $this->childmatkas->all(
            $filter->forAuthor($this->getUser()->getId()) ,
            $request->query->getInt('page', 1),
            self::PER_PAGE,
            $request->query->get('sort'),
            $request->query->get('direction')
        );

        return $this->render('app/proekts/pasekas/childdrevs/index.html.twig', [
            'plemmatka' => $plemmatka,
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }
/////////////////////////////
    /**
     * @Route("/{sezondrev_id}/create", name=".create")
     * @param DrevMatka $plemmatka
     * @param string $sezondrev_id
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(Request $request, DrevMatka $plemmatka, string $sezondrev_id, Create\Handler $handler): Response
    {
//        $this->denyAccessUnlessGranted(DrevMatkaAccess::VIEW, $plemmatka);

        $sezonPlem = $plemmatka->getSezondrev(new Id($sezondrev_id))->getName();

        $command = new Create\Command(
            $plemmatka->getId()->getValue(),
            $this->getUser()->getId(),
            $plemmatka->getSezondrev(new Id($sezondrev_id))->getName()
        );

        if ($parent = $request->query->get('parent')) {
            $command->parent = $parent;
        }
       $rasaId = $plemmatka->getNomer()->getMattrut()->getNomwet()->getWetka()->getLinia()->getRodo()->getRasa()->getId()->getValue();

        $form = $this->createForm(Create\Form::class, $command, ['rasa_id' => $rasaId]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('app.proekts.pasekas.childdrevs');
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/proekts/pasekas/drevmatkas/childdrev/create.html.twig', [
            'plemmatka' => $plemmatka,
            'sezonPlem' => $sezonPlem,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show", name=".show", requirements={"id"=Guid::PATTERN})
     * @param DrevMatka $plemmatka
     * @param Request $request
     * @return Response
     */
    public function show(DrevMatka $plemmatka,
                         Request $request ): Response
    {
//dd($plemmatka);
//        $this->denyAccessUnlessGranted(DrevMatkaAccess::EDIT, $plemmatka);
        // $commentCommand = new Comment\AddSezon\Command(
        //     $this->getUser()->getId(),
        //     DrevMatka::class,
        //     $plemmatka->getId()->getValue()
        // );

        // $commentForm = $this->createForm(Comment\AddSezon\Form::class, $commentCommand);
        // $commentForm->handleRequest($request);
        // if ($commentForm->isSubmitted() && $commentForm->isValid()) {
        //     try {
        //         $commentHandler->handle($commentCommand);
        //         return $this->redirectToRoute('app.proekts.pasekas.matkas.plemmatkas.redaktorss.show', ['plemmatka_id' => $plemmatka->getId()]);
        //     } catch (\DomainException $e) {
        //         $this->errors->handle($e);
        //         $this->addFlash('error', $e->getMessage());
        //     }
        // }
//        dd( $plemmatka->getUchastniks());
        return $this->render('app/proekts/pasekas/drevmatkas/childdrev/show.html.twig', [
            'plemmatka' => $plemmatka,
            'uchastniks' => $plemmatka->getUchasdrevs() ,
            // 'comments' => $comments->allForDrevMatka($plemmatka->getId()->getValue()),
            // 'commentForm' => $commentForm->createView(),

        ]);
    }
}
