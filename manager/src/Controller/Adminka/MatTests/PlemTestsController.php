<?php

declare(strict_types=1);

namespace App\Controller\Adminka\MatTests;

use App\Annotation\Guid;

use App\Model\Adminka\Entity\Matkas\ChildMatka\ChildMatka;
use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatka;
use App\ReadModel\Adminka\MatTests\PlemTest\Filter;

use App\Model\Adminka\UseCase\MatTests\PlemTest\Create;
use App\Model\Adminka\UseCase\MatTests\PlemTest\Remove;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\ReadModel\Adminka\MatTests\PlemTest\PlemTestFetcher;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/adminka/mattests", name="adminka.mattests")
 */
class PlemTestsController extends AbstractController
{
    private const PER_PAGE = 50;

    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("", name="")
     * @param Request $request
     * @param PlemTestFetcher $fetcher
     * @return Response
     */
    public function index(Request $request, PlemTestFetcher $fetcher): Response
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
            $request->query->get('sort', 'name'),
            $request->query->get('direction', 'asc')
        );

        return $this->render('app/adminka/mattests/index.html.twig', [
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/create/{childmatka_id}", name=".create", requirements={"id"=Guid::PATTERN})
     * @ParamConverter("childmatka", options={"id" = "childmatka_id"})
     * @param Request $request
//     * @param NomerRepository $nomers
     * @param ChildMatka $childmatka
//     * @param MestoNomerRepository $mestonomers
//     * @param string $id
     * @param PlemTestFetcher $plemtests
     * @param Create\Handler $handler
     * @return Response
     */
    public function create( Request $request,
                            ChildMatka $childmatka,
                           PlemTestFetcher $plemtests,
//                           PersonaRepository $personas,
//                           MestoNomerRepository $mestonomers,
//                           NomerRepository $nomers,
                           Create\Handler $handler): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMINKA_MANAGE_PLEMMATKAS');

//        if (!$plemtests->existsPerson($this->getUser()->getId())) {
//            $this->addFlash('error', 'Начните с выбора ПерсонНомера ');
//            return $this->redirectToRoute('adminka.uchasties.personas.diapazon');
//        }

//        if (!$plemtests->existsMesto($this->getUser()->getId())) {
//            $this->addFlash('error', 'Пожалуйста, определитесь с номером места расположения Вашей пасеки ');
//            return $this->redirectToRoute('mesto.infamesto.okrugs');
//        }

//        $nomer = $nomers->get(new Id($id));

//        $uchastieId =  $this->getUser()->getId();
//        $persona = $personas->get(new PersonaId($uchastieId));
//        $mestonomer = $mestonomers->get(new MestoNomerId($uchastieId));



        if ($plemtests->exists($childmatka->getId()->getValue())) {
            $this->addFlash('error', 'маточка есть  в списке на тест..');
            return $this->redirectToRoute('adminka.mattests' );
//                , ['id' => $user->getId()]);
        }

//        dd($childmatka);
          $command = new Create\Command($childmatka->getId()->getValue());
        $command->name = $childmatka->getName();

         $command->star_linia = $childmatka->getPlemMatka()->getNomer()->getLinia()->getNameStar();
        $command->star_nomer = $childmatka->getPlemMatka()->getNomer()->getNameStar();
         $command->goda_vixod = $childmatka->getPlemMatka()->getGodaVixod();
         $command->title = $childmatka->getPlemMatka()->getTitle();


        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);



//        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('adminka.mattests');
            } catch (\DomainException $e) {
                $this->logger->warning($e->getMessage(), ['exception' => $e]);
                $this->addFlash('error', $e->getMessage());
            }
//        }

        return $this->render('app/adminka/mattests/create.html.twig', [
//            'form' => $form->createView(),
            'command' => $command,
        ]);
    }

    /**
     * @Route("/{id}/delete", name=".delete", methods={"POST"})
     * @param PlemMatka $plemtest
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(PlemMatka $plemtest, Request $request, Remove\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('adminka.mattests');
        }

        $command = new Remove\Command($plemtest->getId()->getValue());

        try {
            $handler->handle($command);
            return $this->redirectToRoute('adminka.mattests');
        } catch (\DomainException $e) {
            $this->logger->warning($e->getMessage(), ['exception' => $e]);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('adminka.mattests');
    }

}