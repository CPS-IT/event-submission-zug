<?php

declare(strict_types=1);

/*
 * This file is part of the event_submission project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Cpsit\EventSubmission\Factory\Job;

use Cpsit\EventSubmission\Domain\Model\Job;

interface JobFactoryInterface
{
    /**
     * Create a \Cpsit\EventSubmission\Domain\Model\Job object
     *
     * @return Job|null Job object. Null if object could not be created
     */
    public function create(array $arguments = []): ?Job;

    /**
     * Factory index within dependency injection
     *
     * @return string
     */
    public static function getDefaultJobFactoryName(): string;
}
