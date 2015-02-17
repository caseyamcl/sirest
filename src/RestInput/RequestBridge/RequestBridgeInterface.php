<?php
/**
 * sirest
 *
 * @license ${LICENSE_LINK}
 * @link ${PROJECT_URL_LINK}
 * @version ${VERSION}
 * @package ${PACKAGE_NAME}
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * ------------------------------------------------------------------
 */

namespace SiRest\RestInput\RequestBridge;

/**
 * Bridges requests for different frameworks
 *
 * @package SiRest\RestInput\RequestBridge
 */
interface RequestBridgeInterface
{
    /**
     * @return string  Get the request body as as string
     */
    function getRequestBody();

    /**
     * @return string  Get the content-type for the request body
     */
    function getContentType();

    /**
     * @return array  Array of arrays ['param_name' => ['val1', 'val2'], etc..]
     */
    function getQueryParams();

    /**
     * @param $name
     * @return array
     */
    function getQueryParam($name);
}
