<?php
/**
 * Balance service.
 */

namespace App\Service;

use App\Repository\BalanceRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class BalanceService.
 */
class BalanceService
{
    /**
     * Balance repository.
     *
     * @var BalanceRepository
     */
    private BalanceRepository $balanceRepository;

    /**
     * Paginator.
     *
     * @var PaginatorInterface
     */
    private PaginatorInterface $paginator;

    /**
     * BalanceService constructor.
     *
     * @param BalanceRepository  $balanceRepository Balance repository
     * @param PaginatorInterface $paginator         Paginator
     */
    public function __construct(BalanceRepository $balanceRepository, PaginatorInterface $paginator)
    {
        $this->balanceRepository = $balanceRepository;
        $this->paginator = $paginator;
    }

    /**
     * Create paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface Paginated list
     */
    public function createPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->balanceRepository->queryAll(),
            $page,
            BalanceRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }
}
