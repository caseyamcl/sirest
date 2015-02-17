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

/**
 * Input Handler Interface
 *
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 */
interface InputHandlerInterface
{
    /**
     * Get options (typically maps to queryString or CLI switches)
     *
     * @return array
     */
    function getQueryParams();

    /**
     * Get option
     *
     * @param string $optionName
     * @return mixed|null
     */
    function getQueryParam($optionName);

    /**
     * Get all parameters (typically maps to POST or JSON data)
     *
     * @return array
     */
    function getDataParams();

    /**
     * Get a single parameter
     *
     * @param string $paramName
     * @returm mixed|null
     */
    function getDataParam($paramName);
}
