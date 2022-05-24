<?php

namespace App\Tests\Mapper;

use App\Entity\Book;
use App\Mapper\BookMapper;
use App\Model\BookDetails;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;

class BookMapperTest extends AbstractTestCase
{
    public function testMap()
    {
        $book = (new Book())
            ->setTitle('title')
            ->setSlug('123123')
            ->setImage('img')
            ->setAuthors(['tester'])
            ->setMeap(true)
            ->setPublicationDate(new DateTimeImmutable('2020-10-10'));

        $this->setEntityId($book, 1);

        $expected = (new BookDetails())
            ->setId(1)
            ->setSlug('123123')
            ->setTitle('title')
            ->setAuthors(['tester'])
            ->setImage('img')
            ->setMeap(true)
            ->setPublicationDate(1602288000);

        $this->assertEquals($expected, BookMapper::map($book, new BookDetails()));
    }
}
