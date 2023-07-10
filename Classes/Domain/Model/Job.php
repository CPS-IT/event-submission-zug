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
        FIELD_RESPONSE_MESSAGE = 'response_message',
        FIELD_IS_API_ERROR = 'is_api_error',
        FIELD_JOB_TRIGGERED_DATE_TIME = 'job_triggered_date_time',
        FIELD_IS_DONE = 'is_done',
        FIELD_INTERNAL_LOG_MESSAGE = 'internal_log_message',
        FIELD_IS_INTERNAL_ERROR = 'is_internal_error';

    protected string $uuid = '';
    protected string $email = '';
    protected string $payload = '';
    protected string $responseMessage = '';
    protected string $internalLogMessage = '';
    protected bool $isApiError = false;
    protected bool $isDone = false;
    protected ?\DateTime $jobTriggeredDateTime = null;
    protected ?\DateTime $requestDateTime = null;
    protected ?bool $isInternalError = null;

    public function buildJob(
        string $uuid,
        string $email,
        string $payload = '',
        string $responseMessage = '',
        bool $isApiError = false,
        ?\DateTime $requestDateTime = null
    ): self {
        $this->setUuid($uuid);
        $this->setEmail($email);
        $this->setRequestDateTime($requestDateTime ?? new \DateTime('NOW'));
        $this->setPayload($payload);
        $this->setResponseMessage($responseMessage);
        $this->setIsApiError($isApiError);
        $this->setIsDone(!$this->getIsApiError());
        return $this;
    }

    public static function createExistingJob(
        array $dbalRecord
    ): Job {
        $job = new self();
        $job->setUuid(self::FIELD_UUID);
        $job->setEmail(self::FIELD_EMAIL);
        $job->setRequestDateTime(
            new \DateTime('@' . (int)$dbalRecord[self::FIELD_REQUEST_DATE_TIME])
        );
        $job->setPayload($dbalRecord[self::FIELD_PAYLOAD]);
        $job->setResponseMessage($dbalRecord[self::FIELD_RESPONSE_MESSAGE]);
        $job->setIsApiError((bool)$dbalRecord[self::FIELD_IS_API_ERROR]);
        $job->setJobTriggeredDateTime(
            new \DateTime('@' . (int)$dbalRecord[self::FIELD_JOB_TRIGGERED_DATE_TIME])
        );
        $job->setIsDone((bool)$dbalRecord[self::FIELD_IS_DONE]);
        $job->setInternalLogMessage($dbalRecord[self::FIELD_INTERNAL_LOG_MESSAGE]);
        $job->setIsInternalError((bool)$dbalRecord[self::FIELD_IS_INTERNAL_ERROR]);
        $job->_setProperty(self::FIELD_UID, $dbalRecord[self::FIELD_UID]);
        $job->setPid($dbalRecord[self::FIELD_PID]);
        return $job;
    }

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

    public function getSciformaId(): int
    {
        return $this->sciformaId;
    }

    public function setSciformaId(int $sciformaId): void
    {
        $this->sciformaId = $sciformaId;
    }

    public function getPayload(): string
    {
        return $this->payload;
    }

    public function setPayload(string $payload): void
    {
        $this->payload = $payload;
    }

    public function getResponseMessage(): string
    {
        return $this->responseMessage;
    }

    public function setResponseMessage(string $responseMessage): void
    {
        $this->responseMessage = $responseMessage;
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

}
