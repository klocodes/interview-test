<?php

namespace App\Services;

use Illuminate\Routing\Exceptions\UrlGenerationException;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Collection;

class Paginator
{
    private const DEFAULT_PAGES_LIMIT = 10;

    private UrlGenerator $url;

    private int $currentPage;

    private int $pagesLimit;

    private int $pagesCount;

    public function __construct(UrlGenerator $url, int $currentPage, ?int $pagesLimit, int $itemsCount, int $itemLimit)
    {
        $this->url = $url;
        $this->currentPage = $currentPage;
        $this->pagesLimit = $pagesLimit ?: self::DEFAULT_PAGES_LIMIT;
        $this->pagesCount = ceil($itemsCount / $itemLimit);

    }

    /**
     * @throws UrlGenerationException
     */
    public function buildUrl(array $parameters = []): string
    {

        return $this->url->toRoute(
            $this->url->getRequest()->route(),
            [
                ...$this->url->getRequest()->route()->parameters(),
                ...$parameters
            ],
            true,
        );
    }

    public function hasPages(): bool
    {
        return $this->pagesCount > 1;
    }

    public function isFirstPage(): string
    {
        return $this->currentPage === 1;
    }

    /**
     * @throws UrlGenerationException
     */
    public function getPreviousPage(): ?string
    {
        if ($this->currentPage > 1) {
            return $this->buildUrl(['page' => ($this->currentPage - 1)]);
        }

        return null;
    }

    /**
     * @throws UrlGenerationException
     */
    public function getNextPage(): ?string
    {
        if ($this->currentPage < $this->pagesCount) {
            return $this->buildUrl(['page' => ($this->currentPage + 1)]);
        }

        return null;
    }

    public function hasMorePages(): bool
    {
        return $this->currentPage < $this->pagesCount;
    }


    /**
     * @throws UrlGenerationException
     */
    public function getFirstPage(): string
    {
        return $this->buildUrl(['page' => 1]);
    }

    /**
     * @throws UrlGenerationException
     */
    public function getLastPage(): string
    {
        return $this->buildUrl(['page' => $this->pagesCount]);
    }

    /**
     * @throws UrlGenerationException
     */
    public function getCurrentPage(): string
    {
        return $this->buildUrl(['page' => $this->currentPage]);
    }

    /**
     * @throws UrlGenerationException
     */
    public function fetchPages(): Collection
    {
        $collection = Collection::make();

        $pageStart = 1;
        $pageEnd = $this->pagesLimit;

        //offset conditions
        $hasOffset = $this->pagesCount > $this->pagesLimit;
        $forwardShift = $this->currentPage > $this->pagesLimit / 2;
        $shiftBack = $this->currentPage < ($this->pagesCount - $this->pagesLimit / 2);

        if (!$hasOffset) {
            $pageEnd = $this->pagesCount;
        }

        if ($hasOffset && $forwardShift) {
            $collection->put(1, $this->getFirstPage());
            $collection->put('back_separator', '...');

            $pageStart = $this->currentPage - ($this->pagesLimit / 2) + 1;
        }

        if ($hasOffset && $shiftBack) {
            $pageEnd = $pageStart + ($this->pagesLimit - 2);
        }

        if ($hasOffset && !$shiftBack) {
            $pageStart = $this->pagesCount - ($this->pagesLimit - 2);
            $pageEnd = $this->pagesCount;
        }

        for ($page = $pageStart; $page <= $pageEnd; $page++) {
            $collection->put(
                $page,
                $page !== $this->currentPage ? $this->buildUrl(['page' => $page]) : null
            );
        }

        if ($pageEnd < $this->pagesCount) {
            $collection->put('front_separator', '...');
            $collection->put($this->pagesCount, $this->getLastPage());
        }

        return $collection;
    }
}
