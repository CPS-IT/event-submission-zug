<?php

namespace Cpsit\EventSubmission\Type;

use TYPO3\CMS\Core\Type\Enumeration;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2023 Dirk Wenzel <wenzel@cps-it.de>
 *  All rights reserved
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the text file GPL.txt and important notices to the license
 * from the author is found in LICENSE.txt distributed with these scripts.
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
class SubmissionStatus extends Enumeration
{

    public const __default = self::UNKNOWN;
    public const UNKNOWN = 0;
    /**
     * submitted by frontend user
     */
    public const NEW = 1;

    /**
     * updated by frontend user before approval
     */
    public const UPDATED_BEFORE_APPROVAL = 2;
    /**
     * approved by editor, ready for processing, event not yet created
     */
    public const APPROVED = 3;

    /**
     * event created after approval
     */
    public const EVENT_CREATED = 4;

    /**
     * updated by frontend user after approval
     */
    public const UPDATED_AFTER_APPROVAL = 5;
    /**
     * updated by frontend user after event creation
     */
    public const UPDATED_AFTER_EVENT_CREATION = 6;

    /**
     * something went wrong during submission, approval or event creation
     * might need intervention by editor
     */
    public const ERROR = 7;
}
