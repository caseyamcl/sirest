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

namespace SiRest\RestOutput;

/**
 * A representation type that has the ability to render errors
 *
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 */
interface ErrorRendererInterface extends RepresentationTypeInterface
{
    /**
     * Render an error
     *
     * @return \Symfony\Component\HttpFoundation\Response|string  Rendered response
     */
    function renderError(\Exception $e, $httpCode, $debug = false);
}

/* EOF: ErrorRendererInterface.php */