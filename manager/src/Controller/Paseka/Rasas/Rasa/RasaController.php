<?php

declare(strict_types=1);

namespace App\Controller\Paseka\Rasas\Rasa;

use App\Annotation\Guid;
use App\Model\Paseka\Entity\Rasas\Rasa\Rasa;
//use App\Model\Work\Entity\Projects\Project\Project;
//use App\Security\Voter\Work\Projects\ProjectAccess;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/paseka/rasas/{id}", name="paseka.rasas.rasa")
 */
class RasaController extends AbstractController
{
    /**
     * @Route("", name=".show", requirements={"id"=Guid::PATTERN})
     * @param Rasa $rasa
     * @return Response
     */
    public function show(Rasa $rasa): Response
    {
        // $this->denyAccessUnlessGranted(ProjectAccess::VIEW, $project);

        return $this->render('app/paseka/rasas/rasa/show.html.twig', compact('rasa'));
    }
}
