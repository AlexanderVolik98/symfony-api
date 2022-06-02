<?php

namespace App\Repository;

use App\Entity\Book;
use App\Exception\BookNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class BookRepository extends ServiceEntityRepository
{
    private const COUNT_SALES_BOOK_FOR_BESTSELLER = 300;

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

    public function getBestSellersBooks(): array
    {
        $query = $this->_em->createQuery("SELECT b FROM App\Entity\Book b 
        JOIN App\Entity\Review r 
        WITH b = r.book WHERE b.saleCount > 200 GROUP BY b.id HAVING SUM(r.rating)/COUNT(r) > 1");

        return $query->getResult();
    }
}
