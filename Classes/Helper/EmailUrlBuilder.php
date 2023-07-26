<?php

declare(strict_types=1);

/*
 * This file is part of the event_submission project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Cpsit\EventSubmission\Helper;

use Exception;

final class EmailUrlBuilder
{
    static public function build(int $pid, array $arguments = [], bool $absolute = true): string
    {
        // Pid should not be 0 or less.
        if ($pid <= 0) {
            throw new Exception(
                'Invalid pid, validation url could not be properly generated.',
                1689946419
            );
        }

        // Validation URL
        return \nn\t3::Http()->buildUri($pid, $arguments, $absolute);
    }

}
