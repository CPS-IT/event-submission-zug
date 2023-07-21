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

interface ApiResponseFactoryInterface
{
    public function create(int $code, array $data = []): ApiResponse;

    public function errorResponse(array $data = []): ApiResponse;

    public function successResponse(array $data = []): ApiResponse;

    /**
     * Factory index within dependency injection
     *
     * @return string
     */
    public static function getDefaultApiResponseFactoryName(): string;
}
