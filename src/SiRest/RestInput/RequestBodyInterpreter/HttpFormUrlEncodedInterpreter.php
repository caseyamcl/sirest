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
class HttpFormUrlEncodedInterpreter implements RequestBodyInterpreterInterface
{
    public function canHandle($reqContentType, $requestBody)
    {
        return ($reqContentType == 'application/x-www-form-urlencoded');
    }

    public function getData($reqContentType, $requestBody)
    {
        parse_str($requestBody, $arr);
        return $arr;
    }

//put your code here
}
