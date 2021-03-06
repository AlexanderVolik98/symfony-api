<?php

namespace App\Tests\Repository;

use App\Entity\Book;
use App\Entity\BookCategory;
use App\Repository\BookRepository;
use App\Tests\AbstractRepositoryTest;
use DateTime;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;

class BookRepositoryTest extends AbstractRepositoryTest
{
    private BookRepository $bookRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bookRepository = $this->getRepositoryForEntity(Book::class);
    }

    public function testFindBooksByCategoryId()
    {
        $deviceCategory = (new BookCategory())->setTitle('Devices')->setSlug('devices');

        $this->em->persist($deviceCategory);

        for ($i = 0; $i < 5; ++$i) {
            $book = $this->createBook('device-'.$i, $deviceCategory);
            $this->em->persist($book);
        }

        $this->em->flush();

        $this->assertCount(5, $this->bookRepository
            ->findBooksByCategoryId($deviceCategory->getId()));
    }

    private function createBook(string $title, BookCategory $deviceCategory): Book
    {
        return (new Book())
            ->setPublicationDate(new DateTimeImmutable())
            ->setAuthors(['author'])
            ->setMeap(true)
            ->setSlug($title)
            ->setDescription('some description')
            ->setIsbn('123321')
            ->setLiveVideo(true)
            ->setLiveProj(true)
            ->setAudio(true)
            ->setCategories((new ArrayCollection([$deviceCategory])))
            ->setTitle($title)
            ->setImage('someImage for '.$title);
    }
}
