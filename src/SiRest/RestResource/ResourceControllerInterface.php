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
     */
    public function get(Request $request, Resource $resource);
}

/* EOF: ControllerInterface.php */