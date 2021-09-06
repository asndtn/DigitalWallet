<?php
/**
 * Currency service.
 */

namespace App\Service;

use App\Entity\Currency;
use App\Repository\CurrencyRepository;
use \Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class CurrencyService.
 */
class CurrencyService
{
    /**
     * Currency repository.
     *
     * @var \App\Repository\CurrencyRepository
     */
    private $currencyRepository;

    /**
     * Paginator.
     *
     * @var \Knp\Component\Pager\PaginatorInterface
     */
    private $paginator;

    /**
     * CurrencyService constructor.
     *
     * @param \App\Repository\CurrencyRepository      $currencyRepository Currency repository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator          Paginator
     */
    public function __construct(CurrencyRepository $currencyRepository, PaginatorInterface $paginator)
    {
        $this->currencyRepository = $currencyRepository;
        $this->paginator = $paginator;
    }

    /**
     * Create paginated list.
     *
     * @param int $page Page number
     *
     * @return \Knp\Component\Pager\Pagination\PaginationInterface Paginated list
     */
    public function createPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->currencyRepository->queryAll(),
            $page,
            CurrencyRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save currency.
     *
     * @param Currency $currency Currency entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Currency $currency): void
    {
        $this->currencyRepository->save($currency);
    }

    /**
     * Delete currency.
     *
     * @param Currency $currency Currency entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Currency $currency): void
    {
        $this->currencyRepository->delete($currency);
    }
}