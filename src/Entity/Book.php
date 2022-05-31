<?php

namespace App\Entity;

use App\Repository\BookRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $title;

    /**
     * @ORM\Column(type="integer", options={"default": 0})
     */
    private int $count;

    /**
     * @ORM\Column(type="integer", options={"default": 0})
     */
    private int $saleCount;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $slug;

    /**
     * @ORM\Column(type="date_immutable")
     */
    private DateTimeInterface $publicationDate;

    /**
     * @ORM\Column(name="sbn", type="string", length=13)
     */
    private string $isbn;

    /**
     * @var Collection<Review>
     * @ORM\OneToMany(targetEntity=Review::class, mappedBy="id")
     */
    private Collection $reviews;

    /**
     * @ORM\Column(type="text", length=255)
     */
    private string $description;

    /**
     * @ORM\ManyToMany(targetEntity=BookCategory::class)
     */
    private Collection $categories;

    /**
     * @var Collection<BookToBookFormat>
     * @ORM\OneToMany(targetEntity=BookToBookFormat::class, mappedBy="book")
     */
    private Collection $formats;

    /**
     * @ORM\Column(type="simple_array")
     */
    private array $authors;

    /**
     * @ORM\Column(type="boolean", options={"default": 0})
     */
    private bool $meap = false;

    /**
     * @ORM\Column(type="boolean", options={"default": 0})
     */
    private bool $liveProj = false;

    /**
     * @ORM\Column(type="boolean", options={"default": 0})
     */
    private bool $audio = false;

    /**
     * @ORM\Column(type="boolean", options={"default": 0})
     */
    private bool $liveVideo = false;

    public function isLiveProj(): bool
    {
        return $this->liveProj;
    }

    public function setLiveProj(bool $liveProj): self
    {
        $this->liveProj = $liveProj;

        return $this;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function setCount(bool $count): self
    {
        $this->count = $count;

        return $this;
    }

    public function getSaleCount(): int
    {
        return $this->saleCount;
    }

    public function setSaleCount(int $saleCount): self
    {
        $this->saleCount = $saleCount;

        return $this;
    }

    public function isAudio(): bool
    {
        return $this->audio;
    }

    public function setAudio(bool $audio): self
    {
        $this->audio = $audio;

        return $this;
    }

    public function isLiveVideo(): bool
    {
        return $this->liveVideo;
    }

    public function setLiveVideo(bool $liveVideo): self
    {
        $this->liveVideo = $liveVideo;

        return $this;
    }

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->formats = new ArrayCollection();
    }

    public function getFormats(): Collection
    {
        return $this->formats;
    }

    public function setFormats(Collection $formats): self
    {
        $this->formats = $formats;

        return $this;
    }

    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function setReviews(Collection $reviews): self
    {
        $this->reviews = $reviews;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function isMeap(): ?bool
    {
        return $this->meap;
    }

    public function setMeap(bool $meap): self
    {
        $this->meap = $meap;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getAuthors(): array
    {
        return $this->authors;
    }

    public function setAuthors(array $authors): self
    {
        $this->authors = $authors;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function setCategories(Collection $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    public function getPublicationDate(): DateTimeInterface
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(DateTimeInterface $publicationDate): self
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    public function getIsbn(): string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
