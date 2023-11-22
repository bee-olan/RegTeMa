<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\ChildDrevs;

use App\Model\Adminka\UseCase\DrevMatkas\ChildDrev\Zakaz;

use App\Controller\ErrorHandler;
use App\Model\Adminka\Entity\DrevMatkas\ChildDrevs\ChildDrev;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("proekt/pasekas/childmatkas", name="proekt.pasekas.childmatkas")
 * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
 */
class ChildZakazStartController extends AbstractController
{
    private const PER_PAGE = 50;

    private $errors;

    public function __construct( ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("/{id}/zakaz", name=".zakaz", methods={"POST"})
     * @param ChildDrev $childmatka
     * @param Request $request
     * @param Zakaz\Handler $handler
     * @return Response
     */
    public function zakaz(ChildDrev $childmatka, Request $request, Zakaz\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('zakaz', $request->request->get('token'))) {
            return $this->redirectToRoute('proekt.pasekas.childmatkas.show', ['id' => $childmatka->getId()]);
        }

        // $this->denyAccessUnlessGranted(ChildDrevAccess::MANAGE, $childmatka);

        $command = new Zakaz\Command($this->getUser()->getId(), $childmatka->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('proekt.pasekas.childmatkas.show', ['id' => $childmatka->getId()]);
    }

}

