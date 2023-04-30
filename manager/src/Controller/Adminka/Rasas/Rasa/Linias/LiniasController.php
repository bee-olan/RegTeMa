<?php

declare(strict_types=1);

namespace App\Controller\Adminka\Rasas\Rasa\Linias;

use App\Annotation\Guid;
use App\Model\Adminka\Entity\Rasas\Linias\Id;
use App\Model\Adminka\Entity\Rasas\Linias\Linia;

use App\ReadModel\Adminka\Rasas\Linias\LiniaFetcher;
//use App\Security\Voter\Adminka\Rasas\MateriAccess;
use App\Controller\ErrorHandler;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/adminka/rasas/linias", name="adminka.rasas.linias")
 */
class LiniasController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("/{id}/show", name=".show", requirements={"id"=Guid::PATTERN})
     * @param Request $request
     * @param Linia $linia
     * @return Response
     */
    public function show(Request $request, Linia $linia): Response
    {
//        dd();
        return $this->redirectToRoute('adminka.rasas.linias',
				['id' => $linia->getRasa()->getId()->getValue()]);
    }
}
