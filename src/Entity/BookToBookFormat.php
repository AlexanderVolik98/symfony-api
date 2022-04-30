<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Book;
use App\Entity\BookFormat;

/**
 * @ORM\Entity
 */
class BookToBookFormat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private float $price;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $discountPercent;

    /**
     * @ORM\JoinColumn(nullable=false)
     * @ORM\ManyToOne(targetEntity=Book::class, inversedBy="formats")
     */
    private Book $book;

    /**
     * @ORM\JoinColumn(nullable=false)
     * @ORM\ManyToOne(targetEntity=BookFormat::class, fetch="EAGER")
     */
    private BookFormat $format;

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return int|null
     */
    public function getDiscountPercent(): ?int
    {
        return $this->discountPercent;
    }

    /**
     * @param int|null $discountPercent
     */
    public function setDiscountPercent(?int $discountPercent): void
    {
        $this->discountPercent = $discountPercent;
    }

    /**
     * @return Book
     */
    public function getBook(): Book
    {
        return $this->book;
    }

    /**
     * @param Book $book
     */
    public function setBook(Book $book): void
    {
        $this->book = $book;
    }

    /**
     * @return BookFormat
     */
    public function getFormat(): BookFormat
    {
        return $this->format;
    }

    /**
     * @param BookFormat $format
     */
    public function setFormat(BookFormat $format): void
    {
        $this->format = $format;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}