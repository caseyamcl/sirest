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
 * Request Body Interpreter Interface
 *
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 */
interface RequestBodyInterpreterInterface
{
    /**
     * Test if the data is of this request type
     *
     * @param string $reqContentType  The Request Content-Type header
     * @param string $requestBody
     * @return boolean
     */
    function canHandle($reqContentType, $requestBody);

    /**
     * Decode data from the request body
     *
     * @param string $reqContentType  The Request Content-Type header
     * @param string $requestBody
     * @return array
     */
    function getData($reqContentType, $requestBody);
}
