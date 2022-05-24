<?php

namespace App\Service;

use App\Entity\Review;
use App\Model\Review as ReviewModel;
use App\Model\ReviewPage;
use App\Repository\ReviewRepository;

class ReviewService
{
    private const PAGE_LIMIT = 5;

    private ReviewRepository $reviewRepository;
    private RatingService $ratingService;

    public function __construct(ReviewRepository $reviewRepository, RatingService $ratingService)
    {
        $this->reviewRepository = $reviewRepository;
        $this->ratingService = $ratingService;
    }

    public function getReviewPageByBookId(int $id, int $page): ReviewPage
    {
        $previousPageForOffset = $page - 1;
        $offset = max($previousPageForOffset, 0) * self::PAGE_LIMIT;
        $paginator = $this->reviewRepository->getPageByBookId($id, $offset, self::PAGE_LIMIT);
        $total = count($paginator);
        $items = [];

        foreach ($paginator as $item) {
            $items[] = $this->map($item);
        }

        return (new ReviewPage())
            ->setRating($this->ratingService->calcReviewRatingForBook($id, $total))
            ->setTotal($total)
            ->setPage($page)
            ->setPerPage(self::PAGE_LIMIT)
            ->setPages(ceil($total / self::PAGE_LIMIT))
            ->setItems($items);
    }

    public function map(Review $review): ReviewModel
    {
        return (new ReviewModel())
            ->setId($review->getId())
            ->setRating($review->getRating())
            ->setCreatedAt($review->getCreatedAt()->getTimestamp())
            ->setAuthor($review->getAuthor())
            ->setContent($review->getContent());
    }
}
