<?php

declare(strict_types=1);

namespace App\Controller\Paseka\Rasas;

use App\Model\Paseka\UseCase\Rasas\Rasa\Create;

use App\ReadModel\Paseka\Rasas\Rasa\Filter;
use App\ReadModel\Paseka\Rasas\Rasa\RasaFetcher;

use App\Controller\ErrorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/paseka/rasas", name="paseka.rasas")
 */
class RasasController extends AbstractController
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
     * @param RasaFetcher $fetcher
     * @return Response
     */
    public function index(Request $request, RasaFetcher $fetcher): Response
    {
        if ($this->isGranted('ROLE_WORK_MANAGE_PROJECTS')) {
            $filter = Filter\Filter::all();
        } else {
            $filter = Filter\Filter::forPchelowod($this->getUser()->getId());
        }

        $form = $this->createForm(Filter\Form::class, $filter);
        $form->handleRequest($request);

        $pagination = $fetcher->all(
            $filter,
            $request->query->getInt('page', 1),
            self::PER_PAGE,
            $request->query->get('sort', 'name'),
            $request->query->get('direction', 'asc')
        );

        return $this->render('app/paseka/rasas/index.html.twig', [
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/create", name=".create")
     * @param Request $request
     * @param RasaFetcher $rasas
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(Request $request, RasaFetcher $rasas, Create\Handler $handler): Response
    {
        $this->denyAccessUnlessGranted('ROLE_WORK_MANAGE_PROJECTS');

        $command = new Create\Command();
        $command->sort = $rasas->getMaxSort() + 1;

        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('paseka.rasas');
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/paseka/rasas/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
