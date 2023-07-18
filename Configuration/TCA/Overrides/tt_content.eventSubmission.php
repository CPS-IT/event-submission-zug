<?php

(function ($extKey = 'event_submission', $table = 'tt_content') {
    $ll = 'LLL:EXT:' . $extKey . '/Resources/Private/Base/Language/locallang_db.xlf:';
    $itemName = 'event_submission_form';
    /*
     * tt_content event submission form element
     */
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
        'tt_content',
        'CType',
        [
            $ll . 'tt_content.CType.event_submission_form',
            $itemName,
            \Cpsit\EventSubmission\Configuration\SettingsInterface::ICON_SUBMISSION_FORM
        ],
        'bullets',
        'before'
    );

    $GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes'][$itemName] = \Cpsit\EventSubmission\Configuration\SettingsInterface::ICON_SUBMISSION_FORM;
    $GLOBALS['TCA']['tt_content']['types']['event_submission_form']['showitem'] = '
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
    --palette--;;general,
    --palette--;;header,
    --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.plugin, pi_flexform,
    --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
    --palette--;;frames,
    --palette--;;appearanceLinks,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
    --palette--;;language, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
    --palette--;;hidden, --palette--;;access,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
    --div--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_category.tabs.category, categories,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes, rowDescription,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended';

    $GLOBALS['TCA']['tt_content']['types'][$itemName]['columnsOverrides'] = [
        'pages' => [
            'config' => [
                'maxitems' => 1,
                'minitems' => 1,
                'size' => 1,
            ],
        ],
    ];

    // Add flexForms for content element configuration
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
        '*',
        'FILE:EXT:'. $extKey . '/Configuration/FlexForms/EventSubmissionForm.xml',
        $itemName
    );

})();
