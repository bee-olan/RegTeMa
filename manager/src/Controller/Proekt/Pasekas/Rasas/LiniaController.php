<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\Rasas;

use App\Annotation\Guid;
use App\Model\Adminka\Entity\Rasas\Rasa;
use App\Model\Adminka\Entity\Rasas\Linias\Linia;
use App\ReadModel\Adminka\Rasas\Linias\CommentLiniaFetcher;
use App\ReadModel\Adminka\Rasas\Linias\LiniaFetcher;
use App\Model\Comment\UseCase\Comment;
use App\Controller\ErrorHandler;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/proekts/pasekas/rasas/{id}/linias", name="app.proekts.pasekas.rasas.linias")
 */
class LiniaController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }


    /**
     * @Route("/plemmatka", name=".plemmatka")
     * @param Rasa $rasa
     * @param Request $request
     * @param CommentLiniaFetcher $comments
     * @param Comment\AddLinia\Handler $commentHandler
     * @param LiniaFetcher $linias
     * @return Response
     */
    public function plemmatka(  Request $request,
                                Rasa $rasa,
                               LiniaFetcher $linias,
                               CommentLiniaFetcher $comments,
                               Comment\AddLinia\Handler $commentHandler
                                ): Response
    {
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
                return $this->redirectToRoute('app.proekts.pasekas.rasas.linias.plemmatka', ['id' => $rasa->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }
//dd($linias->allOfRasa($rasa->getId()->getValue()));
        return $this->render('app/proekts/pasekas/rasas/linias/plemmatka.html.twig', [
            'rasa' => $rasa,
            'linias' => $linias->allOfRasa($rasa->getId()->getValue()),
            'comments' => $comments->allForLinia($rasa->getId()->getValue()),
            'commentForm' => $commentForm->createView(),
        ]);
    }

    /**
     * @Route("/{linia_id}", name=".show", requirements={"linia_id"=Guid::PATTERN})
     * @param Rasa $rasa
     * @return Response
     */
    public function show(Rasa $rasa): Response
    {
        return $this->redirectToRoute('app.proekts.pasekas.rasas.linias',
				['id' => $rasa->getId()]);
    }
}
