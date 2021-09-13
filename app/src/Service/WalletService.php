<?php
/**
 * Wallet service.
 */

namespace App\Service;

use App\Entity\User;
use App\Entity\Wallet;
use App\Repository\WalletRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
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
     * @var WalletRepository
     */
    private WalletRepository $walletRepository;

    /**
     * Paginator.
     *
     * @var PaginatorInterface
     */
    private PaginatorInterface $paginator;

    /**
     * WalletService constructor.
     *
     * @param WalletRepository   $walletRepository Wallet repository
     * @param PaginatorInterface $paginator        Paginator
     */
    public function __construct(WalletRepository $walletRepository, PaginatorInterface $paginator)
    {
        $this->walletRepository = $walletRepository;
        $this->paginator = $paginator;
    }

    /**
     * Create paginated list.
     *
     * @param int  $page Page number
     * @param User $user User entity
     *
     * @return PaginationInterface Paginated list
     */
    public function createPaginatedList(int $page, UserInterface $user): PaginationInterface
    {
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
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Wallet $wallet): void
    {
        $this->walletRepository->save($wallet);
    }

    /**
     * Delete wallet.
     *
     * @param Wallet $wallet Wallet entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Wallet $wallet): void
    {
        $this->walletRepository->delete($wallet);
    }

    /**
     * Find wallet by Id.
     *
     * @param int $id Wallet Id
     *
     * @return Wallet|null Category entity
     */
    public function findOneById(int $id): ?Wallet
    {
        return $this->walletRepository->findOneById($id);
    }
}
