<?php

namespace App\Repository;

use App\Entity\Book;
use App\Entity\BookCategory;
use App\Exception\BookNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Doctrine\Persistence\ManagerRegistry;

class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
     * @return Book[]
     */
    public function findBooksByCategoryId(int $id): array
    {
        $query = $this->_em->createQuery('SELECT b FROM App\Entity\Book b WHERE :categoryId MEMBER OF b.categories');
        $query->setParameter('categoryId', $id);

        return $query->getResult();
    }

    public function getById(int $id): Book
    {
        /** @var Book $book */
        $book = $this->find($id);

        if (null === $book) {
            throw new BookNotFoundException();
        }

        return $book;
    }

    public function getBestSellersBooks(int $saleCount): array
    {
        $query = $this->_em->createQuery("SELECT b FROM App\Entity\Book b 
        JOIN App\Entity\Review r 
        WITH b = r.book WHERE b.saleCount > :saleCount GROUP BY b.id HAVING SUM(r.rating)/COUNT(r) > 1")
        ->setParameter('saleCount', $saleCount);

        return $query->getResult();
    }

    public function getBooksByCategories(array $categories, int $limit): array
    {
        $query = $this->_em->createQuery('SELECT b FROM App\Entity\Book b WHERE :categories MEMBER OF b.categories');
        $query->setParameter('categories', $categories)
            ->setMaxResults($limit);

        return $query->getResult();
    }
}
