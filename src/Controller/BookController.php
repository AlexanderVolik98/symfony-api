<?php

namespace App\Controller;

use App\Model\BookListResponse;
use App\Service\BookService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Model\ErrorResponse;
use App\Model\BookDetails;

class BookController extends AbstractController
{
    private BookService $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * @Route("/api/v1/book/category/{id}/books", name="category", methods={"GET"})
     * @OA\Response(
     *     ref="/api/v1/book/category/{id}/books",
     *     response=200,
     *     description="поаыдлавоыдавоыдал",
     *     @Model(type=BookListResponse::class)
     * )
     * @OA\Response (
     *     ref="/api/v1/book/category/{id}/books",
     *     response=404,
     *     description="book category not found",
     *     @Model(type=ErrorResponse::class)
     * )
     */
    public function booksCategory(int $id): Response
    {
        return $this->json($this->bookService->getBookByCategory($id));
    }

    /**
     * @Route("/api/v1/book/{id}", name="book", methods={"GET"})
     * @OA\Response(
     *     ref="/api/v1/book/{id}",
     *     response=200,
     *     description="поаыдлавоыдавоыдал",
     *     @Model(type=BookDetails::class)
     * )
     * @OA\Response (
     *     ref="/api/v1/book/category/{id}/books",
     *     response=404,
     *     description="book category not found",
     *     @Model(type=ErrorResponse::class)
     * )
     */
    public function bookById(int $id): Response
    {
        return $this->json($this->bookService->getBookById($id));
    }
}
