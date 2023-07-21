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

class EventGetApiResponseFactory implements ApiResponseFactoryInterface
{
    public const SUCCESS_CODE = ApiResponseInterface::EVENT_GET_SUCCESS;
    public const ERROR_CODE = ApiResponseInterface::EVENT_GET_ERROR;
    public const DEFAULT_FACTORY_NAME = 'EventGetApiResponse';
    public function successResponse(Job $job): ApiResponse
    {
        $data = $job->getPayload();
        return $this->create(self::SUCCESS_CODE, $data);
    }

    public function errorResponse(): ApiResponse
    {
        return $this->create(self::ERROR_CODE, '');
    }

    public function create($code, $data): ApiResponse
    {
        return GeneralUtility::makeInstance(ApiResponse::class, $code, $data);
    }

    public static function getDefaultApiResponseFactoryName(): string
    {
        return self::DEFAULT_FACTORY_NAME;
    }
}
