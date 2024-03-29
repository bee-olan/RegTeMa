<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Personaa;

use App\Annotation\Guid;

use App\ReadModel\Adminka\Uchasties\PersonaFetcher;
use App\ReadModel\User\UserFetcher;

//use App\ReadModel\Paseka\Uchasties\PersonaFetcher;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Controller\ErrorHandler;


/**
 * @Route("/proekt/personaa", name="proekt.personaa")
 */
class InformController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


	/**
     * @Route("/inform", name=".inform")
     * @return Response
     * @return UserFetcher $users
     * @param PersonaFetcher $uchasties
     */
    public function inform(PersonaFetcher $uchasties, UserFetcher $users): Response
    {
       
        $user = $users->get($this->getUser()->getId());
        $last = $user->getName()->getLast();

        $personas = $uchasties->allPers();

        $personanom = $uchasties ->find($this->getUser()->getId());


        return $this->render('proekt/personaa/inform.html.twig',
                                compact('personas', 'personanom', 'last'));
    }
}
