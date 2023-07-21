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
use Cpsit\EventSubmission\Factory\ApiResponse\ApiResponseFactoryFactory;
use Cpsit\EventSubmission\Validator\ValidatorFactory;
use Cpsit\EventSubmission\Validator\ValidatorInterface;
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
     * "email": "nix@foo.org",
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
     * @Api\Localize()
     * @return string
     * @throws Exception
     */
    public function send(): string
    {
        try {

            $this->assertValidRequest();

            /** @var  $apiResponseFactory */
            $apiResponseFactory = GeneralUtility::makeInstance(ApiResponseFactoryFactory::class)
                ->get('UserSendValidationRequestApiResponse');

            // Event submission settings
            $settings = $this->request->getSettings()['eventSubmission'] ?? [];
            // TypoScript settings for sendValidationRequest end point
            $sendValidationRequestSettings = $settings['user']['sendValidationRequest'] ?? [];

            // Validation URL
            $validationUrl = \nn\t3::Http()->buildUri(
                $settings['appPid'],
                ['validationHash' => $this->getRequest()->getBody()['validationHash']],
                true
            );

            $templateVariables = [
                'mailTitle' => \nn\t3::LL()->get('user.sendValidationRequest.mail.title', Extension::NAME),
                'validationUrl' => $validationUrl,
                'htmlLang' => \nn\t3::Environment()->getLanguageKey(),
                'extensionName' => Extension::NAME,
                'logoImage' => $sendValidationRequestSettings['mail']['logoImage'] ?? '',
            ];

            // Render Html mail
            $mailHtml = @\nn\t3::Template()->render(
                $sendValidationRequestSettings['mail']['templateName'] ?? self::MAIL_TEMPLATE_NAME,
                $templateVariables,
                $sendValidationRequestSettings['view'] ?? self::TEMPLATE_PATHS
            );

            // Set absender data
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
                'plaintext' => null,
                'fromEmail' => $fromEmail,
                'fromName' => $fromName,
                'toEmail' => $this->getRequest()->getBody()['email'],
                'returnPath_email' => $sendValidationRequestSettings['mail']['sender']['returnPath'],
                'subject' => \nn\t3::LL()->get('user.sendValidationRequest.mail.subject', Extension::NAME),
                'absPrefix' => \nn\t3::Environment()->getBaseURL(),
                'attachments' => '',
            ]);

            return $apiResponseFactory->successResponse($this->getRequest()->getBody()['validationHash'])->__toString();

        } catch (\Exception $e) {
            return $apiResponseFactory->errorResponse()->__toString();
        }
    }

    /**
     * @throws Exception
     */
    public function assertValidRequest(): void
    {
        /** @var ValidatorInterface $validator */
        $validator = GeneralUtility::makeInstance(ValidatorFactory::class)
            ->get('UserSendValidationRequest');

        // Early return request body validation failed
        if (!$validator->isValid($this->getRequest()->getBody())) {
            throw new \Exception(
                'Invalid request body for UserSendValidationRequest',
                1689928124
            );
        }

    }
}
