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

use Psr\Http\Message\RequestInterface;

/**
 * Class Psr7RequestBridge
 *
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 */
class Psr7RequestBridge implements RequestBridgeInterface
{
    /**
     * @var RequestInterface
     */
    private $psr7Request;

    // ---------------------------------------------------------------

    /**
     * @param RequestInterface $psr7Request
     */
    public function __construct(RequestInterface $psr7Request)
    {
        $this->psr7Request = $psr7Request;
    }

    /**
     * @return string  Get the request body as as string
     */
    function getRequestBody()
    {
        return $this->psr7Request->getBody()->__toString();
    }

    /**
     * @return string  Get the content-type for the request body
     */
    function getContentType()
    {
        return $this->psr7Request->getHeader('Content-Type');
    }

    /**
     * @return array  Array of arrays ['param_name' => ['val1', 'val2'], etc..]
     */
    function getQueryParams()
    {
        parse_str($this->psr7Request->getUri()->getQuery(), $items);

        foreach ($items as $k => $item) {
            $items[$k] = (array) $item;
        }

        return $items;
    }

    /**
     * @param $name
     * @return array
     */
    function getQueryParam($name)
    {
        $vals = $this->getQueryParams();
        return (array_key_exists($name, $vals))
          ? $vals[$name]
          : [];
    }
}
