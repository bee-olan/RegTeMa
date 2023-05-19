<?php

declare(strict_types=1);

namespace App\Controller\Adminka\Rasas\Rasa\Linias;

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

/**
 * @Route("/adminka/rasas/linias/nomer_linia/{linia_id}", name="adminka.rasas.linias.nomer_linia")
 */
class NomerLiniaCreateController extends AbstractController
{
    // private $logger;

    // public function __construct(LoggerInterface $logger)
    // {
    //     $this->logger = $logger;
    // }

    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("/vetka/{name_star}", name=".vetka" , requirements={"id"=Guid::PATTERN})
     * @ParamConverter("linia", options={"id" = "linia_id"})
     * @param Rasa $rasa
     * @param Linia $linia
     * @param LiniaFetcher $linias
     * @param string $name_star
     * @return Response
     */
    public function vetka(Request $request, Linia $linia, string $name_star, LiniaFetcher $linias): Response
    {
        $rasa = $linia->getRasa();
//        $liniaa = $linias->allOfVetka($linia->getId()->getValue());
//        dd($name_star );
        return $this->render('app/adminka/rasas/linias/index.html.twig', [
            'rasa' => $rasa,
            'linias' => $linias->allOfVetka($linia->getId()->getValue(), $name_star),
        ]);
    }


    /**
     * @Route("/create/{id}", name=".create" , requirements={"id"=Guid::PATTERN})
     * @ParamConverter("linia", options={"id" = "linia_id"})
     * @param Rasa $rasa
     * @param Linia $linia
	 * @param LiniaFetcher $linias
     * @param string $id
     * @param Request $request
     * @param CreateNomLin\Handler $handler
     * @return Response
     */
    public function create(Request $request, Linia $linia, string $id, LiniaFetcher $linias,  CreateNomLin\Handler $handler): Response
   {
      $nameStar =  ($linia->getNomer(new NomerId($id)))->getNameStar();
       $name =  ($linia->getNomer(new NomerId($id)));
//       dd( $name);
        $rasa = $linia->getRasa();
       $maxSort = $linias->getMaxSortLinia($linia->getRasa()->getId()->getValue()) + 1;
//       $nameStar =  $nameStar."_".$name;

       $command = CreateNomLin\Command::fromRasa($rasa, $linia, $maxSort, $nameStar, $id);// заполнение  значениями из Rasa

        if ($vetka = $request->query->get('vetka')) {
            $command->vetka = $vetka;
        }

        $form = $this->createForm(CreateNomLin\Form::class, $command);
        $form->handleRequest($request);
//dd($command);
        // if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('adminka.rasas.linias.nomers', ['linia_id' => $linia->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
                // $this->logger->warning($e->getMessage(), ['exception' => $e]);
                // $this->addFlash('error', $e->getMessage());
            }
        // }
        return $this->render('app/adminka/rasas/linias/create.html.twig', [
            'vetka' => $vetka,
            'rasa' => $rasa,
            // 'form' => $form->createView(),
            'name' => $command->title,
        ]);
   }

}
