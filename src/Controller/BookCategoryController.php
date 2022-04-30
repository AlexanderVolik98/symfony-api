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
     * @Route("/api/v1/book/categories", name="categories", methods={"GET"})
     * @OA\Response(
     *     ref="/api/v1/book/categories",
     *     response=200,
     *     @Model(type=BookCategoryListResponse::class)
     * )
     */
    public function getCategories(): Response
    {
        return $this->json($this->bookCategoryService->getCategories());
    }
}
