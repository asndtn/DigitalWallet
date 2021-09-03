<?php
/**
 * Input service.
 */

namespace App\Service;

use App\Entity\Input;
use App\Entity\User;
use App\Repository\InputRepository;
use \Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class InputService.
 */
class InputService
{
    /**
     * Input repository.
     *
     * @var \App\Repository\InputRepository
     */
    private $inputRepository;

    /**
     * Paginator.
     *
     * @var \Knp\Component\Pager\PaginatorInterface
     */
    private $paginator;

    /**
     * Category service.
     *
     * @var \App\Service\CategoryService
     */
    private $categoryService;

    /**
     * Tag service.
     *
     * @var \App\Service\TagService
     */
    private $tagService;

    /**
     * Wallet service.
     *
     * @var \App\Service\WalletService
     */
    private $walletService;

    /**
     * Input service constructor.
     *
     * @param \App\Repository\InputRepository         $inputRepository Input repository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator       Paginator
     * @param \App\Service\CategoryService            $categoryService Category service
     * @param \App\Service\TagService                 $tagService      Tag service
     * @param \App\Service\WalletService              $walletService   Wallet service
     */
    public function __construct(InputRepository $inputRepository, PaginatorInterface $paginator, CategoryService $categoryService, TagService $tagService, WalletService $walletService)
    {
        $this->inputRepository = $inputRepository;
        $this->paginator = $paginator;
        $this->categoryService = $categoryService;
        $this->tagService = $tagService;
        $this->walletService = $walletService;
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
            $this->inputRepository->queryByOwner($user, $filters),
            $page,
            InputRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save input.
     *
     * @param Input $input Input entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
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
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Input $input): void
    {
        $this->inputRepository->delete($input);
    }

    /**
     * Prepare filters for the tasks list.
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

        if (isset($filters['wallet_id']) && is_numeric($filters['wallet_id'])) {
            $wallet = $this->walletService->findOneById(
                $filters['wallet_id']
            );
            if (null !== $wallet) {
                $resultFilters['wallet'] = $wallet;
            }
        }

        return $resultFilters;
    }
}