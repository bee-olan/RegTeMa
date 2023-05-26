<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\IzChildPlems;

use App\Model\Adminka\Entity\Matkas\ChildMatka\ChildMatkaRepository;
use App\Model\Adminka\Entity\Matkas\ChildMatka\Id;


use App\Model\Adminka\UseCase\Matkas\ChildMatka\Executor;
use App\Model\Adminka\UseCase\Matkas\ChildMatka\Plan;
use App\Model\Adminka\UseCase\Matkas\ChildMatka\PerewodPlem;
use App\Model\Adminka\UseCase\Matkas\ChildMatka\Take;
use App\Model\Adminka\UseCase\Matkas\ChildMatka\TakeAndStart;
use App\Model\Adminka\Entity\Matkas\ChildMatka\ChildMatka;
use App\ReadModel\Proekt\Pasekas\ChildMatka\Side\Filter;
use App\ReadModel\Proekt\Pasekas\ChildMatka\Side\ChildSideFetcher;

use App\Controller\ErrorHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/proekt/pasekas/izChildPlems", name="proekt.pasekas.izChildPlems")
// * @ParamConverter("childmatka", options={"id" = "childId"})
 */
class PerewodPlemController extends AbstractController
{
    private const PER_PAGE = 50;

    private $errors;

    public function __construct( ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

//, methods={"POST"}) ?????????????????????????????????////
    /**
     * @Route("/{childId}/perewodPlem", name=".perewodPlem")
     * @param Request $request
     * @param ChildMatkaRepository $childRepo
     * @param int $childId
     * @param PerewodPlem\Handler $handler
     * @return Response
     */
    public function perewodPlem(Request $request,
                                ChildMatkaRepository $childRepo,
                                int $childId,
                                PerewodPlem\Handler $handler): Response
    {

        $childmatka = $childRepo->get(new Id($childId));
//        dd($childmatka);

//        if (!$this->isCsrfTokenValid('perewodPlem', $request->request->get('token'))) {
//            return $this->redirectToRoute('proekt.pasekas.childmatkas.show', ['id' => $childmatka->getId()]);
//        }

        // $this->denyAccessUnlessGranted(ChildMatkaAccess::MANAGE, $childmatka);

        $command = new PerewodPlem\Command($this->getUser()->getId(), $childmatka->getId()->getValue());

        try {
            $handler->handle($command);
//            return $this->redirectToRoute('proekt.pasekas.matkas');
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('proekt.pasekas.childmatkas.show', ['id' => $childmatka->getId()]);
    }   

}

