<?php

namespace App\Tests\Controller;

use App\Entity\Book;
use App\Entity\BookCategory;
use App\Tests\AbstractControllerTest;
use DateTime;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;

class BookControllerTest extends AbstractControllerTest
{
    public function testBooksByCategory()
    {
        $categoryId = $this->createCategory();

        $this->client->request('GET', '/api/v1/book/category/'.$categoryId.'/books');
        $responceContent = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertResponseIsSuccessful();
        $this->assertJsonDocumentMatchesSchema($responceContent, [
            'type' => 'object',
            'required' => ['items'],
            'properties' => [
                'items' => [
                    'type' => 'array',
                    'items' => [
                        'type' => 'object',
                        'required' => ['id', 'title', 'slug', 'image', 'authors', 'meap', 'publicationDate'],
                        'properties' => [
                            'title' => ['type' => 'string'],
                            'slug' => ['type' => 'string'],
                            'image' => ['type' => 'string'],
                            'authors' => [
                                'type' => 'array',
                                'items' => ['type' => 'string'],
                            ],
                            'publicationDate' => ['type' => 'integer'],
                            'meap' => ['type' => 'boolean'],
                            'id' => ['type' => 'integer'],
                        ],
                    ],
                ],
            ],
        ]);
    }

    private function createCategory(): int
    {
        $bookCategory = (new BookCategory())->setTitle('Devices')->setSlug('devices');
        $this->em->persist($bookCategory);

        $this->em->persist((new Book())
            ->setTitle('Test book')
            ->setDescription('some desc')
            ->setImage('some image')
            ->setSlug('test-book')
            ->setMeap(true)
            ->setIsbn('123321')
            ->setDescription('test desc')
            ->setPublicationDate((new DateTimeImmutable()))
            ->setAuthors(['Tester'])
            ->setCategories((new ArrayCollection([$bookCategory]))));

        $this->em->flush();

        return $bookCategory->getId();
    }
}
