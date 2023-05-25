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
     * @Route("/{plemmatka_id},{childId}/assign", name=".assign")
     * @param PlemMatka $plemmatka
     * @param Request $request
     * @param int $childId
     * @param CreateAssign\Handler $handler
     * @return Response
     */
    public function assign(Request $request, PlemMatka $plemmatka, int $childId, CreateAssign\Handler $handler): Response
    {
        // Привязывает к проекту-ПлемМатка - нового  сотрудника
        $this->denyAccessUnlessGranted(PlemMatkaAccess::MANAGE_UCHASTIES, $plemmatka);

        //Проверка на : Если попытается привязать сотрудника, но еще нет департ-сообщества, то соотв. сообщение
        if (!$plemmatka->getDepartments()) {
            $this->addFlash('error', 'Добавьте СЕЗОНЫ перед добавлением участников.');
            return $this->redirectToRoute('adminka.matkas.plemmatka.redaktors.uchasties', ['plemmatka_id' => $plemmatka->getId()]);
        }

        $command = new CreateAssign\Command($plemmatka->getId()->getValue(), $childId);

//        $form = $this->createForm(CreateAssign\Form::class, $command, ['plemmatka' => $plemmatka->getId()->getValue()]);
//        $form->handleRequest($request);

//        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                dd("стор assign");
                return $this->redirectToRoute('adminka.matkas.plemmatka.redaktors.uchasties', ['plemmatka_id' => $plemmatka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
//        }

        return $this->render('app/adminka/matkas/plemmatka/redaktors/uchasties/assign.html.twig', [
            'plemmatka' => $plemmatka,
            'form' => $form->createView(),
        ]);
    }
//
//    /**
//     * @Route("/{uchastie_id}", name=".show", requirements={"uchastie_id"=Guid::PATTERN}))
//     * @param PlemMatka $plemmatka
//     * @return Response
//     */
//    public function show(PlemMatka $plemmatka): Response
//    {
//        return $this->redirectToRoute('adminka.matkas.plemmatka.redaktors.uchasties', ['plemmatka_id' => $plemmatka->getId()]);
//    }
}
