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

use Cpsit\EventSubmission\Domain\Model\Job;
use TYPO3\CMS\Impexp\Exception;

class ValidatorFactory
{
    protected array $factories = [];

    public function __construct(\Traversable $factories)
    {
        $this->factories = iterator_to_array($factories);
    }

    public function get(
        string $factoryIndex = ''
    ): ?ValidatorInterface {
        if (array_key_exists($factoryIndex, $this->factories)) {
            return $this->factories[$factoryIndex];
        } else {
            throw new Exception(
                sprintf('Error validator factory: validator "%s" could not be found', $factoryIndex),
                1689292298
            );
        }
    }
}
