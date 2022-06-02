<?php

namespace App\Model;

class BookListResponse
{
    private array $items;

    private int $total;

    /**
     * @param BookListItem[] $items
     */
    public function __construct(array $items, int $total)
    {
        $this->items = $items;
        $this->total = $total;
    }

    /**
     * @return BookListItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getTotal(): int
    {
        return $this->total;
    }
}