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

use Closure;

/**
 * Views are newable entities.
 * 
 * Most of the work should be done in 'buildRepresentations', where the collection
 * of representationTypes is passed in during runtime.
 *
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 */
abstract class View implements ViewInterface
{
    /**
     * @var array  Array of mime-type => callback/Response/strings
     */
    private $representations;
    
    // --------------------------------------------------------------

    /**
     * Add representations to the view based on registered types or simple callbacks
     *
     * Ex:
     *  $this->addType(RepresentationTypeInterface $type)
     *  $this->addRepresentation('application/json', array('x' => 'y'));
     *
     * @param SiRest\RestOutput\RepresentationTypesCollection $types
     */
    abstract public function buildRepresentations(RepresentationTypeCollection $types);

    // --------------------------------------------------------------

    /**
     * Return any additional headers that were included in the view
     * 
     * @return array
     */
    public function getHeaders()
    {
        return array();
    }
    
    // --------------------------------------------------------------

    /**
     * {@inheritdoc}
     */   
    public function getRepresentations()
    {
        return $this->representations;
    }
    
    // ---------------------------------------------------------------    

    /**
     * Add a representation type
     * 
     * Adds a defined representation type to the array.
     * 
     * If \Closure is not set, then it uses the default render() method
     * from the representation type object
     * 
     * @param RepresentationTypeInterface $rep
     * @param Closure                     $callback
     */
    final protected function addType(RepresentationTypeInterface $rep, Closure $callback)
    {
        $this->representations[$rep->getMime()] = function() use ($rep, $callback) { 
            return $rep->render($callback($rep));
        };
    }

    // ---------------------------------------------------------------    

    /**
     * Add a representation
     * 
     * Adds a custom representation to the representation array
     * 
     * @param string $mime
     * @param \Symfony\Component\HttpFoundation\Response|Closure|callable|string $resp
     */
    final protected function addRepresentation($mime, $resp)
    {
        $this->representations[$mime] = $resp;
    }   
}

/* EOF: View.php */