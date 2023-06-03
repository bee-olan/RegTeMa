<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\Matkas\PlemMatka;

use App\Annotation\Guid;

use App\Model\Adminka\Entity\Matkas\Kategoria\Permission;
use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatka;

use App\Model\Adminka\Entity\OtecForRas\Linias\Nomers\Id;
use App\Model\Adminka\Entity\OtecForRas\Linias\Nomers\NomerRepository as OtNomerRepository;
use App\ReadModel\Adminka\Matkas\KategoriaFetcher;
use App\ReadModel\Adminka\Matkas\PlemMatka\PlemMatkaFetcher;

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

   /**
    * @Route("/{plemmatka_id}", name=".show", requirements={"plemmatka_id"=Guid::PATTERN})
    * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
    * @param PlemMatka $plemmatka
    * @param PlemMatkaFetcher $fetchers
    * @param OtNomerRepository $nomerRepo
    * @return Response
    */
   public function show(  PlemMatka $plemmatka,
                            KategoriaFetcher $kategoria,
                            PlemMatkaFetcher $fetchers,
                            OtNomerRepository $nomerRepo
                        ): Response
   {
       $session = new Session();
       $sesMessages  = $session->getFlashBag()->get('notice', []);

        $otecNomer = $nomerRepo->get(new Id($plemmatka->getOtecNomer()->getId()->getValue()));


       $kategorias = $kategoria->all();
       $permissions = Permission::names();

      $infaMesto = $fetchers->infaMesto($plemmatka->getMesto()->getNomer());

       return $this->render('proekt/pasekas/matkas/plemmatkas/show.html.twig',
           compact('plemmatka', 'infaMesto',
               'kategorias', 'permissions',
                'sesMessages', 'otecNomer'
           ));
   }
}
