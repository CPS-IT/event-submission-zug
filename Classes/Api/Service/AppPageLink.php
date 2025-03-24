<?php

namespace Cpsit\EventSubmission\Api\Service;

use Cpsit\EventSubmission\Domain\Model\ApiResponseInterface;
use Cpsit\EventSubmission\Factory\ApiResponse\ApiResponseFactoryFactory;
use Cpsit\EventSubmission\Factory\ApiResponse\ApiResponseFactoryInterface;
use nn\t3;
use Nng\Nnrestapi\Annotations as Api;
use Nng\Nnrestapi\Api\AbstractApi;

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

/**
 * Service API end point for GET appPageLink method
 *
 * @Api\Endpoint
 */
final class AppPageLink extends AbstractApi
{
    public const RESPONSE_NAME = 'ServicePageLinkApiResponse';
    public const PARAMETER_ID = 'id';

    protected ApiResponseFactoryInterface $responseFactory;

    public function __construct(
        protected ApiResponseFactoryFactory $apiResponseFactoryFactory
    ) {
        $this->responseFactory = $this->apiResponseFactoryFactory->get(self::RESPONSE_NAME);
    }

    /**
     * ## Get a link to the application page GET
     *
     * ## Parameters
     * ### id
     * unique id of a page containing the frontend plugin for event submission.
     * A link will only be generated, if this page exists and is publicly available.
     *
     * ## Responses:
     *
     * **Success:**
     *
     * ```
     * {
     * "code": 200,
     * "message": "Application page link generated.",
     * "data": {
     *   "appPageLink": "https://foo.org/bar/"
     *  }
     * }
     * ```
     *
     * **Error:**
     *
     * ```
     * {
     * "code": 500,
     * "message": "Could not generate a valid link to the application page",
     * "data": ""
     * }
     * ```
     *
     *
     * @Api\Route("GET /service/appPageLink/{id}")
     * @Api\Access("public")
     * @Api\Localize
     * @return array
     * @throws \Exception
     * @throws \JsonException
     */
    public function get(): array
    {
        $responseData = [];

        try {
            $responseData = [
                'appPageLink' => $this->getApplicationPageLink(),
            ];
            $responseCode = ApiResponseInterface::APP_PAGE_LINK_REQUEST_SUCCESS;
        } catch (\Exception $exception) {
            $responseCode = ApiResponseInterface::APP_PAGE_LINK_REQUEST_ERROR;
        }

        return $this->responseFactory
            ->create($responseCode, $responseData)->toArray();
    }

    /**
     * @return string
     */
    protected function getApplicationPageLink(): string
    {
        $arguments = $this->request->getArguments();
        $id = $arguments[self::PARAMETER_ID];
        return \nn\t3::Page()->getLink(
            $id,
            [
                '_language' => t3::Environment()->getLanguage(),
            ],
            true
        );
    }
}
