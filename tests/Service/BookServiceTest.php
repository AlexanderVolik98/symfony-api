<?php

namespace App\Tests\Service;

use App\Entity\Book;
use App\Entity\BookCategory;
use App\Exception\BookCategoryNotFoundException;
use App\Model\BookListItem;
use App\Model\BookListResponse;
use App\Repository\BookCategoryRepository;
use App\Repository\BookRepository;
use App\Repository\ReviewRepository;
use App\Service\BookService;
use App\Tests\AbstractTestCase;
use DateTime;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;

class BookServiceTest extends AbstractTestCase
{
    public function testGetBookByCategoryNotFound(): void
    {
        $reviewRepository = $this->createMock(ReviewRepository::class);
        $bookRepository = $this->createMock(BookRepository::class);
        $bookCategoryRepository = $this->createMock(BookCategoryRepository::class);
        $bookCategoryRepository->expects($this->once())
            ->method('existById')
            ->with(130)
            ->willReturn(false);

        $this->expectException(BookCategoryNotFoundException::class);

        (new BookService($bookRepository, $bookCategoryRepository, $reviewRepository))->getBookByCategory(130);
    }

    public function testGetBooksByCategory(): void
    {
        $reviewRepository = $this->createMock(ReviewRepository::class);
        $bookRepository = $this->createMock(BookRepository::class);
        $bookRepository->expects($this->once())
            ->method('findBooksByCategoryId')
            ->with(130)
            ->willReturn([$this->createBookEntity()]);

        $bookCategoryRepository = $this->createMock(BookCategoryRepository::class);
        $bookCategoryRepository->expects($this->once())
            ->method('existById')
            ->with(130)
            ->willReturn(true);

        $service = new BookService($bookRepository, $bookCategoryRepository, $reviewRepository);

        $expected = new BookListResponse([$this->createBookItemModel()]);

        $this->assertEquals($expected, $service->getBookByCategory(130));
    }

    private function createBookEntity(): Book
    {
        $book = (new Book())
            ->setTitle('Test Book')
            ->setSlug('test-book')
            ->setMeap(false)
            ->setIsbn('123123')
            ->setDescription('test desc')
            ->setImage('test Image')
            ->setCategories(new ArrayCollection())
            ->setPublicationDate(new DateTimeImmutable('2020-10-10'))
            ->setAuthors(['f']);

        $this->setEntityId($book, 130);

        return $book;
    }

    private function createBookItemModel(): BookListItem
    {
        $bookModel = (new BookListItem())
            ->setTitle('Test Book')
            ->setSlug('test-book')
            ->setMeap(false)
            ->setImage('test Image')
            ->setPublicationDate(1602288000)
            ->setAuthors(['f']);

        $this->setEntityId($bookModel, 130);

        return $bookModel;
    }
}
