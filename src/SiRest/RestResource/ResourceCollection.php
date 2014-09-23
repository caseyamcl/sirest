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

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Collection of Resources
 * 
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 */
class ResourceCollection extends ArrayCollection
{   
    public function add($value)
    {
        $this->setResource($value);
    }

    // --------------------------------------------------------------

    public function setResource(Resource $resource)
    {
        $this->set($resource->getSlug(), $resource);
    }
    
    // --------------------------------------------------------------
    
    /**
     * Wraps parent::set() to provide some additional rules
     * 
     * @param string $key
     * @param \SiRest\RestResource\Resource $value
     * @throws \InvalidArgumentException
     */
    public function set($key, $value)
    {
        if ($value->getSlug() != $key) {
            user_error(sprintf(
                "%s::set() key parameter (1) ignored: %s",
                get_called_class(),
                $key
            ), E_NOTICE);
        }
        
        if ( ! $value instanceOf Resource) {
            throw new \InvalidArgumentException(sprintf(
                "%s::set() expects a HealthResource",
                get_called_class()
            ));
        }
        
        parent::set($value->getSlug(), $value);
    }
}

/* EOF: ResourceCollection.php */