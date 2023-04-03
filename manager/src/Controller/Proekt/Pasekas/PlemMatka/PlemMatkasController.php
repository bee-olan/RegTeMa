<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\PlemMatka;

use App\Annotation\Guid;

use App\Model\Adminka\Entity\Matkas\Kategoria\Permission;
use App\ReadModel\Adminka\Matkas\KategoriaFetcher;

use App\Model\Mesto\Entity\InfaMesto\MestoNomerRepository;
use App\Model\Mesto\Entity\InfaMesto\Id as MestoNomerId;

use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatka;
use App\Model\Adminka\Entity\Rasas\Linias\Nomers\Id;
use App\Model\Adminka\Entity\Rasas\Linias\Nomers\NomerRepository;

use App\Model\Adminka\Entity\Uchasties\Personas\PersonaRepository;
use App\Model\Adminka\Entity\Uchasties\Personas\Id as PersonaId;

use App\Model\Adminka\UseCase\Matkas\PlemMatka\Create;
use App\Model\Adminka\UseCase\Matkas\PlemMatka\Remove;

use App\ReadModel\Proekt\Pasekas\PlemMatka\Side\Filter;
use App\ReadModel\Proekt\Pasekas\PlemMatka\Side\PlemSideFetcher;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/proekt/pasekas/matkas", name="proekt.pasekas.matkas")
 */
class PlemMatkasController extends AbstractController
{
    private const PER_PAGE = 10;

    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("", name="")
     * @param Request $request
     * @param PlemSideFetcher $fetcher
     * @return Response
     */
    public function index(Request $request, PlemSideFetcher $fetcher): Response
    {

        if ($this->isGranted('ROLE_PASEKA_MANAGE_PLEMMATKAS')) {
            $filter = Filter\Filter::all();
//            dd($filter);
        } else {
            $filter = Filter\Filter::forUchastie($this->getUser()->getId());
        }

        $form = $this->createForm(Filter\Form::class, $filter);
        $form->handleRequest($request);

        $pagination = $fetcher->all(
            $filter,
            $request->query->getInt('page', 1),
            self::PER_PAGE,
            $request->query->get('sort', 'name', 'persona'),
            $request->query->get('direction', 'asc')
        );

        return $this->render('proekt/pasekas/matkas/index.html.twig', [
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }


}