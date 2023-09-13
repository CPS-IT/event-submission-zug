<?php
defined('TYPO3') or die();

$ll = 'LLL:EXT:event_submission/Resources/Private/Language/locallang_db.xlf:';

return [
    'ctrl' => [
        'title' => $ll . 'tx_eventsubmission_domain_model_job',
        'label' => 'request_date_time',
        'label_alt' => 'email,event',
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
        'typeicon_column' => 'approved',
        'typeicon_classes' => [
            'default' => 'event-submission-job',
            '1' => 'event-submission-job-approved'
        ],
    ],
    'interface' => [],
    'types' => [
        '0' => [
            'showitem' => '
                approval_status,
                approved,
                event,
                email,
                payload,
            --div--;' . $ll . 'tx_eventsubmission_domain_model_job.tab.request,
                request_date_time,
                response_code,
                is_api_error,
            --div--;' . $ll . 'tx_eventsubmission_domain_model_job.tab.internal,
                job_triggered_date_time,
                is_done,
                uuid,
                internal_log_message,
                is_internal_error'
        ],
    ],
    'columns' => [
        'email' => [
            'label' => $ll . 'tx_eventsubmission_domain_model_job.email',
            'config' => [
                'type' => 'input',
                'width' => 100,
                'eval' => 'trim,',
                'readOnly' => true,
            ],
        ],
        'uuid' => [
            'label' => $ll . 'tx_eventsubmission_domain_model_job.uuid',
            'config' => [
                'type' => 'input',
                'width' => 200,
                'eval' => 'trim',
                'readOnly' => true,
            ],
        ],
        'request_date_time' => [
            'label' => $ll . 'tx_eventsubmission_domain_model_job.request_date_time',
            'exclude' => true,
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
            'label' => $ll . 'tx_eventsubmission_domain_model_job.payload',
            'config' => [
                'type' => 'user',
                'renderType' => \Cpsit\EventSubmission\Form\Element\SubmissionPayloadDisplayNode::getNodeName()
            ],
        ],
        'response_code' => [
            'label' => $ll . 'tx_eventsubmission_domain_model_job.response_code',
            'exclude' => true,
            'config' => [
                'type' => 'input',
                'width' => 10,
                'eval' => 'trim, int',
                'readOnly' => true,
                'default' => 0,
            ],
        ],
        'is_api_error' => [
            'label' => $ll . 'tx_eventsubmission_domain_model_job.is_api_error',
            'exclude' => true,
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxLabeledToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'labelChecked' => 'Success',
                        'labelUnchecked' => 'Error',
                        'invertStateDisplay' => true,
                    ],
                ],
                'readOnly' => true,
            ],
        ],
        'job_triggered_date_time' => [
            'exclude' => true,
            'label' => $ll . 'tx_eventsubmission_domain_model_job.job_triggered_date_time',
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
            'label' => $ll . 'tx_eventsubmission_domain_model_job.is_done',
            'exclude' => true,
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxLabeledToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'labelChecked' => 'Done',
                        'labelUnchecked' => 'not done',
                    ],
                ],
                'readOnly' => true,
            ],
        ],
        'internal_log_message' => [
            'label' => $ll . 'tx_eventsubmission_domain_model_job.internal_log_message',
            'exclude' => true,
            'config' => [
                'type' => 'input',
                'width' => 200,
                'eval' => 'trim',
                'readOnly' => true,
            ],
        ],
        'is_internal_error' => [
            'label' => $ll . 'tx_eventsubmission_domain_model_job.is_internal_error',
            'exclude' => true,
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxLabeledToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'labelChecked' => 'Successful',
                        'labelUnchecked' => 'Error',
                        'invertStateDisplay' => true,
                    ],
                ],
                'readOnly' => true,
            ],
        ],
        'approved' => [
            'label' => $ll . 'tx_eventsubmission_domain_model_job.approved',
            'description' => $ll . 'tx_eventsubmission_domain_model_job.approved_description',
            'displayCond' => [
                'AND' => [
                    'FIELD:is_done:!=:1',
                ],
            ],
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxLabeledToggle',
                'items' => [
                    [
                        1 => '',
                        0 => '',
                        'labelChecked' => $ll . 'tx_eventsubmission_domain_model_job.approved.1',
                        'labelUnchecked' => $ll . 'tx_eventsubmission_domain_model_job.approved.0',
                    ],
                ],
            ],
        ],
        'approval_status' => [
            'label' => $ll . 'tx_eventsubmission_domain_model_job.approval_status',
            'description' => $ll . 'tx_eventsubmission_domain_model_job.approval_status_description',
            'config' => [
                'type' => 'user',
                'renderType' => \Cpsit\EventSubmission\Form\Element\SubmissionApprovalStatusNode::getNodeName()
            ]
        ],
        'event' => [
            'label' => $ll . 'tx_eventsubmission_domain_model_job.event',
            'description' => $ll . 'tx_eventsubmission_domain_model_job.event_description',
            'config' => [
                'type' => 'group',
                'allowed' => 'tx_news_domain_model_news',
                'maxitems' => 1,
                'minitems' => 1,
                'size' => 1,
                'foreign_table' => 'tx_news_domain_model_news',
                // we cannot use this option: if enabled form engine produces JS error
                //'hideDeleteIcon' => true,
                'hideSuggest' => true,
                'fieldWizard' => [
                    'tableList' => [
                        'disabled' => true
                    ],
                ],
                'fieldControl' => [
                    'elementBrowser' => [
                        'disabled' => true,
                    ],
                    'editPopup' => [
                        'disabled' => false,
                    ],
                    'addRecord' => [
                        'disabled' => true,
                    ],
                    'listModule' => [
                        'disabled' => true,
                    ],
                ],
            ],
            'displayCond' => [
                'AND' => [
                    'FIELD:is_done:=:1',
                    'FIELD:is_internal_error:!=:1',
                    'FIELD:approved:=:1'
                ],
            ]

        ]
    ],
];
