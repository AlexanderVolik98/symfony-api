<?php

namespace App\DataFixtures;

use App\Entity\Book;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BookFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $androidCategory = $this->getReference(BookCategoryFixtures::ANDROID_CATEGORY);
        $phpCategory = $this->getReference(BookCategoryFixtures::PHP_CATEGORY);
        $devicesCategory = $this->getReference(BookCategoryFixtures::DEVICES_CATEGORY);
        $archCategory = $this->getReference(BookCategoryFixtures::ARCHITECTURE_CATEGORY);

        $booksData = [
            ['Clean Code', 424, 144, new DateTimeImmutable('2019-04-01'), true, '123123', 'test descr', ['Robert Martin'],
                'clean-code', (new ArrayCollection([$archCategory])), 'https://images.manning.com/360/480/', true, false, true, ],

            ['The Joy of PHP Programming', 1424, 102, new DateTimeImmutable('2019-04-01'), true, '123123', 'test descr', ['Alan Forbes'],
                'the-joy-of-php-programming', (new ArrayCollection([$phpCategory])), 'https://images.manning.com/360/480/', true, false, true, ],

            ['Head First PHP & MySQL', 1294, 52, new DateTimeImmutable('2019-04-01'), true, '123123', 'test descr', ['Lynn Beighley', 'Michael Morrison'],
                'head-first-php-mysql', (new ArrayCollection([$phpCategory])), 'https://images.manning.com/360/480/', true, false, true, ],

            ['I Am Satoshi Nakamoto', 424, 52, new DateTimeImmutable('2019-04-01'), true, '123123', 'test descr', ['Robert Martin'],
                'clean-code', (new ArrayCollection([$archCategory])), 'https://images.manning.com/360/480/', false, false, true, ],

            ['PHP: A Beginner’s Guide', 424, 52, new DateTimeImmutable('2019-04-01'), true, '123123', 'test descr', ['Robert Martin'],
                'php-beginners-guide', (new ArrayCollection([$phpCategory])), 'https://images.manning.com/360/480/', true, false, true, ],

            ['Design Patterns: Elements of Reusable Object-Oriented Software', 424, 52, new DateTimeImmutable('2021-04-01'), true, '123123', 'test descr', ['Robert Martin'],
                'design-patterns-elements-reusable-object-oriented-software', (new ArrayCollection([$androidCategory])), 'https://images.manning.com/360/480/', true, false, true, ],

            ['Clean Architecture: A Craftsman’s Guide to Software Structure and Design', 424, 200, new DateTimeImmutable('2020-04-01'), true, '123123', 'test descr', ['Robert Martin'],
                'clean-architecture-craftsmans-guide-software-structure-and-design', (new ArrayCollection([$archCategory])), 'https://images.manning.com/360/480/', true, false, true, ],

            ['Learning PHP, MySQL, JavaScript, & CSS: A Step-by-Step Guide to Creating Dynamic Websites', 4212, 522, new DateTimeImmutable('2019-04-01'), true, '123123', 'test descr', ['Robin Nixon'],
                'learning-php-mysql-javascript-css-step-step-guide-creating-dynamic-websites', (new ArrayCollection([$devicesCategory])), 'https://images.manning.com/360/480/', true, false, true, ],

            ['OtherBook', 422, 10, new DateTimeImmutable('2019-04-01'), true, '123123', 'test descr', ['Robert Martin'],
                'clean-code', (new ArrayCollection([$archCategory])), 'https://images.manning.com/360/480/', true, false, true, ],

            ['OtherBook2', 2414, 420, new DateTimeImmutable('2019-04-01'), true, '123123', 'test descr', ['I Am Satoshi Nakamoto'],
                'clean-code', (new ArrayCollection([$archCategory, $devicesCategory, $androidCategory])), 'https://images.manning.com/360/480/', true, false, true, ],

            ['OtherBook3', 22, 1, new DateTimeImmutable('2019-04-01'), true, '123123', 'test descr', ['I Am Satoshi Nakamoto 2'],
                'clean-code', (new ArrayCollection([$archCategory])), 'https://images.manning.com/360/480/', true, false, true, ],

            ['OtherBook4', 424, 52, new DateTimeImmutable('2019-04-01'), true, '123123', 'test descr', ['I Am Satoshi Nakamoto 3'],
                'clean-code', (new ArrayCollection([$archCategory])), 'https://images.manning.com/360/480/', true, false, true, ],
        ];

        foreach ($booksData as $bookData) {
            $manager->persist($this->createBook($bookData));
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            BookCategoryFixtures::class,
        ];
    }

    private function createBook(array $data): Book
    {
        list($title, $count, $saleCount, $publishDate, $meap, $isbn, $desc, $authors,
            $slug, $categories, $image, $liveProj, $audio, $video) = $data;

        return (new Book())
            ->setTitle($title)
            ->setCount($count)
            ->setSaleCount($saleCount)
            ->setPublicationDate($publishDate)
            ->setMeap($meap)
            ->setIsbn($isbn)
            ->setDescription($desc)
            ->setAuthors($authors)
            ->setSlug($slug)
            ->setCategories($categories)
            ->setImage($image)
            ->setLiveProj($liveProj)
            ->setAudio($audio)
            ->setLiveVideo($video);
    }
}
