<?php

namespace App\Mapper;

use App\Entity\Book;

class BookMapper
{
    public static function map(Book $book, BookModelMappableInterface $model): BookModelMappableInterface
    {
        return $model
            ->setId($book->getId())
            ->setTitle($book->getTitle())
            ->setSlug($book->getSlug())
            ->setImage($book->getImage())
            ->setAuthors($book->getAuthors())
            ->setMeap($book->isMeap())
            ->setPublicationDate($book->getPublicationDate()->getTimestamp());
    }
}
