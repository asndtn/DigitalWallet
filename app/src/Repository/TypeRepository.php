<?php
/**
 * Type repository.
 */

namespace App\Repository;

use App\Entity\Type;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class TypeRepository.
 *
 * @method Type|null find($id, $lockMode = null, $lockVersion = null)
 * @method Type|null findOneBy(array $criteria, array $orderBy = null)
 * @method Type[]    findAll()
 * @method Type[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeRepository extends ServiceEntityRepository
{
    /**
     * Items per page.
     *
     * Use constants to define configuration options that rarely change instead
     * of specifying them in app/config/config.yml.
     * See https://symfony.com/doc/current/best_practices.html#configuration.
     *
     * @constant int
     */
    public const PAGINATOR_ITEMS_PER_PAGE = 10;

    /**
     * TypeRepository constructor.
     *
     * @param ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Type::class);
    }

    /** Query all records.
     *
     * @return QueryBuilder QueryBuilder
     */
    public function queryAll(): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->orderBy('type.name', 'DESC');
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
        $this->_em->persist($type);
        $this->_em->flush();
    }

    /**
     * Delete record.
     *
     * @param Type $type Type entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Type $type): void
    {
        $this->_em->remove($type);
        $this->_em->flush();
    }

    /**
     * Get or create new query builder.
     *
     * @return QueryBuilder QueryBuilder
     */
    private function getOrCreateQueryBuilder(): QueryBuilder
    {
        return null ?? $this->createQueryBuilder('type');
    }
}
