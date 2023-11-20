<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\DrevMatkas\Redaktors;

use App\Annotation\Guid;

use App\Model\Adminka\Entity\DrevMatkas\DrevMatka\DrevMatka;
use App\Model\Adminka\Entity\DrevMatkas\DrevMatka\SezonDrev\Id;

//use  App\Model\Adminka\UseCase\Matkas\PlemMatka\Department\Create;
//use  App\Model\Adminka\UseCase\Matkas\PlemMatka\Department\Edit;
//use  App\Model\Adminka\UseCase\Matkas\PlemMatka\Department\Remove;

use App\Controller\ErrorHandler;

use App\ReadModel\Adminka\DrevMatkas\SezonDrevFetcher;
use App\Security\Voter\Adminka\Matkas\PlemMatkaAccess;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/proekts/pasekas/drevmatkas/{plemmatka_id}/redaktors/sezondrevs", name="app.proekts.pasekas.drevmatkas.redaktors.sezondrevs")
 * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
 */
class SezonDrevController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("", name="")
     * @param DrevMatka $plemmatka
     * @param SezonDrevFetcher $sezonDrevs
     * @return Response
     */
    public function index(DrevMatka $plemmatka, SezonDrevFetcher $sezonDrevs): Response
    {
//        $this->denyAccessUnlessGranted(PlemMatkaAccess::MANAGE_UCHASTIES, $plemmatka);
dd($sezonDrevs->allOfDrevMatka($plemmatka->getId()->getValue()));

        return $this->render('app/proekts/pasekas/drevmatkas/redaktors/sezondrevs/index.html.twig', [
            'plemmatka' => $plemmatka,
            'sezonDrevs' => $sezonDrevs->allOfDrevMatka($plemmatka->getId()->getValue()),
        ]);
    }

    /**
     * @Route("/{id}", name=".show", requirements={"id"=Guid::PATTERN}))
     * @param DrevMatka $plemmatka
     * @return Response
     */
    public function show(DrevMatka $plemmatka): Response
    {
        return $this->redirectToRoute('paseka.matkas.plemmatka.redaktors.departments', ['plemmatka_id' => $plemmatka->getId()]);
    }
}
