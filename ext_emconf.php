<?php
$EM_CONF['event_submission'] = [
    'title' => 'Event Submission',
    'description' => 'Submit event proposals through a web form',
    'category' => 'fe',
    'state' => 'alpha',
    'author' => 'Dirk Wenzel',
    'author_email' => 'd.wenzel@familie-redlich.de',
    'author_company' => 'CPS GmbH',
    'version' => '1.1.0',
    'constraints' => [
        'depends' => [
            'typo3' => '11.99.99-0.0.0',
        ],
        'conflicts' => [],
        'suggests' => [],
    ]
];
