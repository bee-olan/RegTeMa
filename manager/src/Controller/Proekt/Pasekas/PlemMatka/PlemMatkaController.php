<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\PlemMatka;

use App\Annotation\Guid;

use App\Model\Adminka\Entity\Matkas\Kategoria\Permission;
use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatka;
//use App\Model\Adminka\Entity\Matkas\Sparings\SparingRepository;
//use App\Model\Adminka\Entity\Matkas\Sparings\Id as SparingId;

use App\Model\Adminka\Entity\Rasas\Linias\Nomers\NomerRepository;
use App\Model\Adminka\Entity\Rasas\Linias\Nomers\Id as NomerId;

use App\Model\Adminka\Entity\Uchasties\Uchastie\UchastieRepository;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Id;
use App\ReadModel\Mesto\InfaMesto\MestoNomerFetcher;
use App\ReadModel\Adminka\Matkas\KategoriaFetcher;
use App\ReadModel\Adminka\Matkas\PlemMatka\PlemMatkaFetcher;
use App\ReadModel\Adminka\Uchasties\PersonaFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/proekt/pasekas/matkas/plemmatkas", name="proekt.pasekas.matkas.plemmatkas")
 */
class PlemMatkaController extends AbstractController
{
//    /**
//     * @Route("/", name="")
//     * @return Response
//     */
//    public function index(): Response
//    {
//
//        return $this->render('proekt/pasekas/matkas/plemmatkas/index.html.twig'
////            ,
////            compact('rasas')
//        );
//    }


   /**
    * @Route("/{plemmatka_id}", name=".show", requirements={"plemmatka_id"=Guid::PATTERN})
    * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
    * @param PlemMatka $plemmatka
    * @param PlemMatkaFetcher $fetchers
    * @return Response
    */
   public function show(  PlemMatka $plemmatka,
                            KategoriaFetcher $kategoria,
                            PlemMatkaFetcher $fetchers
                        ): Response
   {
       $session = new Session();
       $sesMessages  = $session->getFlashBag()->get('notice', []);

//dd($plemmatka->getOtecNomer()->getLinia()->getName());

//       $uchastie = $uchasties->get(new Id($plemmatka->getUchastieId()));
//
       $kategorias = $kategoria->all();
       $permissions = Permission::names();


//
      $infaMesto = $fetchers->infaMesto($plemmatka->getMesto()->getNomer());
//       dd($infaMesto);
       return $this->render('proekt/pasekas/matkas/plemmatkas/show.html.twig',
           compact('plemmatka', 'infaMesto',
               'kategorias', 'permissions',
                'sesMessages'
           ));
   }
}
