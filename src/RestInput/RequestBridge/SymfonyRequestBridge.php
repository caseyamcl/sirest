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

use Symfony\Component\HttpFoundation\Request;

/**
 * Symfony Request Bridge
 *
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 */
class SymfonyRequestBridge implements RequestBridgeInterface
{
    /**
     * @var Request
     */
    private $symRequest;

    // ---------------------------------------------------------------

    /**
     * Constructor
     *
     * @param Request $symRequest
     */
    public function __construct(Request $symRequest)
    {
        $this->symRequest = $symRequest;
    }

    // ---------------------------------------------------------------

    /**
     * @return string  Get the request body as as string
     */
    function getRequestBody()
    {
        return $this->symRequest->getContent();
    }

    // ---------------------------------------------------------------

    /**
     * @return string  Get the content-type for the request body
     */
    function getContentType()
    {
        return $this->symRequest->headers->get('Content-Type');
    }

    // ---------------------------------------------------------------

    /**
     * @return array  Array of arrays of strings
     */
    function getQueryParams()
    {
        $out = array();
        foreach ($this->symRequest->query->all() as $key => $param) {
            $out[$key] = (array) $param;
        }
    }

    // ---------------------------------------------------------------

    /**
     * @param string $name
     * @return array
     */
    function getQueryParam($name)
    {
        return (array) $this->symRequest->query->get($name);
    }
}
