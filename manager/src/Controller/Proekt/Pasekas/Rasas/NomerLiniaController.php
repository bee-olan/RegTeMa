<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\Rasas;

use App\Annotation\Guid;
use App\Model\Adminka\Entity\Rasas\Linias\Id;
use App\Model\Adminka\Entity\Rasas\Linias\Linia;
use App\Model\Adminka\Entity\Rasas\Rasa;

use App\ReadModel\Adminka\Rasas\Linias\CommentLiniaFetcher;
use App\ReadModel\Adminka\Rasas\Linias\LiniaFetcher;
use App\Model\Comment\UseCase\Comment;
use App\Model\Adminka\Entity\Rasas\Linias\Nomers\Id as NomerId;
use App\Controller\ErrorHandler;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/proekt/pasekas/rasas/{linia_id}/linias", name="proekt.pasekas.rasas.linias")
 */
class NomerLiniaController extends AbstractController
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
    //  * @ParamConverter("linia", options={"id" = "linia_id"})
     * @param Rasa $rasa
     * @param Linia $linia
     * @param CommentLiniaFetcher $comments
     * @param Comment\AddLinia\Handler $commentHandler
     * @param LiniaFetcher $linias
     * @param string $name_star
     * @return Response
     */
    public function vetka(Request $request, Linia $linia, string $name_star, 
                        LiniaFetcher $linias,
                        CommentLiniaFetcher $comments,
                        Comment\AddLinia\Handler $commentHandler
                        ): Response
    {
        dd($name_star);
        $rasa = $linia->getRasa();

        $commentCommand = new Comment\AddLinia\Command(
            $this->getUser()->getId(),
            Rasa::class,
            $rasa->getId()->getValue()
        );

        $commentForm = $this->createForm(Comment\AddLinia\Form::class, $commentCommand);
        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            try {
                $commentHandler->handle($commentCommand);
                return $this->redirectToRoute('proekt.pasekas.rasas.linias.plemmatka', ['id' => $rasa->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

       
    //   dd($linias->allOfVetka($linia->getId()->getValue(), $name_star));
//      
return $this->render('proekt/pasekas/rasas/linias/plemmatka.html.twig', [
            'rasa' => $rasa,
            'linias' => $linias->allOfVetka($linia->getId()->getValue(), $name_star),
            'comments' => $comments->allForLinia($rasa->getId()->getValue()),
            'commentForm' => $commentForm->createView(),
        ]);
    }
}
