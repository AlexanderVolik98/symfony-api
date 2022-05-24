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
use App\Service\RatingService;
use App\Tests\AbstractTestCase;
use DateTime;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;

class BookServiceTest extends AbstractTestCase
{
    private ReviewRepository $reviewRepository;
    private BookRepository $bookRepository;
    private BookCategoryRepository $bookCategoryRepository;
    private RatingService $ratingService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->reviewRepository = $this->createMock(ReviewRepository::class);
        $this->bookRepository = $this->createMock(BookRepository::class);
        $this->bookCategoryRepository = $this->createMock(BookCategoryRepository::class);
        $this->ratingService = $this->createMock(RatingService::class);
    }

    public function testGetBookByCategoryNotFound(): void
    {
        $this->bookCategoryRepository->expects($this->once())
            ->method('existById')
            ->with(130)
            ->willReturn(false);

        $this->expectException(BookCategoryNotFoundException::class);

        $this->createBookService()->getBookByCategory(130);
    }

    private function createBookService(): BookService
    {
        return new BookService($this->bookRepository,
            $this->bookCategoryRepository,
            $this->reviewRepository,
            $this->ratingService
        );
    }

    public function testGetBooksByCategory(): void
    {
        $this->bookRepository->expects($this->once())
            ->method('findBooksByCategoryId')
            ->with(130)
            ->willReturn([$this->createBookEntity()]);

        $this->bookCategoryRepository->expects($this->once())
            ->method('existById')
            ->with(130)
            ->willReturn(true);

        $expected = new BookListResponse([$this->createBookItemModel()]);

        $this->assertEquals($expected, $this->createBookService()->getBookByCategory(130));
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
