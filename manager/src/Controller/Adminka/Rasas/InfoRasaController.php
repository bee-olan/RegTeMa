<?php

declare(strict_types=1);

namespace App\Controller\Adminka\Rasas;

use App\Model\Adminka\Entity\Rasas\Rasa;
use App\Model\Adminka\Entity\Rasas\Rasas\Linia;
use App\Model\Adminka\Entity\Rasas\Linias\Id;

use App\ReadModel\Adminka\Rasas\RasaFetcher;
use App\ReadModel\Adminka\Rasas\Linias\LiniaFetcher;
use App\Controller\ErrorHandler;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/adminka/rasas", name="adminka.rasas")
 */
// @IsGranted("ROLE_Adminka_MANAGE_MATERIS")

class InfoRasaController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


    /**
     * @Route("/info_rasa", name=".info_rasa")
     * @param Request $request,
     * @param RasaFetcher $fetcher
//     * @param Rasa $rasaR
     * @return Response
     */
    public function infoRasa(Request $request, RasaFetcher $fetcher): Response
    {
        $rasass = $fetcher->all();

    $rasas = $fetcher->allRasaLinNom();

    $rasaLsNs = [];
    foreach ($rasas as $item) {       
         $rasaLsNs[$item['name']][$item['linias']][$item['nomers']][$item['nomer_id']] = $item['nomer_title'];
       // $nomerId[$item['nomers']] = $item['nomer_id'];

    }

//dd($rasaLsNs);
    return $this->render('app/adminka/rasas/info_rasa.html.twig',
								compact('rasaLsNs','rasass'));
    }
	
	 /**
     * @Route("/info_linia/{id}", name=".info_linia")
	 * @ParamConverter("rasas", options={"id" = "rasa_id"})
     * @param Rasa $rasa
     * @param LiniaFetcher $linias
     * @return Response
     */
    public function infoLinia(Rasa $rasa, LiniaFetcher $linias): Response
    {
        //$this->denyAccessUnlessGranted(MateriAccess::MANAGE_MEMBERS, $materi);
       //allOfRasLin
        $liniaa = $linias->allOfRasLin($rasa->getId()->getValue());
        $liniaaa = [];
        foreach ($liniaa as $item) {
            $liniaaa[$item['name_star']][$item['nomers']] = $item['id'];
        }
dd($liniaa);
        return $this->render('app/adminka/rasas/info_linia.html.twig', [
            'rasas' => $rasa,
			'liniaaa' => $liniaaa,
            'linias' => $linias->allOfRasLin($rasa->getId()->getValue()),
        ]);
    }


}
