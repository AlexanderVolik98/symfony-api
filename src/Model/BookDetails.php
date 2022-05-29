<?php

namespace App\Model;

use App\Entity\BookCategory;
use App\Mapper\BookModelMappableInterface;

class BookDetails implements BookModelMappableInterface
{
    private int $id;

    private string $title;

    private string $slug;

    private string $image;

    /**
     * @var string[]
     */
    private array $authors;

    private bool $liveProj;

    private bool $audio;

    private bool $liveVideo;

    private bool $meap;

    private int $publicationDate;

    private int $rating;

    private int $reviews;

    public function isLiveProj(): bool
    {
        return $this->liveProj;
    }

    public function setLiveProj(bool $liveProj): self
    {
        $this->liveProj = $liveProj;

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

    /**
     * @var BookFormat[]
     */
    private array $formats;

    /**
     * @var BookCategory[]
     */
    private array $categories;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): self
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

    public function isMeap(): bool
    {
        return $this->meap;
    }

    public function setMeap(bool $meap): self
    {
        $this->meap = $meap;

        return $this;
    }

    public function getPublicationDate(): int
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(int $publicationDate): self
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    public function getRating()
    {
        return $this->rating;
    }

    public function setRating($rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getReviews(): int
    {
        return $this->reviews;
    }

    public function setReviews(int $reviews): self
    {
        $this->reviews = $reviews;

        return $this;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function setCategories(array $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    public function getFormats(): array
    {
        return $this->formats;
    }

    public function setFormats(array $formats): self
    {
        $this->formats = $formats;

        return $this;
    }
}
