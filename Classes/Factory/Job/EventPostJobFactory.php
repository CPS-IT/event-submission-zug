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
use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Ramsey\Uuid\Uuid;

final class EventPostJobFactory implements JobFactoryInterface
{
    public function __construct(
        protected Request $request,
        protected Response $response,
    ) {
    }

    public function create(): ?Job
    {
        $job = GeneralUtility::makeInstance(Job::class);
        $job->setUuid(Uuid::uuid4()->toString());
        $job->setPid($this->getStoragePidFromSiteConfig());
        $job->setEmail($this->request->getBody()['email'] ?? '');
        $job->setRequestDateTime(new \DateTime('NOW'));
        // Todo: sanitize and validate payload
        $job->setPayload($this->request->getRawBody());
        $job->setResponseCode(ApiResponseInterface::EVENT_SUBMISSION_SUCCESS);
        $job->setIsApiError(false);

        try {
            $job = \nn\t3::Db()->insert($job);
        } catch (\Exception $e) {
            $job->setResponseCode(ApiResponseInterface::EVENT_SUBMISSION_ERROR);
            $job->setIsApiError(true);
            return null;
        }
        return $job;
    }

    protected function getStoragePidFromSiteConfig(): int
    {
        /** @var Site $site */
        $site = $this->request->getMvcRequest()->getAttribute('site');
        return (int)$site->getConfiguration()['settings']['eventSubmission']['storagePageUid'] ?? 0;
    }
}
