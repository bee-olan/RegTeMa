<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\PlemMatka;

use App\Annotation\Guid;

use App\Model\Adminka\Entity\Matkas\Kategoria\Permission;

use App\ReadModel\Adminka\Matkas\KategoriaFetcher;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/proekts/pasekas/matkas/kategor/kategor", name="app.proekts.pasekas.matkas.kategor.kategor")
 */
class KategorController extends AbstractController
{
 
    /**
     * @Route("/", name="")
     * @param Request $request
     * @param KategoriaFetcher $kategoria
     * @return Response
     */
    public function kategor( KategoriaFetcher $kategoria): Response
    {
        $kategorias = $kategoria->all();
       $permissions = Permission::names();

        return $this->render('app/proekts/pasekas/matkas/kategor/kategor.html.twig',
            compact('kategorias', 'permissions') );
    }

}