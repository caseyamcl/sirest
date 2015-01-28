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

use Silex\ControllerCollection;

/**
 * HealthResource Manager
 */
class ResourceManager
{
    private $resources;
    
    // --------------------------------------------------------------
          
    public function __construct(ResourceCollection $resources = null)
    {
        $this->resources = $resources ?: new ResourceCollection;
    }
       
    // --------------------------------------------------------------
           
    /**
     * Shortcut method to add an resource to the collection
     * 
     * @param Resource $resource
     */
    public function addResource(RestResource $resource)
    {
        $this->resources->add($resource);
    }
    
    // --------------------------------------------------------------
          
    /**
     * Shortcut method to get an resource from the collection
     * 
     * @param string $resourceSlug
     * @return Endpoint
     */
    public function getResource($resourceSlug)
    {
        return $this->resources->get($resourceSlug);
    }
    
    // --------------------------------------------------------------
        
    /**
     * Return EndpointCollection, which is traversable
     * 
     * @return EndpointCollection
     */
    public function getResources()
    {
        return $this->resources;
    }

    // --------------------------------------------------------------
    
    /**
     * Register routes with Silex Application
     * 
     * @param \Silex\ControllerCollection $routes
     */
    public function registerRoutes(ControllerCollection $routes)
    {
        foreach ($this->resources as $resource) {
            $resource->register($routes);
        }
    }    
}

/* EOF: EndpointManager.php */
