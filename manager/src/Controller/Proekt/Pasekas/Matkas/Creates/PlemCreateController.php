<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\Matkas\Creates;

use App\Annotation\Guid;

use App\Model\Adminka\Entity\OtecForRas\Linias\Nomers\Id;

use App\Model\Adminka\Entity\Matkas\Kategoria\Permission;
use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatka;
use App\Model\Adminka\Entity\OtecForRas\Linias\Nomers\NomerRepository;
use App\Model\Drevos\Entity\Rass\LiniBr\VetkaBr\NomerBr\NomerBr;
use App\ReadModel\Adminka\Matkas\KategoriaFetcher;
use App\ReadModel\Adminka\OtecForRas\Linias\Nomers\NomerFetcher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use App\Model\Adminka\UseCase\Matkas\PlemMatka\Create;
//use App\Model\Adminka\Entity\Rasas\Linias\Nomers\Nomer;
use App\ReadModel\Mesto\InfaMesto\MestoNomerFetcher;
use App\ReadModel\Adminka\Matkas\PlemMatka\PlemMatkaFetcher;
use App\ReadModel\Adminka\Uchasties\PersonaFetcher;
use App\ReadModel\Adminka\Uchasties\Uchastie\UchastieFetcher;

use App\Controller\ErrorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/proekts/pasekas/matkas/plemmatkas/creates", name="app.proekts.pasekas.matkas.plemmatkas.creates")
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
    * @param PlemMatkaFetcher $plemmatkas
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

        return $this->render('app/proekts/pasekas/matkas/plemmatkas/creates/index.html.twig'
        );
    }

    /**
    * @Route("/plemmatka/{id}", name=".plemmatka" , requirements={"id"=Guid::PATTERN})
    * @param Request $request
    * @param UchastieFetcher $uchasties 
    *  @param NomerBr $nomer
    * @param PersonaFetcher $personas
    * @param MestoNomerFetcher $mestoNomers
    * @return Response
    */
    public function plemmatka( Request $request,
                            UchastieFetcher $uchasties,    
                            PersonaFetcher $personas, 
                            MestoNomerFetcher $mestos,
                               NomerBr $nomer): Response
    {

        if (!$uchasties->find($this->getUser()->getId())) {           
            $this->addFlash('error', 'Внимание!!! Для продолжения нужно стать участником проекта! ');
            return $this->redirectToRoute('app.proekts.pasekas.uchasties.uchastiee');
        }
       
    //    dd($nomer);
        $persona = $personas->find($this->getUser()->getId());

        $mesto = $mestos->find($this->getUser()->getId());

        return $this->render('app/proekts/pasekas/matkas/plemmatkas/creates/plemmatka.html.twig',
            compact('nomer', 'persona', 'mesto') );
    }

//    /**
//     * @Route("/create/{id}", name=".create" , requirements={"id"=Guid::PATTERN})
//     * @param Request $request
//     * @param NomerBr $nomer
//     * @param PlemMatkaFetcher $plemmatkas
//     * @param KategoriaFetcher $kategoria
//     * @param Create\Handler $handler
//     * @return Response
//     */
//    public function create( Request $request, NomerBr $nomer,
//                            PlemMatkaFetcher $plemmatkas,
//                            KategoriaFetcher $kategoria,
//                            Create\Handler $handler): Response
//    {
//
//        //        $this->denyAccessUnlessGranted('ROLE_MANAGE_PLEMMATKAS');
//
//        $kategorias = $kategoria->all();
//        $permissions = Permission::names();
//
//        $sort = $plemmatkas->getMaxSort() + 1;
//        $command = new Create\Command($this->getUser()->getId(), $sort, $nomer->getId()->getValue());
//
//
//        $form = $this->createForm(Create\Form::class, $command, ['rasa_id' => $nomer->getLinia()->getRasa()->getId()->getValue()]);
//        $form->handleRequest($request);
//
//        $kakToTak = $nomer->getLinia()->getNameStar()."-".$nomer->getName();
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            try {
//                $handler->handle($command);
//                return $this->redirectToRoute('app.proekts.pasekas.matkas.plemmatkas.creates.sdelano', [ 'name' => $command->name]);
//            } catch (\DomainException $e) {
//                $this->errors->handle($e);
//                $this->addFlash('error', $e->getMessage());
//            }
//        }
//
//        return $this->render('app/proekts/pasekas/matkas/plemmatkas/creates/create.html.twig', [
//            'form' => $form->createView(),
//            'command' => $command,
//            'kategorias' => $kategorias,
//            'permissions' => $permissions,
//            'kakToTak' => $kakToTak
//        ]);
//    }

//    /**
//    * @Route("/sdelano/{name}", name=".sdelano" )
//    * @ParamConverter("name", options={"id" = "name"})
//    * @param Request $request
//    * @param NomerRepository  $nomerOtecs
//    * @param PlemMatka $plemmatka
//    * @param MestoNomerFetcher $mestoNomers
//     * @param PlemMatkaFetcher $plemmatkas
//     * @return Response
//     */
//    public function sdelano( PlemMatka $plemmatka,
//                             NomerRepository  $nomerOtecs,
//                             Request $request,
//                            PersonaFetcher $personas, MestoNomerFetcher $mestoNomers,
////                            NomerRepository $nomers,
//                            PlemMatkaFetcher $plemmatkas): Response
//    {
//
//    //    dd($plemmatka->getNomer()->getLinia()->getRasa()->getName());
//        $nomer = $plemmatka->getNomer()->getTitle();
//
//        $nomerOtec = $nomerOtecs->get(new Id($plemmatka->getOtecNomer()->getId()->getValue()));
////dd($nomerOtec->getLinia()->getName());
////        dd($nomerOtec->getName());
//        // $mesto = $plemmatka->getMesto()->getNomer();
//// dd($plemmatka->getOtecNomer()->getLinia()->getNomers(new Id($plemmatka->getOtecNomer()->getId()->getValue())));
////        $plemId = $plemmatkas->findIdByPlemMatka($plemmatka);
//
//
//        return $this->render('app/proekts/pasekas/matkas/plemmatkas/creates/sdelano.html.twig',
//          [
//              'plemmatka' => $plemmatka,
//                'nomerOtec' => $nomerOtec,
//                // 'mesto' => $mesto,
//                'nomer' => $nomer,
//          ])
//           ;
//    }
//


    /**
     * @Route("/{plemmatka_id}", name=".show", requirements={"plemmatka_id"=Guid::PATTERN})
     * @param PlemMatka $plemmatka
     * @param PlemMatkaFetcher $fetchers
     * @return Response
     */
    public function show(  PlemMatkaFetcher $fetchers,
                          PlemMatka $plemmatka
    ): Response
    {

        // $plemmatka = $fetchers->find($plem_id);
        // dd( $plemmatka);


        return $this->render('app/proekts/pasekas/matkas/plemmatkas/redaktorss/show.html.twig',
            compact('plemmatka'               
            ));
    }



}
