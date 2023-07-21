<?php

declare(strict_types=1);

/*
 * This file is part of the event_submission project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Cpsit\EventSubmission\Factory\ApiResponse;

use TYPO3\CMS\Impexp\Exception;

class ApiResponseFactoryFactory
{
    protected array $factories = [];

    public function __construct(\Traversable $factories)
    {
        $this->factories = iterator_to_array($factories);
    }

    /**
     * @throws Exception
     */
    public function get(string $factory): ApiResponseFactoryInterface
    {
        if (array_key_exists($factory, $this->factories)) {
            return $this->factories[$factory];
        } else {
            throw new Exception('Exception message', 1689292298);
        }
    }
}
