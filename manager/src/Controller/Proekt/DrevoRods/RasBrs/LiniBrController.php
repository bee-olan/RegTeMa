<?php

declare(strict_types=1);

namespace App\Controller\Proekt\DrevoRods\RasBrs;

use App\Annotation\Guid;

use App\Model\Drevos\Entity\Rass\Ras;
use App\Model\Comment\UseCase\Comment;
use App\Controller\ErrorHandler;
use App\ReadModel\Drevos\Rass\LiniBrs\CommentLiniaFetcher;
use App\ReadModel\Drevos\Rass\LiniBrs\LiniBrFetcher;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/proekts/drevorods/rasbrs/{id}/linibrs", name="app.proekts.drevorods.rasbrs.linibrs")
 */
class LiniBrController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }


    /**
     * @Route("/plemlini", name=".plemlini")
     * @param Ras $rasa
     * @param Request $request
     * @param CommentLiniaFetcher $comments
     * @param Comment\AddLinia\Handler $commentHandler
     * @param LiniBrFetcher $linias
     * @return Response
     */
    public function plemlini(  Request $request,
                                Ras $rasa,
                               LiniBrFetcher $linias,
                               CommentLiniaFetcher $comments,
                               Comment\AddLinia\Handler $commentHandler
                                ): Response
    {

        $commentCommand = new Comment\AddLinia\Command(
            $this->getUser()->getId(),
            Ras::class,
            $rasa->getId()->getValue()
        );

        $commentForm = $this->createForm(Comment\AddLinia\Form::class, $commentCommand);

        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            try {
                $commentHandler->handle($commentCommand);
//                dd("ok!!!.??");
                return $this->redirectToRoute('app.proekts.drevorods.rasbrs.linibrs.plemlini', ['id' => $rasa->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }
//dd($linias->allOfRasa($rasa->getId()->getValue()));
        return $this->render('app/proekts/drevorods/rasbrs/linibrs/plemlini.html.twig', [
            'rasa' => $rasa,
            'linias' => $linias->allOfRas($rasa->getId()->getValue()),
            'comments' => $comments->allForLinia($rasa->getId()->getValue()),
            'commentForm' => $commentForm->createView(),
        ]);
    }

//    /**
//     * @Route("/{linia_id}", name=".show", requirements={"linia_id"=Guid::PATTERN})
//     * @param Ras $rasa
//     * @return Response
//     */
//    public function show(Ras $rasa): Response
//    {
//        return $this->redirectToRoute('app.proekts.pasekas.rasas.linias',
//				['id' => $rasa->getId()]);
//    }
}
