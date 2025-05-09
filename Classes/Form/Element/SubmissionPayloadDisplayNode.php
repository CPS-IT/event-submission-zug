<?php

namespace Cpsit\EventSubmission\Form\Element;

use Cpsit\CpsUtility\Utility\TypoScriptUtility;
use Cpsit\EventSubmission\Domain\Model\FormField;
use Cpsit\EventSubmission\Domain\Model\Job;
use Cpsit\EventSubmission\Form\FormElementAttributesTrait;
use Cpsit\EventSubmission\Form\RegistrableInterface;
use Cpsit\EventSubmission\Form\RegistrableTrait;
use Cpsit\EventSubmission\Service\FormFieldFromTcaService;
use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2023 Dirk Wenzel <wenzel@cps-it.de>
 *  All rights reserved
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the text file GPL.txt and important notices to the license
 * from the author is found in LICENSE.txt distributed with these scripts.
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
class SubmissionPayloadDisplayNode extends AbstractFormElement implements RegistrableInterface
{
    use FormElementAttributesTrait;
    use RegistrableTrait;

    public const NODE_ID = 1690545326;
    public const NODE_NAME = 'eventSubmissionPayloadDisplay';
    public const NODE_PRIORITY = 30;
    public const DEFAULT_LANGUAGE_FILE = 'LLL:EXT:event_submission/Resources/Private/Language/locallang_db.xlf';

    public const FIELD_ORDER = [
        'title',
        'teaser',
        'location_simple',
        'region',
        'organizer_simple',
        'organizer_type',
        'email',
        'timezone',
        'datetime',
        'event_end',
        'bodytext',
        'language',
        'event_mode',
        'event_type',
        'field_of_action',
        'emailValidated',
        'validationHash',
        'is_ank_procedure',
        'ank_funded_projects',
        'ank_grant_name',
        'ank_procedure',
    ];

    /**
     * @inheritDoc
     * @noinspection DuplicatedCode
     */
    public function render(): array
    {
        $row = $this->data['databaseRow'];
        $languageService = $this->getLanguageService();
        try {
            $payload = json_decode($row[Job::FIELD_PAYLOAD], true, 512, JSON_THROW_ON_ERROR);
            // re-order by static::FIELD_ORDER
            $order = static::FIELD_ORDER;
            foreach ($order as $key => $value) {
                if (!isset($payload[$value])) {
                    unset($order[$key]);
                }
            }
            $payload = array_merge(array_flip($order), $payload);
        } catch (\JsonException $e) {
            // render error message
            $payload = [
                'error' => $languageService->sL(static::DEFAULT_LANGUAGE_FILE . ':message.invalidJsonInPayload'),
            ];
        }

        $fieldInformationResult = $this->renderFieldInformation();
        $fieldInformationHtml = $fieldInformationResult['html'];
        $resultArray = $this->mergeChildReturnIntoExistingResult(
            $this->initializeResultArray(),
            $fieldInformationResult,
            false
        );

        $attributes = $this->getFormElementAttributes();

        $html = [];
        $html[] = '<div class="formengine-field-item t3js-formengine-field-item" style="padding: 5px;">';
        $html[] = $fieldInformationHtml;
        $html[] = '<div class="form-wizards-wrap">';
        $html[] = '<div class="form-wizards-element">';
        $html[] = '<div class="form-control-wrap">';
        $html[] = '<dl' . GeneralUtility::implodeAttributes($attributes, true) . ' />';
        foreach ($payload as $key => $value) {
            $label = $languageService->sL(static::DEFAULT_LANGUAGE_FILE . ':payload.label.' . $key);

            // find label and value from typo script configuration
            if (empty($label)) {
                $formField = $this->getLabelFromTypoScriptConf($key);

                if (is_array($formField)) {
                    $label = $formField['label'] ?? null;
                    if (!empty($formField['options']) && is_array($formField['options'])) {
                        foreach ($formField['options'] as $option) {
                            if (isset($option['label']) && isset($option['value']) && $option['value'] == $value) {
                                $value = $option['label'];
                            }
                        }
                    }
                }
            }

            $label = (empty($label) ? $key : $label);
            $html[] = '<dt >' . htmlspecialchars($label) . '</dt>';

            // todo specification requires sub classes, find output independent from structure.
            if (is_array($value)) {
                $value = implode(', ', $value);
            }
            $html[] = '<dd>' . htmlspecialchars($value ?? '') . '</dd>';
        }
        $html[] = '</dl>';

        $html[] = '</div>';
        $html[] = '</div>';
        $html[] = '</div>';
        $html[] = '</div>';
        $resultArray['html'] = implode(LF, $html);

        return $resultArray;
    }

    protected function getLabelFromTypoScriptConf($column): ?array
    {
        $formFieldFromTcaService = new FormFieldFromTcaService();
        if (empty($this->data['databaseRow']['pid'])) {
            return null;
        }
        // load typo script from current pid
        $typoscriptObject = \nn\t3::Settings()->getTyposcriptObject($this->data['databaseRow']['pid']);

        if (empty($typoscriptObject->setup) || !is_array($typoscriptObject->setup)) {
            return null;
        }

        $typoScriptUtility = GeneralUtility::makeInstance(TypoScriptUtility::class);
        $typoscript = $typoScriptUtility->convertTypoScriptArrayToPlainArray($typoscriptObject->setup);

        // get tca form fields configuration
        $tables = \nn\t3::Settings()->getFromPath(
            'plugin.tx_nnrestapi.settings.eventSubmission.tcaFormFields',
            $typoscript
        );

        if (!is_array($tables)) {
            return null;
        }

        foreach ($tables as $table => $settings) {
            $fields = GeneralUtility::trimExplode(',', $settings['fields'] ?? '', true);
            if (empty($fields) || !in_array($column, $fields)) {
                continue;
            }
            $formField = $formFieldFromTcaService->get($table, $column);
            if ($formField instanceof FormField) {
                return $formField->__toArray();
            }
        }
        return null;
    }
}
