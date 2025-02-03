<?php

declare(strict_types=1);

/*
 * This file is part of the event_submission project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Cpsit\EventSubmission\Validator;

interface ValidatorInterface
{
    public function isValid(array $requestBody): bool;

    /**
     * Factory index within dependency injection
     *
     * @return string
     */
    public static function getDefaultValidatorName(): string;
}
