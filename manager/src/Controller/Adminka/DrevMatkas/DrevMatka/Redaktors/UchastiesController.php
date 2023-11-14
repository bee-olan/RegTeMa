<?php

declare(strict_types=1);

namespace App\Controller\Adminka\DrevMatkas\DrevMatka\Redaktors;

use App\Annotation\Guid;

use App\Model\Adminka\Entity\DrevMatkas\DrevMatka;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Id;
use App\Model\Adminka\Entity\Uchasties\Uchastie\UchastieRepository;
use App\Model\Adminka\UseCase\DrevMatkas\DrevMatka\UchasDrev;

use App\Controller\ErrorHandler;
use App\Security\Voter\Adminka\Matkas\PlemMatkaAccess;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/adminka/drevmatkas/drevmatka/{plemmatka_id}/redaktors/uchasties", name="adminka.drevmatkas.drevmatka.redaktors.uchasties")
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
// выводит из проекта uchasdrevs - учстников


        return $this->render('app/adminka/drevmatkas/drevmatka/redaktors/uchasties/index.html.twig', [
            'plemmatka' => $plemmatka,
            'uchasdrevs' => $plemmatka->getUchasdrevs(),
        ]);
    }

    /**
     * @Route("/assign", name=".assign")
     * @param DrevMatka $plemmatka
     * @param Request $request
     * @param UchasDrev\Add\Handler $handler
     * @param UchastieRepository $uchasRepos;
     * @return Response
     */
    public function assign(Request $request, DrevMatka $plemmatka, UchastieRepository $uchasRepos,  UchasDrev\Add\Handler $handler): Response
    {
        // Привязывает к проекту-ПлемМатка - нового  сотрудника
//        $this->denyAccessUnlessGranted(DrevMatkaAccess::MANAGE_UCHASTIES, $plemmatka);
//dd($plemmatka->getPersona()->getId()->getValue());
        $uchasRepo = $uchasRepos->get(new Id($plemmatka->getPersona()->getId()->getValue()));
        dd($uchasRepo->getNike());
        //Проверка на : Если попытается привязать сотрудника, но еще нет департ-сообщества, то соотв. сообщение
        if (!$plemmatka->getSezondrevs()) {
            $this->addFlash('error', 'Добавьте СЕЗОНЫ перед добавлением участников.');
            return $this->redirectToRoute('adminka.drevmatkas.drevmatka.redaktors.uchasties', ['plemmatka_id' => $plemmatka->getId()]);
        }

        $command = new UchasDrev\Add\Command($plemmatka->getId()->getValue());

        $form = $this->createForm(UchasDrev\Add\Form::class, $command, ['plemmatka' => $plemmatka->getId()->getValue()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('adminka.drevmatkas.drevmatka.redaktors.uchasties', ['plemmatka_id' => $plemmatka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/adminka/drevmatkas/drevmatka/redaktors/uchasties/assign.html.twig', [
            'plemmatka' => $plemmatka,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{uchastie_id}/edit", name=".edit")
     * @param DrevMatka $plemmatka
     * @param string $uchastie_id
     * @param Request $request
     * @param UchasDrev\Edit\Handler $handler
     * @return Response
     */
    public function edit(DrevMatka $plemmatka, string $uchastie_id, Request $request, UchasDrev\Edit\Handler $handler): Response
    {
//        $this->denyAccessUnlessGranted(DrevMatkaAccess::MANAGE_UCHASTIES, $plemmatka);

//        $uchasdrev = $plemmatka->getUchasDrev(new Id($uchastie_id));
        $uchasdrev = $plemmatka->getUchasdrev(new Id($uchastie_id));

        $command = UchasDrev\Edit\Command::fromUchasDrev($plemmatka, $uchasdrev);

        $form = $this->createForm(UchasDrev\Edit\Form::class, $command, ['plemmatka' => $plemmatka->getId()->getValue()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('adminka.drevmatkas.drevmatka.redaktors.uchasties', ['plemmatka_id' => $plemmatka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/adminka/drevmatkas/drevmatka/redaktors/uchasties/edit.html.twig', [
            'plemmatka' => $plemmatka,
            'uchasdrev' => $uchasdrev,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{uchastie_id}/revoke", name=".revoke", methods={"POST"})
     * @param DrevMatka $plemmatka
     * @param string $uchastie_id
     * @param Request $request
     * @param UchasDrev\Remove\Handler $handler
     * @return Response
     */
    public function revoke(DrevMatka $plemmatka, string $uchastie_id, Request $request, UchasDrev\Remove\Handler $handler): Response
    {
//        $this->denyAccessUnlessGranted(DrevMatkaAccess::MANAGE_UCHASTIES, $plemmatka);

        if (!$this->isCsrfTokenValid('revoke', $request->request->get('token'))) {
            return $this->redirectToRoute('adminka.drevmatkas.drevmatka.redaktors.sezondrevs', ['plemmatka_id' => $plemmatka->getId()]);
        }

        $command = new UchasDrev\Remove\Command($plemmatka->getId()->getValue(), $uchastie_id);

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('adminka.drevmatkas.drevmatka.redaktors.uchasties', ['plemmatka_id' => $plemmatka->getId()]);
    }

    /**
     * @Route("/{uchastie_id}", name=".show", requirements={"uchastie_id"=Guid::PATTERN}))
     * @param DrevMatka $plemmatka
     * @return Response
     */
    public function show(DrevMatka $plemmatka): Response
    {
        return $this->redirectToRoute('adminka.drevmatkas.drevmatka.redaktors.uchasties', ['plemmatka_id' => $plemmatka->getId()]);
    }
}
