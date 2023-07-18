<?php
if (!defined('TYPO3')) {
    die('Access denied.');
}

use Cpsit\EventSubmission\Configuration\Extension;
use Cpsit\EventSubmission\Controller\AppController;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

ExtensionUtility::configurePlugin(
    Extension::VENDOR_NAME . '.' . Extension::NAME,
    'App',
    [
        AppController::class => implode(',', [
            'app',
        ]),
    ],
    [],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT,
);
