<?php
/**
 * Balance controller.
 */

namespace App\Controller;

use App\Entity\Balance;
use App\Repository\BalanceRepository;
use Knp\Component\Pager\PaginatorInterface;
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
     * Index action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Repository\BalanceRepository $balanceRepository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator Paginator
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="balance_index",
     * )
     */
    public function index(Request $request, BalanceRepository $balanceRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $balanceRepository->queryAll(),
            $request->query->getInt('page', 1),
            BalanceRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render(
            'balance/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param \App\Entity\Balance $balance Balance entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
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
