<?php
/**
 * Input repository.
 */

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Input;
use App\Entity\Tag;
use App\Entity\User;
use App\Entity\Wallet;
use DateTimeInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

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
    public const PAGINATOR_ITEMS_PER_PAGE = 10;

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
     * Query wallets by owner.
     *
     * @param User  $user    User entity
     * @param array $filters Filters array
     */
    public function queryByOwner(User $user, array $filters = []): QueryBuilder
    {
        $queryBuilder = $this->queryAll($filters);
        $queryBuilder->andWhere('wallet.owner = :owner')
            ->setParameter('owner', $user);

        return $queryBuilder;
    }

    /**
     * Query all records.
     *
     * @param array $filters Filters array
     *
     * @return QueryBuilder QueryBuilder
     */
    public function queryAll(array $filters): QueryBuilder
    {
        $queryBuilder = $this->getOrCreateQueryBuilder()
            ->select(
                'partial input.{id, amount, date, category}',
                'partial category.{id, name}',
                'partial tags.{id, name}',
                'wallet'
            )
            ->join('input.category', 'category')
            ->join('input.wallet', 'wallet')
            ->leftJoin('input.tags', 'tags')
            ->orderBy('input.category', 'DESC');

        $queryBuilder = $this->applyFiltersToList($queryBuilder, $filters);

        return $queryBuilder;
    }

    /**
     * Query by wallet.
     *
     * @param $fromDate
     * @param $to
     * @param User $user
     * @param array $filters
     *
     * @return QueryBuilder
     */
    public function queryByWallet(User $user, $wallet, array $filters = []): QueryBuilder
    {
        $queryBuilder = $this->queryByOwner($user, $filters);
        $queryBuilder
            ->andWhere('input.wallet = :wallet')
            ->setParameter('wallet', $wallet);

        return $queryBuilder;
    }

    /**
     * Query by date.
     *
     * @param DateTimeInterface $fromDate from date
     * @param DateTimeInterface $to       to date
     * @param User              $user     User entity
     * @param array             $filters  Filters array
     */
    public function queryByDate($fromDate, $to, User $user, $wallet, array $filters = []): QueryBuilder
    {
        $queryBuilder = $this->queryByWallet($user, $wallet, $filters);
        $queryBuilder
            ->andWhere('input.date BETWEEN :fromDate AND :to')
            ->setParameter('fromDate', $fromDate)
            ->setParameter('to', $to);

        return $queryBuilder;
    }

    /**
     * Get or create new query builder.
     *
     * @return QueryBuilder QueryBuilder
     */
    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?? $this->createQueryBuilder('input');
    }

    /**
     * Save record.
     *
     * @param \App\Entity\Input $input Input entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Input $input): void
    {
        $this->_em->persist($input);
        $this->_em->flush();
    }

    /**
     * Delete record.
     *
     * @param \App\Entity\Input $input Input entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Input $input): void
    {
        $this->_em->remove($input);
        $this->_em->flush();
    }

    /**
     * Apply filters to paginated list.
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder
     * @param array                      $filters      Filters array
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    private function applyFiltersToList(QueryBuilder $queryBuilder, array $filters = []): QueryBuilder
    {
        if (isset($filters['category']) && $filters['category'] instanceof Category) {
            $queryBuilder->andWhere('category = :category')
                ->setParameter('category', $filters['category']);
        }

        if (isset($filters['tag']) && $filters['tag'] instanceof Tag) {
            $queryBuilder->andWhere('tags IN (:tag)')
                ->setParameter('tag', $filters['tag']);
        }

        if (isset($filters['wallet']) && $filters['wallet'] instanceof Wallet) {
            $queryBuilder->andWhere('wallet = :wallet')
                ->setParameter('wallet', $filters['wallet']);
        }

        return $queryBuilder;
    }
}
