<?php

namespace App\Service;

use App\Entity\Book;
use App\Entity\BookCategory;
use App\Entity\BookToBookFormat;
use App\Exception\BookCategoryNotFoundException;
use App\Mapper\BookMapper;
use App\Model\BookCategory as BookCategoryModel;
use App\Model\BookDetails;
use App\Model\BookFormat;
use App\Model\BookListItem;
use App\Model\BookListResponse;
use App\Repository\BookCategoryRepository;
use App\Repository\BookRepository;
use App\Repository\ReviewRepository;
use Doctrine\Common\Collections\Collection;

class BookService
{
    private BookRepository $bookRepository;
    private BookCategoryRepository $bookCategoryRepository;
    private ReviewRepository $reviewRepository;
    private RatingService $ratingService;

    public function __construct(
        BookRepository $bookRepository,
        BookCategoryRepository $bookCategoryRepository,
        ReviewRepository $reviewRepository,
        RatingService $ratingService
    ) {
        $this->bookCategoryRepository = $bookCategoryRepository;
        $this->bookRepository = $bookRepository;
        $this->reviewRepository = $reviewRepository;
        $this->ratingService = $ratingService;
    }

    public function getBookByCategory(int $categoryId): BookListResponse
    {
        if (!$this->bookCategoryRepository->existById($categoryId)) {
            throw new BookCategoryNotFoundException();
        }

        $books = $this->bookRepository->findBooksByCategoryId($categoryId);

        return new BookListResponse(
            array_map(
                fn (Book $book) => BookMapper::map($book, new BookListItem()), $books
            ), count($books));
    }

    public function getBookById(int $id): BookDetails
    {
        $book = $this->bookRepository->getById($id);
        $reviews = $this->reviewRepository->countByBookId($book->getId());
        $rating = $this->ratingService->calcReviewRatingForBook($book->getId(), $reviews);

        $categories = $book->getCategories()
            ->map(fn (BookCategory $bookCategory) => new BookCategoryModel(
                    $bookCategory->getId(), $bookCategory->getTitle(), $bookCategory->getSlug()
                )
            );

        return BookMapper::map($book, new BookDetails())
            ->setRating($rating)
            ->setReviews($reviews)
            ->setFormats($this->mapFormats($book->getFormats()))
            ->setCategories($categories->toArray());
    }

    public function getBestBooks(): BookListResponse
    {
        $books = $this->bookRepository->getBestSellersBooks();

        return new BookListResponse(
            array_map(
                fn (Book $book) => BookMapper::map($book, new BookListItem()), $books
            ), count($books));
    }

    /**
     * @param Collection<BookToBookFormat> $formats
     */
    private function mapFormats(Collection $formats): array
    {
        return $formats
            ->map(fn (BookToBookFormat $formatJoin) => (new BookFormat())
                ->setId($formatJoin->getFormat()->getId())
                ->setTitle($formatJoin->getFormat()->getTitle())
                ->setDescription($formatJoin->getFormat()->getDescription())
                ->setComment($formatJoin->getFormat()->getComment())
                ->setPrice($formatJoin->getPrice())
                ->setDiscountPercent($formatJoin->getDiscountPercent())
            )->toArray();
    }
}
