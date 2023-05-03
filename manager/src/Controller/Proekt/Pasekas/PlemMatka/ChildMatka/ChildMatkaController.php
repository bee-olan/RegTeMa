<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\PlemMatka\ChildMatka;

use App\Annotation\Guid;

use App\Model\Adminka\Entity\Matkas\PlemMatka\Department\Id;
use App\Model\Adminka\UseCase\Matkas\ChildMatka\Create;

use App\ReadModel\Adminka\Matkas\ChildMatka\Filter;
use App\ReadModel\Adminka\Matkas\ChildMatka\ChildMatkaFetcher;

use App\Controller\ErrorHandler;
use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatka;
use App\ReadModel\Proekt\Pasekas\PlemMatka\Side\PlemSideFetcher;
use App\Security\Voter\Adminka\Matkas\PlemMatkaAccess;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("proekt/pasekas/matkas/plemmatkas/{plemmatka_id}/childmatka", name="proekt.pasekas.matkas.plemmatkas.childmatka")
 * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
 */
class ChildMatkaController extends AbstractController
{
    private const PER_PAGE = 50;

    private $childmatkas;
    private $errors;

    public function __construct(ChildMatkaFetcher $childmatkas, ErrorHandler $errors)
    {
        $this->childmatkas = $childmatkas;
        $this->errors = $errors;
    }
// страничка конкретной  задачи
    /**
     * @Route("", name="")
     * @param PlemMatka $plemmatka
     * @param Request $request
     * @return Response
     */
    public function index(PlemMatka $plemmatka, Request $request): Response
    {
        $this->denyAccessUnlessGranted(PlemMatkaAccess::VIEW, $plemmatka);

        $filter = Filter\Filter::forPlemMatka($plemmatka->getId()->getValue());

        $form = $this->createForm(Filter\Form::class, $filter);

        $form->handleRequest($request);


        $pagination = $this->childmatkas->all(
            $filter,
            $request->query->getInt('page', 1),
            self::PER_PAGE,
            $request->query->get('sort', 't.date'),
            $request->query->get('direction', 'desc')
        );

        return $this->render('proekt/pasekas/childmatkas/index.html.twig', [
            'plemmatka' => $plemmatka,
            'sezons' => $plemmatka->getDepartments(),
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }
///////////////////////////////////////
    /**
     * @Route("/me", name=".me")
     * @param PlemMatka $plemmatka
     * @param Request $request
     * @return Response
     */
    public function me(PlemMatka $plemmatka, Request $request): Response
    {
//        $this->denyAccessUnlessGranted(PlemMatkaAccess::VIEW, $plemmatka);

        $filter = Filter\Filter::forPlemMatka($plemmatka->getId()->getValue());

        $form = $this->createForm(Filter\Form::class, $filter, [
            'action' => $this->generateUrl('proekt.paekas.matkas.plemmatkas.childmatkas', ['plemmatka_id' => $plemmatka->getId()]),
        ]);
        $form = $this->createForm(Filter\Form::class, $filter);
        $form->handleRequest($request);

        $pagination = $this->childmatkas->all(
            $filter->forExecutor($this->getUser()->getId()),
            $request->query->getInt('page', 1),
            self::PER_PAGE,
            $request->query->get('sort', 't.date'),
            $request->query->get('direction', 'desc')
        );

        return $this->render('proekt/pasekas/childmatkas/index.html.twig', [
            'plemmatka' => $plemmatka,
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/own", name=".own")
     * @param PlemMatka $plemmatka
     * @param Request $request
     * @return Response
     */
    public function own(PlemMatka $plemmatka, Request $request): Response
    {
//        $this->denyAccessUnlessGranted(PlemMatkaAccess::VIEW, $plemmatka);

        $filter = Filter\Filter::forPlemMatka($plemmatka->getId()->getValue());

        $form = $this->createForm(Filter\Form::class, $filter, [
        'action' => $this->generateUrl('proekt.paekas.matkas.plemmatkas.childmatkas', ['plemmatka_id' => $plemmatka->getId()]),
        ]);

        $form->handleRequest($request);

        $pagination = $this->childmatkas->all(
            $filter->forAuthor($this->getUser()->getId()),
            $request->query->getInt('page', 1),
            self::PER_PAGE,
            $request->query->get('sort'),
            $request->query->get('direction')
        );

        return $this->render('proekt/pasekas/childmatkas/index.html.twig', [
            'plemmatka' => $plemmatka,
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }
/////////////////////////////
    /**
     * @Route("/{department_id}/create", name=".create")
     * @param PlemMatka $plemmatka
     * @param string $department_id
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(Request $request, PlemMatka $plemmatka, string $department_id, Create\Handler $handler): Response
    {
        $this->denyAccessUnlessGranted(PlemMatkaAccess::VIEW, $plemmatka);

        $sezonPlem = $plemmatka->getDepartment(new Id($department_id))->getName();

        $command = new Create\Command(
            $plemmatka->getId()->getValue(),
            $this->getUser()->getId(),
            $plemmatka->getDepartment(new Id($department_id))->getName()
        );

        if ($parent = $request->query->get('parent')) {
            $command->parent = $parent;
        }

        $form = $this->createForm(Create\Form::class, $command, ['rasa_id' => $plemmatka->getNomer()->getLinia()->getRasa()->getId()->getValue()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('proekt.pasekas.childmatkas');
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('proekt/pasekas/matkas/plemmatkas/childmatka/create.html.twig', [
            'plemmatka' => $plemmatka,
            'sezonPlem' => $sezonPlem,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show", name=".show", requirements={"id"=Guid::PATTERN})
     * @param PlemMatka $plemmatka
     * @param Request $request
     * @return Response
     */
    public function show(PlemMatka $plemmatka,
                         Request $request ): Response
    {
//dd($plemmatka);
//        $this->denyAccessUnlessGranted(PlemMatkaAccess::EDIT, $plemmatka);
        // $commentCommand = new Comment\AddSezon\Command(
        //     $this->getUser()->getId(),
        //     PlemMatka::class,
        //     $plemmatka->getId()->getValue()
        // );

        // $commentForm = $this->createForm(Comment\AddSezon\Form::class, $commentCommand);
        // $commentForm->handleRequest($request);
        // if ($commentForm->isSubmitted() && $commentForm->isValid()) {
        //     try {
        //         $commentHandler->handle($commentCommand);
        //         return $this->redirectToRoute('proekt.pasekas.matkas.plemmatkas.redaktorss.show', ['plemmatka_id' => $plemmatka->getId()]);
        //     } catch (\DomainException $e) {
        //         $this->errors->handle($e);
        //         $this->addFlash('error', $e->getMessage());
        //     }
        // }
        return $this->render('proekt/pasekas/matkas/plemmatkas/childmatka/show.html.twig', [
            'plemmatka' => $plemmatka,
            'uchastniks' => $plemmatka->getUchastniks(),
            // 'comments' => $comments->allForPlemMatka($plemmatka->getId()->getValue()),
            // 'commentForm' => $commentForm->createView(),

        ]);
    }
}
