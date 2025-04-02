# Event Submission

## Introduction
Submit proposals for events using REST API endpoints.
Those are meant to be used by a browser side app.

This frontend app is (currently) not included.

## Overview
* [Configuration](Documentation/ForAdministrators/Configuration.md)
* [API Specification](Documentation/ForDevelopers/APIspecification.md)
* [Workflow](Documentation/ForDevelopers/Workflow.md)

## Installation

Install the extension using composer: `composer require cpsit/event-submission`
**Note**: currently the package is not yet published on [packagist.org](https://packagist.org/). Please make
sure to include the [github repository](https://github.com/CPS-IT/event-submission.git) in your `composer.json`.

### Dependencies

* TYPO3 v11.5
* `nng/nnrestapi:^1.4` ([Extension Documentation](https://labor.99grad.de/typo3-docs/typo3-nnrestapi/index.html))
* `georgringer/eventnews:^5.0`
* `blueways/bw-jsoneditor":1.1`


## License

Copyright notice

(c) 2021 Team Bravo <info@familie-redlich.de>
All rights reserved

The GNU General Public License can be found at
http://www.gnu.org/copyleft/gpl.html.
A copy is found in the text file GPL.txt and important notices to the license
from the author is found in LICENSE.txt distributed with these scripts.
This script is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
This copyright notice MUST APPEAR in all copies of the script!
