<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\IzChildPlems;

use App\Annotation\Guid;
use App\Model\Adminka\Entity\Matkas\PlemMatka\Department\Id;

use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatkaRepository;
use  App\Model\Adminka\UseCase\IzChildPlems\CreadDepart;

use App\Security\Voter\Adminka\Matkas\PlemMatkaAccess;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Controller\ErrorHandler;
use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatka;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/proekt/pasekas/izChildPlems", name="proekt.pasekas.izChildPlems")
 */
class CreateDepartController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }


    /**
     * @Route("/{plemmatka_id}/createDepart", name=".createDepart")
     * @param Request $request
//     * @param PlemMatka $plemmatka
     * @param string $plemmatka_id
     * @param CreadDepart\Handler $handler
     * @return Response
     */
    public function createDepart(Request $request, string $plemmatka_id,
//                                 PlemMatka $plemmatka,
                                 CreadDepart\Handler $handler): Response
    {
//        dd($plemmatka_id);
        $command = new CreadDepart\Command($plemmatka_id);

        try {
            $handler->handle($command);
//            dd("из depart");
            return $this->redirectToRoute('proekt.pasekas.izChildPlems.perewodPlem', [ 'plemmatka_id' => $plemmatka_id ]);

        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

    }
}

