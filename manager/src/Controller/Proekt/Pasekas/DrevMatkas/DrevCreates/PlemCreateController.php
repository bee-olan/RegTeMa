<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\DrevMatkas\DrevCreates;

use App\Annotation\Guid;


use App\Model\Adminka\Entity\DrevMatkas\DrevMatka;
use App\Model\Adminka\Entity\Matkas\Kategoria\Permission;
use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatka;

use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Noms\Nom;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Noms\NomRepository;
use App\Model\Drevos\Entity\Rass\Rods\Linis\Wetkas\NomWets\MatTruts\Noms\Id;

use App\ReadModel\Adminka\DrevMatkas\DrevMatkaFetcher;
use App\ReadModel\Adminka\Matkas\KategoriaFetcher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use App\Model\Adminka\UseCase\Matkas\PlemMatka\Create;
use App\ReadModel\Mesto\InfaMesto\MestoNomerFetcher;

use App\ReadModel\Adminka\Uchasties\PersonaFetcher;
use App\ReadModel\Adminka\Uchasties\Uchastie\UchastieFetcher;

use App\Controller\ErrorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/proekts/pasekas/drevmatkas/drevcreates/creates", name="app.proekts.pasekas.drevmatkas.drevcreates")
 */
class PlemCreateController extends AbstractController
{

    private $errors;

    public function __construct( ErrorHandler $errors)
    {
        $this->errors = $errors;
    }


    /**
    * @Route("/", name="")
    * @param Request $request
//    * @param DrevMatkaFetcher $drevmatkas
    * @param UchastieFetcher $uchasties,
    * @return Response
    */
    public function index( Request $request,
                        UchastieFetcher $uchasties                     
                        ): Response
    { 

        // $uchastie = $uchasties->find($this->getUser()->getId());

        if (!$uchasties->find($this->getUser()->getId())) {
            $this->addFlash('error', 'Внимание!!! Пожалуйста, начните с этого! ');
            return $this->redirectToRoute('app.proekts.pasekas.uchasties.uchastiee');
        }

        return $this->render('app/proekts/pasekas/drevmatkas/drevcreates/index.html.twig'
        );
    }

    /**
    * @Route("/plemmatka/{id}", name=".plemmatka" , requirements={"id"=Guid::PATTERN})
    * @param Request $request
    * @param UchastieFetcher $uchasties 
    *  @param Nom $nomer
    * @param PersonaFetcher $personas
    * @param MestoNomerFetcher $mestoNomers
    * @return Response
    */
    public function plemmatka( Request $request,
                            UchastieFetcher $uchasties,    
                            PersonaFetcher $personas, 
                            MestoNomerFetcher $mestos,
                            Nom $nomer): Response
    {

        if (!$uchasties->find($this->getUser()->getId())) {           
            $this->addFlash('error', 'Внимание!!! Для продолжения нужно стать участником проекта! ');
            return $this->redirectToRoute('app.proekts.pasekas.uchasties.uchastiee');
        }
       

        $nomwet = $nomer->getMattrut()->getNomwet()->getTitW();
        $wetka = $nomer->getMattrut()->getNomwet()->getWetka()->getNameW()."-".$nomwet;
        $linia = $nomer->getMattrut()->getNomwet()->getWetka()->getLinia();
        $lini = $linia->getName();
        $rass = $linia->getRodo()->getRasa()->getName();

        $persona = $personas->find($this->getUser()->getId());

        $mesto = $mestos->find($this->getUser()->getId());

        return $this->render('app/proekts/pasekas/drevmatkas/drevcreates/plemmatka.html.twig',
            compact('nomer', 'persona', 'mesto', 'wetka', 'rass', 'lini') );
    }

    /**
     * @Route("/create/{id}", name=".create" , requirements={"id"=Guid::PATTERN})
     * @param Request $request
     * @param Nom $nomer
     * @param DrevMatkaFetcher $drevmatkas
     * @param KategoriaFetcher $kategoria
     * @param Create\Handler $handler
     * @return Response
     */
    public function create( Request $request, Nom $nomer,
                            DrevMatkaFetcher $drevmatkas,
                            KategoriaFetcher $kategoria,
                            Create\Handler $handler): Response
    {

        //        $this->denyAccessUnlessGranted('ROLE_MANAGE_PLEMMATKAS');

//        $kategorias = $kategoria->all();
//        $permissions = Permission::names();

        $sort = $drevmatkas->getMaxSort() + 1;
        $command = new Create\Command($this->getUser()->getId(), $sort, $nomer->getId()->getValue());


        $form = $this->createForm(Create\Form::class, $command, ['rasa_id' => $nomer->getLinia()->getRasa()->getId()->getValue()]);
        $form->handleRequest($request);

        $kakToTak = $nomer->getLinia()->getNameStar()."-".$nomer->getName();

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('app.proekts.pasekas.drevmatkas.drevcreates.sdelano', [ 'name' => $command->name]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/proekts/pasekas/drevmatkas/drevcreates/create.html.twig', [
            'form' => $form->createView(),
            'command' => $command,
//            'kategorias' => $kategorias,
//            'permissions' => $permissions,
            'kakToTak' => $kakToTak
        ]);
    }

    /**
    * @Route("/sdelano/{name}", name=".sdelano" )
    * @ParamConverter("name", options={"id" = "name"})
    * @param Request $request
    * @param NomRepository  $nomerOtecs
    * @param PlemMatka $plemmatka
    * @param MestoNomerFetcher $mestoNomers
     * @param DrevMatkaFetcher $drevmatkas
     * @return Response
     */
    public function sdelano( PlemMatka $plemmatka,
                             NomRepository  $nomerOtecs,
                             Request $request,
                            PersonaFetcher $personas, MestoNomerFetcher $mestoNomers,
//                            NomerRepository $nomers,
                            DrevMatkaFetcher $drevmatkas): Response
    {

    //    dd($plemmatka->getNomer()->getLinia()->getRasa()->getName());
        $nomer = $plemmatka->getNomer()->getTitle();

        $nomerOtec = $nomerOtecs->get(new Id($plemmatka->getOtecNomer()->getId()->getValue()));
//dd($nomerOtec->getLinia()->getName());
//        dd($nomerOtec->getName());
        // $mesto = $plemmatka->getMesto()->getNomer();
// dd($plemmatka->getOtecNomer()->getLinia()->getNomers(new Id($plemmatka->getOtecNomer()->getId()->getValue())));
//        $plemId = $drevmatkas->findIdByPlemMatka($plemmatka);


        return $this->render('app/proekts/pasekas/drevmatkas/drevcreates/sdelano.html.twig',
          [
              'plemmatka' => $plemmatka,
                'nomerOtec' => $nomerOtec,
                // 'mesto' => $mesto,
                'nomer' => $nomer,
          ])
           ;
    }
//


    /**
     * @Route("/{plemmatka_id}", name=".show", requirements={"plemmatka_id"=Guid::PATTERN})
     * @param DrevMatka $drevmatka
     * @param DrevMatkaFetcher $fetchers
     * @return Response
     */
    public function show(  DrevMatkaFetcher $fetchers,
                           DrevMatka $drevmatka
    ): Response
    {

        // $drevmatka = $fetchers->find($plem_id);
        // dd( $drevmatka);


        return $this->render('app/proekts/pasekas/drevmatkas/drevcreates/redaktorss/show.html.twig',
            compact('drevmatka'
            ));
    }



}
