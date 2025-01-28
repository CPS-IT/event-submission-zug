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
use TYPO3\CMS\Core\Utility\GeneralUtility;

class FromArray implements JobFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function create(array $arguments = []): ?Job
    {
        if (empty($arguments)) {
            return null;
        }
        $job = GeneralUtility::makeInstance(Job::class);
        foreach ($arguments as $key => $value) {
            $method = 'set' . ucfirst(GeneralUtility::underscoredToLowerCamelCase($key));
            if (method_exists($job, $method)) {
                $job->$method($value);
            }
        }
        return $job;
    }

    public static function getDefaultJobFactoryName(): string
    {
        return 'FromArray';
    }
}
