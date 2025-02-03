<?php

namespace Cpsit\EventSubmission\Form;

use TYPO3\CMS\Core\Utility\StringUtility;

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
trait FormElementAttributesTrait
{
    /**
     * Main data array to work on, given from parent to child elements
     *
     * @var array
     */
    protected array $data = [];

    /**
     * @return array
     */
    protected function getFormElementAttributes(): array
    {
        $fieldId = StringUtility::getUniqueId('formengine-textarea-');

        $parameterArray = $this->data['parameterArray'];
        $attributes = [
            'id' => $fieldId,
            'name' => htmlspecialchars($parameterArray['itemFormElName']),
            'data-formengine-input-name' => htmlspecialchars($parameterArray['itemFormElName']),
        ];

        $classes = [
            'form-control',
            't3js-formengine-textarea',
            'formengine-textarea',
        ];
        $attributes['class'] = implode(' ', $classes);
        return $attributes;
    }
}
