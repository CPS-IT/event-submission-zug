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

final class TemplateService implements ServiceInterface
{
    public const TEMPLATE_PATHS = [
        'templateRootPaths' => ['EXT:event_submission/Resources/Private/Templates'],
        'layoutRootPaths' => ['EXT:event_submission/Resources/Private/Layouts'],
        'partialRootPaths' => ['EXT:event_submission/Resources/Private/Partials'],
    ];

    public function render(
        string $templateName,
        array $templatesPaths = self::TEMPLATE_PATHS,
        array $templateVariables = []
    ): string {
        // Render Html mail
        return @\nn\t3::Template()->render(
            $templateName,
            $templateVariables,
            $templatesPaths
        );
    }
}
