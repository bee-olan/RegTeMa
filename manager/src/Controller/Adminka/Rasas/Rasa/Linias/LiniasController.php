<?php

declare(strict_types=1);

namespace App\Controller\Adminka\Rasas\Rasa\Linias;

use App\Annotation\Guid;
use App\Model\Adminka\Entity\Rasas\Linias\Id;
use App\Model\Adminka\Entity\Rasas\Linias\Linia;

use App\Model\Adminka\Entity\Rasas\Linias\LiniaRepository;
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
 * @Route("/adminka/rasas/{id}/linias", name="adminka.rasas.linias")
 */
class LiniasController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("/show", name=".show")
     * @param Request $request
//     *  @param Linia $linia
     * @param LiniaRepository $linias
     * @return Response
     */
    public function show(Request $request, LiniaRepository $linias, string $id): Response
    {
        $linia = $linias->get(new Id($id)) ;

        return $this->redirectToRoute('adminka.rasas.linias',
				['id' => $linia->getRasa()->getId()->getValue()]);
    }
}
