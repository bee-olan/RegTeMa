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

use App\Model\Adminka\UseCase\DrevMatkas\DrevMatka\Create;
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

        $drevMat = $nomer->drevMat();
        $miniDrevMat = $nomer->miniDrevMat();
//        $nomwet = $nomer->getMattrut()->getNomwet()->getTitW();
//        $wetka = $nomer->getMattrut()->getNomwet()->getWetka()->getNameW()."-".$nomwet;
//        $linia = $nomer->getMattrut()->getNomwet()->getWetka()->getLinia();
//        $lini = $linia->getName();
//        $rass = $linia->getRodo()->getRasa()->getName();

        $persona = $personas->find($this->getUser()->getId());

        $mesto = $mestos->find($this->getUser()->getId());

        return $this->render('app/proekts/pasekas/drevmatkas/drevcreates/plemmatka.html.twig',
            compact('drevMat', 'nomer','persona', 'mesto', 'miniDrevMat') );
//            compact('nomer', 'persona', 'mesto', 'wetka', 'rass', 'lini') );
    }

    /**
     * @Route("/create/{id}", name=".create" , requirements={"id"=Guid::PATTERN})
     * @param Request $request
     * @param Nom $nomer
     * @param DrevMatkaFetcher $drevmatkas

     * @param Create\Handler $handler
     * @return Response
     */
    public function create( Request $request, Nom $nomer,
                            DrevMatkaFetcher $drevmatkas,
                            Create\Handler $handler): Response
    {



        $sort = $drevmatkas->getMaxSort()+1;

        $command = new Create\Command( $sort , $nomer->getId()->getValue());

            try {
                $handler->handle($command);
                return $this->redirectToRoute('app.proekts.pasekas.drevmatkas.drevcreates.sdelano', [ 'name' => $command->name]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }

        return $this->render('app/proekts/pasekas/drevmatkas/drevcreates/create.html.twig', [
            'command' => $command,
        ]);
    }

    /**
    * @Route("/sdelano/{name}", name=".sdelano" )
    * @ParamConverter("name", options={"id" = "name"})
    * @param Request $request
    * @param DrevMatka $plemmatka
    * @param MestoNomerFetcher $mestoNomers
     * @param DrevMatkaFetcher $drevmatkas
     * @return Response
     */
    public function sdelano(Request $request,
                            DrevMatka $plemmatka,
                            PersonaFetcher $personas,
                            MestoNomerFetcher $mestoNomers,
                            DrevMatkaFetcher $drevmatkas): Response
    {


        $nomer = $plemmatka->getNomer()->getTit();

//        $miniDrevMat = $nom->miniDrevMat();

        return $this->render('app/proekts/pasekas/drevmatkas/drevcreates/sdelano.html.twig',
          [
              'plemmatka' => $plemmatka,
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
