<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\Matkas\PlemMatka\Redaktors;

use App\Annotation\Guid;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Id;
use App\Model\Adminka\UseCase\Matkas\PlemMatka\Uchastnik;

use App\Controller\ErrorHandler;
use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatka;
use App\Security\Voter\Adminka\Matkas\PlemMatkaAccess;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/proekts/pasekas/matkas/{plemmatka_id}/redaktorss/uchastiess", name="app.proekts.pasekas.matkas.plemmatkas.redaktorss.uchastiess")
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
     * @param PlemMatka $plemmatka
     * @return Response
     */
    public function index(PlemMatka $plemmatka): Response
    {
//        $this->denyAccessUnlessGranted(PlemMatkaAccess::MANAGE_UCHASTIES, $plemmatka);
// выводит из проекта uchastniks - учстников
        return $this->render('app/proekts/pasekas/matkas/plemmatkas/redaktorss/uchastiess/index.html.twig', [
            'plemmatka' => $plemmatka,
            'uchastniks' => $plemmatka->getUchastniks(),
        ]);
    }

//    /**
//     * @Route("/assign", name=".assign")
//     * @param PlemMatka $plemmatka
//     * @param Request $request
//     * @param Uchastnik\Add\Handler $handler
//     * @return Response
//     */
//    public function assign(PlemMatka $plemmatka, Request $request, Uchastnik\Add\Handler $handler): Response
//    {
//        // Привязывает к проекту-ПлемМатка - нового  сотрудника
//       // $this->denyAccessUnlessGranted(PlemMatkaAccess::MANAGE_UCHASTIES, $plemmatka);
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
     * @param PlemMatka $plemmatka
//     * @param string $uchastie_id
     * @param Request $request
     * @param Uchastnik\EditSez\Handler $handler
     * @return Response
     */
    public function edit( Request $request,
                        PlemMatka $plemmatka,
                        Uchastnik\EditSez\Handler $handler): Response
    {
        //$this->denyAccessUnlessGranted(PlemMatkaAccess::MANAGE_UCHASTIES, $plemmatka);
        $uchastnikI = $plemmatka->getPersona()->getId()->getValue();
        if ($uchastnikI ==! $this->getUser()->getId()) {
            $this->addFlash('error', 'Эту матку зарегистрировали не Вы.');
            return $this->redirectToRoute('app.proekts.pasekas.matkas');
        }
//dd($this->getUser()->getId());
//        $uchastnik = $plemmatka->getUchastnik(new Id($this->getUser()->getId()));
        $uchastnik = $plemmatka->getUchastnik(new Id($uchastnikI));
        $command = Uchastnik\EditSez\Command::fromUchastnik($plemmatka, $uchastnik);

        $form = $this->createForm(Uchastnik\EditSez\Form::class, $command, ['plemmatka' => $plemmatka->getId()->getValue()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('app.proekts.pasekas.matkas.plemmatkas.redaktorss.show', ['plemmatka_id' => $plemmatka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/proekts/pasekas/matkas/plemmatkas/redaktorss/uchastiess/edit.html.twig', [
            'plemmatka' => $plemmatka,
            'uchastnik' => $uchastnik,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/{uchastie_id}", name=".show", requirements={"uchastie_id"=Guid::PATTERN}))
     * @param PlemMatka $plemmatka
     * @return Response
     */
    public function show(PlemMatka $plemmatka): Response
    {
        return $this->redirectToRoute('paseka.matkas.plemmatka.redaktors.uchasties', ['plemmatka_id' => $plemmatka->getId()]);
    }
}
