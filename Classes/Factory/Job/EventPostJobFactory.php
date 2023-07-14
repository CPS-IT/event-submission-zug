<?php

declare(strict_types=1);

/*
 * This file is part of the event_submission project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Cpsit\EventSubmission\Factory\Job;

use Cpsit\EventSubmission\Domain\Model\ApiResponseInterface;
use Cpsit\EventSubmission\Domain\Model\Job;
use Cpsit\EventSubmission\Domain\Repository\JobRepository;
use Nng\Nnrestapi\Mvc\Request;
use Nng\Nnrestapi\Mvc\Response;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Ramsey\Uuid\Uuid;

final class EventPostJobFactory implements JobFactoryInterface
{
    protected JobRepository $jobRepository;

    public function __construct(
        protected Request $request,
        protected Response $response,
    ) {
        $this->jobRepository = GeneralUtility::makeInstance(JobRepository::class);
    }

    public function create(): ?Job
    {
        $job = GeneralUtility::makeInstance(Job::class);
        $job->setUuid(Uuid::uuid4()->toString());
        $job->setEmail($this->request->getBody()['email'] ?? '');
        $job->setRequestDateTime($requestDateTime ?? new \DateTime('NOW'));
        $job->setPayload($this->request->getRawBody());
        $job->setResponseCode(ApiResponseInterface::EVENT_SUBMISSION_SUCCESS);
        $job->setIsApiError(false);

        try {
            $this->jobRepository->add($job);
        } catch (\Exception $e) {
            $job->setResponseCode(ApiResponseInterface::EVENT_SUBMISSION_ERROR);
            $job->setIsApiError(true);
            return null;
        }
        return $job;
    }
}