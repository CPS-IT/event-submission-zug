<?php

if (!defined('TYPO3')) {
    die('Access denied.');
}

use Cpsit\EventSubmission\Domain\Model\Job;
use TYPO3\CMS\Scheduler\Task\TableGarbageCollectionTask;

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']
[TableGarbageCollectionTask::class]['options']['tables']
[Job::TABLE_NAME] = [
    'dateField' => 'crdate',
    'expirePeriod' => '90',
];
