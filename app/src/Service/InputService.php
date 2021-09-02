<?php
/**
 * Input service.
 */

namespace App\Service;

use App\Entity\Input;
use App\Repository\InputRepository;
use \Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

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
     * Input service constructor.
     *
     * @param \App\Repository\InputRepository $inputRepository    Input repository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator        Paginator
     */
    public function __construct(InputRepository $inputRepository, PaginatorInterface $paginator)
    {
        $this->inputRepository = $inputRepository;
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
            $this->inputRepository->queryAll(),
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
}