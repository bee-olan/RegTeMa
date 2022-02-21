<?php

declare(strict_types=1);

namespace App\Controller\Matkis;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/matkis", name="matkis")
     * @return Response
     */
    public function index(): Response
    {
        return $this->redirectToRoute('matkis.u4astniks.groups');
    }
}
