<?php

// declare(strict_types=1);

 namespace App\Controller\Paseka\Rasas\Rasa\Settings;

// use App\Annotation\Guid;
// use App\Model\Paseka\Entity\Rasas\Rasa\Linia\Id;
// use App\Model\Paseka\Entity\Rasas\Rasa\Rasa;
// use App\Model\Paseka\UseCase\Rasas\Rasa\Linia\Create;
// use App\Model\Paseka\UseCase\Rasas\Rasa\Linia\Edit;
// use App\Model\Paseka\UseCase\Rasas\Rasa\Linia\Remove;

// use App\ReadModel\Paseka\Rasas\Rasa\LiniaFetcher;

// use App\Security\Voter\Paseka\Rasas\RasaAccess;
// use App\Controller\ErrorHandler;
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
 use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Routing\Annotation\Route;

// /** 
//  * @Route("/paseka/rasas/{rasa_id}/settings/linias", name="paseka.rasas.rasa.settings.linias")
//  * @ParamConverter("rasa", options={"id" = "rasa_id"})
//  */
 class LiniasController extends AbstractController
 {
//     private $errors;

//     public function __construct(ErrorHandler $errors)
//     {
//         $this->errors = $errors;
//     }

//     /**
//      * @Route("", name="")
//      * @param Rasa $rasa
//      * @param LiniaFetcher $linias
//      * @return Response
//      */
//     public function index(Rasa $rasa, LiniaFetcher $linias): Response
//     {
//         // $this->denyAccessUnlessGranted(RasaAccess::MANAGE_MEMBERS, $rasa);

//         return $this->render('app/paseka/rasas/rasa/settings/linias/index.html.twig', [
//             'rasa' => $rasa,
//             'linias' => $linias->allOfRasa($rasa->getId()->getValue()),
//         ]);
//     }

//     /**
//      * @Route("/create", name=".create")
//      * @param Rasa $rasa
//      * @param Request $request
//      * @param Create\Handler $handler
//      * @return Response
//      */
//     public function create(Rasa $rasa, Request $request, Create\Handler $handler): Response
//     {
//         // $this->denyAccessUnlessGranted(RasaAccess::MANAGE_MEMBERS, $rasa);

//         $command = new Create\Command($rasa->getId()->getValue());

//         $form = $this->createForm(Create\Form::class, $command);
//         $form->handleRequest($request);

//         if ($form->isSubmitted() && $form->isValid()) {
//             try {
//                 $handler->handle($command);
//                 return $this->redirectToRoute('paseka.rasas.rasa.settings.linias', ['rasa_id' => $rasa->getId()]);
//             } catch (\DomainException $e) {
//                 $this->errors->handle($e);
//                 $this->addFlash('error', $e->getMessage());
//             }
//         }

//         return $this->render('app/paseka/rasas/rasa/settings/linias/create.html.twig', [
//             'rasa' => $rasa,
//             'form' => $form->createView(),
//         ]);
//     }

//     /**
//      * @Route("/{id}/edit", name=".edit")
//      * @param Rasa $rasa
//      * @param string $id
//      * @param Request $request
//      * @param Edit\Handler $handler
//      * @return Response
//      */
//     public function edit(Rasa $rasa, string $id, Request $request, Edit\Handler $handler): Response
//     {
//         // $this->denyAccessUnlessGranted(RasaAccess::MANAGE_MEMBERS, $rasa);

//         $linia = $rasa->getLinia(new Id($id));

//         $command = Edit\Command::fromLinia($rasa, $linia);

//         $form = $this->createForm(Edit\Form::class, $command);
//         $form->handleRequest($request);

//         if ($form->isSubmitted() && $form->isValid()) {
//             try {
//                 $handler->handle($command);
//                 return $this->redirectToRoute('paseka.rasas.rasa.settings.linias.show', ['rasa_id' => $rasa->getId(), 'id' => $id]);
//             } catch (\DomainException $e) {
//                 $this->errors->handle($e);
//                 $this->addFlash('error', $e->getMessage());
//             }
//         }

//         return $this->render('app/paseka/rasas/rasa/settings/linias/edit.html.twig', [
//             'rasa' => $rasa,
//             'linia' => $linia,
//             'form' => $form->createView(),
//         ]);
//     }

//     /**
//      * @Route("/{id}/delete", name=".delete", methods={"POST"})
//      * @param Rasa $rasa
//      * @param string $id
//      * @param Request $request
//      * @param Remove\Handler $handler
//      * @return Response
//      */
//     public function delete(Rasa $rasa, string $id, Request $request, Remove\Handler $handler): Response
//     {
//         // $this->denyAccessUnlessGranted(RasaAccess::MANAGE_MEMBERS, $rasa);

//         if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
//             return $this->redirectToRoute('paseka.rasas.rasa.settings.linias', ['rasa_id' => $rasa->getId()]);
//         }

//         $linia = $rasa->getLinia(new Id($id));

//         $command = new Remove\Command($rasa->getId()->getValue(), $linia->getId()->getValue());

//         try {
//             $handler->handle($command);
//         } catch (\DomainException $e) {
//             $this->errors->handle($e);
//             $this->addFlash('error', $e->getMessage());
//         }

//         return $this->redirectToRoute('paseka.rasas.rasa.settings.linias', ['rasa_id' => $rasa->getId()]);
//     }

//     /**
//      * @Route("/{id}", name=".show", requirements={"id"=Guid::PATTERN}))
//      * @param Rasa $rasa
//      * @return Response
//      */
//     public function show(Rasa $rasa): Response
//     {
//         return $this->redirectToRoute('paseka.rasas.rasa.settings.linias', ['rasa_id' => $rasa->getId()]);
//     }
}
