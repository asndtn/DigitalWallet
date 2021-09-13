<?php
/**
 * Balance controller.
 */

namespace App\Controller;

use App\Entity\Balance;
use App\Service\BalanceService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BalanceController.
 *
 * @Route("/balance")
 *
 * @IsGranted("ROLE_ADMIN")
 */
class BalanceController extends AbstractController
{
    /**
     * Balance service.
     *
     * @var BalanceService
     */
    private BalanceService $balanceService;

    /**
     * BalanceController constructor.
     *
     * @param BalanceService $balanceService Balance service
     */
    public function __construct(BalanceService $balanceService)
    {
        $this->balanceService = $balanceService;
    }

    /**
     * Index action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP Response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="balance_index",
     * )
     */
    public function index(Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $pagination = $this->balanceService->createPaginatedList($page);

        return $this->render(
            'balance/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param Balance $balance Balance entity
     *
     * @return Response HTTP Response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="balance_show",
     *     requirements={"id": "[1-9]\d*"}
     * )
     */
    public function show(Balance $balance): Response
    {
        return $this->render(
            'balance/show.html.twig',
            ['balance' => $balance]
        );
    }
}
