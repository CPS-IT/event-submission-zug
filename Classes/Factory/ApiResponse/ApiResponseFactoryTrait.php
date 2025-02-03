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
use TYPO3\CMS\Core\Utility\GeneralUtility;

trait ApiResponseFactoryTrait
{
    public function successResponse(array $data = []): ApiResponse
    {
        return $this->create(self::SUCCESS_CODE, $data);
    }

    public function errorResponse(array $data = []): ApiResponse
    {
        return $this->create(self::ERROR_CODE, $data);
    }

    public function create(int $code, array $data = [], string $message = ''): ApiResponse
    {
        return GeneralUtility::makeInstance(ApiResponse::class, $code, $data);
    }

    public static function getDefaultApiResponseFactoryName(): string
    {
        return self::DEFAULT_FACTORY_NAME;
    }
}
