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
     * @var array
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

    protected function getFirstAcceptedHandler($reqContentType, $requestBody)
    {
        foreach ($this->handlers as $handler) {
            if ($handler->canHandle($reqContentType, $requestBody)) {
                return $handler;
            }
        }

        //if made it here, none of them can handle it
        return false;
    }
}

/* EOF: ChainRequestBodyInterpreter.php */