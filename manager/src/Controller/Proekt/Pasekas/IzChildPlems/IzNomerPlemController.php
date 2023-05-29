<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\IzChildPlems;

use App\Annotation\Guid;

use App\Model\Adminka\Entity\Matkas\ChildMatka\Id as ChildId;
use App\Model\Adminka\Entity\Matkas\ChildMatka\ChildMatkaRepository;
use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatkaRepository;
use App\Model\Adminka\Entity\Rasas\Linias\Nomers\NomerRepository;
use App\Model\Adminka\Entity\Rasas\Linias\Nomers\Id;

use App\Model\Adminka\UseCase\IzChildPlems\CreateNomerPlem;
use App\Model\Adminka\Entity\Rasas\Linias\Nomers\Nomer;

use App\Controller\ErrorHandler;
use App\ReadModel\Adminka\Matkas\PlemMatka\PlemMatkaFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/proekt/pasekas/izChildPlems", name="proekt.pasekas.izChildPlems")
 */
class IzNomerPlemController extends AbstractController
{

    private $errors;

    public function __construct( ErrorHandler $errors)
    {
        $this->errors = $errors;
    }


    /**
    * @Route("/{id}/izNomerPlem", name=".izNomerPlem")
    * @param Request $request
    * @param NomerRepository $nomers
    * @param PlemMatkaRepository $plemRepo
    * @param PlemMatkaFetcher $plemFet
    * @param string $id
    * @param CreateNomerPlem\Handler $handler
    * @return Response
    */
    public function izNomerPlem( Request $request,
                                 CreateNomerPlem\Handler $handler,
                                 string $id,
                                 NomerRepository $nomers,
//                                 ChildMatkaRepository $childRepo,
                                 PlemMatkaFetcher $plemFet,
                                PlemMatkaRepository $plemRepo
                                ): Response
    {
        $nomerId = (new Id($id))->getValue();

        $sort = $plemFet->getMaxSort() + 1;

        $command = new CreateNomerPlem\Command($this->getUser()->getId(), $sort, $nomerId );

        try {
                $handler->handle($command);
            $plemmatka_id = $plemRepo->getPlemId($command->name);

                return $this->redirectToRoute('proekt.pasekas.izChildPlems.createDepart',
                    [ 'plemmatka_id' => $plemmatka_id ]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }

//
//        return $this->render('proekt/pasekas/izChildPlems/izNomerPlem.html.twig',
//            compact('plemmatka'
//            ));
    }


}
