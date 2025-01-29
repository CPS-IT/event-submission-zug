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
use Cpsit\EventSubmission\Domain\Repository\JobRepository;
use Cpsit\EventSubmission\Event\SubmissionWithdrawnEvent;
use Cpsit\EventSubmission\Exceptions\InvalidArgumentException;
use Cpsit\EventSubmission\Factory\ApiResponse\ApiResponseFactoryFactory;
use Cpsit\EventSubmission\Factory\ApiResponse\ApiResponseFactoryInterface;
use Cpsit\EventSubmission\Type\SubmissionStatus;
use Nng\Nnrestapi\Annotations as Api;
use Nng\Nnrestapi\Api\AbstractApi;
use Psr\EventDispatcher\EventDispatcherInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

/**
 * Event API end point for PUT method
 *
 * @Api\Endpoint
 */
final class Withdraw extends AbstractApi implements EventApiInterface
{
    public const RESPONSE_NAME = 'EventWithdrawApiResponse';
    protected ApiResponseFactoryInterface $responseFactory;
    public const MESSAGE_INVALID_ARGUMENT = 'Invalid or missing argument %s.';

    public function __construct(
        ApiResponseFactoryFactory                 $apiResponseFactoryFactory,
        private readonly JobRepository            $jobRepository,
        private readonly PersistenceManager       $persistenceManager,
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

        try {
            if(!is_array($arguments) || empty($arguments[self::PARAMETER_ID])) {
                $message = sprintf(self::MESSAGE_INVALID_ARGUMENT, self::PARAMETER_ID);
                throw new InvalidArgumentException($message, $responseCode);
            }
            $id = $arguments[self::PARAMETER_ID];
            $responseData = [
                'id' => $id,
            ];

            $job = $this->jobRepository->findOneByUuid($id);

            // update job status
            // Note: job could be approved and imported already
            if ($job instanceof Job) {
                $job->setStatus(SubmissionStatus::WITHDRAWN)
                    ->setApproved(false);
                $this->jobRepository->update($job);
                $this->persistenceManager->persistAll();
                $responseCode = ApiResponseInterface::EVENT_WITHDRAW_SUCCESS;
                $this->eventDispatcher->dispatch(
                    new SubmissionWithdrawnEvent(
                        $job,
                        $this->getRequest()->getSettings()
                    )
                );
            }

        } catch (\Exception $exception) {
            return $this->responseFactory
                ->errorResponse()
                ->setMessage($exception->getMessage())
                ->setCode($exception->getCode())
                ->toArray();
        }

        return $this->responseFactory
            ->create($responseCode, $responseData)
            ->toArray();
    }
}
