<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\IzChildPlems;

use App\Annotation\Guid;

use App\Model\Adminka\Entity\Matkas\ChildMatka\Id as ChildId;
use App\Model\Adminka\Entity\Matkas\ChildMatka\ChildMatkaRepository;
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
    * @param ChildMatkaRepository $childRepo
    * @param PlemMatkaFetcher $plemFet
    * @param string $id
    * @param CreateNomerPlem\Handler $handler
    * @return Response
    */
    public function izNomerPlem( Request $request,
                                 CreateNomerPlem\Handler $handler,
                                 string $id,
                                 NomerRepository $nomers,
                                 ChildMatkaRepository $childRepo,
                                 PlemMatkaFetcher $plemFet
                                ): Response
    {
        $nomerId = (new Id($id))->getValue();
//        $nomer = $nomers->get(new Id($id));
//        $child = explode("-",$nomer->getName() );
//        $childId = (int)$child[0];
//        $childmatka = $childRepo->get(new ChildId($childId));

//        dd($childmatka);

        $sort = $plemFet->getMaxSort() + 1;

        $command = new CreateNomerPlem\Command($this->getUser()->getId(), $sort, $nomerId );

        try {
                $handler->handle($command);
                dd("stopee");
                return $this->redirectToRoute('proekt.pasekas.matkas.plemmatkas.creates.sdelano', [ 'name' => $command->name]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }


        return $this->render('proekt/pasekas/izChildPlems/izNomerPlem.html.twig',
            compact('plemmatka'               
            ));
    }

//    /**
//     * @Route("/create/{id}", name=".create" , requirements={"id"=Guid::PATTERN})
//     * @param Request $request
//     * @param Nomer $nomer
//     * @param PlemMatkaFetcher $plemmatkas
//     * @param KategoriaFetcher $kategoria
//     * @param CreateNomerPlem\Handler $handler
//     * @return Response
//     */
//    public function create( Request $request, Nomer $nomer,
//                            PlemMatkaFetcher $plemmatkas,
//                            KategoriaFetcher $kategoria,
//                            Create\Handler $handler): Response
//    {
//
//        //        $this->denyAccessUnlessGranted('ROLE_MANAGE_PLEMMATKAS');
//
//        $kategorias = $kategoria->all();
//        $permissions = Permission::names();
//
//        $sort = $plemmatkas->getMaxSort() + 1;
//        $command = new Create\Command($this->getUser()->getId(), $sort, $nomer->getId()->getValue());
//
//
//        $form = $this->createForm(Create\Form::class, $command, ['rasa_id' => $nomer->getLinia()->getRasa()->getId()->getValue()]);
//        $form->handleRequest($request);
//
//        $kakToTak = $nomer->getLinia()->getNameStar()."-".$nomer->getName();
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            try {
//                $handler->handle($command);
//                return $this->redirectToRoute('proekt.pasekas.matkas.plemmatkas.creates.sdelano', [ 'name' => $command->name]);
//            } catch (\DomainException $e) {
//                $this->errors->handle($e);
//                $this->addFlash('error', $e->getMessage());
//            }
//        }
//
//        return $this->render('proekt/pasekas/matkas/plemmatkas/creates/create.html.twig', [
//            'form' => $form->createView(),
//            'command' => $command,
//            'kategorias' => $kategorias,
//            'permissions' => $permissions,
//            'kakToTak' => $kakToTak
//        ]);
//    }

}
