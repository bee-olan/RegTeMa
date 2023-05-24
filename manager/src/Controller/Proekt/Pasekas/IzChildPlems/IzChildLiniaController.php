<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\IzChildPlems;

use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatka;
use App\Annotation\Guid;
use App\Model\Adminka\Entity\Rasas\Linias\Id;
use App\Model\Adminka\Entity\Rasas\Linias\Linia;
use App\Model\Adminka\Entity\Rasas\Linias\LiniaRepository;
use App\Model\Adminka\Entity\Rasas\Rasa;
use App\Model\Adminka\UseCase\IzChildPlems\CreateChildLinia;
use App\ReadModel\Adminka\Rasas\Linias\LiniaFetcher;
use App\Model\Adminka\Entity\Rasas\Linias\Nomers\Id as NomerId;
use App\Controller\ErrorHandler;
use App\ReadModel\Adminka\Rasas\Linias\Nomers\NomerFetcher;
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
        $liniass = $linias->allOfVetka($idL, "A-1");

//        foreach ($liniass as $liniaa) {
//            if ($liniaa) {
//                dd($liniaa['id']);
//                throw new \DomainException('Такой участник уже добавлен.');
//            }
//        }
        $linId = new Id($liniass[0]['id']);

        $linia = $liniaRep->get($linId );
//        dd($linia);

//        $maxSort = $nomers->getMaxSortNomer($linId) + 1;
//dd($maxSort);
//        $rasa = $linia->getRasa();
//        $liniaa = $linias->allOfVetka($linia->getId()->getValue());

        return $this->redirectToRoute('proekt.pasekas.izChildPlems.createLiniaNomer',
            [
//            'rasa' => $rasa,
                'linia_id' => $linia->getId()->getValue(),
                'name_star'  => $name_star,
            ]);

    }

    /**
     * @Route("/izChildLinia/{plemmatka_id},{department_id}", name=".izChildLinia" , requirements={"department_id"=Guid::PATTERN})
     * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
    * @param PlemMatka $plemmatka
    * @param Rasa $rasa
    * @param Linia $linia
	* @param LiniaFetcher $linias
    * @param string $department_id
    * @param Request $request
    * @param CreateChildLinia\Handler $handler
    * @return Response
    */
    public function izChildLiniaCreate(Request $request,
                                        PlemMatka $plemmatka, 
                                        // Linia $linia, 
                                        string $department_id, 
                                        LiniaFetcher $linias,
                                       CreateChildLinia\Handler $handler): Response
   {
    $linia = $plemmatka->getNomer()->getLinia();

    $nameStar = $linia->getNameStar();

    $rasa = $linia->getRasa(); 

    $name = $plemmatka->getNomer()->getName();
        
    $idn =  $plemmatka->getNomer()->getId()->getValue();

       $maxSort = $linias->getMaxSortLinia($rasa->getId()->getValue()) + 1;
 
//        dd( $linia->getId()->getValue());

       $command = CreateChildLinia\Command::fromRasa($rasa, $linia, $maxSort, $nameStar, $idn);// заполнение  значениями из Rasa

        if ($vetka = $request->query->get('vetka')) {

            $command->vetka = $linia->getId()->getValue();
        }

//        $form = $this->createForm(CreateChildLinia\Form::class, $command);
//        $form->handleRequest($request);
        // if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
//                dd( $vetka);
                return $this->redirectToRoute('proekt.pasekas.izChildPlems.izVetka',
                    ['linia_id' => $linia->getId()->getValue(), 'name_star' => $vetka ]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
              
            }
        // }
        return $this->render('proekt/pasekas/izChildPlems/izChildLinia.html.twig', [
            'vetka' => $vetka,
            'rasa' => $rasa,
            // 'form' => $form->createView(),
            'name' => $command->title,
        ]);
   }
}

