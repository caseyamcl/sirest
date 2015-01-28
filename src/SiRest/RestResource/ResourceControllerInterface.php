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

namespace SiRest\RestResource;

use Symfony\Component\HttpFoundation\Request;

/**
 * Endpoint Controller Interface
 */
interface ResourceControllerInterface
{
    /**
     * GET Index
     *
     * @param Request  $request
     * @param Resource $resource
     * @return mixed
     */
    function get(Request $request, RestResource $resource);
}

/* EOF: ControllerInterface.php */
