<?php

declare(strict_types=1);

/*
 * This file is part of the event_submission project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Cpsit\EventSubmission\Factory\ApiResponse\Service;

use Cpsit\EventSubmission\Domain\Model\ApiResponseInterface;
use Cpsit\EventSubmission\Factory\ApiResponse\ApiResponseFactoryInterface;
use Cpsit\EventSubmission\Factory\ApiResponse\ApiResponseFactoryTrait;

class SettingsResponseFactory implements ApiResponseFactoryInterface
{
    use ApiResponseFactoryTrait;
    public const SUCCESS_CODE = ApiResponseInterface::APP_SETTINGS_SUCCESS;
    public const ERROR_CODE = ApiResponseInterface::APP_SETTINGS_ERROR;
    public const DEFAULT_FACTORY_NAME = 'ServiceSettingsApiResponse';

}
