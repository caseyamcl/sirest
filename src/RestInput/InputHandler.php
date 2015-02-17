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

namespace SiRest\RestInput;

use SiRest\RestInput\RequestBodyInterpreter\RequestBodyInterpreterInterface;
use SiRest\RestInput\RequestBridge\RequestBridgeInterface;
use SiRest\RestInput\RequestBodyInterpreter\RequestBodyInterpreterInterface as RequestBodyInterpreter;

/**
 * Gets input data from Symfony Request, and can optionally interpret different
 * types of data passed into the body of the request
 *
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 */
class InputHandler implements InputHandlerInterface
{
    /**
     * @var RequestBridgeInterface
     */
    private $request;

    /**
     * @var RequestBodyInterpreterInterface
     */
    private $reqBodyInterpreter;

    /**
     * @var array|null
     */
    private $reqBodyData;

    // --------------------------------------------------------------

    /**
     * Constructor
     *
     * @param RequestBodyInterpreter $reqBodyInterpreter
     * @param RequestBridgeInterface $requestBridge
     */
    public function __construct(RequestBodyInterpreter $reqBodyInterpreter, RequestBridgeInterface $requestBridge)
    {
        $this->reqBodyInterpreter = $reqBodyInterpreter;
        $this->request  = $requestBridge;

        $this->initReqBodyData();
    }

    // --------------------------------------------------------------

    /**
     * Return a single query string value (option)
     *
     * @param string $optionName
     * @return mixed|null
     */
    public function getQueryParam($optionName)
    {
        return $this->request->getQueryParam($optionName);
    }

    // --------------------------------------------------------------

    /**
     * Return all query string values (options)
     *
     * @return array
     */
    public function getQueryParams()
    {
        return $this->request->getQueryParams();
    }

    // --------------------------------------------------------------

    /**
     * Return a given parameter from either the request body, or from $_POST
     *
     * @param string $paramName
     * @return mixed|null
     */
    public function getDataParam($paramName)
    {
        return ($this->reqBodyData && isset($this->reqBodyData[$paramName]))
            ? $this->reqBodyData[$paramName]
            : null;
    }

    // --------------------------------------------------------------

    /**
     * Returns the parameters from either the request body, or from $_POST (request)
     *
     * @return array
     */
    public function getDataParams()
    {
        return ($this->reqBodyData)
            ? array_merge($this->reqBodyData)
            : (array) $this->request->request->all();
    }

    // --------------------------------------------------------------

    /**
     * Parse the request body using the interpreter if it has been set
     */
    protected function initReqBodyData()
    {
        $rawContent = $this->request->getRequestBody();
        $reqCType   = $this->request->getRequestFormat();

        if ($this->reqBodyInterpreter && $this->reqBodyInterpreter->canHandle($reqCType, $reqBody)) {
            $this->reqBodyData = $this->reqBodyInterpreter->getData($reqCType, $reqBody);
        }
        else {
            $this->reqBodyData = null;
        }
    }

}
