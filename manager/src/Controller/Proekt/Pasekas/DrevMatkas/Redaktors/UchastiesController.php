<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\DrevMatkas\Redaktors;

use App\Annotation\Guid;
use App\Model\Adminka\Entity\DrevMatkas\DrevMatka\DrevMatka;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Id;
use App\Model\Adminka\UseCase\DrevMatkas\DrevMatka\UchasDrev;

use App\Controller\ErrorHandler;
use App\Security\Voter\Adminka\Matkas\PlemMatkaAccess;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/proekts/pasekas/drevmatkas/{plemmatka_id}/redaktors/uchasties", name="app.proekts.pasekas.drevmatkas.redaktors.uchasties")
 * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
 */
class UchastiesController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("", name="")
     * @param DrevMatka $plemmatka
     * @return Response
     */
    public function index(DrevMatka $plemmatka): Response
    {
//        $this->denyAccessUnlessGranted(DrevMatkaAccess::MANAGE_UCHASTIES, $plemmatka);
// выводит из проекта uchastniks - учстников
        return $this->render('app/proekts/pasekas/drevmatkas/redaktors/uchasties/index.html.twig', [
            'plemmatka' => $plemmatka,
            'uchastniks' => $plemmatka->getUchasdrevs(),
        ]);
    }

//    /**
//     * @Route("/assign", name=".assign")
//     * @param DrevMatka $plemmatka
//     * @param Request $request
//     * @param Uchastnik\Add\Handler $handler
//     * @return Response
//     */
//    public function assign(DrevMatka $plemmatka, Request $request, Uchastnik\Add\Handler $handler): Response
//    {
//        // Привязывает к проекту-ПлемМатка - нового  сотрудника
//       // $this->denyAccessUnlessGranted(DrevMatkaAccess::MANAGE_UCHASTIES, $plemmatka);
////Проверка на : Если попытается привязать сотрудника, но еще нет департ-сообщества, то соотв. сообщение
//        if (!$plemmatka->getDepartments()) {
//            $this->addFlash('error', 'Добавьте сезоны перед добавлением участников.');
//            return $this->redirectToRoute('paseka.matkas.plemmatka.redaktors.uchasties', ['plemmatka_id' => $plemmatka->getId()]);
//        }
//
//        $command = new Uchastnik\Add\Command($plemmatka->getId()->getValue());
//
//        $form = $this->createForm(Uchastnik\Add\Form::class, $command, ['plemmatka' => $plemmatka->getId()->getValue()]);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            try {
//                $handler->handle($command);
//                return $this->redirectToRoute('paseka.matkas.plemmatka.redaktors.uchasties', ['plemmatka_id' => $plemmatka->getId()]);
//            } catch (\DomainException $e) {
//                $this->errors->handle($e);
//                $this->addFlash('error', $e->getMessage());
//            }
//        }
//
//        return $this->render('app/paseka/matkas/plemmatka/redaktors/uchasties/assign.html.twig', [
//            'plemmatka' => $plemmatka,
//            'form' => $form->createView(),
//        ]);
//    }

    /**
     * @Route("/edit", name=".edit")
     * @param DrevMatka $plemmatka
//     * @param string $uchastie_id
     * @param Request $request
     * @param UchasDrev\EditSez\Handler $handler
     * @return Response
     */
    public function edit( Request $request,
                        DrevMatka $plemmatka,
                        UchasDrev\EditSez\Handler $handler): Response
    {
        //$this->denyAccessUnlessGranted(DrevMatkaAccess::MANAGE_UCHASTIES, $plemmatka);
        $uchasdrevI = $plemmatka->getPersona()->getId()->getValue();
        if ($uchasdrevI ==! $this->getUser()->getId()) {
            $this->addFlash('error', 'Эту матку зарегистрировали не Вы.');
            return $this->redirectToRoute('app.proekts.pasekas.drevmatkas');
        }

//        $uchasdrev = $plemmatka->getUchasDrev(new Id($this->getUser()->getId()));
        $uchasdrev = $plemmatka->getUchasDrev(new Id($uchasdrevI));
        $command = UchasDrev\EditSez\Command::fromUchasDrev($plemmatka, $uchasdrev);

        $form = $this->createForm(UchasDrev\EditSez\Form::class, $command, ['plemmatka' => $plemmatka->getId()->getValue()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('app.proekts.pasekas.drevmatkas.redaktors.show', ['plemmatka_id' => $plemmatka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/proekts/pasekas/drevmatkas/redaktors/uchasties/edit.html.twig', [
            'plemmatka' => $plemmatka,
            'uchasdrev' => $uchasdrev,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/{uchastie_id}", name=".show", requirements={"uchastie_id"=Guid::PATTERN}))
     * @param DrevMatka $plemmatka
     * @return Response
     */
    public function show(DrevMatka $plemmatka): Response
    {
        return $this->redirectToRoute('app.proekts.pasekas.drevmatkas.redaktors.uchasties', ['plemmatka_id' => $plemmatka->getId()]);
    }
}
