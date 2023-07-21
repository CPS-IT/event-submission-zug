<?php

namespace Cpsit\EventSubmission\Factory\ApiResponse;

use Cpsit\EventSubmission\Domain\Model\ApiResponse;
use Cpsit\EventSubmission\Domain\Model\Job;
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
trait ApiResponseFactoryTrait
{

    public function successResponse(array $data = []): ApiResponse
    {
        return $this->create(EventGetApiResponseFactory::SUCCESS_CODE, $data);
    }

    public function errorResponse(array $data = []): ApiResponse
    {
        return $this->create(EventGetApiResponseFactory::ERROR_CODE, '');
    }

    public function create(int $code, array $data = []): ApiResponse
    {
        return GeneralUtility::makeInstance(ApiResponse::class, $code, $data);
    }

    public static function getDefaultApiResponseFactoryName(): string
    {
        return self::DEFAULT_FACTORY_NAME;
    }
}
