<?php
defined('TYPO3') or die();

$ll = 'LLL:EXT:event_submission/Resources/Private/Language/locallang_db.xlf:';

return [
    'ctrl' => [
        'title' => $ll . 'tx_eventsubmission_model_job',
        'label' => 'uuid',
        'label_alt' => 'email',
        'label_alt_force' => true,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'sortby' => 'crdate',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'searchFields' => 'uid, email, uuid, payload',
        'typeicon_classes' => [
            'default' => 'event-submition-job',
        ],
    ],
    'interface' => [],
    'types' => [
        '0' => [
            'showitem' => '
            email,
            uuid,
            request_date_time,
            payload,
            response_message,
            is_api_error,
            job_triggered_date_time,
            is_done,
            internal_log_message,
            is_internal_error'
        ],
    ],
    'columns' => [
        'email' => [
            'label' => $ll . 'tx_eventsubmission_model_job.uuid',
            'config' => [
                'type' => 'input',
                'width' => 100,
                'eval' => 'trim,',
                'readOnly' => true,
            ],
        ],
        'uuid' => [
            'label' => $ll . 'tx_eventsubmission_model_job.uuid',
            'config' => [
                'type' => 'input',
                'width' => 200,
                'eval' => 'trim',
                'readOnly' => true,
            ],
        ],
        'language' => [
            'label' => $ll . 'tx_eventsubmission_model_job.language',
            'config' => [
                'type' => 'language',
                'readOnly' => true,

            ]
        ],
        'request_date_time' => [
            'label' => $ll . 'tx_eventsubmission_model_job.request_date_time',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 10,
                'eval' => 'datetime',
                'default' => 0,
                'readOnly' => true,
            ],
        ],
        'payload' => [
            'label' => $ll . 'tx_eventsubmission_model_job.payload',
            'config' => [
                'type' => 'text',
                'width' => 200,
                'eval' => 'trim',
                'readOnly' => true,
            ],
        ],
        'response_message' => [
            'label' => $ll . 'tx_eventsubmission_model_job.response_message',
            'config' => [
                'type' => 'input',
                'width' => 200,
                'eval' => 'trim',
                'readOnly' => true,
            ],
        ],
        'is_api_error' => [
            'label' => $ll . 'tx_eventsubmission_model_job.is_api_error',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxLabeledToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'labelChecked' => $ll . 'tx_eventsubmission_model_job.job.is_api_error.error',
                        'labelUnchecked' => $ll . 'tx_eventsubmission_model_job.job.is_api_error.error',
                        'invertStateDisplay' => true
                    ],
                ],
                'readOnly' => true,
            ],
        ],
        'job_triggered_date_time' => [
            'exclude' => true,
            'label' => $ll . 'tx_eventsubmission_model_job.job_triggered_date_time',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 10,
                'eval' => 'datetime',
                'default' => 0,
                'readOnly' => true,
            ],
        ],
        'is_done' => [
            'label' => $ll . 'tx_eventsubmission_model_job.is_done',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxLabeledToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'labelChecked' => 'is done',
                        'labelUnchecked' => 'was not done, yet',
                    ],
                ],
                'readOnly' => true,
            ],
        ],
        'internal_log_message' => [
            'label' => $ll . 'tx_eventsubmission_model_job.internal_log_message',
            'config' => [
                'type' => 'input',
                'width' => 200,
                'eval' => 'trim',
                'readOnly' => true,
            ],
        ],
        'is_internal_error' => [
            'label' => $ll . 'tx_eventsubmission_model_job.is_internal_error',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxLabeledToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'labelChecked' => 'was not successful',
                        'labelUnchecked' => 'was successful/ not done',
                    ],
                ],
                'readOnly' => true,
            ],
        ],
    ],
];
