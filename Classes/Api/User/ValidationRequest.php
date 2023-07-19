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

use Cpsit\EventSubmission\Configuration\Extension;
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
    const MAIL_TEMPLATE_NAME = 'SendValidationRequest';
    const TEMPLATE_PATHS = [
        'templateRootPaths' => ['EXT:event_submission/Resources/Private/Templates'],
        'layoutRootPaths' => ['EXT:event_submission/Resources/Private/Layouts'],
        'partialRootPaths' => ['EXT:event_submission/Resources/Private/Partials']
    ];

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
        // Event submission settings
        $settings = $this->request->getSettings()['eventSubmission'] ?? [];
        // TypoScript settings for sendValidationRequest end point
        $sendValidationRequestSettings = $settings['user']['sendValidationRequest'] ?? [];

        $mailHtml = \nn\t3::Template()->render(
            $sendValidationRequestSettings['mail']['templateName'] ?? self::MAIL_TEMPLATE_NAME,
            [
                'htmlLang' => \nn\t3::Environment()->getLanguageKey(),
                'mailTitle' => 'Event submission validation request',
            ],
            $sendValidationRequestSettings['view'] ?? self::TEMPLATE_PATHS
        );

        $test = $GLOBALS;


        $fromEmail = $GLOBALS['TYPO3_CONF_VARS']['MAIL']['defaultMailFromAddress'];
        $fromName = $GLOBALS['TYPO3_CONF_VARS']['MAIL']['defaultMailFromName'];


        if (!empty($sendValidationRequestSettings['mail']['sender']['email'])) {
            $fromEmail = $sendValidationRequestSettings['mail']['sender']['email'];
        }
        if (!empty($sendValidationRequestSettings['mail']['sender']['name'])) {
            $fromName = $sendValidationRequestSettings['mail']['sender']['name'];
        }

        \nn\t3::Mail()->send([
            'html' => $mailHtml,
            #'plaintext'       => Optional: Text-Version
            'fromEmail' => $fromEmail,
            'fromName' => $fromName,
            'toEmail' => 'v.falcon@familie-redlich.de',
            'subject' => \nn\t3::LL()->get('user.sendValidationRequest.mail.subject', Extension::NAME),
            'emogrify' => '',
            'absPrefix' => \nn\t3::Environment()->getBaseURL(),
        ]);

        $apiResponseFactory = GeneralUtility::makeInstance(ApiResponseFactory::class)
            ->get('UserSendValidationRequestApiResponse');
        return $apiResponseFactory->errorResponse()->__toString();


    }


}
