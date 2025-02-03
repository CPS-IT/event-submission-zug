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

use Cpsit\EventSubmission\Domain\Model\ApiResponseInterface;

class UserSendValidationRequestApiResponseFactory implements ApiResponseFactoryInterface
{
    use ApiResponseFactoryTrait;

    public const DEFAULT_FACTORY_NAME = 'UserSendValidationRequestApiResponse';
    public const SUCCESS_CODE = ApiResponseInterface::USER_SEND_VALIDATION_REQUEST_SUCCESS;
    public const ERROR_CODE = ApiResponseInterface::USER_SEND_VALIDATION_REQUEST_ERROR;
}
