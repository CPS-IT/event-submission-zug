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

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Job extends AbstractEntity
{
    public const
        TABLE_NAME = 'tx_ikiprojectimport_domain_model_job',
        FIELD_UID = 'uid',
        FIELD_PID = 'pid',
        FIELD_UUID = 'uuid',
        FIELD_EMAIL = 'email',
        FIELD_REQUEST_DATE_TIME = 'request_date_time',
        FIELD_PAYLOAD = 'payload',
        FIELD_RESPONSE_CODE = 'response_code',
        FIELD_IS_API_ERROR = 'is_api_error',
        FIELD_JOB_TRIGGERED_DATE_TIME = 'job_triggered_date_time',
        FIELD_IS_DONE = 'is_done',
        FIELD_INTERNAL_LOG_MESSAGE = 'internal_log_message',
        FIELD_IS_INTERNAL_ERROR = 'is_internal_error',
        FIELD_APPROVED = 'approved';

    protected string $uuid = '';
    protected string $email = '';
    protected string $payload = '';
    protected int $responseCode = 0;
    protected string $internalLogMessage = '';
    protected bool $isApiError = false;
    protected bool $isDone = false;
    protected bool $approved = false;
    protected ?\DateTime $jobTriggeredDateTime = null;
    protected ?\DateTime $requestDateTime = null;
    protected ?bool $isInternalError = null;

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getRequestDateTime(): ?\DateTime
    {
        return $this->requestDateTime;
    }

    public function setRequestDateTime(?\DateTime $requestDateTime): void
    {
        $this->requestDateTime = $requestDateTime;
    }

    public function getPayload(): string
    {
        return $this->payload;
    }

    public function setPayload(string $payload): void
    {
        $this->payload = $payload;
    }

    /**
     * @return int
     */
    public function getResponseCode(): int
    {
        return $this->responseCode;
    }

    /**
     * @param int $responseCode
     */
    public function setResponseCode(int $responseCode): void
    {
        $this->responseCode = $responseCode;
    }

    public function isApiError(): bool
    {
        return $this->getIsApiError();
    }

    public function getIsApiError(): bool
    {
        return $this->isApiError;
    }

    public function setIsApiError(bool $isApiError): void
    {
        $this->isApiError = $isApiError;
    }

    public function getJobTriggeredDateTime(): ?\DateTime
    {
        return $this->jobTriggeredDateTime;
    }

    public function setJobTriggeredDateTime(?\DateTime $jobTriggeredDateTime): void
    {
        $this->jobTriggeredDateTime = $jobTriggeredDateTime;
    }

    public function isDone(): bool
    {
        return $this->getIsDone();
    }

    public function getIsDone(): bool
    {
        return $this->isDone;
    }

    public function setIsDone(bool $isDone): void
    {
        $this->isDone = $isDone;
    }

    public function getInternalLogMessage(): string
    {
        return $this->internalLogMessage;
    }

    public function setInternalLogMessage(string $internalLogMessage): void
    {
        $this->internalLogMessage = $internalLogMessage;
    }

    public function isInternalError(): ?bool
    {
        return $this->getIsInternalError();
    }

    public function getIsInternalError(): ?bool
    {
        return $this->isInternalError;
    }

    public function setIsInternalError(?bool $isInternalError): void
    {
        $this->isInternalError = $isInternalError;
    }

    public function isApproved(): bool
    {
        return $this->approved;
    }

    public function setApproved(bool $approved): void
    {
        $this->approved = $approved;
    }
}
