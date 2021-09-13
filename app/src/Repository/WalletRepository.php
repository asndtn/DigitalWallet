<?php
/**
 * Wallet repository.
 */

namespace App\Repository;

use App\Entity\User;
use App\Entity\Wallet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

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
    public const PAGINATOR_ITEMS_PER_PAGE = 10;

    /**
     * Wallet repository constructor.
     *
     * @param ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wallet::class);
    }

    /**
     * Query all records.
     *
     * @return QueryBuilder QueryBuilder
     */
    public function queryAll(): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->select('partial wallet.{id}', 'partial type.{id, name}', 'partial currency.{id, name}', 'partial balance.{id, balanceAmount}')
            ->join('wallet.type', 'type')
            ->join('wallet.currency', 'currency')
            ->join('wallet.balance', 'balance')
            ->orderBy('wallet.type', 'DESC');
    }

    /**
     * Query wallets by owner.
     *
     * @param User $user User entity
     *
     * @return QueryBuilder Query builder
     */
    public function queryByOwner(User $user): QueryBuilder
    {
        $queryBuilder = $this->queryAll();

        $queryBuilder->andWhere('wallet.owner = :owner')
            ->setParameter('owner', $user);

        return $queryBuilder;
    }

    /**
     * Save record.
     *
     * @param Wallet $wallet Wallet entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Wallet $wallet): void
    {
        $this->_em->persist($wallet);
        $this->_em->flush();
    }

    /**
     * Delete wallet.
     *
     * @param Wallet $wallet Wallet entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Wallet $wallet): void
    {
        $this->_em->remove($wallet);
        $this->_em->flush();
    }

    /**
     * Get or create new query builder.
     *
     * @return QueryBuilder QueryBuilder
     */
    private function getOrCreateQueryBuilder(): QueryBuilder
    {
        return null ?? $this->createQueryBuilder('wallet');
    }
}
