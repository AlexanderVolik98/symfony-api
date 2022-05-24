<?php

namespace App\Tests\Controller;

use App\Entity\Book;
use App\Entity\Review;
use App\Tests\AbstractControllerTest;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;

class ReviewControllerTest extends AbstractControllerTest
{
    public function testAction(): void
    {
        $book = $this->createBook();
        $this->createReview($book);

        $this->em->flush();

        $this->client->request('GET', '/api/v1/book/'.$book->getId().'/reviews');

        $responceContent = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertResponseIsSuccessful();
        $this->assertJsonDocumentMatchesSchema($responceContent, [
            'type' => 'object',
            'required' => ['items', 'rating', 'pages', 'page', 'perPage', 'total'],
            'properties' => [
                'rating' => ['type' => 'number'],
                'pages' => ['type' => 'integer'],
                'page' => ['type' => 'integer'],
                'perPage' => ['type' => 'integer'],
                'total' => ['type' => 'integer'],
                'items' => [
                    'type' => 'array',
                    'required' => ['id', 'content', 'author', 'rating', 'createdAt'],
                    'properties' => [
                        'id' => ['type' => 'integer'],
                        'rating' => ['type' => 'integer'],
                        'createdAt' => ['type' => 'integer'],
                        'content' => ['type' => 'string'],
                        'author' => ['type' => 'string'],
                    ],
                ],
            ],
        ]);
    }

    private function createBook(): Book
    {
        $book = ((new Book())
            ->setTitle('Test book')
            ->setDescription('some desc')
            ->setImage('some image')
            ->setSlug('test-book')
            ->setMeap(true)
            ->setIsbn('123321')
            ->setDescription('test desc')
            ->setPublicationDate((new DateTimeImmutable()))
            ->setCategories(new ArrayCollection())
            ->setAuthors(['Tester']));

        $this->em->persist($book);

        return $book;
    }

    private function createReview(Book $book)
    {
        $this->em->persist((new Review())
            ->setAuthor('tester')
            ->setContent('test content')
            ->setCreatedAt(new DateTimeImmutable())
            ->setRating(5)
            ->setBook($book));
    }
}
