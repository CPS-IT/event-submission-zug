<?php

namespace Cpsit\EventSubmission\Event;

/*
 * This file is part of the iki_event_approval project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use Cpsit\EventSubmission\Domain\Model\Job;

final readonly class SubmissionWithdrawnEvent
{
    public function __construct(
        private array $job,
        private array $settings
    ) {}

    public function getJob(): array
    {
        return $this->job;
    }

    public function getSettings(): array
    {
        return $this->settings;
    }
}
