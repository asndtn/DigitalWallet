<?php
/**
 * Wallet repository.
 */

namespace App\Repository;

use App\Entity\Wallet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * Class WalletRepository.
 *
 * @method Wallet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Wallet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Wallet[]    findAll()
 * @method Wallet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WalletRepository extends ServiceEntityRepository
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
    const PAGINATOR_ITEMS_PER_PAGE = 10;

    /**
     * Wallet repository constructor.
     *
     * @param \Doctrine\Persistence\ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wallet::class);
    }

    /**
     * Query all records by idUser.
     *
     * @return \Doctrine\ORM\QueryBuilder QueryBuilder
     */
    public function queryAllbyIdUser(): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->orderBy('wallet.idUser', 'DESC');
    }

    /**
     * Query all records by idWallet_Type.
     *
     * @return \Doctrine\ORM\QueryBuilder QueryBuilder
     */
    public function queryAllbyIdWallet_Type(): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->orderBy('wallet.idWallet_Type', 'DESC');
    }

    /**
     * Query all records by idCurrency_Type.
     *
     * @return \Doctrine\ORM\QueryBuilder QueryBuilder
     */
    public function queryAllbyIdCurrency_Type(): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->orderBy('wallet.idCurrency_Type', 'DESC');
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
        return $queryBuilder ?? $this->createQueryBuilder('wallet');
    }
}
