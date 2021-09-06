<?php
/**
 * Type service.
 */

namespace App\Service;

use App\Entity\Type;
use App\Repository\TypeRepository;
use \Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class TypeService.
 */
class TypeService
{
    /**
     * Type repository.
     *
     * @var \App\Repository\TypeRepository
     */
    private $typeRepository;

    /**
     * Paginator.
     *
     * @var \Knp\Component\Pager\PaginatorInterface
     */
    private $paginator;

    /**
     * TypeService constructor.
     *
     * @param \App\Repository\TypeRepository      $typeRepository Type repository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator          Paginator
     */
    public function __construct(TypeRepository $typeRepository, PaginatorInterface $paginator)
    {
        $this->typeRepository = $typeRepository;
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
            $this->typeRepository->queryAll(),
            $page,
            TypeRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save type.
     *
     * @param Type $type Type entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Type $type): void
    {
        $this->typeRepository->save($type);
    }

    /**
     * Delete type.
     *
     * @param Type $type Type entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Type $type): void
    {
        $this->typeRepository->delete($type);
    }
}