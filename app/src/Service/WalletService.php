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
     * Type service.
     *
     * @var \App\Service\TypeService
     */
    private $typeService;

    /**
     * Currency service.
     *
     * @var \App\Service\CurrencyService
     */
    private $currencyService;

    /**
     * WalletService constructor.
     *
     * @param \App\Repository\WalletRepository        $walletRepository Wallet repository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator        Paginator
     * @param \App\Service\TypeService                $typeService      Type service
     * @param \App\Service\CurrencyService            $currencyService  Currency service
     */
    public function __construct(WalletRepository $walletRepository, PaginatorInterface $paginator, TypeService $typeService, CurrencyService $currencyService)
    {
        $this->walletRepository = $walletRepository;
        $this->paginator = $paginator;
        $this->typeService = $typeService;
        $this->currencyService = $currencyService;
    }

    /**
     * Prepare filters for the wallets list.
     *
     * @param array $filters Raw filters from request
     *
     * @return array Result array of filters
     */
    private function prepareFilters(array $filters): array
    {
        $resultFilters = [];
        if (isset($filters['type_id']) && is_numeric($filters['type_id'])) {
            $type = $this->typeService->findOneById(
                $filters['type_id']
            );
            if (null !== $type) {
                $resultFilters['type'] = $type;
            }
        }

        if (isset($filters['currency_id']) && is_numeric($filters['currency_id'])) {
            $currency = $this->currencyService->findOneById($filters['currency_id']);
            if (null !== $currency) {
                $resultFilters['currency'] = $currency;
            }
        }

        return $resultFilters;
    }

    /**
     * Create paginated list.
     *
     * @param int                                                 $page    Page number
     * @param \Symfony\Component\Security\Core\User\UserInterface $user    User entity
     * @param array                                               $filters Filters array
     *
     * @return \Knp\Component\Pager\Pagination\PaginationInterface Paginated list
     */
    public function createPaginatedList(int $page, UserInterface $user, array $filters = []): PaginationInterface
    {
        $filters = $this->prepareFilters($filters);

        return $this->paginator->paginate(
            $this->walletRepository->queryByOwner($user, $filters),
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

    /**
     * Find wallet by Id.
     *
     * @param int $id Wallet Id
     *
     * @return \App\Entity\Wallet|null Wallet entity
     */
    public function findOneById(int $id): ?Wallet
    {
        return $this->walletRepository->findOneById($id);
    }
}