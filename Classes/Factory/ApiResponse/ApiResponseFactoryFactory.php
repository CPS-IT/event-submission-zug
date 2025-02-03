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

class ApiResponseFactoryFactory
{
    protected array $factories = [];
    public const MISSING_FACTORY_MESSAGE = 'Factory %s could not be found message';
    public const MISSING_FACTORY_CODE = 1689292298;

    public function __construct(\Traversable $factories)
    {
        $this->factories = iterator_to_array($factories);
    }

    /**
     * @throws MissingFactoryException
     */
    public function get(string $factory): ApiResponseFactoryInterface
    {
        if (array_key_exists($factory, $this->factories)) {
            return $this->factories[$factory];
        }

        $message = sprintf(self::MISSING_FACTORY_MESSAGE, $factory);
        throw new MissingFactoryException($message, self::MISSING_FACTORY_CODE);
    }
}
