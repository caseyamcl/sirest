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
 * Representation Type Collection
 */
class RepresentationTypeCollection implements \IteratorAggregate
{
    /**
     * @var array
     */
    private $types;

    // --------------------------------------------------------------

    /**
     * Constructor
     * 
     * @param \SiRest\RestOutput\RepresentationTypeInterface[] $representations
     */
    public function __construct($representations = array())
    {
        foreach ($representations as $key => $type) {
            $this->set($key, $type);
        }
    }
    
    // --------------------------------------------------------------

    /**
     * @param string $key
     * @param \SiRest\RestOutput\RepresentationTypeInterface $type
     */
    public function set($key, RepresentationTypeInterface $type)
    {
        $this->types[$key] = $type;
    }

    // --------------------------------------------------------------

    /**
     * @param string $key
     * @return \SiRest\RestOutput\RepresentationTypeInterface
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    // --------------------------------------------------------------

    /**
     * @param string $key
     * @return boolean
     */
    public function __isset($key)
    {
        return $this->has($key);
    }

    // --------------------------------------------------------------

    /**
     * @param string $key
     * @return \SiRest\RestOutput\RepresentationTypeInterface
     */    
    public function get($key)
    {
        return $this->types[$key];
    }

    // --------------------------------------------------------------

    /**
     * @param string $key
     * @return boolean
     */    
    public function has($key)
    {
        return isset($this->types[$key]);
    }

    // --------------------------------------------------------------

    /**
     * @param string $key
     */    
    public function remove($key)
    {
        unset($this->types[$key]);
    }

    // --------------------------------------------------------------

    /**
     * @return array
     */    
    public function keys()
    {
        return array_keys($this->types);
    }

    // --------------------------------------------------------------

    /**
     * @param \SiRest\RestOutput\RepresentationTypeInterface $type
     * @return boolean
     */
    public function contains(RepresentationTypeInterface $type)
    {
        return in_array($type, $this->types, false);
    }

    // --------------------------------------------------------------

    /**
     * @return array
     */
    public function all()
    {
        return $this->types;
    }
    
    // --------------------------------------------------------------

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->all());
    }    
    
    // --------------------------------------------------------------

    /**
     * Return array of representations that can render errors
     * 
     * @return array
     */
    public function errorRenderers()
    {
        $arr = array();

        foreach ($this->types as $type) {
            if ($type instanceof ErrorRendererInterface) {
                $arr[] = $type;
            }
        }

        return $arr;
    }
}

/* EOF: RepresentationTypeCollection.php */