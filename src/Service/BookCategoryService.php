<?php

namespace App\Service;

use App\Entity\BookCategory;
use App\Model\BookCategory as BookCategoryModel;
use App\Model\BookCategoryListResponse;
use App\Repository\BookCategoryRepository;

class BookCategoryService
{
    private BookCategoryRepository $bookCategoryRepository;

    public function __construct(BookCategoryRepository $bookCategoryRepository)
    {
        $this->bookCategoryRepository = $bookCategoryRepository;
    }

    public function getCategories(): BookCategoryListResponse
    {
        $categories = $this->bookCategoryRepository->findAllsortedByTitle();

        $items = array_map(
            fn (BookCategory $bookCategory) => new BookCategoryModel(
                $bookCategory->getId(), $bookCategory->getTitle(), $bookCategory->getSlug()
            ),
            $categories
        );

        return new BookCategoryListResponse($items);
    }
}
