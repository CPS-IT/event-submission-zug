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
use Cpsit\EventSubmission\Factory\ApiResponse\ApiResponseFactoryInterface;
use Cpsit\EventSubmission\Service\MailService;
use Cpsit\EventSubmission\Service\TemplateService;
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
    public const MAIL_TEMPLATE_NAME = 'SendValidationRequest';
    public const RESPONSE_NAME = 'UserSendValidationRequestApiResponse';

    protected ApiResponseFactoryInterface $responseFactory;

    public function __construct(
        protected ApiResponseFactoryFactory $apiResponseFactory,
        protected TemplateService $templateService,
        protected MailService $mailService,
    ) {
        $this->responseFactory = $apiResponseFactory->get(self::RESPONSE_NAME);
    }

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

            $this->mailService->send(
                $this->getRequest()->getBody()['email'],
                \nn\t3::LL()->get('user.sendValidationRequest.mail.subject', Extension::NAME),
                $this->renderEmailBody(),
                '',
                $this->request->getSettings()['eventSubmission']['mail']['fromEmail'],
                $this->request->getSettings()['eventSubmission']['mail']['fromName']
            );

            $data = [
                'validationHash' => $this->getRequest()->getBody()['validationHash']
            ];

            return $this->responseFactory->successResponse($data)->__toString();

        } catch (\Exception $e) {
            return $this->responseFactory->errorResponse()->__toString();
        }
    }

    protected function renderEmailBody(): string
    {
        $templateVariables = [
            'mailTitle' => \nn\t3::LL()->get('user.sendValidationRequest.mail.title', Extension::NAME),
            'validationUrl' => $this->buildValidationUrl(),
            'htmlLang' => \nn\t3::Environment()->getLanguageKey(),
            'extensionName' => Extension::NAME,
            'logoImage' => $this->request->getSettings()['eventSubmission']['mail']['logoImage'] ?? '',
        ];

        return $this->templateService->render(
            self::MAIL_TEMPLATE_NAME,
            $this->request->getSettings()['eventSubmission']['view'] ?? [],
            $templateVariables
        );
    }

    /**
     * @throws \Exception
     */
    protected function buildValidationUrl(): string
    {
        $pid = $this->request->getSettings()['eventSubmission']['appPid'] ?? 0;

        // Pid should not be 0 or less.
        if ($pid <= 0) {
            throw new \Exception(
                'Invalid pid, validation url could not be properly generated.',
                1689946419
            );
        }

        // Validation URL
        return \nn\t3::Http()->buildUri(
            $pid,
            ['validationHash' => $this->getRequest()->getBody()['validationHash']],
            true
        );
    }

    /**
     * @throws Exception
     */
    protected function assertValidRequest(): void
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
