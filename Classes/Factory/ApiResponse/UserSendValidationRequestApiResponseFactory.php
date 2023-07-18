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

use Cpsit\EventSubmission\Domain\Model\ApiResponse;
use Cpsit\EventSubmission\Domain\Model\ApiResponseInterface;
use Cpsit\EventSubmission\Domain\Model\Job;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class UserSendValidationRequestApiResponseFactory implements ApiResponseFactoryInterface
{
    public function successResponse(string $validationHash): ApiResponse
    {
        $data = [
            'validationHash' => $validationHash
        ];
        return $this->create(ApiResponseInterface::USER_SEND_VALIDATION_REQUEST_SUCCESS, json_encode($data));
    }

    public function errorResponse(): ApiResponse
    {
        return $this->create(ApiResponseInterface::USER_SEND_VALIDATION_REQUEST_ERROR, '');
    }

    public function create($code, $data): ApiResponse
    {
        return GeneralUtility::makeInstance(ApiResponse::class, $code, $data);
    }

    public static function getDefaultApiResponseFactoryName(): string
    {
        return 'UserSendValidationRequestApiResponse';
    }


}
