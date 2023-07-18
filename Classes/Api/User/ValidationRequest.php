<?php

declare(strict_types=1);

/*
 * This file is part of the event_submission project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Cpsit\EventSubmission\Api\User;

use Cpsit\EventSubmission\Factory\ApiResponse\ApiResponseFactory;
use Nng\Nnrestapi\Annotations as Api;
use Nng\Nnrestapi\Api\AbstractApi;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Impexp\Exception;

/**
 * Event post api end point
 *
 * @Api\Endpoint()
 */
final class ValidationRequest extends AbstractApi
{
    /**
     * ## Send user validation request email POST
     *
     * Send a user validation email
     *
     * ### Payload:
     *
     * ```
     * {
     * "email": "foo@bar",
     * "validationHash": "dfde719e-9f19-40b5-af2e-6f96d4034cda"
     * }
     * ```
     * ## Responses:
     *
     * **Success:**
     *
     * ```
     * {
     * "code": 300,
     * "message": "Validation email successfully sent",
     * "data": {
     *   "validationHash": "dfde719e-9f19-40b5-af2e-6f96d4034cda"
     *   }
     * }
     * ```
     *
     * **Error:**
     *
     * ```
     * {
     * "code": 500,
     * "message": "Validation email could not be sent",
     * "data": ""
     * }
     * ```
     *
     * @Api\Example("{'email': 'foo@bar', 'validationHash': 'dfde719e-9f19-40b5-af2e-6f96d4034cda'}")
     *
     * @Api\Route("POST /sendValidationRequest")
     * @Api\Access("public")
     * @return string
     * @throws Exception
     */
    public function send(): string
    {


        $apiResponseFactory = GeneralUtility::makeInstance(ApiResponseFactory::class)
            ->get('UserSendValidationRequestApiResponse');
        return $apiResponseFactory->errorResponse()->__toString();


    }
}
