<?php

namespace App\Repository;

use App\Entity\Review;
use Countable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Traversable;

class ReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    }

    public function countByBookId(int $id): int
    {
        return $this->count(['book' => $id]);
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\NoResultException
     */
    public function getBookTotalRatingSum(int $id): int
    {
        return (int) $this->_em->createQuery('SELECT SUM(r.rating) FROM App\Entity\Review r WHERE r.book = :id')
            ->setParameter('id', $id)
            ->getSingleScalarResult();
    }

    /**
     * @return Traversable&Countable
     */
    public function getPageByBookId(int $id, int $offset, int $limit)
    {
        $query = $this->_em->createQuery('SELECT r FROM App\Entity\Review r WHERE r.book = :id ORDER BY r.createdAt DESC')
            ->setParameter('id', $id)
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        return new Paginator($query, false);
    }
}
