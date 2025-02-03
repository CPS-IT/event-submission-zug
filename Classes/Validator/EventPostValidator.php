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

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Validate event post request payload
 *
 * Expects: array $requestBody
 * Example:
 * ```
 * [
 *   "email" => "nix@foo.org",
 *   "title" => "Event post title"
 *    ...
 * ]
 * ```
 */
class EventPostValidator implements \Cpsit\EventSubmission\Validator\ValidatorInterface
{
    public function isValid(array $requestBody): bool
    {
        if (empty($requestBody['email']) || !GeneralUtility::validEmail($requestBody['email'])) {
            return false;
        }

        if (empty($requestBody['title'])) {
            return false;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public static function getDefaultValidatorName(): string
    {
        return 'EventPostValidator';
    }
}
