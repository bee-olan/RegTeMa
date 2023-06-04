<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\IzChildPlems;

use App\Annotation\Guid;

use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatka;

use App\Model\Adminka\Entity\Rasas\Rasa;

use App\Model\Adminka\UseCase\IzChildPlems\CreateChildLinia;
use App\Model\Adminka\Entity\Matkas\ChildMatka\ChildMatkaRepository;
use App\Model\Adminka\Entity\Matkas\ChildMatka\Id as ChildId;

use App\Model\Adminka\Entity\Rasas\Linias\Id;
use App\Model\Adminka\Entity\Rasas\Linias\Linia;
use App\Model\Adminka\Entity\Rasas\Linias\LiniaRepository;
use App\ReadModel\Adminka\Matkas\RoleFetcher;
use App\ReadModel\Adminka\Rasas\Linias\LiniaFetcher;

use App\Model\Adminka\Entity\Uchasties\Uchastie\Id as UchastieId;

use App\Controller\ErrorHandler;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/proekt/pasekas/izChildPlems", name="proekt.pasekas.izChildPlems")
 */
class IzChildLiniaController extends AbstractController
{

    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("/izVetka/{linia_id},{name_star},{nomerNameStar}", name=".izVetka" , requirements={"id"=Guid::PATTERN})
//     * @ParamConverter("linia", options={"id" = "linia_id"})
     * @param Rasa $rasa
     * @param Linia $linia
     * @param LiniaFetcher $linias
     * @param LiniaRepository $liniaRep
     * @param string $name_star
     * @param string $linia_id
     * @param string $nomerNameStar
     * @return Response
     */
    public function izVetka(Request $request,
//                            Linia $linia,
                            string $name_star,
                            string $linia_id,
                            string $nomerNameStar,
                            LiniaFetcher $linias,
                            LiniaRepository $liniaRep
    ): Response
    {

        $idL= (new Id($linia_id))->getValue();

//
        $liniass = $linias->allOfVetka($idL,  $name_star);


        $linId = new Id($liniass[0]['id']);

        $linia = $liniaRep->get($linId );
//        dd($linia->getId()->getValue());

        return $this->redirectToRoute('proekt.pasekas.izChildPlems.createLiniaNomer',
            [
                'linia_id' => $linia->getId()->getValue(),
                'nomerNameStar'  => $nomerNameStar,
            ]);

    }

    /**
     * @Route("/izChildLinia/{plemmatka_id}", name=".izChildLinia" , requirements={"department_id"=Guid::PATTERN})
     * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
     * @param Request $request
    * @param PlemMatka $plemmatka
    * @param Rasa $rasa
//    * @param Linia $linia
    * @param ChildMatkaRepository $childRepo
	* @param LiniaRepository $linias
    * @param LiniaFetcher $liniaFet
//     * @param RoleFetcher $roleFetcher
    * @param CreateChildLinia\Handler $handler
    * @return Response
    */
    public function izChildLiniaCreate(Request $request,
                                        PlemMatka $plemmatka,
                                        ChildMatkaRepository $childRepo,
                                       LiniaFetcher $liniaFet,
                                        LiniaRepository $linias,
                                       CreateChildLinia\Handler $handler): Response
   {
       $session = new Session();

       $session->clear();
       if ($parent = (int)$request->query->get('parent')) {
           $child = $childRepo->get(new ChildId($parent));

           $childS = ([
               'plemId' => $child->getPlemMatka(),
               'godaVixod'=> $child->getGodaVixod(),
               'sezonPlem'=> $child->getSezonPlem(),

           ]);
         $session->set('childS', $childS);
       }
       // устанавливать флеш-сообщения
       $session->getFlashBag()->add('notice', 'Внимание! Вы перевели данную маточку в ПлемМатки, теперь можно объявлять её дочерних (ДочьМаток)');
// извлекать сообщения



//        $childSs =  $session->get('childS');
//       $session->clear();

//        dd($childSs['roles']);
//=========================================

//       dd($childmatka);

       $liniaa = $child->getPlemMatka()->getNomer()->getLinia();
//
//       $nomer = $childmatka->getPlemMatka()->getNomer()->getNameStar();
//
       $nomerNameStar =$parent."-".$child->getGodaVixod();
//dd($nomerNameStar);


       $rasa = $liniaa->getRasa();

       $liniass = $liniaFet->listOfRasa($rasa->getId()->getValue());
//dd($liniass);
       foreach ($liniass as $key => $lini) {

           if ($lini == $liniaa->getId()->getValue()) {
//               dd($key);
               return $this->redirectToRoute('proekt.pasekas.izChildPlems.createLiniaNomer',
                   [
                       'linia_id' => $key,
                       'nomerNameStar' => $nomerNameStar,
                   ]);
           }
       }

    $command =new CreateChildLinia\Command((int)$parent);

            try {
                $handler->handle($command);

//                $linia = $linias->getByLinia($command->nameStar, $command->idVetka );
//                dd($linia);
                return $this->redirectToRoute('proekt.pasekas.izChildPlems.izVetka',
                    ['linia_id' => $command->idVetka, 'name_star' =>$command->nameStar, 'nomerNameStar' =>$nomerNameStar ]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
              
            }
//
//        return $this->render('proekt/pasekas/izChildPlems/izChildLinia.html.twig', [
//
//            'name' => $command->title,
//        ]);
   }
}

