<?php

namespace App\Tests\Controller;

use App\Entity\Book;
use App\Entity\BookCategory;
use App\Entity\BookFormat;
use App\Entity\BookToBookFormat;
use App\Tests\AbstractControllerTest;
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
                            'id' => ['type' => 'integer'],
                            'publicationDate' => ['type' => 'integer'],
                            'image' => ['type' => 'string'],
                            'meap' => ['type' => 'boolean'],
                            'authors' => [
                                'type' => 'array',
                                'items' => ['type' => 'string'],
                            ],
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

    public function testBookById(): void
    {
        $book = $this->createBook();

        $this->client->request('GET', '/api/v1/book/'.$book->getId());
        $responseContent = json_decode($this->client->getResponse()->getContent());

        $this->assertJsonDocumentMatchesSchema($responseContent, [
            'type' => 'object',
            'required' => ['id', 'title', 'slug', 'image', 'authors', 'meap', 'publicationDate', 'rating', 'reviews',
                'categories', 'formats', ],
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
                'categories' => ['type' => 'array', 'items' => [
                    'type' => 'object',
                    'properties' => [''],
                ]],
            ],
        ]);
    }

    private function createBook(): Book
    {
        $bookCategory = (new BookCategory())->setTitle('Devices')->setSlug('devices');
        $this->em->persist($bookCategory);

        $format = (new BookFormat())->setTitle('format')->setDescription('bla bla bla')->setComment('hello world');
        $this->em->persist($format);

        $book = (new Book())
            ->setTitle('title book')
            ->setCategories(new ArrayCollection([$bookCategory]))
            ->setPublicationDate(new DateTimeImmutable())
            ->setMeap(true)
            ->setImage('image')
            ->setAuthors(['tester'])
            ->setSlug('slug')
            ->setDescription('bla')
            ->setIsbn('123123');

        $this->em->persist($book);

        $join = (new BookToBookFormat())
            ->setPrice(232.42)
            ->setFormat($format)
            ->setDiscountPercent(5)
            ->setBook($book);

        $this->em->persist($join);

        $this->em->flush();

        return $book;
    }
}
