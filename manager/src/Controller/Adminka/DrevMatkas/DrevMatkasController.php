<?php

declare(strict_types=1);

namespace App\Controller\Adminka\DrevMatkas;

use App\Annotation\Guid;

use App\Controller\ErrorHandler;
use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatka;


//use App\Model\Adminka\UseCase\Matkas\PlemMatka\Create;
use App\Model\Adminka\UseCase\DrevMatkas\DrevMatka\Remove;
use App\ReadModel\Adminka\DrevMatkas\DrevMatkaFetcher;
//use App\ReadModel\Adminka\Matkas\PlemMatka\Filter;
use App\ReadModel\Adminka\DrevMatkas\Filter;
use App\ReadModel\Adminka\Matkas\PlemMatka\PlemMatkaFetcher;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/adminka/drevmatkas", name="adminka.drevmatkas")
 */
class DrevMatkasController extends AbstractController
{
    private const PER_PAGE = 50;

    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("", name="")
     * @param Request $request
     * @param DrevMatkaFetcher $fetcher
     * @return Response
     */
    public function index(Request $request, DrevMatkaFetcher $fetcher): Response
    {
//        $filter = new Filter\Filter();

//        if ($this->isGranted('ROLE_ADMINKA_MANAGE_PLEMMATKAS')) {
            $filter = Filter\Filter::allPagin();
//        } else {
//            $filter = Filter\Filter::forUchastie($this->getUser()->getId());
//        }

        $form = $this->createForm(Filter\Form::class, $filter);
        $form->handleRequest($request);

        $pagination = $fetcher->allPagin(
            $filter,
            $request->query->getInt('page', 1),
            self::PER_PAGE,
            $request->query->get('sort', 'name'),
            $request->query->get('direction', 'asc')
        );

        return $this->render('app/adminka/drevmatkas/index.html.twig', [
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}/delete", name=".delete", methods={"POST"})
     * @param PlemMatka $plemmatka
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(PlemMatka $plemmatka, Request $request, Remove\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('adminka.drevmatkas');
        }

        $command = new Remove\Command($plemmatka->getId()->getValue());

        try {
            $handler->handle($command);
            return $this->redirectToRoute('adminka.drevmatkas');
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('adminka.drevmatkas');
    }

}