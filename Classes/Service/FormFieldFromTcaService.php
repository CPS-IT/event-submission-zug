<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 *
 */

namespace Cpsit\EventSubmission\Service;

use Cpsit\EventSubmission\Domain\Model\FormField;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class FormFieldFromTcaService
{
    private ServerRequestInterface $request;

    public function get(string $tableName, string $columnName, array $confOverrides = []): ?FormField
    {
        $column = $this->getColumConfig($tableName, $columnName);
        if ($column === null && empty($column['config']['type'])) {
            return null;
        }

        $formField = new FormField();
        $formField->setId(GeneralUtility::underscoredToLowerCamelCase($columnName));
        $formField->setType($this->getColumnType($column));
        $formField->setName($columnName);
        $formField->setValidation($this->getColumnEval($column));
        $formField->setLabel($this->translate($column['label'] ?? ''));
        $formField->setHelp($this->translate($column['description'] ?? ''));
        $formField->setOptions($this->getColumItems($column));
        $max = $column['config']['max'] ?? '';
        $formField->setLengthMax((string)$max);
        $min = $column['config']['min'] ?? '';
        $formField->setLengthMin((string)$min);

        return $formField;
    }

    protected function getColumnType(array $column): string
    {
        $type = $column['config']['type'];

        if ($type == 'text') {
            $type = 'textarea';
        }
        if ($type == 'input') {
            $type = 'text';
        }
        if ($type == 'check') {
            $type = 'checkbox';
        }
        return $type;
    }

    protected function getColumnEval(array $column): string
    {
        if ($column['config']['type'] == 'select') {
            $minItems = $column['config']['minitems'] ?? null;
            return $minItems ? 'required' : '';
        }

        $eval = $column['config']['eval'] ?? '';
        $eval = GeneralUtility::trimExplode(',', $eval, true);

        if (!empty($column['config']['required'])) {
            $eval[] = 'required';
        }

        return implode('|', $eval);
    }


    protected function getColumItems(array $column): array
    {
        $options = [];
        if ($column['config']['type'] == 'select' && count($column['config']['items']) && empty($column['config']['foreign_table'])) {
            foreach ($column['config']['items'] as $option) {
                $label = $option['0'] ?? $option['label'] ?? '';
                $options[] = [
                    'label' => $this->translate($label),
                    'value' => $option['1'] ?? $option['value'] ?? ''
                ];
            }
        }

        return $options;
    }

    protected function getColumConfig(string $tableName, string $columnName): ?array
    {
        return $GLOBALS['TCA'][$tableName]['columns'][$columnName] ?? null;
    }

    protected function translate(string $string): string
    {
        if (str_starts_with($string, 'LLL:')) {
            return LocalizationUtility::translate($string) ?? '';
        }
        return $string;
    }

    private function getRequest(): ServerRequestInterface
    {
        return $GLOBALS['TYPO3_REQUEST'];
    }
}
