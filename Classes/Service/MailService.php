<?php

declare(strict_types=1);

/*
 * This file is part of the event_submission project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Cpsit\EventSubmission\Service;

final class MailService implements ServiceInterface
{
    public function send(
        string $toEmail,
        string $subject,
        string $html,
        string $plaintext = '',
        string $fromEmail = '',
        string $fromName = '',
        array $attachments = [],
        string $returnPathEmail = '',
        bool $absPrefix = true,
    ): void {

        // Sender data from $GLOBALS
        if (empty($fromEmail)) {
            $fromEmail = $GLOBALS['TYPO3_CONF_VARS']['MAIL']['defaultMailFromAddress'];
        }
        if (empty($fromName)) {
            $fromName = $GLOBALS['TYPO3_CONF_VARS']['MAIL']['defaultMailFromName'];
        }

        \nn\t3::Mail()->send([
            'toEmail' => $toEmail,
            'subject' => $subject,
            'html' => $html,
            'plaintext' => $plaintext,
            'fromEmail' => $fromEmail,
            'fromName' => $fromName,
            'attachments' => $attachments,
            'returnPath_email' => $returnPathEmail,
            'absPrefix' => $absPrefix ? \nn\t3::Environment()->getBaseURL() : '',
        ]);

    }


}
