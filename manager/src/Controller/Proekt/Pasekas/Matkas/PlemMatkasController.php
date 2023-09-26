<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\Matkas;

use App\Annotation\Guid;

use App\Controller\ErrorHandler;


use App\ReadModel\Proekt\Pasekas\PlemMatka\Side\Filter;
use App\ReadModel\Proekt\Pasekas\PlemMatka\Side\PlemSideFetcher;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/proekts/pasekas/matkas", name="app.proekts.pasekas.matkas")
 */
class PlemMatkasController extends AbstractController
{
    private const PER_PAGE = 10;

    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("", name="")
     * @param Request $request
     * @param PlemSideFetcher $fetcher
     * @return Response
     */
    public function index(Request $request, PlemSideFetcher $fetcher): Response
    {

        if ($this->isGranted('ROLE_ADMINKA_MANAGE_PLEMMATKAS')) {
            $filter = Filter\Filter::all();

        } else {
            $filter = Filter\Filter::forUchastie($this->getUser()->getId());

        }

        $form = $this->createForm(Filter\Form::class, $filter);
        $form->handleRequest($request);

        $pagination = $fetcher->all(
            $filter,
            $request->query->getInt('page', 1),
            self::PER_PAGE,
            $request->query->get('sort', 'name', 'persona'),
            $request->query->get('direction', 'asc')
        );

        if (!$pagination->getItems() ) {
            $this->addFlash('error', 'Внимание!!!  У Вас нет зарегистрированных или Активных ПлемМаток. Сейчас Вы на страничке для регистрации');
            return $this->redirectToRoute('app.proekts.pasekas.matkas.plemmatkas.creates');
        }
        return $this->render('app/proekts/pasekas/matkas/index.html.twig', [
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }


}