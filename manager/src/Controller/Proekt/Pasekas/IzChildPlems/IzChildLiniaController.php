<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\IzChildPlems;

use App\Model\Adminka\Entity\Matkas\ChildMatka\ChildMatkaRepository;
use App\Model\Adminka\Entity\Matkas\ChildMatka\Id as ChildId;
use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatka;
use App\Annotation\Guid;
use App\Model\Adminka\Entity\Rasas\Linias\Id;
use App\Model\Adminka\Entity\Rasas\Linias\Linia;
use App\Model\Adminka\Entity\Rasas\Linias\LiniaRepository;
use App\Model\Adminka\Entity\Rasas\Rasa;
use App\Model\Adminka\UseCase\IzChildPlems\CreateChildLinia;
use App\ReadModel\Adminka\Rasas\Linias\LiniaFetcher;

use App\Controller\ErrorHandler;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @Route("/izVetka/{linia_id},{name_star}", name=".izVetka" , requirements={"id"=Guid::PATTERN})
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

                            LiniaFetcher $linias,
                            LiniaRepository $liniaRep
    ): Response
    {

        $idL= (new Id($linia_id))->getValue();

//
        $liniass = $linias->allOfVetka($idL,  $nomerNameStar);


        $linId = new Id($liniass[0]['id']);

        $linia = $liniaRep->get($linId );
        dd($linia->getId()->getValue());

        return $this->redirectToRoute('proekt.pasekas.izChildPlems.createLiniaNomer',
            [
                'linia_id' => $linia->getId()->getValue(),
                'name_star'  => $name_star,
            ]);

    }

    /**
     * @Route("/izChildLinia/{plemmatka_id}", name=".izChildLinia" , requirements={"department_id"=Guid::PATTERN})
     * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
    * @param PlemMatka $plemmatka
    * @param Rasa $rasa
//    * @param Linia $linia
    * @param ChildMatkaRepository $childRepo
	* @param LiniaRepository $linias
    * @param LiniaFetcher $liniaFet
    * @param Request $request
    * @param CreateChildLinia\Handler $handler
    * @return Response
    */
    public function izChildLiniaCreate(Request $request,
                                        PlemMatka $plemmatka,
                                        ChildMatkaRepository $childRepo,
//                                         Linia $linia,
                                       LiniaFetcher $liniaFet,
                                        LiniaRepository $linias,
                                       CreateChildLinia\Handler $handler): Response
   {

       if ($parent = (int)$request->query->get('parent')) {}

       $childmatka = $childRepo->get(new ChildId($parent));

       ;

       $liniaa = $childmatka->getPlemMatka()->getNomer()->getLinia();
//
//       $nomer = $childmatka->getPlemMatka()->getNomer()->getNameStar();
//
       $nomerNameStar =$parent."-".$childmatka->getGodaVixod();
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
                dd("стор 1");
//                $linia = $linias->getByLinia($command->nameStar, $command->idVetka );
//                dd($linia);
                return $this->redirectToRoute('proekt.pasekas.izChildPlems.izVetka',
                    ['linia_id' => $command->idVetka, 'name_star' =>$command->nameStar ]);
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

