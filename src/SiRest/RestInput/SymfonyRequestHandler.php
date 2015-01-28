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
use Symfony\Component\HttpFoundation\Request;
use SiRest\RestInput\RequestBodyInterpreter\RequestBodyInterpreterInterface as RequestBodyInterpreter;

/**
 * Gets input data from Symfony Request, and can optionally interpret different
 * types of data passed into the body of the request
 *
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 */
class SymfonyRequestHandler implements InputHandlerInterface
{
    /**
     * @var \Symfony\Component\HttpFoundation\Request
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
     * @param Request                $request
     */
    public function __construct(RequestBodyInterpreter $reqBodyInterpreter = null, Request $request = null)
    {
        if ($reqBodyInterpreter) {
            $this->setReqBodyInterpreter($reqBodyInterpreter);
        }

        if ($request) {
            $this->setRequest($request);
        }
    }

    // --------------------------------------------------------------

    public function setReqBodyInterpreter(RequestBodyInterpreter $reqBodyInterpreter)
    {
        $this->reqBodyInterpreter = $reqBodyInterpreter;

        // Parse the request body data with the new reqBodyInterperter
        if ($this->request) {
            $this->parseReqBody($this->request);
        }
    }

    // --------------------------------------------------------------

    /**
     * Set the Request Object
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
        $this->parseReqBody($request);
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
        return $this->request->query->get($optionName);
    }

    // --------------------------------------------------------------

    /**
     * Return all query string values (options)
     *
     * @return array
     */
    public function getQueryParams()
    {
        return $this->request->query->all();
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
        if ($this->reqBodyData && isset($this->reqBodyData[$paramName])) {
            return $this->reqBodyData[$paramName];
        }
        else {
            return $this->request->request->get($paramName);
        }
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
            ? array_merge($this->reqBodyData, (array) $this->request->request->all())
            : (array) $this->request->request->all();
    }

    // --------------------------------------------------------------

    /**
     * Parse the request body using the interpreter if it has been set
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    protected function parseReqBody(Request $request)
    {
        $reqBody  = $request->getContent();
        $reqCType = $request->headers->get('Content-Type');

        if ($this->reqBodyInterpreter && $this->reqBodyInterpreter->canHandle($reqCType, $reqBody)) {
            $this->reqBodyData = $this->reqBodyInterpreter->getData($reqCType, $reqBody);
        }
        else {
            $this->reqBodyData = null;
        }
    }

}
