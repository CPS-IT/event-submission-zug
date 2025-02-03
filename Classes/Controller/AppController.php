<?php

declare(strict_types=1);

/*
 * This file is part of the event_submission project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Cpsit\EventSubmission\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class AppController extends ActionController
{
    public function appAction(): ResponseInterface
    {
        $this->view->assignMultiple(
            [
                'baseUrl' => \nn\t3::Environment()->getBaseUrl(),
                'siteConfig' => \nn\t3::Settings()->getSiteConfig(),
            ]
        );
        return $this->htmlResponse();
    }
}
