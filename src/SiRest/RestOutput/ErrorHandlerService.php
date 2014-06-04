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
use Exception;

/**
 * A service for handling errors
 */
class ErrorHandlerService
{
    /**
     * @var SiRest\RestOutput\RepresentationTypeCollection
     */
    private $types;
    
    /**
     * @var SiRest\RestOutput\ViewRenderer
     */
    private $renderer;
    
    /**
     * @var boolean
     */
    private $debugMode;
    
    // --------------------------------------------------------------    
    
    /**
     * Constructor
     * 
     * @param \SiRest\RestOutput\ViewRenderer $renderer
     * @param \SiRest\RestOutput\RepresentationTypeCollection $types
     * @param boolean $debugMode
     */
    public function __construct(ViewRenderer $renderer, RepresentationTypeCollection $types, $debugMode = false)
    {
        $this->types    = $types;
        $this->renderer = $renderer;        
        $this->setDebugMode($debugMode);
    }

    // --------------------------------------------------------------

    /**
     * Set debug mode
     * 
     * @param boolean $debugMode
     */
    public function setDebugMode($debugMode)
    {
        $this->debugMode = (boolean) $debugMode;
    }

    // --------------------------------------------------------------

    /**
     * Handle error
     * 
     * @param Exception $e
     * @param int $httpCode
     * @return \Symfony\Component\HttpFoundation\Response|string|null
     */
    public function handleError(Exception $e, $httpCode)
    {
        // Render the error
        $resp = $this->renderer->render($this->generateErrorView($e, $httpCode), $httpCode);
        
        // Return the response, or 'null' if the response is empty
        // (null causes the next error handler up the stack to handle the error
        return ($this->responseHasContent($resp)) ? $resp : null;
    }

    // --------------------------------------------------------------
    
    /**
     * Generate an error view
     * 
     * @param Exception $e
     * @param int $httpCode
     * @return \SiRest\RestOutput\ErrorView
     */
    protected function generateErrorView(Exception $e, $httpCode)
    {
        return new ErrorView($this->types, $e, $httpCode, $this->debugMode);
    }
    
    // --------------------------------------------------------------
    
    /**
     * Does the response have any content?
     * 
     * @param \Symfony\Component\HttpFoundation\Response|string $response
     * @return boolean
     */
    protected function responseHasContent($response)
    {
        $respContent = ($response instanceOf Response)
            ? $response->getContent()
            : $response;
                
        return (boolean) $respContent;
    }
}

/* EOF: ErrorHandlerService.php */