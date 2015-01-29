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
 * Representation Type Interface
 */
interface RepresentationTypeInterface
{
    /**
     * @return string  The mime-type
     */
    function getMime();
    
    /**
     * @param array $params
     * @return \Symfony\Component\HttpFoundation\Response|string
     */
    function render(array $params = []);
}

/* EOF: RepresentationTypeInterface.php */
