<?php

namespace App\Controller;

use App\Model\BookCategoryListResponse;
use App\Service\BookCategoryService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookCategoryController extends AbstractController
{
    private $bookCategoryService;

    public function __construct(bookCategoryService $bookCategoryService)
    {
        $this->bookCategoryService = $bookCategoryService;
    }

    /**
     * @Route("/api/v1/books/categories", name="categories", methods={"GET"})
     * @OA\Response(
     *     response=200,
     *     description="get books for category section",
     *     @Model(type=BookCategoryListResponse::class)
     * )
     */
    public function getCategories(): Response
    {
        return $this->json($this->bookCategoryService->getCategories());
    }
}
