<?php
/**
 * Type service.
 */

namespace App\Service;

use App\Entity\Type;
use App\Repository\TypeRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class TypeService.
 */
class TypeService
{
    /**
     * Type repository.
     */
    private TypeRepository $typeRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * TypeService constructor.
     *
     * @param TypeRepository     $typeRepository Type repository
     * @param PaginatorInterface $paginator      Paginator
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
     * @return PaginationInterface Paginated list
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
     * @throws ORMException
     * @throws OptimisticLockException
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
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Type $type): void
    {
        $this->typeRepository->delete($type);
    }
}
