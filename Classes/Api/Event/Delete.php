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
use Cpsit\EventSubmission\Factory\ApiResponse\MissingFactoryException;
use JsonException;
use Nng\Nnhelpers\Utilities\Db;
use Nng\Nnrestapi\Annotations as Api;
use Nng\Nnrestapi\Api\AbstractApi;

/**
 * Event API end point for DELETE method
 *
 * @Api\Endpoint()
 */
final class Delete extends AbstractApi implements EventApiInterface

{
    public const RESPONSE_NAME = 'EventDeleteApiResponse';
    protected ApiResponseFactoryInterface $responseFactory;
    protected Db $db;

    /**
     * @throws MissingFactoryException
     */
    public function __construct(ApiResponseFactoryFactory $apiResponseFactoryFactory, Db $db)
    {
        $this->responseFactory = $apiResponseFactoryFactory->get(self::RESPONSE_NAME);
        $this->db = $db;
    }

    /**
     * ## Event submission DELETE
     *
     * DELETE an event submission
     *
     * ## Responses:
     *
     * **Success:**
     *
     * ```
     * {
     *   "code": 900,
     *   "message": "Event proposal deleted",
     *   "data": {
     *     "id": "40ff4e68-1c64-4551-8b37-453b35ada721",
     *   }
     * ```
     *
     * **Error:**
     *
     * ```
     * {
     *   "code": 1000,
     *   "message": "Event submission could not be deleted",
     *   "data": {
     *     "id": "40ff4e68-1c64-4551-8b37-453b35ada721",
     *   }
     * }
     *
     * ```
     *
     * @Api\Route("DELETE /event/{id}")
     * @Api\Access("public")
     * @return array
     * @throws JsonException
     */
    public function delete(): array
    {
        $arguments = $this->request->getArguments();
        $responseCode = ApiResponseInterface::EVENT_DELETE_ERROR;
        $id = $arguments[self::PARAMETER_ID];
        $responseData = [
            'id' => $id
        ];

        // delete job by identifier, job must not be approved, deleted or imported yet
        $result = $this->db->delete(Job::TABLE_NAME,
            [
                Job::FIELD_UUID => $id,
                Job::FIELD_APPROVED => 0,
                Job::FIELD_IS_DONE => 0,
                Job::FIELD_DELETED => 0
            ]
        );

        if ($result === 1) {
            $responseCode = ApiResponseInterface::EVENT_DELETE_SUCCESS;
        }

        return $this->responseFactory
            ->create($responseCode, $responseData)
            ->toArray();
    }
}
