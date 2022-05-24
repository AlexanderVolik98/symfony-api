<?php

namespace App\Service;

use App\Repository\ReviewRepository;

class RatingService
{
    private ReviewRepository $reviewRepository;

    public function __construct(ReviewRepository $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }

    public function calcReviewRatingForBook(int $id, int $total): float
    {
        return $total > 0 ? $this->reviewRepository->getBookTotalRatingSum($id) / $total : 0;
    }
}