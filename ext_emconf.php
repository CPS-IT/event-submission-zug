<?php

$EM_CONF['event_submission'] = [
    'title' => 'Event Submission',
    'description' => 'Submit event proposals through a web form',
    'category' => 'fe',
    'state' => 'alpha',
    'author' => 'Dirk Wenzel',
    'author_email' => 'd.wenzel@familie-redlich.de',
    'author_company' => 'CPS GmbH',
    'version' => '2.0.1',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-13.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
