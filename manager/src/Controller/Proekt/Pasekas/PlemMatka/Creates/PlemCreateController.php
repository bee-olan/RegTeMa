<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\PlemMatka\Creates;

use App\Annotation\Guid;

use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatka;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use App\Model\Adminka\UseCase\Matkas\PlemMatka\Create;
use App\Model\Adminka\Entity\Rasas\Linias\Nomers\Nomer;
use App\ReadModel\Mesto\InfaMesto\MestoNomerFetcher;
use App\ReadModel\Adminka\Matkas\PlemMatka\PlemMatkaFetcher;
use App\ReadModel\Adminka\Uchasties\PersonaFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/proekt/pasekas/matkas/plemmatkas/creates", name="proekt.pasekas.matkas.plemmatkas.creates")
 */
class PlemCreateController extends AbstractController
{
    /**
     * @Route("/", name="")
     * @return Response
     */
    public function index(): Response
    {

        return $this->render('proekt/pasekas/matkas/plemmatkas/creates/index.html.twig'
        );
    }

    /**
     * @Route("/plemmatka/{id}", name=".plemmatka" , requirements={"id"=Guid::PATTERN})
     * @param Request $request
     *  @param Nomer $nomer
     * @param PersonaFetcher $personas
     * @param MestoNomerFetcher $mestoNomers
//     * @param string $id
     * @return Response
     */
    public function plemmatka( Request $request,
                              PersonaFetcher $personas, MestoNomerFetcher $mestos,
                              Nomer $nomer): Response
    {

        $persona = $personas->find($this->getUser()->getId());

        $mesto = $mestos->find($this->getUser()->getId());
//        dd($persona);
        return $this->render('proekt/pasekas/matkas/plemmatkas/creates/plemmatka.html.twig',
            compact('nomer', 'persona', 'mesto') );
    }

    /**
     * @Route("/create/{id}", name=".create" , requirements={"id"=Guid::PATTERN})
     * @param Request $request
     * @param Nomer $nomer
     * @param PersonaFetcher $personas
     * @param MestoNomerFetcher $mestoNomers
     * @param PlemMatkaFetcher $plemmatkas
     * @param Create\Handler $handler
     * @return Response
     */
    public function create( Request $request, Nomer $nomer,
                                PlemMatkaFetcher $plemmatkas,
                                PersonaFetcher $personas,
                                MestoNomerFetcher $mestoNomers,
                                Create\Handler $handler): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MANAGE_PLEMMATKAS');

//        if (!$plemmatkas->existsPerson($this->getUser()->getId())) {
//            $this->addFlash('error', 'Начните с выбора ПерсонНомера ');
//            return $this->redirectToRoute('proekt/pasekas.uchasties.personas.diapazon');
//        }

//        if (!$plemmatkas->existsMesto($this->getUser()->getId())) {
//            $this->addFlash('error', 'Пожалуйста, определитесь с номером места расположения Вашей пасеки ');
//            return $this->redirectToRoute('mesto.infamesto.okrugs');
//        }


        $sort = $plemmatkas->getMaxSort() + 1;
        $command = new Create\Command($this->getUser()->getId(), $sort, $nomer->getId()->getValue());


        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('proekt.pasekas.matkas.plemmatkas.creates.sdelano', [ 'name' => $command->name]);
                dd($command->name);
            } catch (\DomainException $e) {
                $this->logger->warning($e->getMessage(), ['exception' => $e]);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('proekt/pasekas/matkas/plemmatkas/creates/create.html.twig', [
            'form' => $form->createView(),
            'command' => $command,
        ]);
    }

    /**
     * @Route("/sdelano/{name}", name=".sdelano" )
     * @ParamConverter("name", options={"id" = "name"})
     * @param Request $request
//     * @param NomerRepository $nomers
     * @param PlemMatka $plemmatka
     * @param MestoNomerFetcher $mestoNomers
//     * @param string $name
     * @param PlemMatkaFetcher $plemmatkas
     * @return Response
     */
    public function sdelano( PlemMatka $plemmatka,
//        string $name,
                             Request $request,
                            PersonaFetcher $personas, MestoNomerFetcher $mestoNomers,
//                            NomerRepository $nomers,
                            PlemMatkaFetcher $plemmatkas): Response
    {


        $nomer = $plemmatka->getNomer()->getTitle();

        $persona = $plemmatka->getPersona()->getNomer();

        $mesto = $plemmatka->getMesto()->getNomer();
//dd($mesto);
//        $plemId = $plemmatkas->findIdByPlemMatka($plemmatka);


        return $this->render('proekt/pasekas/matkas/plemmatkas/creates/sdelano.html.twig',
          [
              'plemmatka' => $plemmatka,
                'persona' => $persona,
                'mesto' => $mesto,
                'nomer' => $nomer,
          ])
           ;
    }
//

//                'plemmatkaa' => $plemmatka->getName(),
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
//        return $this->render('app/proekt/pasekas/matkas/plemmatka/show.html.twig',
//            compact('plemmatka', 'infaRasaNom', 'infaMesto', 'uchastie','kategorias', 'permissions'));
//    }
}
