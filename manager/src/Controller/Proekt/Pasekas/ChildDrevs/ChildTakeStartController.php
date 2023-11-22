<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\ChildDrevs;

use App\Model\Adminka\Entity\DrevMatkas\ChildDrevs\ChildDrev;
use App\Model\Adminka\UseCase\DrevMatkas\ChildDrev\Executor;
use App\Model\Adminka\UseCase\DrevMatkas\ChildDrev\Plan;
use App\Model\Adminka\UseCase\DrevMatkas\ChildDrev\Start;
use App\Model\Adminka\UseCase\DrevMatkas\ChildDrev\Take;
use App\Model\Adminka\UseCase\DrevMatkas\ChildDrev\TakeAndStart;

//use App\Model\Adminka\Entity\DrevMatkas\ChildDrevs\Side\Filter;
//use App\Model\Adminka\Entity\DrevMatkas\ChildDrevs\ChildSideFetcher;

use App\Controller\ErrorHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("proekt/pasekas/childmatkas", name="proekt.pasekas.childmatkas")
 * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
 */
class ChildTakeStartController extends AbstractController
{
    private const PER_PAGE = 50;

    private $errors;

    public function __construct( ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("/{id}/take", name=".take", methods={"POST"})
     * @param ChildDrev $childmatka
     * @param Request $request
     * @param Take\Handler $handler
     * @return Response
     */
    public function take(ChildDrev $childmatka, Request $request, Take\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('take', $request->request->get('token'))) {
            return $this->redirectToRoute('proekt.pasekas.childmatkas.show', ['id' => $childmatka->getId()]);
        }

        // $this->denyAccessUnlessGranted(ChildDrevAccess::MANAGE, $childmatka);

        $command = new Take\Command($this->getUser()->getId(), $childmatka->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('proekt.pasekas.childmatkas.show', ['id' => $childmatka->getId()]);
    }

    /**
     * @Route("/{id}/take/start", name=".take_and_start", methods={"POST"})
     * @param ChildDrev $childmatka
     * @param Request $request
     * @param TakeAndStart\Handler $handler
     * @return Response
     */
    public function takeAndStart(ChildDrev $childmatka, Request $request, TakeAndStart\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('take-and-start', $request->request->get('token'))) {
            return $this->redirectToRoute('proekt.pasekas.childmatkas.show', ['id' => $childmatka->getId()]);
        }

        // $this->denyAccessUnlessGranted(ChildDrevAccess::MANAGE, $childmatka);

        $command = new TakeAndStart\Command($this->getUser()->getId(), $childmatka->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('proekt.pasekas.childmatkas.show', ['id' => $childmatka->getId()]);
    }

    /**
     * @Route("/{id}/start", name=".start", methods={"POST"})
     * @param ChildDrev $childmatka
     * @param Request $request
     * @param Start\Handler $handler
     * @return Response
     */
    public function start(ChildDrev $childmatka, Request $request, Start\Handler $handler): Response
    {
        
        if (!$this->isCsrfTokenValid('start', $request->request->get('token'))) {
            return $this->redirectToRoute('proekt.pasekas.childmatkas.show', ['id' => $childmatka->getId()]);
        }

        // $this->denyAccessUnlessGranted(ChildDrevAccess::MANAGE, $childmatka);

        $command = new Start\Command($this->getUser()->getId(), $childmatka->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('proekt.pasekas.childmatkas.show', ['id' => $childmatka->getId()]);
    }   

}

