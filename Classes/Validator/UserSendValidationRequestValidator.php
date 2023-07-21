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
 * Validate send validation request payload
 *
 * Expects: array $requestBody
 * Example:
 * ```
 * [
 *   "email" => "nix@foo.org",
 *   "validationHash" => "dfde719e-9f19-40b5-af2e-6f96d4034cda"
 * ]
 * ```
 */
class UserSendValidationRequestValidator implements \Cpsit\EventSubmission\Validator\ValidatorInterface
{
    public function isValid(array $requestBody): bool
    {

        if (empty($requestBody['email']) || !GeneralUtility::validEmail($requestBody['email'])) {
            return false;
        }

        if (empty($requestBody['validationHash']) || !GeneralUtility::validEmail($requestBody['email'])) {
            return false;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public static function getDefaultValidatorName(): string
    {
        return 'UserSendValidationRequest';
    }
}
