<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\Review;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ReviewFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return [
            BookFixtures::class,
        ];
    }

    public function load(ObjectManager $manager)
    {
        $bookRepository = $manager->getRepository(Book::class);

        foreach ($bookRepository->findAll() as $book) {
            /* @var Book $book */
            for ($i = 1; $i < 6; ++$i) {
                $manager->persist((new Review())
                    ->setRating(rand(1, 5))
                    ->setBook($book)
                    ->setContent('это текст-"рыба", часто используемый в печати
                     и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице')
                    ->setAuthor('I Am Satoshi Nakamoto')
                    ->setCreatedAt(new DateTimeImmutable())
                );
            }
        }

        $manager->flush();
    }
}
