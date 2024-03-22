<?php

namespace App\Features\Shared\Dto;

use App\Services\Paginator;
use Illuminate\Support\Collection;

class PaginatedItems
{
    private int $count;

    private Collection $items;

    private Paginator $paginator;

    public function __construct(int $count, Collection $items, Paginator $paginator)
    {
        $this->count = $count;
        $this->items = $items;
        $this->paginator = $paginator;
    }

    public function count(): int
    {
        return $this->count;
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

    public function getPaginator(): Paginator
    {
        return $this->paginator;
    }
}
