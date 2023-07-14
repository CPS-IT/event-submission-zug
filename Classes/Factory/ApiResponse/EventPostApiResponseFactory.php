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

class EventPostApiResponseFactory implements ApiResponseFactoryInterface
{
    public function successResponse(Job $job): ApiResponse
    {
        $data = [
            'editToken' => $job->getUuid(),
            'id' => $job->getUid()
        ];
        return $this->create(ApiResponseInterface::EVENT_SUBMISSION_SUCCESS, json_encode($data));
    }

    public function errorResponse(): ApiResponse
    {
        return $this->create(ApiResponseInterface::EVENT_SUBMISSION_ERROR, '');
    }

    public function create($code, $data): ApiResponse
    {
        return GeneralUtility::makeInstance(ApiResponse::class, $code, $data);
    }

    public static function getDefaultApiResponseFactoryName(): string
    {
        return 'EventPostApiResponse';
    }


}