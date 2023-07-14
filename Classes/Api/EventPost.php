<?php

declare(strict_types=1);

/*
 * This file is part of the event_submission project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Cpsit\EventSubmission\Api;

use Cpsit\EventSubmission\Domain\Model\Job;
use Cpsit\EventSubmission\Factory\ApiResponse\ApiResponseFactory;
use Cpsit\EventSubmission\Factory\ApiResponse\ApiResponseFactoryInterface;
use Cpsit\EventSubmission\Factory\Job\EventPostJobFactory;
use Nng\Nnrestapi\Annotations as Api;
use Nng\Nnrestapi\Api\AbstractApi;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Impexp\Exception;

/**
 * Event post api end point
 *
 * @Api\Endpoint()
 */
final class EventPost extends AbstractApi
{
    protected ApiResponseFactoryInterface $apiResponseFactory;

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
     * Response:
     *
     * @Api\Example("{'editToken': '513d03ce-6eeb-4134-9198-484176a5c314','id': 77543}")
     *
     * @Api\Route("POST /event")
     * @Api\Access("public")
     * @return string
     * @throws Exception
     */
    public function create(): string
    {
        $job = GeneralUtility::makeInstance(
            EventPostJobFactory::class,
            $this->request,
            $this->response
        )->create();

        $this->apiResponseFactory = GeneralUtility::makeInstance(ApiResponseFactory::class)->get('EventPostApiResponse');

        if ($job instanceof Job) {
            return $this->apiResponseFactory->successResponse($job)->__toString();
        }

        return $this->apiResponseFactory->errorResponse()->__toString();
    }
}
