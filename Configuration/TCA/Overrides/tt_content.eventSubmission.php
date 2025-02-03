<?php

(function ($extKey = 'event_submission', $table = 'tt_content') {
    $ll = 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_db.xlf:';
    $contentElementType = 'eventsubmission_app';

    /*
     * tt_content event submission form element
     */
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
        'tt_content',
        'CType',
        [
            $ll . 'tt_content.CType.eventsubmission_app',
            $contentElementType,
            'content-form',
        ],
        'bullets',
        'before'
    );
    $GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes'][$contentElementType] = 'content-form';
    $GLOBALS['TCA']['tt_content']['types']['eventsubmission_app']['showitem'] = '
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
    --palette--;;general,
    --palette--;;header,
      bodytext,
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

    $GLOBALS['TCA']['tt_content']['types'][$contentElementType]['columnsOverrides'] = [
        'bodytext' => [
            'label' => $ll . 'label.additionalFieldsConfiguration',
            'config' => [
                'renderType' => 'jsonForm',
            ],
        ],
        'pages' => [
            'config' => [
                'maxitems' => 1,
                'minitems' => 1,
                'size' => 1,
            ],
        ],
    ];
})();
