<?php

declare(strict_types=1);

namespace App\Controller\Proekt\DrevoRods\RasBrs;

use App\Annotation\Guid;
//use App\Model\Adminka\Entity\LiniBrs\Rasa;
//use App\Model\Adminka\Entity\Rasas\Linias\Linia;
//use App\ReadModel\Adminka\Rasas\Linias\CommentVetkaBrFetcher;

use App\Model\Comment\UseCase\Comment;
use App\Controller\ErrorHandler;
use App\Model\Drevos\Entity\Rass\LiniBr\LiniBr;
use App\ReadModel\Drevos\Rass\LiniBrs\VetkaBrs\VetkaBrFetcher;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/proekts/drevorods/rasbrs/linibrs/{id}/vetbrs", name="app.proekts.drevorods.rasbrs.linibrs.vetbrs")
 */
class VetBrController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }


    /**
     * @Route("/plemvet", name=".plemvet")
     * @param LiniBr $linia
     * @param Request $request
//     * @param Comment\AddLinia\Handler $commentHandler
     * @param VetkaBrFetcher $vetkas
     * @return Response
     */
    public function plemvet(  Request $request,
                                LiniBr $linia,
                               VetkaBrFetcher $vetkas
//                               Comment\AddLinia\Handler $commentHandler
                                ): Response
    {

//        $commentCommand = new Comment\AddLinia\Command(
//            $this->getUser()->getId(),
//            Ras::class,
//            $linia->getId()->getValue()
//        );

//        $commentForm = $this->createForm(Comment\AddLinia\Form::class, $commentCommand);
//        $commentForm->handleRequest($request);
//        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
//            try {
//                $commentHandler->handle($commentCommand);
//                return $this->redirectToRoute('app.proekts.pasekas.rasas.vetkas.plemmatka', ['id' => $linia->getId()]);
//            } catch (\DomainException $e) {
//                $this->errors->handle($e);
//                $this->addFlash('error', $e->getMessage());
//            }
//        }
//dd($vetkas->allOfLiniBr($linia->getId()->getValue()));
        return $this->render('app/proekts/drevorods/rasbrs/linibrs/vetbrs/plemvet.html.twig', [
            'linia' => $linia,
            'rasa' => $linia->getRasa(),
            'vetkas' => $vetkas->allOfLiniBr($linia->getId()->getValue()),
//            'comments' => $comments->allForLinia($linia->getId()->getValue()),
//            'commentForm' => $commentForm->createView(),
        ]);
    }

//    /**
//     * @Route("/{vetka_id}", name=".show", requirements={"vetka_id"=Guid::PATTERN})
//     * @param LiniBr $linia
//     * @return Response
//     */
//    public function show(LiniBr $linia): Response
//    {
//        return $this->redirectToRoute('app.proekts.pasekas.linias.vetkas',
//				['id' => $linia->getId()]);
//    }
}
