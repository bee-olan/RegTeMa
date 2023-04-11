<?php

declare(strict_types=1);

namespace App\Controller\Adminka\Matkas\PlemMatka;

use App\Model\Adminka\Entity\Matkas\PlemMatka\PlemMatka;
use App\ReadModel\Adminka\Matkas\Actions\ActionFetcher;
use App\ReadModel\Adminka\Matkas\Actions\Filter;
use App\Security\Voter\Adminka\Matkas\PlemMatkaAccess;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/adminka/matkas/{plemmatka_id}/actions", name="adminka.matkas.plemmatka.actions")
 * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
 */
class ActionsController extends AbstractController
{
    private const PER_PAGE = 50;

    private $actions;

    public function __construct(ActionFetcher $actions)
    {
        $this->actions = $actions;
    }

    /**
     * @Route("", name="")
     * @param PlemMatka $plemmatka
     * @param Request $request
     * @return Response
     */
    public function index(PlemMatka $plemmatka, Request $request): Response
    {
        $this->denyAccessUnlessGranted(PlemMatkaAccess::VIEW, $plemmatka);

        $filter = Filter::forPlemMatka($plemmatka->getId()->getValue());

        $pagination = $this->actions->all(
            $filter,
            $request->query->getInt('page', 1),
            self::PER_PAGE
        );

        return $this->render('app/adminka/matkas/actions.html.twig', [
            'plemmatka' => $plemmatka,
            'pagination' => $pagination,
        ]);
    }
}
