<?php

declare(strict_types=1);

/*
 * This file is part of the event_submission project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Cpsit\EventSubmission\Domain\Model;

use Cpsit\EventSubmission\Service\TranslationService;

class ApiResponse implements ApiResponseInterface
{
    public function __construct(
        protected int $code,
        protected string $data,
    )
    {
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function setCode(int $code): void
    {
        $this->code = $code;
    }

    public function getData(): string
    {
        return $this->data;
    }

    public function setData(string $data): void
    {
        $this->data = $data;
    }

    public function getMessage(): string
    {
        return TranslationService::translate('api_response_message.' . $this->getCode());
    }

    public function __toString(): string
    {
        $response = [
            'code' => $this->getCode(),
            'message' => $this->getMessage(),
            'data' => $this->getData(),
        ];

        return json_encode($response);
    }
}