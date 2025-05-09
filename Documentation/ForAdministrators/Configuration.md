# Configuration

## nnrestapi Extension configuration

Follow the instruction in
the `nnrestapi` [documentation](https://labor.99grad.de/typo3-docs/typo3-nnrestapi/index.html).

## Site configuration

Configuration have to be set in the TYPO3 site config.
The following configuration options are available:

```yaml
settings:
  eventSubmission:
    storagePageUid: <page uid>
```

### eventSubmission (array)

Contains all configuration options.

**Path**  Site `settings.eventSubmission`

### storagePageUid (int)

Page id where the job records are to be stored.

**Path:**  Site `settings.eventSubmission.storagePageUid`
**Default:**  `9`
