<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\DrevMatkas;

use App\Annotation\Guid;

use App\Controller\ErrorHandler;

use App\ReadModel\Proekt\Pasekas\DrevMatka\Filter;

use App\ReadModel\Proekt\Pasekas\DrevMatka\DrevPlemFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/proekts/pasekas/drevmatkas", name="app.proekts.pasekas.drevmatkas")
 */
class DrevMatkasController extends AbstractController
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
     * @param DrevPlemFetcher $fetcher
     * @return Response
     */
    public function index(Request $request, DrevPlemFetcher $fetcher): Response
    {

//        if ($this->isGranted('ROLE_ADMINKA_MANAGE_PLEMMATKAS')) {
            $filter = Filter\Filter::all();

//        } else {
//            $filter = Filter\Filter::forUchastie($this->getUser()->getId());
//
//        }

        $form = $this->createForm(Filter\Form::class, $filter);
        $form->handleRequest($request);

        $pagination = $fetcher->all(
            $filter,
            $request->query->getInt('page', 1),
            self::PER_PAGE,
            $request->query->get('sort', 'name'),
            $request->query->get('direction', 'asc')
        );
//        dd("тут");
//, 'persona'
        if (!$pagination->getItems() ) {
            $this->addFlash('error', 'Внимание!!!  У Вас нет зарегистрированных или Активных ПлемМаток. Сейчас Вы на страничке для регистрации');
            return $this->redirectToRoute('app.proekts.pasekas.matkas.plemmatkas.creates');
        }
        return $this->render('app/proekts/pasekas/drevmatkas/index.html.twig', [
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }


}