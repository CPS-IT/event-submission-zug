<?php
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
use Cpsit\EventSubmission\Factory\ApiResponse\ApiResponseFactoryFactory;
use Cpsit\EventSubmission\Factory\ApiResponse\ApiResponseFactoryInterface;
use Cpsit\EventSubmission\Type\SubmissionStatus;
use JsonException;
use Nng\Nnhelpers\Utilities\Db;
use Nng\Nnrestapi\Annotations as Api;
use Nng\Nnrestapi\Api\AbstractApi;

/**
 * Event API end point for PUT method
 *
 * @Api\Endpoint()
 */
final class Get extends AbstractApi implements EventApiInterface
{
    public const RESPONSE_NAME = 'EventGetApiResponse';
    protected ApiResponseFactoryInterface $responseFactory;
    protected Db $db;

    public function __construct(ApiResponseFactoryFactory $apiResponseFactoryFactory, Db $db)
    {
        $this->responseFactory = $apiResponseFactoryFactory->get(self::RESPONSE_NAME);
        $this->db = $db;
    }

    /**
     * ## Event submission GET
     *
     * GET an event submission
     *
     * ## Responses:
     *
     * **Success:**
     *
     * ```
     * {
     *   "code": 700,
     *   "message": "Event submission found",
     *   "data": {
     *     "email": "nix@foo.org",
     *     "title": "A event proposal with title",
     *     "teaser": "Teaser text for event proposal. The teaser must not contain any html tags.",
     *     "datetime": "2017-07-21T17:00:00",
     *     "event_end": "2017-07-21T19:00:00",
     *     "timezone": "Europe/Berlin",
     *     "bodytext": "Do not miss this event! It will be awesome.",
     *     "event_mode": "hybrid",
     *     "organizer_simple": "International Climate Initiative",
     *     "location_simple": "A cool venue",
     *     "external_reference": "Foo external reference for event",
     *     "country": 13,
     *     "language": "de"
     *   }
     * ```
     *
     * **Error:**
     *
     * ```
     * {
     *   "code": 800,
     *   "message": "Requested event submission could not be found",
     *   "data": ""
     * }
     *
     * ```
     *
     * @Api\Route("GET /event/{id}")
     * @Api\Access("public")
     * @Api\Localize()
     * @return array
     * @throws JsonException
     */
    public function index(): array
    {
        $arguments = $this->request->getArguments();
        $responseData = [];
        $responseCode = ApiResponseInterface::EVENT_GET_ERROR;
        $id = $arguments[self::PARAMETER_ID];

        // find job by identifier
        // Note: job could be approved and imported yet
        $job = $this->db->findOneByValues(Job::TABLE_NAME,
            [
                Job::FIELD_UUID => $id,
            ]
        );

        if (!empty($job)) {
            $responseData = json_decode($job[Job::FIELD_PAYLOAD], true, 512, JSON_THROW_ON_ERROR);
            $responseData[Job::FIELD_APPROVED] = (bool)$job[Job::FIELD_APPROVED];
            // we use the name of the enum case as string representation for the `status` field
            $responseData[Job::FIELD_STATUS] = SubmissionStatus::from($job[Job::FIELD_STATUS])->name;
            $responseCode = ApiResponseInterface::EVENT_GET_SUCCESS;
        }

        return $this->responseFactory
            ->create($responseCode, $responseData)
            ->toArray();
    }
}
