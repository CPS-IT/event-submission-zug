<?php

declare(strict_types=1);

/*
 * This file is part of the event_submission project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Cpsit\EventSubmission\Helper;

use Cpsit\EventSubmission\Domain\Model\ApiResponseInterface;
use Cpsit\EventSubmission\Domain\Model\Job;
use Cpsit\EventSubmission\Type\SubmissionStatus;
use Nng\Nnrestapi\Mvc\Request;
use Nng\Nnrestapi\Mvc\Response;
use Ramsey\Uuid\Uuid;

final class HydrateJobFromEventPostRequest
{
    static public function hydrate(Request $request, Response $response): array
    {
        return [
            'uuid' => Uuid::uuid4()->toString(),
            'status' => SubmissionStatus::NEW,
            'email' => $request->getBody()['email'],
            'requestDateTime' => (new \DateTime('NOW')),
            'payload' => $request->getRawBody(),
            'responseCode' => ApiResponseInterface::EVENT_SUBMISSION_SUCCESS,
            'isApiError' => false,
            'pid' => (int)$request->getSettings()['insertDefaultValues']['Cpsit\EventSubmission\Domain\Model\Job']['pid'] ?? 0
        ];
    }
}
