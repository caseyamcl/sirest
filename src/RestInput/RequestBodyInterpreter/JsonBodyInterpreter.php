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
 * Description of JsonBodyInterpreter
 *
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 */
class JsonBodyInterpreter implements RequestBodyInterpreterInterface
{
    /**
     * JsonBodyInterpreter can handle any JSON-encoded body
     *
     * @param string $reqContentType
     * @param string $requestBody
     * @return bool
     */
    public function canHandle($reqContentType, $requestBody)
    {
        if (strpos($reqContentType, 'json') !== false) {
            return (boolean) @json_decode($requestBody);
        }
        else {
            return false;
        }
    }

    /**
     * Get the data into an array
     *
     * @param string $reqContentType
     * @param string $requestBody
     * @return array
     */
    public function getData($reqContentType, $requestBody)
    {
        return json_decode($requestBody, true) ?: array();
    }

//put your code here
}
