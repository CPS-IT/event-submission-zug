# Event Submission

Submit proposals for events through a web form.

Api specifications can be found hier `EXT:event_submission/Resources/Public/Spec/event-submission-api.oas3.yaml

# Dependencies

This extension depends on EXT:nnrestapi

# Installation

Install the extension using composer: `composer require cpsit/event-submission`

# Configuration

## nnrestapi Extension configuration

Follow the instruction in
the `nnrestapi` [documentation](https://labor.99grad.de/typo3-docs/typo3-nnrestapi/index.html).

## Site configuration

The following configuration options are available:  have to be set in the TYPO3 site config, unter den configuration
key `settings` `eventSubmission`
storagePageUid: 463

### eventSubmission (array)

Contains all configuration options.

**Path**  Site `settings.eventSubmission`

### storagePageUid (int)

Pid where the job records are to be stored.

**Path:**  Site `settings.eventSubmission.storagePageUid`
**Default:**  0




