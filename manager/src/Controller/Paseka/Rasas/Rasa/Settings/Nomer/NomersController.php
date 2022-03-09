<?php

declare(strict_types=1);

namespace App\Controller\Paseka\Rasas\Rasa\Settings\Nomer;

use App\Annotation\Guid;

use App\Model\Paseka\Entity\Rasas\Rasa\Linia\Nomer\Id;
use App\Model\Paseka\Entity\Rasas\Rasa\Linia\Linia;
use App\Model\Paseka\UseCase\Rasas\Rasa\Linia\Nomer\Nomer;
use App\Model\Paseka\UseCase\Rasas\Rasa\Linia\Nomer\Create;
use App\Model\Paseka\UseCase\Rasas\Rasa\Linia\Nomer\Edit;
use App\Model\Paseka\UseCase\Rasas\Rasa\Linia\Nomer\Remove;
use App\ReadModel\Paseka\Rasas\Rasa\Nomer\NomerFetcher;
//use App\Security\Voter\Paseka\Materis\Linia\LiniaAccess;
use App\Controller\ErrorHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/paseka/rasas/rasa/settings/linias/{linia_id}/nomers", name="paseka.rasas.rasa.settings.linias.nomers")
 * @ParamConverter("linia", options={"id" = "linia_id"})
 */
class NomersController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("", name="")
     * @param Linia $linia
     * @param NomerFetcher $nomers
     * @return Response
     */
    public function index(Linia $linia, NomerFetcher $nomers): Response
    {
        // $this->denyAccessUnlessGranted(LiniaAccess::MANAGE_MEMBERS, $linia);
//dd( $linia->getId()->getValue());
        return $this->render('app/paseka/rasas/rasa/settings/linias/nomers/index.html.twig', [
            'linia' => $linia,
            'nomers' => $nomers->allOfLinia($linia->getId()->getValue()),
        ]);
    }

//     /**
//      * @Route("/create", name=".create")
//      * @param Linia $linia
//      * @param NomerFetcher $nomers
//      * @param Request $request
//      * @param Create\Handler $handler
//      * @return Response
//      */
//     public function create(Linia $linia, NomerFetcher $nomers, Request $request, Create\Handler $handler): Response
//     {
//         // $this->denyAccessUnlessGranted(LiniaAccess::MANAGE_MEMBERS, $linia);
//         $command = new Create\Command($linia->getId()->getValue());
//         $command->title = $linia->getTitle();
//     $command->sortNomer = $nomers->getMaxSortNomer($linia->getId()->getValue()) + 1;
// //dd($command->sortNomer);
//         $form = $this->createForm(Create\Form::class, $command);
//         $form->handleRequest($request);

//         if ($form->isSubmitted() && $form->isValid()) {
//             try {
// 				$command->title =  $command->title."_".$command->name;
//                 $handler->handle($command);
//                 return $this->redirectToRoute('paseka.rasas.rasa.settings.nomers', ['linia_id' => $linia->getId()]);
//             } catch (\DomainException $e) {
//                 $this->errors->handle($e);
//                 $this->addFlash('error', $e->getMessage());
//             }
//         }
//         return $this->render('app/paseka/rasas/rasa/settings/nomers/create.html.twig', [
//             'linia' => $linia,
//             'form' => $form->createView(),
//         ]);
//     }

//     /**
//      * @Route("/{id}/edit", name=".edit")
//      * @param Linia $linia
//      * @param string $id
//      * @param Request $request
//      * @param Edit\Handler $handler
//      * @return Response
//      */
//     public function edit(Linia $linia, string $id, Request $request, Edit\Handler $handler): Response
//     {
//         // $this->denyAccessUnlessGranted(LiniaAccess::MANAGE_MEMBERS, $linia);

//          $nomer = $linia->getNomer(new Id($id));

// 		$command = Edit\Command::fromNomer($linia, $nomer);
//         $form = $this->createForm(Edit\Form::class, $command);
//         $form->handleRequest($request);

//         if ($form->isSubmitted() && $form->isValid()) {
//             try {
// 				$command->title = "????????";
//                 $handler->handle($command);
//                 return $this->redirectToRoute('paseka.rasas.rasa.settings.nomers.show', 
// 											['linia_id' => $linia->getId(), 'id' => $id]);
//             } catch (\DomainException $e) {
//                 $this->errors->handle($e);
//                 $this->addFlash('error', $e->getMessage());
//             }
//         }

//         return $this->render('app/paseka/rasas/rasa/settings/nomers/edit.html.twig', [
//             'linia' => $linia,
//             'nomer' => $nomer,
//             'form' => $form->createView(),
//         ]);
//     }

//     /**
//      * @Route("/{id}/delete", name=".delete", methods={"POST"})
//      * @param Linia $linia
//      * @param string $id
//      * @param Request $request
//      * @param Remove\Handler $handler
//      * @return Response
//      */
//     public function delete(Linia $linia, string $id, Request $request, Remove\Handler $handler): Response
//     {
//         //$this->denyAccessUnlessGranted(MateriAccess::MANAGE_MEMBERS, $materi);

//         if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
//             return $this->redirectToRoute('paseka.rasas.rasa.settings.nomers', ['linia_id' => $linia->getId()]);
//         }

//         $nomer= $linia->getNomer(new Id($id));

//         $command = new Remove\Command($linia->getId()->getValue(), $nomer->getId()->getValue());

//         try {
//             $handler->handle($command);
//         } catch (\DomainException $e) {
//             $this->errors->handle($e);
//             $this->addFlash('error', $e->getMessage());
//         }

//         return $this->redirectToRoute('paseka.rasas.rasa.settings.nomers', 
// 					['linia_id' => $linia->getId()]);
//     }

//     // /**
//     //  * @Route("/{id}", name=".show", requirements={"id"=Guid::PATTERN}))
//     //  * @param Nomer $nomer
//     //  * @return Response
//     //  */
//     // public function show(Nomer $nomer): Response
//     // {
//     //     return $this->redirectToRoute('paseka.materis.rasas.linia.nomer', ['nomer_id' => $nomer->getId()]);
//     // }
	
// 	 /**
//      * @Route("/{id}", name=".show", requirements={"id"=Guid::PATTERN}))
//      * @param Linia $linia
//      * @return Response
//      */
//     public function show(Linia $linia): Response
//     {
//         return $this->redirectToRoute('paseka.rasas.rasa.settings.nomers', 
// 				['linia_id' => $linia->getId()]);
//     }
}
