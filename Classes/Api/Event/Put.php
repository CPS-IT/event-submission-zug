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
use JsonException;
use Nng\Nnhelpers\Utilities\Db;
use Nng\Nnrestapi\Annotations as Api;
use Nng\Nnrestapi\Api\AbstractApi;
use TYPO3\CMS\Impexp\Exception;

/**
 * Event API end point for PUT method
 *
 * @Api\Endpoint()
 */
final class Put extends AbstractApi implements EventApiInterface

{
    public const RESPONSE_NAME = 'EventPutApiResponse';
    protected ApiResponseFactoryFactory $apiResponseFactoryFactory;
    protected ApiResponseFactoryInterface $responseFactory;
    protected Db $db;
    public function __construct(ApiResponseFactoryFactory $apiResponseFactory, Db $db)
    {
        $this->apiResponseFactoryFactory = $apiResponseFactory;
        $this->responseFactory = $this->apiResponseFactoryFactory->get(self::RESPONSE_NAME);
        $this->db = $db;
    }

    /**
     * ## Event submission PUT
     *
     * Replace an event submission
     *
     * ### Payload:
     *
     * ```
     * {
     *   "email": "nix@foo.org",
     *   "title": "A event proposal with title",
     *   "teaser": "Teaser text for event proposal. The teaser must not  contain any html tags\n",
     *   "datetime": "2017-07-21T17:00:00",
     *   "event_end": "2017-07-21T19:00:00",
     *   "timezone": 1575,
     *   "bodytext": "Do not miss this event! It will be awesome.",
     *   "event_mode": "hybrid",
     *   "organizer_simple": "International Climate Initiative",
     *   "location_simple": "A cool venue",
     *   "reference_id": "994432",
     *   "country": 13,
     *   "language": "de"
     * }
     * ```
     * ## Responses:
     *
     * **Success:**
     *
     * ```
     * {
     *   "code": 200,
     *   "message": "Successfully changed event proposal",
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
     *   "code": 600,
     *   "message": "Update of event proposal failed",
     *   "data": ""
     * }
     *
     * ```
     *
     * @Api\Route("PUT /{language}/event/{id}")
     * @Api\Access("public")
     * @return string
     * @throws JsonException
     */
    public function update(): string
    {
        $arguments = $this->request->getArguments();
        $responseData = [];
        $responseCode = ApiResponseInterface::EVENT_UPDATE_ERROR;
        $id = $arguments[self::PARAMETER_ID];

        // find job by identifier, job must not be approved and imported yet
        $job = $this->db->findOneByValues(Job::TABLE_NAME,
            [
                Job::FIELD_UUID => $id,
                Job::FIELD_APPROVED => 0,
                Job::FIELD_IS_DONE => 0
            ]
        );

        // update job
        if(!empty($job)) {
            // replace payload
            $job[Job::FIELD_PAYLOAD] = json_encode($this->request->getRawBody(), JSON_THROW_ON_ERROR);
            $job[Job::FIELD_REQUEST_DATE_TIME] = time();
            $this->db->update(Job::TABLE_NAME, $job, $job[Job::FIELD_UID]);

            $responseData = json_decode($job[Job::FIELD_PAYLOAD], true, 512, JSON_THROW_ON_ERROR);
            $responseCode = ApiResponseInterface::EVENT_UPDATE_SUCCESS;
        }

        return $this->responseFactory
            ->create($responseCode, $responseData)
            ->__toString();
    }
}
