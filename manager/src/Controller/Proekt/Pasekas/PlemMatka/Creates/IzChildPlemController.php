<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\PlemMatka\Creates;

use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatka;
use App\Annotation\Guid;
use App\Model\Adminka\Entity\Rasas\Linias\Id;
use App\Model\Adminka\Entity\Rasas\Linias\Linia;
use App\Model\Adminka\Entity\Rasas\Rasa;
use App\Model\Adminka\UseCase\Rasas\Linias\CreateNomLin;
use App\ReadModel\Adminka\Rasas\Linias\LiniaFetcher;
use App\Model\Adminka\Entity\Rasas\Linias\Nomers\Id as NomerId;
use App\Controller\ErrorHandler;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// {linia_id}
/**
 * @Route("/proekt/pasekas/matkas/plemmatkas/creates/{plemmatka_id}", name="proekt.pasekas.matkas.plemmatkas.creates")
 */
class IzChildPlemController extends AbstractController
{

//     private $errors;

//     public function __construct(ErrorHandler $errors)
//     {
//         $this->errors = $errors;
//     }

//     /**
//      * @Route("/iz_child_vetka_creat/{department_id}", name=".iz_child_vetka_creat" , requirements={"id"=Guid::PATTERN})
//      * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
//     * @param PlemMatka $plemmatka
//     * @param Rasa $rasa
//     * @param Linia $linia
// 	* @param LiniaFetcher $linias
//     * @param string $department_id
//     * @param Request $request
//     * @param CreateNomLin\Handler $handler
//     * @return Response
//     */
//     public function izChildVetkaCreate(Request $request,
//                                         PlemMatka $plemmatka, 
//                                         Linia $linia, 
//                                         string $department_id, 
//                                         LiniaFetcher $linias,  
//                                         CreateNomLin\Handler $handler): Response
//    {
// dd($plemmatka);
//     //   $nameStar =  ($linia->getNomer(new NomerId($id)))->getNameStar();
//     //    $name =  ($linia->getNomer(new NomerId($id)));
//         //       dd( $name);
//         $rasa = $linia->getRasa();
//        $maxSort = $linias->getMaxSortLinia($linia->getRasa()->getId()->getValue()) + 1;

//        $command = CreateNomLin\Command::fromRasa($rasa, $linia, $maxSort, $nameStar, $id);// заполнение  значениями из Rasa

//         if ($vetka = $request->query->get('vetka')) {
//             $command->vetka = $vetka;
//         }

//         $form = $this->createForm(CreateNomLin\Form::class, $command);
//         $form->handleRequest($request);
//         // if ($form->isSubmitted() && $form->isValid()) {
//             try {
//                 $handler->handle($command);
//                 return $this->redirectToRoute('adminka.rasas.linias.nomers', ['linia_id' => $linia->getId()]);
//             } catch (\DomainException $e) {
//                 $this->errors->handle($e);
//                 $this->addFlash('error', $e->getMessage());
//                 // $this->logger->warning($e->getMessage(), ['exception' => $e]);
//                 // $this->addFlash('error', $e->getMessage());
//             }
//         // }
//         return $this->render('app/adminka/rasas/linias/create.html.twig', [
//             'vetka' => $vetka,
//             'rasa' => $rasa,
//             // 'form' => $form->createView(),
//             'name' => $command->title,
//         ]);
//    }
}

