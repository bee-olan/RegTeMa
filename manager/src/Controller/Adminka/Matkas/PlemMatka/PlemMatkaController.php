<?php

declare(strict_types=1);

namespace App\Controller\Adminka\Matkas\PlemMatka;

use App\Annotation\Guid;


use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatka;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

    /**
     * @Route("/adminka/matkas/{id}", name="adminka.matkas.plemmatka")
     */
class PlemMatkaController extends AbstractController
{
    /**
     * @Route("", name=".show", requirements={"id"=Guid::PATTERN})
     * @param PlemMatka $plemmatka
     * @return Response
     */
    public function show(PlemMatka $plemmatka): Response
    {
        return $this->render('app/adminka/matkas/plemmatka/show.html.twig', compact('plemmatka'));
    }
}
//    /**
//     * @Route("", name="")
//     * @param Request $request
//     * @param PlemMatkaFetcher $fetcher
//     * @return Response
//     */
//    public function index(Request $request, PlemMatkaFetcher $fetcher): Response
//    {
//        $filter = new Filter\Filter();
//
//        $form = $this->createForm(Filter\Form::class, $filter);
//        $form->handleRequest($request);
//
//        $pagination = $fetcher->all(
//            $filter,
//            $request->query->getInt('page', 1),
//            self::PER_PAGE,
//            $request->query->get('sort', 'name', 'persona'),
//            $request->query->get('direction', 'asc')
//        );
//
//        return $this->render('app/paseka/matkas/index.html.twig', [
//            'pagination' => $pagination,
//            'form' => $form->createView(),
//        ]);
//    }
//
//    /**
//     * @Route("/plemmatka-create/{id}", name=".plemmatka-create" , requirements={"id"=Guid::PATTERN})
//     * @param Request $request
//     * @param NomerRepository $nomers
//     * @param PersonaRepository $personas
//     * @param MestoNomerRepository $mestonomers
//     * @param string $id
//     * @param PlemMatkaFetcher $plemmatkas
//     * @param Create\Handler $handler
//     * @return Response
//     */
//    public function plemmatkaCreate(string $id, Request $request,
//                           PlemMatkaFetcher $plemmatkas,
//                           PersonaRepository $personas,
//                           MestoNomerRepository $mestonomers,
//                           NomerRepository $nomers,
//                           Create\Handler $handler): Response
//    {
////        $this->denyAccessUnlessGranted('ROLE_WORK_MANAGE_PROJECTS');
//
//        if (!$plemmatkas->existsPerson($this->getUser()->getId())) {
//            $this->addFlash('error', 'Начните с выбора ПерсонНомера ');
//            return $this->redirectToRoute('paseka.uchasties.personas.diapazon');
//        }
//
//        if (!$plemmatkas->existsMesto($this->getUser()->getId())) {
//            $this->addFlash('error', 'Пожалуйста, определитесь с номером места расположения Вашей пасеки ');
//            return $this->redirectToRoute('mesto.infamesto.okrugs');
//        }
//
//        $nomer = $nomers->get(new Id($id));
//
//        $uchastieId =  $this->getUser()->getId();
//        $persona = $personas->get(new PersonaId($uchastieId));
//        $mestonomer = $mestonomers->get(new MestoNomerId($uchastieId));
//
//        $command = new Create\Command();
//
//        $command->rasaNomId = $id;
//
//        $command->uchastieId = $uchastieId;
//
//        $command->persona = $persona->getNomer();
//
//        $command->sort = $plemmatkas->getMaxSortPerson($command->persona) + 1;
//
//        $command->mesto = $mestonomer->getNomer();
//
//        $command->name = $nomer->getTitle()." : ".$command->mesto."_пН-". $command->persona."_№".$command->sort;
//
//        //dd($command);
//
//        $form = $this->createForm(Create\Form::class, $command);
//        $form->handleRequest($request);
//
//
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            try {
//                $handler->handle($command);
////dd($command);
//                return $this->redirectToRoute('paseka.matkas.plemmatka.sdelano',
//                    [ 'id_nom' => $id  , 'plemmatka' => $command->name]);
//
//            } catch (\DomainException $e) {
//                $this->logger->warning($e->getMessage(), ['exception' => $e]);
//                $this->addFlash('error', $e->getMessage());
//            }
//        }
//
//        return $this->render('app/paseka/matkas/create.html.twig', [
//            'form' => $form->createView(),
//            'command' => $command,
//        ]);
//    }
//
//
//    /**
//     * @Route("/create/{id}", name=".create")
//     * @param Request $request
//     * @param NomerRepository $nomers
//     * @param PersonaRepository $personas
//     * @param MestoNomerRepository $mestonomers
//     * @param string $id
//     * @param PlemMatkaFetcher $plemmatkas
//     * @param Create\Handler $handler
//     * @return Response
//     */
//    public function create(string $id, Request $request,
//                           PlemMatkaFetcher $plemmatkas,
//                           PersonaRepository $personas,
//                           MestoNomerRepository $mestonomers,
//                           NomerRepository $nomers,
//                           Create\Handler $handler): Response
//    {
////        $this->denyAccessUnlessGranted('ROLE_WORK_MANAGE_PROJECTS');
//
//        if (!$plemmatkas->existsPerson($this->getUser()->getId())) {
//            $this->addFlash('error', 'Начните с выбора ПерсонНомера ');
//            return $this->redirectToRoute('paseka.uchasties.personas.diapazon');
//        }
//
//        if (!$plemmatkas->existsMesto($this->getUser()->getId())) {
//            $this->addFlash('error', 'Пожалуйста, определитесь с номером места расположения Вашей пасеки ');
//            return $this->redirectToRoute('mesto.infamesto.okrugs');
//        }
//
//        $nomer = $nomers->get(new Id($id));
//
//        $uchastieId =  $this->getUser()->getId();
//        $persona = $personas->get(new PersonaId($uchastieId));
//        $mestonomer = $mestonomers->get(new MestoNomerId($uchastieId));
//
//
//        $command = new Create\Command();
//
//        $command->rasaNomId = $id;
//
//        $command->uchastieId = $uchastieId;
//
//        $command->persona = $persona->getNomer();
//
//        $command->sort = $plemmatkas->getMaxSortPerson($command->persona) + 1;
//
//        $command->mesto = $mestonomer->getNomer();
//
//        $command->name = $nomer->getTitle()." : ".$command->mesto."_пН-". $command->persona."_№".$command->sort;
//
//        //dd($command);
//
//        $form = $this->createForm(Create\Form::class, $command);
//        $form->handleRequest($request);
//
//
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            try {
//                $handler->handle($command);
//                return $this->redirectToRoute('paseka.matkas');
//            } catch (\DomainException $e) {
//                $this->logger->warning($e->getMessage(), ['exception' => $e]);
//                $this->addFlash('error', $e->getMessage());
//            }
//        }
//
//        return $this->render('app/paseka/matkas/create.html.twig', [
//            'form' => $form->createView(),
//            'command' => $command,
//        ]);
//    }
//
//    /**
//     * @Route("/{id}/delete", name=".delete", methods={"POST"})
//     * @param PlemMatka $plemmatka
//     * @param Request $request
//     * @param Remove\Handler $handler
//     * @return Response
//     */
//    public function delete(PlemMatka $plemmatka, Request $request, Remove\Handler $handler): Response
//    {
//        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
//            return $this->redirectToRoute('paseka.matkas');
//        }
//
//        $command = new Remove\Command($plemmatka->getId()->getValue());
//
//        try {
//            $handler->handle($command);
//            return $this->redirectToRoute('paseka.matkas');
//        } catch (\DomainException $e) {
//            $this->logger->warning($e->getMessage(), ['exception' => $e]);
//            $this->addFlash('error', $e->getMessage());
//        }
//
//        return $this->redirectToRoute('paseka.matkas');
//    }

//}