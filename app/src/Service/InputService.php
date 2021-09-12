<?php
/**
 * Input service.
 */

namespace App\Service;

use App\Entity\Input;
use App\Entity\User;
use App\Entity\Wallet;
use App\Repository\InputRepository;
use DateTimeInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class InputService.
 */
class InputService
{
    /**
     * Input repository.
     *
     * @var InputRepository
     */
    private $inputRepository;

    /**
     * Paginator.
     *
     * @var PaginatorInterface
     */
    private $paginator;

    /**
     * Category service.
     *
     * @var CategoryService
     */
    private $categoryService;

    /**
     * Tag service.
     *
     * @var TagService
     */
    private $tagService;

    /**
     * InputService constructor.
     *
     * @param InputRepository    $inputRepository Input repository
     * @param PaginatorInterface $paginator       Paginator
     * @param CategoryService    $categoryService Category service
     * @param TagService         $tagService      Tag service
     */
    public function __construct(InputRepository $inputRepository, PaginatorInterface $paginator, CategoryService $categoryService, TagService $tagService)
    {
        $this->inputRepository = $inputRepository;
        $this->paginator = $paginator;
        $this->categoryService = $categoryService;
        $this->tagService = $tagService;
    }

    /**
     * Create paginated list.
     *
     * @param int   $page    Page number
     * @param User  $user    User entity
     * @param array $filters Filters array
     *
     * @return PaginationInterface Paginated list
     */
    public function createPaginatedList(int $page, User $user, array $filters = []): PaginationInterface
    {
        $filters = $this->prepareFilters($filters);

        return $this->paginator->paginate(
            $this->inputRepository->queryByOwner($user, $filters),
            $page,
            InputRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Filter by wallet.
     *
     * @param $wallet
     *
     * @return PaginationInterface
     */
    public function filterByWallet(int $page, User $user, $wallet, array $filters = [])
    {
        $filters = $this->prepareFilters($filters);

        return $this->paginator->paginate(
            $this->inputRepository->queryByWallet($user, $wallet, $filters),
            $page,
            InputRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Create paginated list.
     *
     * @param DateTimeInterface $fromDate From date
     * @param DateTimeInterface $to       To date
     * @param int               $page     Page number
     * @param User              $user     User entity
     * @param Wallet            $wallet   Wallet Id
     * @param array             $filters  Filters array
     *
     * @return PaginationInterface Paginated list
     */
    public function filterByDate($fromDate, $to, int $page, User $user, Wallet $wallet, array $filters = []): PaginationInterface
    {
        $filters = $this->prepareFilters($filters);

        return $this->paginator->paginate(
            $this->inputRepository->queryByDate($fromDate, $to, $user, $wallet, $filters),
            $page,
            InputRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save input.
     *
     * @param Input $input Input entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Input $input): void
    {
        $this->inputRepository->save($input);
    }

    /**
     * Delete input.
     *
     * @param Input $input Input entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Input $input): void
    {
        $this->inputRepository->delete($input);
    }

    /**
     * Getter for Input variables.
     *
     * @param Input $input Input entity
     */
    public function getVariables(Input $input): array
    {
        $wallet = $input->getWallet();
        $balance = $wallet->getBalance();
        $balanceAmount = $balance->getBalanceAmount();

        return [$balance, $balanceAmount];
    }

    /**
     * Prepare filters for the inputs list.
     *
     * @param array $filters Raw filters from request
     *
     * @return array Result array of filters
     */
    private function prepareFilters(array $filters): array
    {
        $resultFilters = [];
        if (isset($filters['category_id']) && is_numeric($filters['category_id'])) {
            $category = $this->categoryService->findOneById(
                $filters['category_id']
            );
            if (null !== $category) {
                $resultFilters['category'] = $category;
            }
        }

        if (isset($filters['tag_id']) && is_numeric($filters['tag_id'])) {
            $tag = $this->tagService->findOneById($filters['tag_id']);
            if (null !== $tag) {
                $resultFilters['tag'] = $tag;
            }
        }

        return $resultFilters;
    }
}
