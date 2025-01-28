<?php

declare(strict_types=1);

/*
 * This file is part of the event_submission project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Cpsit\EventSubmission\Domain\Model\Dto;

class JobDemand implements DemandInterface
{
    /**
     * Page Ids to search for
     * @var int[]
     */
    protected array $pageIds = [];

    /**
     * @var int
     */
    protected int $limit = 100;

    /**
     * @var int
     */
    protected int $offset = 0;

    /**
     * @var string
     */
    protected string $sorting = 'requestDateTime desc';

    /**
     * Status
     * @var int[]
     */
    protected array $status = [];

    public function getSorting(): string
    {
        return $this->sorting;
    }

    public function setSorting(string $sorting): void
    {
        $this->sorting = $sorting;
    }

    public function getStatus(): array
    {
        return $this->status;
    }

    public function setStatus(array $status): void
    {
        $this->status = $status;
    }

    public function getPageIds(): array
    {
        return $this->pageIds;
    }

    public function setPageIds(array $pageIds): void
    {
        $this->pageIds = $pageIds;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function setOffset(int $offset): void
    {
        $this->offset = $offset;
    }
}
