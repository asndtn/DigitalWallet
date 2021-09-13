<?php
/**
 * Tag repository.
 */

namespace App\Repository;

use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class TagRepository.
 *
 * @method Tag|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tag|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tag[]    findAll()
 * @method Tag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TagRepository extends ServiceEntityRepository
{
    /**
     * Items per page.
     *
     * Use constants to define configuration options that rarely change instead
     * of specifying them in app/config/config.yml.
     * See https://symfony.com/doc/current/best_practices.html#configuration
     *
     * @constant int
     */
    public const PAGINATOR_ITEMS_PER_PAGE = 10;

    /**
     * Tag repository constructor.
     *
     * @param ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tag::class);
    }

    /**
     * Query all records.
     *
     * @return QueryBuilder QueryBuilder
     */
    public function queryAll(): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->orderBy('tag.name', 'DESC');
    }

    /**
     * Save record.
     *
     * @param Tag $tag Tag entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Tag $tag): void
    {
        $this->_em->persist($tag);
        $this->_em->flush();
    }

    /**
     * Delete record.
     *
     * @param Tag $tag Tag entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Tag $tag): void
    {
        $this->_em->remove($tag);
        $this->_em->flush();
    }

    /**
     * Get or create new query builder.
     *
     * @return QueryBuilder QueryBuilder
     */
    private function getOrCreateQueryBuilder(): QueryBuilder
    {
        return null ?? $this->createQueryBuilder('tag');
    }
}
