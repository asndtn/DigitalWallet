<?php
/**
 * Currency controller.
 */

namespace App\Controller;

use App\Entity\Currency;
use App\Repository\CurrencyRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CurrencyController.
 *
 * @Route("/currency")
 */
class CurrencyController extends AbstractController
{
    /**
     * Index action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Repository\CurrencyRepository $currencyRepository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator Paginator
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="currency_index",
     * )
     */
    public function index(Request $request, CurrencyRepository $currencyRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $currencyRepository->queryAll(),
            $request->query->getInt('page', 1),
            CurrencyRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render(
            'currency/index.html.twig',
            ['pagination' => $pagination ]
        );
    }

    /**
     * Show action.
     *
     * @param \App\Entity\Wallet $wallet Wallet entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="currency_show",
     *     requirements={"id": "[1-9]\d*"}
     * )
     */
    public function show(Currency $currency): Response
    {
        return $this->render(
            'currency/show.html.twig',
            ['currency' => $currency]
        );
    }
}