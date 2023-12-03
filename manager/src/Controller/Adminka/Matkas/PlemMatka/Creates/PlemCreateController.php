<?php

declare(strict_types=1);

namespace App\Controller\Adminka\Matkas\PlemMatka\Creates;

use App\Annotation\Guid;

use App\Model\Adminka\Entity\Matkas\Kategoria\Permission;
use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatka;


use App\Model\Adminka\UseCase\Matkas\PlemMatka\Create;
//use App\Model\Adminka\Entity\Rasas\Linias\Nomers\Nomer;


use App\Model\Drevos\Entity\Rass\LiniBr\VetkaBr\NomerBr\NomerBr;
use App\ReadModel\Mesto\InfaMesto\MestoNomerFetcher;

use App\ReadModel\Adminka\Matkas\PlemMatka\PlemMatkaFetcher;
use App\ReadModel\Adminka\Uchasties\PersonaFetcher;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/adminka/matkas/plemmatka/creates", name="adminka.matkas.plemmatka.creates")
 */
class PlemCreateController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("/", name="")
     * @return Response
     */
    public function index(): Response
    {

        return $this->render('app/adminka/matkas/plemmatka/creates/index.html.twig'
        );
    }

    /**
     * @Route("/plemmatka/{id}", name=".plemmatka" , requirements={"id"=Guid::PATTERN})
     * @param Request $request
     *  @param NomerBr $nomer
     * @param PersonaFetcher $personas
     * @param MestoNomerFetcher $mestoNomers
//     * @param string $id
     * @return Response
     */
    public function plemmatka( Request $request,
                              PersonaFetcher $personas, MestoNomerFetcher $mestos,
                               NomerBr $nomer): Response
    {

        $persona = $personas->find($this->getUser()->getId());

        $mesto = $mestos->find($this->getUser()->getId());
//        dd($persona);
        return $this->render('app/adminka/matkas/plemmatka/creates/plemmatka.html.twig',
            compact('nomer', 'persona', 'mesto') );
    }

    /**
     * @Route("/create/{id}", name=".create" , requirements={"id"=Guid::PATTERN})
     * @param Request $request
     * @param NomerBr $nomer
     * @param PersonaFetcher $personas
     * @param MestoNomerFetcher $mestoNomers
     * @param PlemMatkaFetcher $plemmatkas
     * @param Create\Handler $handler
     * @return Response
     */
    public function create( Request $request, NomerBr $nomer,
                                PlemMatkaFetcher $plemmatkas,
                                PersonaFetcher $personas,
                                MestoNomerFetcher $mestoNomers,
                                Create\Handler $handler): Response
    {
//        $this->denyAccessUnlessGranted('ROLE_ADMINKA_MANAGE_PLEMMATKAS');

//        if (!$plemmatkas->existsPerson($this->getUser()->getId())) {
//            $this->addFlash('error', 'Начните с выбора ПерсонНомера ');
//            return $this->redirectToRoute('adminka.uchasties.personas.diapazon');
//        }

//        if (!$plemmatkas->existsMesto($this->getUser()->getId())) {
//            $this->addFlash('error', 'Пожалуйста, определитесь с номером места расположения Вашей пасеки ');
//            return $this->redirectToRoute('mesto.infamesto.okrugs');
//        }

        $sort = $plemmatkas->getMaxSort() + 1;
        $command = new Create\Command($this->getUser()->getId(), $sort, $nomer->getId()->getValue());


        $form = $this->createForm(Create\Form::class, $command, ['rasa_id' => $nomer->getVetka()->getLinia()->getRasa()->getId()->getValue()]);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('adminka.matkas');
            } catch (\DomainException $e) {
                $this->logger->warning($e->getMessage(), ['exception' => $e]);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/adminka/matkas/create.html.twig', [
            'form' => $form->createView(),
            'command' => $command,
        ]);
    }

//    /**
//     * @Route("/sdelano/{id_nom}/{plemmatka}", name=".sdelano" , requirements={"id_nom"=Guid::PATTERN})
//     * @param Request $request
//     * @param NomerRepository $nomers
//     * @param PersonaFetcher $personas
//     * @param MestoNomerFetcher $mestoNomers
//     * @param string $id_nom
//     * @param string $plemmatka
//     * @param PlemMatkaFetcher $plemmatkas
//     * @return Response
//     */
//    public function sdelano(string $id_nom, string $plemmatka, Request $request,
//                            PersonaFetcher $personas, MestoNomerFetcher $mestoNomers,
//                            NomerRepository $nomers, PlemMatkaFetcher $plemmatkas): Response
//    {
//
//        $idUser = $this->getUser()->getId();
//
//        $nomer = $nomers->get(new NomerId($id_nom));
//
//        $persona = $personas->find($idUser);
//
//        $mestoNomer = $mestoNomers->find($idUser);
//
//        $plemId = $plemmatkas->findIdByPlemMatka($plemmatka);
//
//
//        return $this->render('app/adminka/matkas/plemmatka/creates/sdelano.html.twig',
//            compact('nomer', 'persona', 'mestoNomer', 'plemmatka', 'plemId') );
//    }
//
//    /**
//     * @Route("/{plem_id}", name=".show", requirements={"plem_id"=Guid::PATTERN})
//     * @param PlemMatka $plemmatka
//     * @param   string $plem_id
//     * @param PlemMatkaFetcher $fetchers
//     * @param UchastieRepository $uchasties
//     * @param KategoriaFetcher $kategoria
//     * @return Response
//     */
//    public function show( string $plem_id, PlemMatkaFetcher $fetchers,
//                          UchastieRepository $uchasties ,
//                          KategoriaFetcher $kategoria ): Response
//    {
//
//        $plemmatka = $fetchers->find($plem_id);
//        // dd( $plemmatka);
//
//        $uchastie = $uchasties->get(new Id($plemmatka->getUchastieId()));
//
//        $kategorias = $kategoria->all();
//        $permissions = Permission::names();
//
//        $infaRasaNom = $fetchers->infaRasaNom($plemmatka->getRasaNomId());
//
//        $infaMesto = $fetchers->infaMesto($plemmatka->getMesto());
//
//        return $this->render('app/adminka/matkas/plemmatka/show.html.twig',
//            compact('plemmatka', 'infaRasaNom', 'infaMesto', 'uchastie','kategorias', 'permissions'));
//    }
}
