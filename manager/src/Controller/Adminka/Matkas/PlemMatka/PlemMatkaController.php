<?php

declare(strict_types=1);

namespace App\Controller\Adminka\Matkas\PlemMatka;

use App\Annotation\Guid;


use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatka;

use App\Security\Voter\Adminka\Matkas\PlemMatkaAccess;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

    /**
     * @Route("/adminka/matkas/{id}", name="adminka.matkas.plemmatka")
     */
class PlemMatkaController extends AbstractController
{
    /**
     * @Route("", name=".show", requirements={"id"=Guid::PATTERN})
     * @param PlemMatka $plemmatka
     * @return Response
     */
    public function show(PlemMatka $plemmatka): Response
    {
        $this->denyAccessUnlessGranted(PlemMatkaAccess::VIEW, $plemmatka);

        return $this->render('app/adminka/matkas/plemmatka/show.html.twig', [
            'plemmatka' => $plemmatka,
            'uchastniks' => $plemmatka->getUchastniks(),
        ]);
    }
}
