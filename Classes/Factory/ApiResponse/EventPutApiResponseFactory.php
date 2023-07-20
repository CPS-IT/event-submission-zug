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

class EventPutApiResponseFactory implements ApiResponseFactoryInterface
{
    public const DEFAULT_FACTORY_NAME = 'EventPutApiResponse';
    public function successResponse(Job $job): ApiResponse
    {
        $data = $job->getPayload();
        return $this->create(ApiResponseInterface::EVENT_UPDATE_SUCCESS, $data);
    }

    public function errorResponse(): ApiResponse
    {
        return $this->create(ApiResponseInterface::EVENT_UPDATE_ERROR, '');
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
