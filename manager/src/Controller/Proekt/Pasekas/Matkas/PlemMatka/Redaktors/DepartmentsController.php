<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\Matkas\PlemMatka\Redaktors;

use App\Annotation\Guid;
use App\Model\Adminka\Entity\Matkas\PlemMatka\Department\Id;

use  App\Model\Adminka\UseCase\Matkas\PlemMatka\Department\Create;
use  App\Model\Adminka\UseCase\Matkas\PlemMatka\Department\Edit;
use  App\Model\Adminka\UseCase\Matkas\PlemMatka\Department\Remove;
use App\ReadModel\Adminka\Matkas\PlemMatka\DepartmentFetcher;
//use App\Security\Voter\Work\Projects\ProjectAccess;
use App\Controller\ErrorHandler;
use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatka;
use App\Security\Voter\Adminka\Matkas\PlemMatkaAccess;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/proekts/pasekas/matkas/plemmatkas/{plemmatka_id}/redaktorss/departmentss", name="app.proekts.pasekas.matkas.plemmatkas.redaktorss.departmentss")
 * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
 */
class DepartmentsController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("", name="")
     * @param PlemMatka $plemmatka
     * @param DepartmentFetcher $departments
     * @return Response
     */
    public function index(PlemMatka $plemmatka, DepartmentFetcher $departments): Response
    {
//        $this->denyAccessUnlessGranted(PlemMatkaAccess::MANAGE_UCHASTIES, $plemmatka);
//dd($plemmatka->getId()->getValue());

        return $this->render('app/proekts/pasekas/matkas/plemmatkas/redaktorss/departmentss/index.html.twig', [
            'plemmatka' => $plemmatka,
            'departmentss' => $departments->allOfPlemMatka($plemmatka->getId()->getValue()),
        ]);
    }

    /**
     * @Route("/{id}", name=".show", requirements={"id"=Guid::PATTERN}))
     * @param PlemMatka $plemmatka
     * @return Response
     */
    public function show(PlemMatka $plemmatka): Response
    {
        return $this->redirectToRoute('paseka.matkas.plemmatka.redaktors.departments', ['plemmatka_id' => $plemmatka->getId()]);
    }
}
