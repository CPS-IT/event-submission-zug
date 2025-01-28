<?php

/** @noinspection PhpMultipleClassDeclarationsInspection */

declare(strict_types=1);

/*
 * This file is part of the event_submission project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Cpsit\EventSubmission\Api\Event;

use Cpsit\EventSubmission\Domain\Model\ApiResponseInterface;
use Cpsit\EventSubmission\Domain\Model\Job;
use Cpsit\EventSubmission\Event\SubmissionWithdrawnEvent;
use Cpsit\EventSubmission\Factory\ApiResponse\ApiResponseFactoryFactory;
use Cpsit\EventSubmission\Factory\ApiResponse\ApiResponseFactoryInterface;
use Cpsit\EventSubmission\Factory\Job\JobFactory;
use Cpsit\EventSubmission\Type\SubmissionStatus;
use Nng\Nnhelpers\Utilities\Db;
use Nng\Nnrestapi\Annotations as Api;
use Nng\Nnrestapi\Api\AbstractApi;
use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * Event API end point for PUT method
 *
 * @Api\Endpoint
 */
final class Withdraw extends AbstractApi implements EventApiInterface
{
    public const RESPONSE_NAME = 'EventWithdrawApiResponse';
    protected ApiResponseFactoryInterface $responseFactory;

    public function __construct(
        ApiResponseFactoryFactory $apiResponseFactoryFactory,
        private readonly Db $db,
        private readonly EventDispatcherInterface $eventDispatcher,
    )
    {
        $this->responseFactory = $apiResponseFactoryFactory->get(self::RESPONSE_NAME);
    }

    /**
     * ## Event submission PUT
     *
     * Withdraw an event submission
     *
     * ## Responses:
     * **Success:**
     *
     * ```
     * {
     *   "code" 1300: ,
     *   "message": "Successfully withdrawn event proposal",
     *   "data": {
     *     "id": "ee55f96-69ca-4d4d-9412-474ce123a2d3",
     *   }
     * ```
     *
     * **Error:**
     *
     * ```
     * {
     *   "code": 1300,
     *   "message": "Withdrawal of event proposal failed",
     *   "data": {
     *     "id": "fee55f96-69ca-4d4d-9412-474ce123a2d3"
     *   }
     * }
     *
     * ```
     *
     * @Api\Route("PUT /event/{id}/withdraw")
     * @Api\Localize
     * @Api\Access("public")
     * @return array
     */
    public function withdraw(): array
    {
        $arguments = $this->request->getArguments();
        $responseCode = ApiResponseInterface::EVENT_WITHDRAW_ERROR;
        $id = $arguments[self::PARAMETER_ID];
        $responseData = [
            'id' => $id,
        ];

        // find job by identifier
        // Note: job could be approved and imported already
        $job = $this->db->findOneByValues(
            Job::TABLE_NAME,
            [
                Job::FIELD_UUID => $id,
            ]
        );

        // update job status
        if (!empty($job)) {
            $data = [
                Job::FIELD_APPROVED => 0,
                Job::FIELD_STATUS => SubmissionStatus::WITHDRAWN,
            ];

            $where = [
                Job::FIELD_UID => $job[Job::FIELD_UID],
            ];
            $result = $this->db->update(Job::TABLE_NAME, $data, $where);


            if ($result === 1) {
                $responseCode = ApiResponseInterface::EVENT_WITHDRAW_SUCCESS;
                $this->eventDispatcher->dispatch(
                    new SubmissionWithdrawnEvent(
                        $job,
                        $this->getRequest()->getSettings()
                    )
                );
            }
        }

        return $this->responseFactory
            ->create($responseCode, $responseData)
            ->toArray();
    }
}
