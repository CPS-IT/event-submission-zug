<?php

declare(strict_types=1);

/*
 * This file is part of the iki Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * README.md file that was distributed with this source code.
 */

namespace Cpsit\EventSubmission\Tests\Unit\Domain\Model;

use Cpsit\EventSubmission\Domain\Model\Job;
use Cpsit\EventSubmission\Factory\Job\FromArray;
use Cpsit\EventSubmission\Factory\Job\JobFactoryInterface;
use Cpsit\EventSubmission\Type\SubmissionStatus;
use GeorgRinger\News\Domain\Model\News;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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
        self::assertSame(
            $this->subject->getStatus(),
            SubmissionStatus::NEW
        );
    }

    public function testStatusCanBeSet(): void
    {
        $newStatus = SubmissionStatus::approved->value;

        $this->subject->setStatus($newStatus);
        self::assertSame(
            $this->subject->getStatus(),
            $newStatus
        );
    }

    /**
     * @return mixed[]
     * @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection
     */
    public static function jobWithValidStatusDataProvider(): array
    {
        return [
            'new and unapproved' => [
                [Job::FIELD_APPROVED => false], // jobTemplate
                SubmissionStatus::NEW,       // expectedStatus
            ],
            'approved, event not created' => [
                [
                    Job::FIELD_APPROVED => true,
                    Job::FIELD_IS_DONE => false,
                ],
                SubmissionStatus::APPROVED,
            ],
            'new with api error' => [
                [Job::FIELD_IS_API_ERROR => true],
                SubmissionStatus::ERROR,
            ],
            'new with internal error' => [
                [Job::FIELD_IS_INTERNAL_ERROR => true],
                SubmissionStatus::ERROR,
            ],
            'approved, event created' => [
                [
                    Job::FIELD_APPROVED => true,
                    Job::FIELD_EVENT => new News(),
                ],
                SubmissionStatus::EVENT_PUBLISHED,
            ],
        ];
    }

    #[DataProvider(methodName: 'jobWithValidStatusDataProvider')]
    public function testGetStatusReturnsValidStatus(array $jobTemplate, int $expectedStatus): void
    {
        $job = $this->jobFactory->create($jobTemplate);
        self::assertNotNull($job);
        self::assertSame(
            $job->getStatus(),
            $expectedStatus
        );
    }
}
