<?php

declare(strict_types=1);

namespace App\Controller\Adminka\Matkas;

use App\Annotation\Guid;

use App\Controller\ErrorHandler;
use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatka;


use App\Model\Adminka\UseCase\Matkas\PlemMatka\Create;
use App\Model\Adminka\UseCase\Matkas\PlemMatka\Remove;
use App\ReadModel\Adminka\Matkas\PlemMatka\Filter;

use App\ReadModel\Adminka\Matkas\PlemMatka\PlemMatkaFetcher;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/adminka/matkas", name="adminka.matkas")
 */
class PlemMatkasController extends AbstractController
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
     * @param PlemMatkaFetcher $fetcher
     * @return Response
     */
    public function index(Request $request, PlemMatkaFetcher $fetcher): Response
    {
//        $filter = new Filter\Filter();

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

        return $this->render('app/adminka/matkas/index.html.twig', [
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/create", name=".create")
     * @param Request $request
//     * @param NomerRepository $nomers
//     * @param PersonaRepository $personas
//     * @param MestoNomerRepository $mestonomers
//     * @param string $id
     * @param PlemMatkaFetcher $plemmatkas
     * @param Create\Handler $handler
     * @return Response
     */
    public function create( Request $request,
                           PlemMatkaFetcher $plemmatkas,
//                           PersonaRepository $personas,
//                           MestoNomerRepository $mestonomers,
//                           NomerRepository $nomers,
                           Create\Handler $handler): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMINKA_MANAGE_PLEMMATKAS');

//        if (!$plemmatkas->existsPerson($this->getUser()->getId())) {
//            $this->addFlash('error', 'Начните с выбора ПерсонНомера ');
//            return $this->redirectToRoute('adminka.uchasties.personas.diapazon');
//        }

//        if (!$plemmatkas->existsMesto($this->getUser()->getId())) {
//            $this->addFlash('error', 'Пожалуйста, определитесь с номером места расположения Вашей пасеки ');
//            return $this->redirectToRoute('mesto.infamesto.okrugs');
//        }

//        $nomer = $nomers->get(new Id($id));
       
        $uchastieId =  $this->getUser()->getId();
//        $persona = $personas->get(new PersonaId($uchastieId));
//        $mestonomer = $mestonomers->get(new MestoNomerId($uchastieId));

        $sort = $plemmatkas->getMaxSort() + 1;
        $command = new Create\Command($uchastieId, $sort );
        $command->sort = $sort;
//        $command->rasaNomId = $id;
//
//        $command->uchastieId = $uchastieId;
//
//        $command->persona = $persona->getNomer();
//

//
//        $command->mesto = $mestonomer->getNomer();
//
//        $command->name = $nomer->getTitle()." : ".$command->mesto."_пН-". $command->persona."_№".$command->sort;

        //dd($command);

        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('adminka.matkas');
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/adminka/matkas/create.html.twig', [
            'form' => $form->createView(),
            'command' => $command,
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
            return $this->redirectToRoute('adminka.matkas');
        }

        $command = new Remove\Command($plemmatka->getId()->getValue());

        try {
            $handler->handle($command);
            return $this->redirectToRoute('adminka.matkas');
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('adminka.matkas');
    }

}