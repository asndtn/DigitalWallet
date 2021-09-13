<?php
/**
 * Currency repository.
 */

namespace App\Repository;

use App\Entity\Currency;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class CurrencyRepository.
 *
 * @method Currency|null find($id, $lockMode = null, $lockVersion = null)
 * @method Currency|null findOneBy(array $criteria, array $orderBy = null)
 * @method Currency[]    findAll()
 * @method Currency[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CurrencyRepository extends ServiceEntityRepository
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
     * Currency repository constructor.
     *
     * @param ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Currency::class);
    }

    /**
     * Query all records.
     *
     * @return QueryBuilder QueryBuilder
     */
    public function queryAll(): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->orderBy('currency.id', 'DESC');
    }

    /**
     * Save record.
     *
     * @param Currency $currency Currency entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Currency $currency): void
    {
        $this->_em->persist($currency);
        $this->_em->flush();
    }

    /**
     * Delete record.
     *
     * @param Currency $currency Currency entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Currency $currency): void
    {
        $this->_em->remove($currency);
        $this->_em->flush();
    }

    /**
     * Get or create new query builder.
     *
     *
     * @return QueryBuilder QueryBuilder
     */
    private function getOrCreateQueryBuilder(): QueryBuilder
    {
        return null ?? $this->createQueryBuilder('currency');
    }
}
