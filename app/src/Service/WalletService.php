<?php
/**
 * Wallet service.
 */

namespace App\Service;

use App\Entity\Wallet;
use App\Repository\WalletRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class WalletService.
 */
class WalletService
{
    /**
     * Wallet repository.
     *
     * @var \App\Repository\WalletRepository
     */
    private $walletRepository;

    /**
     * Paginator.
     *
     * @var \Knp\Component\Pager\PaginatorInterface
     */
    private $paginator;

    /**
     * Wallet service constructor.
     *
     * @param \App\Repository\WalletRepository $walletRepository Wallet repository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator Paginator
     */
    public function __construct(WalletRepository $walletRepository, PaginatorInterface $paginator)
    {
        $this->walletRepository = $walletRepository;
        $this->paginator = $paginator;
    }

    /**
     * Create paginated list.
     *
     * @param int $page Page number
     *
     */
    public function createPaginatedList(int $page, UserInterface $user): PaginationInterface
    {
        //TODO queryByOwner via Services
        return $this->paginator->paginate(
            $this->walletRepository->queryByOwner($user),
            $page,
            WalletRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save wallet.
     *
     * @param Wallet $wallet Wallet entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Wallet $wallet): void
    {
        $this->walletRepository->save($wallet);
    }

    /**
     * Delete wallet.
     *
     * @param Wallet $wallet
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Wallet $wallet): void
    {
        $this->walletRepository->delete($wallet);
    }
}