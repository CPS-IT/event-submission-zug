<?php

declare(strict_types=1);

/*
 * This file is part of the event_submission project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Cpsit\EventSubmission\Service;

use Cpsit\EventSubmission\Configuration\Extension;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Translation service
 *
 * Use extbase localization utility with a predefined extension name if none given.
 */
final class TranslationService
{
    public static function translate(string $key, ?string $extensionName = null, array $arguments = null): string
    {
        $extensionName = $extensionName ?? Extension::NAME;

        return (string)LocalizationUtility::translate($key, $extensionName, $arguments);
    }
}
