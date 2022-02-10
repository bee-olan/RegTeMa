<?php

declare(strict_types=1);

namespace App\Controller\Work;

use phpcent\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/work", name="work")
     * @return Response
     */
    public function index(Client $centrifugo): Response
    {
        $centrifugo->publish('alerts', ['message'=> 'PHP-HELLO!']);
			return $this->redirectToRoute('work.projects');
    }
}
