<?php

namespace Cpsit\EventSubmission\Tests\Unit\Domain\Model;

use Cpsit\EventSubmission\Domain\Model\Job;
use Cpsit\EventSubmission\Type\SubmissionStatus;
use PHPUnit\Framework\TestCase;

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
class JobTest extends TestCase
{
    protected Job $subject;

    public function setUp(): void
    {
        parent::setUp();
        $this->subject = new Job();
    }

    public function testInitialStatusIsUnknown():void
    {
        $this->assertSame(
            $this->subject->getStatus(),
            SubmissionStatus::UNKNOWN
        );
    }

}
