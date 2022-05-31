<?php

namespace App\Controller;

use App\Service\ReviewService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Model\ReviewPage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReviewController extends AbstractController
{
    private ReviewService $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    /**
     * @Route("/api/v1/books/{id}/reviews", name="reviews", methods={"GET"})
     * @OA\Parameter(name="page", in="query", description="review page number", @OA\Schema(type="integer"))
     * @OA\Response(
     *     response=200,
     *     description="desc",
     *     @Model(type=ReviewPage::class)
     * )
     */
    public function action(int $id, Request $request): Response
    {
        return $this->json($this->reviewService->getReviewPageByBookId(
            $id, $request->query->get('page', 1)));
    }
}
