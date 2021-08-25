<?php
/**
 * Input repository.
 */

namespace App\Repository;

use App\Entity\Input;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * Class InputRepository.
 *
 * @method Input|null find($id, $lockMode = null, $lockVersion = null)
 * @method Input|null findOneBy(array $criteria, array $orderBy = null)
 * @method Input[]    findAll()
 * @method Input[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InputRepository extends ServiceEntityRepository
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
    const PAGINATOR_ITEMS_PER_PAGE = 3;

    /**
     * Input repository constructor.
     *
     * @param \Doctrine\Persistence\ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Input::class);
    }

    /**
     * Query all records.
     *
     * @return \Doctrine\ORM\QueryBuilder QueryBuilder
     */
    public function queryAll(): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->orderBy('input.category', 'DESC');
    }

    /**
     * Get or create new query builder.
     *
     * @param QueryBuilder|null $queryBuilder
     *
     * @return QueryBuilder QueryBuilder
     */
    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?? $this->createQueryBuilder('input');
    }
}
