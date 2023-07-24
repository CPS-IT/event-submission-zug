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

use Cpsit\EventSubmission\Domain\Model\Job;
use Cpsit\EventSubmission\Factory\ApiResponse\ApiResponseFactoryFactory;
use Cpsit\EventSubmission\Factory\ApiResponse\ApiResponseFactoryInterface;
use Cpsit\EventSubmission\Factory\Job\JobFactory;
use Cpsit\EventSubmission\Helper\HydrateJobFromEventPostRequest;
use Exception;
use Nng\Nnrestapi\Annotations as Api;
use Nng\Nnrestapi\Api\AbstractApi;

/**
 * Event post api end point
 *
 * @Api\Endpoint()
 */
final class Post extends AbstractApi
{

    public const RESPONSE_NAME = 'EventPostApiResponse';

    protected ApiResponseFactoryInterface $responseFactory;

    public function __construct(
        protected ApiResponseFactoryFactory $apiResponseFactory,
        protected JobFactory $jobFactory
    ) {
        $this->responseFactory = $apiResponseFactory->get(self::RESPONSE_NAME);
    }

    /**
     * ## Event submission POST
     *
     * Create an event submission job
     *
     * ### Payload:
     *
     * ```
     * {
     * "email": "nix@foo.org",
     * "title": "A event proposal with title",
     * "teaser": "Teaser text for event proposal. The teaser must not  contain any html tags\n",
     * "datetime": "2017-07-21T17:00:00",
     * "event_end": "2017-07-21T19:00:00",
     * "timezone": 1575,
     * "bodytext": "Do not miss this event! It will be awesome.",
     * "event_mode": "hybrid",
     * "organizer_simple": "International Climate Initiative",
     * "location_simple": "A cool venue",
     * "reference_id": "994432",
     * "country": 13,
     * "language": "de"
     * }
     * ```
     * ## Responses:
     *
     * **Success:**
     *
     * ```
     * {
     *   "code": 100,
     *   "message": "Event submission created successful",
     *   "data": {
     *     "editToken": "513d03ce-6eeb-4134-9198-484176a5c314",
     *     "id": 77543
     *   }
     * ```
     *
     * **Error:**
     *
     * ```
     * {
     *   "code": 400,
     *   "message": "Event submission unsuccessful",
     *   "data": ""
     * }
     *
     * ```
     *
     * @Api\Route("POST /event")
     * @Api\Access("public")
     * @return string
     * @throws Exception
     */
    public function create(): string
    {
        $hydrateJob = HydrateJobFromEventPostRequest::hydrate($this->request, $this->response);
        $job = $this->jobFactory->get('FromArray', $hydrateJob);

        if ($job instanceof Job) {
            try {
                /** @var Job $job */
                $job = \nn\t3::Db()->insert($job);
                $data = json_decode($job->getPayload(), true, 512, JSON_THROW_ON_ERROR);
                return $this->responseFactory->successResponse($data)->__toString();
            } catch (Exception $e) {
                return $this->responseFactory->errorResponse()->__toString();
            }
        }
        return $this->responseFactory->errorResponse()->__toString();
    }
}
