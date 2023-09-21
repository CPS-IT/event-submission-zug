# Event Submission

Submit proposals for events through a web form.

Api specifications can be found hier `EXT:
event_submission/Resources/Public/Spec/event-submission-api.oas3.yaml

# Dependencies

This extension depends on EXT:nnrestapi

# Installation

Install the extension using composer: `composer require cpsit/event-submission`

# Configuration

## nnrestapi Extension configuration

Follow the instruction in
the `nnrestapi` [documentation](https://labor.99grad.de/typo3-docs/typo3-nnrestapi/index.html).

## Site configuration

The following configuration options are available:  have to be set in the TYPO3
site config, unter den configuration
key `settings` `eventSubmission`
storagePageUid: 463

### eventSubmission (array)

Contains all configuration options.

**Path**  Site `settings.eventSubmission`

### storagePageUid (int)

Pid where the job records are to be stored.

**Path:**  Site `settings.eventSubmission.storagePageUid`
**Default:**  0

# Specification

Specification in `/Resources/Public/Spec/event-submission-api.oas3.yaml`
Request examples in  `/Resources/Tests/Requests/*.http`.

# Example workflow

1. Submit an event:
    POST a payload to end point /api/event
    ```
    {
        "email": "nix@foo.org",
        "title": "New event proposal with title",
        "teaser": "Teaser text for event proposal. The teaser must not  contain any html tags",
        "datetime": "2017-07-21T17:00:00",
        "event_end": "2017-07-21T19:00:00",
        "timezone": "Europe/Berlin",
        "bodytext": "Do not miss this event! It will be awesome.",
        "event_mode": "hybrid",
        "organizer_simple": "International Climate Initiative",
        "location_simple": "A cool venue",
        "reference_id": "994432",
        "country": 13,
        "language": "de",
        "location": {
            "location_title": "location title",
            "location_short_title": "location short title",
            "location_description": "location description"
        }
    }
   ```

1. Receive mail containing link to change submission is sent.
1. Appove record in TYPO3 Backend
1. Run symfony command `iki-event-approval:generate`





