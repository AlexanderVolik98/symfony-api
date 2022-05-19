<?php

namespace App\Tests\Service;

use App\Entity\BookCategory;
use App\Model\BookCategory as BookCategoryModel;
use App\Model\BookCategoryListResponse;
use App\Repository\BookCategoryRepository;
use App\Service\BookCategoryService;
use App\Tests\AbstractTestCase;

class BookCategoryServiceTest extends AbstractTestCase
{
    public function testGetCategories()
    {
        $category = (new BookCategory())->setTitle('Test')->setSlug('test');
        $this->setEntityId($category, 8);

        // создаем репозиторий с моком
        $repository = $this->createMock(BookCategoryRepository::class);
        $repository->expects($this->once())
            ->method('findAllsortedByTitle')
            ->willReturn([$category]);

        // то что действительно получили
        $servise = new BookCategoryService($repository);

        // то что мы ожидаем получить
        $expected = new BookCategoryListResponse([(new BookCategoryModel(8, 'Test', 'test'))]);

        $this->assertEquals($expected, $servise->getCategories());
    }
}
