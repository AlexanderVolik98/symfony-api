<?php

namespace App\Controller;

use App\Model\BookDetails;
use App\Model\BookListResponse;
use App\Model\ErrorResponse;
use App\Service\BookService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    private BookService $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * @Route("/api/v1/books/{id}", name="book", methods={"GET"})
     * @OA\Response(
     *     response=200,
     *     description="get book by id",
     *     @Model(type=BookDetails::class)
     * )
     * @OA\Response (
     *     response=404,
     *     description="book not found",
     *     @Model(type=ErrorResponse::class)
     * )
     */
    public function bookById(int $id): Response
    {
        return $this->json($this->bookService->getBookById($id));
    }

    /**
     * @Route("/api/v1/books/category/{id}", name="category", methods={"GET"})
     * @OA\Response(
     *     response=200,
     *     description="get Books by category id",
     *     @Model(type=BookListResponse::class)
     * )
     * @OA\Response (
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
     * @Route("/api/v1/books/best", name="bestsBooks", methods={"GET"}, priority="10")
     * @OA\Response(
     *     response=200,
     *     description="get bestsellers",
     *     @Model(type=BookDetails::class)
     * )
     */
    public function booksBest(): Response
    {
        return $this->json($this->bookService->getBestBooks());
    }

    /**
     * @Route("/api/v1/books/{id}/similar", name="similarBooks", methods={"GET"})
     * @OA\Response(
     *     response=200,
     *     description="get similar books for section you might also like",
     *     @Model(type=BookDetails::class)
     * )
     * @OA\Response (
     *     response=404,
     *     description="book not found",
     *     @Model(type=ErrorResponse::class)
     * )
     */
    public function booksSimilar(int $id): Response
    {
        return $this->json($this->bookService->getSimilarBooksById($id));
    }
}
