<?php

namespace Cpsit\EventSubmission\Api\Service;

use Cpsit\EventSubmission\Domain\Model\ApiResponseInterface;
use Cpsit\EventSubmission\Factory\ApiResponse\ApiResponseFactoryFactory;
use Cpsit\EventSubmission\Factory\ApiResponse\ApiResponseFactoryInterface;
use Cpsit\EventSubmission\Service\FormFieldFromTcaService;
use Nng\Nnrestapi\Annotations as Api;
use Nng\Nnrestapi\Api\AbstractApi;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Service API end point for GET appPageLink method
 *
 * @Api\Endpoint
 */
final class Settings extends AbstractApi
{
    public const RESPONSE_NAME = 'ServiceSettingsApiResponse';

    protected ApiResponseFactoryInterface $responseFactory;

    public function __construct(
        protected ApiResponseFactoryFactory $apiResponseFactoryFactory,
        protected FormFieldFromTcaService $formFieldFromTcaService
    ) {
        $this->responseFactory = $this->apiResponseFactoryFactory->get(self::RESPONSE_NAME);
    }

    /**
     * ## Get app settings
     *
     * ## Responses:
     *
     * **Success:**
     *
     * ```
     * {
     * "code": 1500,
     * "message": "Application settings generated.",
     * "data": {
     *   "formFields": [
     *     {
     *       "id": "locationTitle",
     *       "type": "text",
     *       "name": "location_title",
     *       "validation": "trim",
     *       "lengthMin": "",
     *       "lengthMax": "250",
     *       "label": "Veranstaltungsort",
     *       "help": "Bitte geben Sie den Namen des Veranstaltungsortes ein, z. B. Stadthalle Zwickau. Geben Sie hier nicht die vollst\u00e4ndige Adresse ein.",
     *       "options": [],
     *       "multiple": false
     *      }
     *    ]
     *  }
     * }
     * ```
     *
     * **Error:**
     *
     * ```
     * {
     * "code": 1600,
     * "message": "Could not generate settings",
     * "data": ""
     * }
     * ```
     *
     *
     * @Api\Route("GET /service/settings")
     * @Api\Access("public")
     * @Api\Localize
     * @return array
     * @throws \Exception
     * @throws \JsonException
     */
    public function get(): array
    {
        try {
            $settings = [
                'formFields' => $this->getTcaFormFieldsFromSettings(),
            ];
            $responseCode = ApiResponseInterface::APP_SETTINGS_SUCCESS;
        } catch (\Exception $exception) {
            $responseCode = ApiResponseInterface::APP_SETTINGS_ERROR;
        }

        return $this->responseFactory
            ->create($responseCode, $settings)->toArray();
    }

    protected function getTcaFormFieldsFromSettings(): array
    {
        $tcaFormFields = [];
        $tables = $this->request->getSettings()['eventSubmission']['tcaFormFields'] ?? [];
        foreach ($tables as $table => $settings) {
            $fields = GeneralUtility::trimExplode(',', $settings['fields'] ?? '', true);
            if (empty($fields)) {
                continue;
            }

            foreach ($fields as $field) {
                $formField = $this->formFieldFromTcaService->get($table, $field);
                if ($formField) {
                    $tcaFormFields[] = $formField->__toArray();
                }
            }
        }
        return $tcaFormFields;
    }
}
