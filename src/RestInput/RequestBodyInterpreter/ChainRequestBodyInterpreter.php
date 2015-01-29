<?php

/*
 * SiRest Rest Libraries for Silex
 *
 * See README.md for more information
 *
 * @link     http://github.com/caseyamcl/sirest  SiRest Homepage
 * @package  SiRest
 * @license  MIT License - See LICENSE.txt for more information
 */

// ------------------------------------------------------------------

namespace SiRest\RestInput\RequestBodyInterpreter;

/**
 * Description of HttpFormUrlEncodedHandler
 *
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 */
class ChainRequestBodyInterpreter implements RequestBodyInterpreterInterface
{
    /**
     * @var array|RequestBodyInterpreterInterface[]
     */
    private $handlers;

    // --------------------------------------------------------------

    public function __construct(array $handlers = array())
    {
        $this->setHandlers($handlers);
    }

    // --------------------------------------------------------------

    public function setHandlers(array $handlers)
    {
        foreach ($handlers as $handler) {
            $this->addHandler($handler);
        }
    }

    // --------------------------------------------------------------

    public function addHandler(RequestBodyInterpreterInterface $handler)
    {
        $this->handlers[] = $handler;
    }

    // --------------------------------------------------------------

    public function canHandle($reqContentType, $requestBody)
    {
        return (boolean) $this->getFirstAcceptedHandler($reqContentType, $requestBody);
    }

    // --------------------------------------------------------------

    /**
     * Get Data
     *
     * @param string $reqContentType
     * @param string $requestBody
     * @return array
     */
    public function getData($reqContentType, $requestBody)
    {
        $handler = $this->getFirstAcceptedHandler($reqContentType, $requestBody);

        if ($handler) {
            return $handler->getData($reqContentType, $requestBody);
        }
        else {
            return array();
        }
    }

    // --------------------------------------------------------------

    /**
     * @param $reqContentType
     * @param $requestBody
     * @return RequestBodyInterpreterInterface
     */
    protected function getFirstAcceptedHandler($reqContentType, $requestBody)
    {
        foreach ($this->handlers as $handler) {
            if ($handler->canHandle($reqContentType, $requestBody)) {
                return $handler;
            }
        }

        // If made it here...
        return null;
    }
}

/* EOF: ChainRequestBodyInterpreter.php */
