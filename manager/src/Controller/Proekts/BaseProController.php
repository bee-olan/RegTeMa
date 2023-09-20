<?php

declare(strict_types=1);

namespace App\Controller\Proekts;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BaseProController extends AbstractController
{
    /**
     * @Route("/proekts/base-pro", name="proekts.base-pro")
     * @return Response
     */
    public function basePro(): Response
    {
//        return $this->redirectToRoute('/proekts/base-pro');
        return $this->render('app/proekts/base-pro.html.twig');
    }
}
