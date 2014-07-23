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

use Symfony\Component\HttpFoundation\Response;

/**
 * View Interface
 *
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 */
interface ViewInterface
{
    /**
     * Returns an array of mime types and their associated values
     *
     * Keys are mime types, values are either callbacks or rendered data
     * for that mime type
     *
     * Ex: [
     *    'application/json' => array($this, 'callback'),
     *    'text/html'        => 'A Literal value'
     *    'img/jpeg'         => function() { return new StreamedResponse('123'); }
     * ]
     *
     * @return array
     */
    function getRepresentations();

    /**
     * Finalize a response before sending it
     *
     * @param \Symfony\Component\HttpFoundation\Response $response
     */
    function finalize(Response $response);
}

/* EOF: ViewInterface.php */