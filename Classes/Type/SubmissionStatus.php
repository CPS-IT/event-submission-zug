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
enum SubmissionStatus: int
{

    case unknown       = 0;  // unknown
    case new           = 1;  // submitted by frontend user
    case approved      = 2;  // approved by editor, ready for processing, event not yet created
    case eventCreated  = 3;  // event created after approval
    case updated       = 4;  // updated by frontend user, new approval required
    case error         = 7;  // something went wrong, might need intervention by editor

    public const UNKNOWN = self::unknown->value;
    public const NEW = self::new->value;
    public const APPROVED = self::approved->value;
    public const EVENT_CREATED = self::eventCreated->value;
    public const UPDATED = self::updated->value;
    public const ERROR = self::error->value;
}
