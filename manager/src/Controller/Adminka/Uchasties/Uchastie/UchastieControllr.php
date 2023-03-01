<?php

declare(strict_types=1);

namespace App\Controller\Adminka\Uchasties\Uchastie;

use App\Annotation\Guid;

use App\Model\Adminka\Entity\Uchasties\Uchastie\Id;
use App\Model\Adminka\Entity\Uchasties\Uchastie\Uchastie;
use App\Model\Adminka\UseCase\Uchasties\Uchastie\Create;
use App\Model\Adminka\Entity\Uchasties\Uchastie\UchastieRepository;

use App\Model\User\Entity\User\User;
use App\Model\User\Entity\User\UserRepository;
use App\ReadModel\Mesto\InfaMesto\MestoNomerFetcher;
//use App\ReadModel\Adminka\Uchasties\PersonaFetcher;
use App\ReadModel\Adminka\Uchasties\Uchastie\UchastieFetcher;
use App\ReadModel\Adminka\Uchasties\Uchastie\Filter;
use App\ReadModel\User\UserFetcher;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/adminka/uchasties/uchastie", name="adminka.uchasties.uchastie")
 */
// это можно удалить есть в проект-пасека-...
class UchastieControllr extends AbstractController
{
    private const PER_PAGE = 20;

    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    /**
     * @Route("", name="")
     * @param Request $request
     * @param UchastieFetcher $fetcher
//     * @param PersonaFetcher $personas
//     * @param MestoNomerFetcher $mestoNomers
     * @return Response
     */
    public function index(Request $request, UchastieFetcher $fetcher): Response

    {
        $filter = new Filter\Filter();

        $form = $this->createForm(Filter\Form::class, $filter);
        $form->handleRequest($request);

        $pagination = $fetcher->all(
            $filter,
            $request->query->getInt('page', 1),
            self::PER_PAGE,
            $request->query->get('sort', 'nike'),
            $request->query->get('direction', 'asc')
        );

        return $this->render('app/adminka/uchasties/index.html.twig', [
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }



//,
//                          PersonaFetcher $personas,
//                          MestoNomerFetcher $mestoNomers
//                            ): Response
//    {
//        $idUser = $this->getUser()->getId();

//        $persona = $personas->find($idUser);

//        $mestoNomer = $mestoNomers->find($idUser);

//        $uchastie = $uchasties->find($idUser);

//        return $this->render('app/adminka/uchasties/uchastie/index.html.twig',
//            compact('uchastie'
//                'persona',
//                'mestoNomer'
//            )
//        );
//    }

    /**
     * @Route("/create", name=".create")
     * @param Request $request
     * @param User $user
//     * @param UserRepository $users
     * @param UchastieFetcher $uchasties
     * @param Create\Handler $handler
     * @return Response
     */
    public function create( Request $request,User $user,
                            UchastieFetcher $uchasties,
//                            UserRepository $users,
                            Create\Handler $handler): Response
    {

        if ($uchasties->exists($user->getId()->getValue())) {
            $this->addFlash('error', 'Участник уже существует.');
            return $this->redirectToRoute('users.show', ['id' => $user->getId()]);
        }

//        $idUser = $this->getUser()->getId();
//        $user = $users->find($idUser);

// следующие присваения перенести в Handler не можeм т.к. инфа  из $user
        $command = new Create\Command($user->getId()->getValue());
        $command->firstName = $user->getName()->getFirst();
        $command->lastName = $user->getName()->getLast();
        $command->email = $user->getEmail() ? $user->getEmail()->getValue() : null;

        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('adminka.uchasties.uchastie');
            } catch (\DomainException $e) {
                $this->logger->warning($e->getMessage(), ['exception' => $e]);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/adminka/uchasties/uchastie/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name=".show", requirements={"id"=Guid::PATTERN} )
     * @param UchastieRepository $uchasties
     * @param MestoNomerFetcher $mestoNomers
     * @return Response
     */
    public function show(UchastieRepository $uchasties, string $id): Response
    {
        $uchastie = $uchasties->get(new Id($id));
        //$infaMesto = $fetchers->infaMesto($plemmatka->getMesto());
       // dd($uchastie);
        return $this->render('app/adminka/uchasties/uchastie/show.html.twig',
            compact('uchastie')
        );
    }

}