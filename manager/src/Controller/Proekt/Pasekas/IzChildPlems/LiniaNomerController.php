<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\IzChildPlems;

use App\Annotation\Guid;

use App\Model\Adminka\UseCase\IzChildPlems\CreateLiniaNomer;

use App\Model\Adminka\Entity\Rasas\Linias\Nomers\Id;
use App\Model\Adminka\Entity\Rasas\Linias\Linia;
use App\Model\Adminka\Entity\Rasas\Linias\Nomers\Nomer;



use App\ReadModel\Adminka\Rasas\Linias\Nomers\NomerFetcher;
//use App\Security\Voter\Paseka\Materis\Linia\LiniaAccess;
use App\Controller\ErrorHandler;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/proekt/pasekas/izChildPlems/{linia_id}", name="proekt.pasekas.izChildPlems")
 * @ParamConverter("linia", options={"id" = "linia_id"})
 */
class LiniaNomerController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("/{name_star}/createLiniaNomer", name=".createLiniaNomer")
     * @param Request $request
     * @param Linia $linia
     * @param NomerFetcher $nomers
     * @param string $name_star
     * @param CreateLiniaNomer\Handler $handler
     * @return Response
     */
    public function createLiniaNomer( Request $request, string $name_star,
                                      CreateLiniaNomer\Handler $handler,
                                        Linia $linia,  
                                        NomerFetcher $nomers): Response
    {


        $maxSort = $nomers->getMaxSortNomer($linia->getId()->getValue()) + 1;

        $command = CreateLiniaNomer\Command::fromLinia($linia,
                                    $maxSort,
                                    $name_star);// заполнение  значениями из

        // $form = $this->createForm(CreateChildNomer\Form::class, $command);

        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
            try {
                 $handler->handle($command);
                $nomer  = $nomers->newNomer($command->linia, $command->nameStar);
//                dd($nomer[0]['id']);
                $id = (new Id($nomer[0]['id']))->getValue();
//                dd("стоп !!!");
                return $this->redirectToRoute('proekt.pasekas.izChildPlems.izNomerPlem', ['id' => (new Id($nomer[0]['id']))->getValue()]);
            } catch (\DomainException $e) {
                $this->logger->warning($e->getMessage(), ['exception' => $e]);
                $this->addFlash('error', $e->getMessage());
            }
        // }
        return $this->render('proekt/pasekas/izChildPlems/createLiniaNomer.html.twig', [
            'linia' => $linia,
            // 'form' => $form->createView(),
            'name' => $command->title,
        ]);
    }

}
