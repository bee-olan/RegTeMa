<?php


namespace App\Controller\Adminka\Matkas;

use App\Model\Comment\UseCase\Comment;
use App\Model\Adminka\UseCase\Matkas\ChildMatka\Executor;

use App\Model\Adminka\UseCase\Matkas\ChildMatka\Plan;

use App\ReadModel\Adminka\Matkas\ChildMatka\ChildMatkaFetcher;

use App\ReadModel\Adminka\Matkas\ChildMatka\Filter;


use App\Controller\ErrorHandler;
use App\Security\Voter\Adminka\Matkas\ChildMatkaAccess;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/adminka/matkas/childmatkas", name="adminka.matkas.childmatkas")
 * @param Request $request
 * @param ChildMatkaFetcher $childmatkas
 * @return Response
 */
class ChildMeOwnController extends AbstractController
{
    private const PER_PAGE = 50;

    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("/me", name=".me")
     * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
     * @param Request $request
     * @param ChildMatkaFetcher $childmatkas
     * @return Response
     */
    public function me(Request $request, ChildMatkaFetcher $childmatkas): Response
    {
        $filter = Filter\Filter::all();

        $form = $this->createForm(Filter\Form::class, $filter, [
            'action' => $this->generateUrl('adminka.matkas.childmatkas'),
        ]);

        $form->handleRequest($request);

        $pagination = $childmatkas->all(
            $filter->forExecutor($this->getUser()->getId()),
            $request->query->getInt('page', 1),
            self::PER_PAGE,
            $request->query->get('sort', 't.id'),
            $request->query->get('direction', 'desc')
        );

        return $this->render('app/adminka/matkas/childmatkas/index.html.twig', [
            'plemmatka' => null,
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/own", name=".own")
     * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
     * @param Request $request
     * @param ChildMatkaFetcher $childmatkas
     * @return Response
     */
    public function own(Request $request, ChildMatkaFetcher $childmatkas): Response
    {
        $filter = Filter\Filter::all();

        $form = $this->createForm(Filter\Form::class, $filter, [
            'action' => $this->generateUrl('adminka.matkas.childmatkas'),
        ]);

        $form->handleRequest($request);

        $pagination = $childmatkas->all(
            $filter->forAuthor($this->getUser()->getId()),
            $request->query->getInt('page', 1),
            self::PER_PAGE,
            $request->query->get('sort', 't.id'),
            $request->query->get('direction', 'desc')
        );

        return $this->render('app/adminka/matkas/childmatkas/index.html.twig', [
            'plemmatka' => null,
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }

}