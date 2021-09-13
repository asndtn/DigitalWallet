<?php
/**
 * Currency controller.
 */

namespace App\Controller;

use App\Entity\Currency;
use App\Form\CurrencyType;
use App\Service\CurrencyService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CurrencyController.
 *
 * @Route("/currency")
 *
 * @IsGranted("ROLE_ADMIN")
 */
class CurrencyController extends AbstractController
{
    /**
     * Currency service.
     *
     * @var CurrencyService
     */
    private CurrencyService $currencyService;

    /**
     * Currency controller constructor.
     *
     * @param CurrencyService $currencyService Currency service
     */
    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
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
     *     name="currency_index",
     * )
     */
    public function index(Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $pagination = $this->currencyService->createPaginatedList($page);

        return $this->render(
            'currency/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param Currency $currency Currency entity
     *
     * @return Response HTTP Response
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
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="currency_create",
     * )
     */
    public function create(Request $request): Response
    {
        $currency = new Currency();
        $form = $this->createForm(CurrencyType::class, $currency);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->currencyService->save($currency);
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
     * @param Request  $request  HTTP request
     * @param Currency $currency Currency entity
     *
     * @return Response HTTP response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     *
     * @Route(
     *     "/{id}/edit",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="currency_edit",
     * )
     */
    public function edit(Request $request, Currency $currency): Response
    {
        $form = $this->createForm(CurrencyType::class, $currency, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->currencyService->save($currency);
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
     * @param Request  $request  HTTP request
     * @param Currency $currency Currency entity
     *
     * @return Response HTTP response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     *
     * @Route(
     *     "/{id}/delete",
     *     methods={"GET", "DELETE"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="currency_delete",
     * )
     */
    public function delete(Request $request, Currency $currency): Response
    {
        if ($currency->getWallets()->count()) {
            $this->addFlash('warning', 'currency_contains_input');

            return $this->redirectToRoute('currency_index');
        }

        $form = $this->createForm(FormType::class, $currency, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->currencyService->delete($currency);
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
