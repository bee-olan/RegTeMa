<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\IzChildPlems;

use App\Annotation\Guid;

use App\Model\Adminka\Entity\Uchasties\Uchastie\Id;
use App\Model\Adminka\UseCase\IzChildPlems\CreateAssign;

use App\Controller\ErrorHandler;
use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatka;
use App\Security\Voter\Adminka\Matkas\PlemMatkaAccess;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/proekt/pasekas/izChildPlems", name="proekt.pasekas.izChildPlems")
 * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
 */
class CreateUchController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }


    /**
     * @Route("/{plemmatka_id}/assign", name=".assign")
     * @param PlemMatka $plemmatka
     * @param Request $request
     * @param CreateAssign\Handler $handler
     * @return Response
     */
    public function assign(Request $request, PlemMatka $plemmatka, CreateAssign\Handler $handler): Response
    {
        // Привязывает к проекту-ПлемМатка - нового  сотрудника
//        $this->denyAccessUnlessGranted(PlemMatkaAccess::MANAGE_UCHASTIES, $plemmatka);
        $session = new Session();
        $childSs =  $session->get('childS');

        //Проверка на : Если попытается привязать сотрудника, но еще нет департ-сообщества, то соотв. сообщение
        if (!$plemmatka->getDepartments()) {
            $this->addFlash('error', 'Добавьте СЕЗОНЫ перед добавлением участников.');
            return $this->redirectToRoute('adminka.matkas.plemmatka.redaktors.uchasties', ['plemmatka_id' => $plemmatka->getId()]);
        }

//        $command = new CreateAssign\Command($plemmatka->getId()->getValue(), $childId);
        $command = new CreateAssign\Command($plemmatka->getId()->getValue());
            try {
                $handler->handle($command);
                $session->clear();
//                dd("стор assign");
                return $this->redirectToRoute('proekt.pasekas.matkas');
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }

    }

}
