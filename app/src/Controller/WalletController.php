<?php
/**
 * Wallet controller.
 */

namespace App\Controller;

use App\Entity\Wallet;
use App\Repository\WalletRepository;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use App\Form\WalletType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class WalletController.
 *
 * @Route("/wallet")
 */
class WalletController extends AbstractController
{
    /**
     * Index action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request          HTTP request
     * @param \App\Repository\WalletRepository          $walletRepository Wallet repository
     * @param \Knp\Component\Pager\PaginatorInterface   $paginator        Paginator
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="wallet_index",
     * )
     */
    public function index(Request $request, WalletRepository $walletRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $walletRepository->queryByOwner($this->getUser()),
            $request->query->getInt('page', 1),
            WalletRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render(
            'wallet/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param \App\Entity\Wallet $wallet Wallet entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
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
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Repository\WalletRepository        $walletRepository Wallet repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="wallet_create",
     * )
     */
    public function create(Request $request, WalletRepository $walletRepository): Response
    {
        $wallet = new Wallet();
        $form = $this->createForm(WalletType::class, $wallet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $wallet->setOwner($this->getUser());
            $walletRepository->save($wallet);

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
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Entity\Wallet                      $wallet           Wallet entity
     * @param \App\Repository\WalletRepository        $walletRepository Wallet repository
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
     *     name="wallet_edit",
     * )
     */
    public function edit(Request $request, Wallet $wallet, WalletRepository $walletRepository): Response
    {
        if ($wallet->getOwner() !== $this->getUser()) {
            $this->addFlash('warning', 'message.item_not_found');

            return $this->redirectToRoute('wallet_index');
        }

        $form = $this->createForm(WalletType::class, $wallet, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $walletRepository->save($wallet);

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
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Entity\Wallet                      $wallet           Wallet entity
     * @param \App\Repository\WalletRepository        $walletRepository Wallet repository
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
     *     name="wallet_delete",
     * )
     */
    public function delete(Request $request, Wallet $wallet, WalletRepository $walletRepository): Response
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
            $walletRepository->delete($wallet);
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