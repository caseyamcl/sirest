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
 * Output service
 *
 * This is to be used in the controller as such:
 *  $view = new $myView($someContextualData);
 *  return $this->outputSvc->render($view);
 */
class OutputService
{
    /**
     * @var RepresentationTypeCollection
     */
    protected $types;

    /**
     * @var ViewRenderer
     */
    protected $renderer;

    // --------------------------------------------------------------

    /**
     * Constructor
     *
     * @param ViewRenderer                 $renderer
     * @param RepresentationTypeCollection $types
     */
    public function __construct(ViewRenderer $renderer, RepresentationTypeCollection $types = null)
    {
        $this->renderer = $renderer;
        $this->types    = $types ?: new RepresentationTypeCollection();
    }

    // --------------------------------------------------------------

    public function getTypes()
    {
        return $this->types;
    }
    
    // --------------------------------------------------------------
    
    public function getRenderer()
    {
        return $this->renderer;
    }
    
    // --------------------------------------------------------------

    /**
     * Render a view
     *
     * @param ViewInterface $view
     * @param int           $httpCode
     * @param array         $extraHeaders
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render(ViewInterface $view, $httpCode = 200, array $extraHeaders = array())
    {
        if ($view instanceOf View) {
            $view->buildRepresentations($this->types);
        }

        return $this->renderer->render($view, $httpCode, $extraHeaders);
    }
}

/* EOF: OutputService.php */
