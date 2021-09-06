<?php
/**
 * Wallet controller.
 */

namespace App\Controller;

use App\Entity\Wallet;
use App\Form\WalletType;
use App\Service\WalletService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class WalletController.
 *
 * @Route("/wallet")
 *
 * @IsGranted("ROLE_USER")
 */
class WalletController extends AbstractController
{
    /**
     * Wallet service.
     *
     * @var WalletService
     */
    private $walletService;

    /**
     * WalletController constructor.
     *
     * @param WalletService $walletService Wallet Service
     */
    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    /**
     * Index wallet.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="wallet_index",
     * )
     */
    public function index(Request $request): Response
    {
        $pagination = $this->walletService->createPaginatedList(
            $request->query->getInt('page', 1),
            $this->getUser(),
            $request->query->getAlnum('filters', [])
        );

        return $this->render(
            'wallet/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show wallet.
     *
     * @param Wallet $wallet Wallet entity
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="wallet_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     *
     * @IsGranted(
     *     "VIEW",
     *     subject="wallet",
     * )
     */
    public function show(Wallet $wallet): Response
    {
        return $this->render(
            'wallet/show.html.twig',
            ['wallet' => $wallet]
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
     *     name="wallet_create",
     * )
     */
    public function create(Request $request): Response
    {
        $wallet = new Wallet();
        $form = $this->createForm(WalletType::class, $wallet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $wallet->setOwner($this->getUser());
            $this->walletService->save($wallet);

            $this->addFlash('success', 'message_created_successfully');

            return $this->redirectToRoute('wallet_index');
        }

        return $this->render(
            'wallet/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param Request $request HTTP request
     * @param Wallet  $wallet  Wallet entity
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
     *     name="wallet_edit",
     * )
     *
     * @IsGranted(
     *     "VIEW",
     *     subject="wallet",
     * )
     */
    public function edit(Request $request, Wallet $wallet): Response
    {
        if ($wallet->getOwner() !== $this->getUser()) {
            $this->addFlash('warning', 'message.item_not_found');

            return $this->redirectToRoute('wallet_index');
        }

        $form = $this->createForm(WalletType::class, $wallet, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->walletService->save($wallet);

            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('wallet_index');
        }

        return $this->render(
            'wallet/edit.html.twig',
            [
                'form' => $form->createView(),
                'wallet' => $wallet,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param Request $request HTTP request
     * @param Wallet  $wallet  Wallet entity
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
     *     name="wallet_delete",
     * )
     *
     * @IsGranted(
     *     "DELETE",
     *     subject="wallet",
     * )
     */
    public function delete(Request $request, Wallet $wallet): Response
    {
        if ($wallet->getOwner() !== $this->getUser()) {
            $this->addFlash('warning', 'message.item_not_found');

            return $this->redirectToRoute('wallet_index');
        }

        $form = $this->createForm(FormType::class, $wallet, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->walletService->delete($wallet);
            $this->addFlash('success', 'message_deleted_successfully');

            return $this->redirectToRoute('wallet_index');
        }

        return $this->render(
            'wallet/delete.html.twig',
            [
                'form' => $form->createView(),
                'wallet' => $wallet,
            ]
        );
    }
}