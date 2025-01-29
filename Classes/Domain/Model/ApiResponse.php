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
use JsonException;

class ApiResponse implements ApiResponseInterface
{
    protected string $message = '';
    public function __construct(
        protected int $code,
        protected array $data,
    ) {}

    public function getCode(): int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;
        return $this;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function getMessage(): string
    {
        if (empty($this->message)) {
            return TranslationService::translate('api_response_message.' . $this->getCode());
        }
        return $this->message;
    }

    /**
     * @throws JsonException
     */
    public function __toString(): string
    {
        return json_encode($this->toArray(), JSON_THROW_ON_ERROR);
    }

    public function toArray(): array
    {
        return [
            'code' => $this->getCode(),
            'message' => $this->getMessage(),
            'data' => $this->getData(),
        ];
    }
}
