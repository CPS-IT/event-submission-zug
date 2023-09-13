<?php

namespace Cpsit\EventSubmission\Tests\Unit\Domain\Model;

use Cpsit\EventSubmission\Domain\Model\Job;
use Cpsit\EventSubmission\Factory\Job\FromArray;
use Cpsit\EventSubmission\Factory\Job\JobFactoryInterface;
use Cpsit\EventSubmission\Type\SubmissionStatus;
use GeorgRinger\News\Domain\Model\News;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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
    protected JobFactoryInterface $jobFactory;

    public function setUp(): void
    {
        parent::setUp();
        $this->subject = new Job();
        $this->jobFactory = GeneralUtility::makeInstance(FromArray::class);
    }

    public function testInitialStatusIsNew(): void
    {
        $this->assertSame(
            $this->subject->getStatus(),
            SubmissionStatus::NEW
        );
    }

    public function testStatusCanBeSet(): void
    {
        $newStatus = SubmissionStatus::approved->value;

        $this->subject->setStatus($newStatus);
        $this->assertSame(
            $this->subject->getStatus(),
            $newStatus
        );
    }

    public function jobWithValidStatusDataProvider(): array
    {
        return [
            'new and unapproved' => [
                [Job::FIELD_APPROVED => false], // jobTemplate
                SubmissionStatus::NEW       // expectedStatus
            ],
            'approved, event not created' => [
                [
                    Job::FIELD_APPROVED => true,
                    Job::FIELD_IS_DONE => 0
                ],
                SubmissionStatus::APPROVED
            ],
            'new with api error' => [
                ['isApiError' => true],
                SubmissionStatus::ERROR
            ],
            'new with internal error' => [
                ['isInternalError' => true],
                SubmissionStatus::ERROR
            ],
            'approved, event created' => [
                [
                    Job::FIELD_APPROVED => true,
                    Job::FIELD_EVENT => new News()
                ],
                SubmissionStatus::EVENT_CREATED
            ]
        ];
    }

    /**
     * @dataProvider jobWithValidStatusDataProvider
     * @param Job $job
     * @param int $expectedStatus
     * @return void
     */
    public function testGetStatusReturnsValidStatus(array $jobTemplate, int $expectedStatus): void
    {
        $job = $this->jobFactory->create($jobTemplate);
        $this->assertNotNull($job);
        //var_dump($job);
        //die();
        $this->assertSame(
            $job->getStatus(),
            $expectedStatus
        );
    }
}
