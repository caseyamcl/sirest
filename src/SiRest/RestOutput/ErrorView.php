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

use Exception;

/**
 * Generic Error View
 *
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 */
class ErrorView implements ViewInterface
{
    /**
     * @var array 
     */
    private $representations;

    // --------------------------------------------------------------

    /**
     * Constructor
     *
     * Sets representations upon construction
     * 
     * @param SiRest\RestOutput\RepresentationTypeCollection $types
     * @param Exception $e
     * @param int       $httpCode
     * @param boolean   $debugMode
     */
    public function __construct(RepresentationTypeCollection $types, Exception $e, $httpCode, $debugMode)
    {                
        // Set each representation to a callback calling the handler method for rendering the error
        foreach ($types as $type) {

            // Skip non ErrorRendererInterface types
            if ( ! $type instanceOf ErrorRendererInterface) {
                continue;
            }
            
            $this->representations[$type->getMime()] = function() use ($type, $e, $httpCode, $debugMode) {
                return call_user_func(array($type, 'renderError'), $e, $httpCode, $debugMode);
            };
        }
        
    }
    
    // --------------------------------------------------------------

    /**
     * {@inheritdoc}
     */
    public function getRepresentations()
    {
        return $this->representations;
    }

    // --------------------------------------------------------------

    public function getHeaders()
    {
        return array();
    }
}

/* EOF: ErrorView.php */