<?php
/**
 * Currency controller.
 */

namespace App\Controller;

use App\Entity\Currency;
use App\Repository\CurrencyRepository;
use App\Form\CurrencyType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
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

    /**
     * Create action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Repository\CurrencyRepository        $currencyRepository Currency repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="currency_create",
     * )
     */
    public function create(Request $request, CurrencyRepository $currencyRepository): Response
    {
        $currency = new Currency();
        $form = $this->createForm(CurrencyType::class, $currency);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $currencyRepository->save($currency);

            $this->addFlash('success', 'message_created_successfully');

            return $this->redirectToRoute('currency_index');
        }

        return $this->render(
            'currency/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Entity\Currency                      $currency           Currency entity
     * @param \App\Repository\CurrencyRepository        $currencyRepository Currency repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/edit",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="currency_edit",
     * )
     */
    public function edit(Request $request, Currency $currency, CurrencyRepository $currencyRepository): Response
    {
        $form = $this->createForm(CurrencyType::class, $currency, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $currencyRepository->save($currency);

            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('currency_index');
        }

        return $this->render(
            'currency/edit.html.twig',
            [
                'form' => $form->createView(),
                'currency' => $currency,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Entity\Currency                      $currency           Currency entity
     * @param \App\Repository\CurrencyRepository        $currencyRepository Currency repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/delete",
     *     methods={"GET", "DELETE"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="currency_delete",
     * )
     */
    public function delete(Request $request, Currency $currency, CurrencyRepository $currencyRepository): Response
    {
        $form = $this->createForm(FormType::class, $currency, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $currencyRepository->delete($currency);
            $this->addFlash('success', 'message_deleted_successfully');

            return $this->redirectToRoute('currency_index');
        }

        return $this->render(
            'currency/delete.html.twig',
            [
                'form' => $form->createView(),
                'currency' => $currency,
            ]
        );
    }
}