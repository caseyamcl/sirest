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

use Symfony\Component\HttpFoundation\Request;
use Silex\ControllerCollection;

/**
 * Default HealthResource Route Provider
 * 
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 */
class ResourceRouteProvider
{
    /**
     * Register route with Silex
     * 
     * @param \Silex\ControllerCollection $routes
     * @param \SiRest\RestResource\Resource $resource
     * @return Silex\Controller
     */
    public function register(ControllerCollection $routes, Resource $resource)
    {
        $slug = $resource->getSlug();
        $bind = $resource->getConfig()->routeName;
        
        $doRoute = function(Request $request, $id = null) use ($resource) {
            return $this->handleRequest($request, $resource, $id);
        };
        
        // both index and single -- {id} parameter is optional
        if ($resource->getIndexController() && $resource->getSingleController()) {
            $route = $routes->match($slug . '/{id}', $doRoute)->value('id', false)->bind($bind);
        }
        // index controller only -- no {id} parameter
        elseif ($resource->getIndexController()) {
            $route = $routes->match($slug, $doRoute)->bind($bind);
        }
        // single controller only -- {id} is not optional
        else {
            $route = $routes->match($slug . '/{id}', $doRoute)->bind($bind);
        }
        
        return $route;
    }
    
    // --------------------------------------------------------------

    /**
     * Handle the request
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \SiRest\RestResource\Resource $resource
     * @param string $id  Optional ID (if not null, then use single controller)
     * @return string|\Symfony\Component\HttpFoundation\Response  Return a response object or string
     */
    protected function handleRequest(Request $request, Resource $resource, $id = null)
    {
        $methodName = strtolower($request->getMethod());
                
        return ($id)
            ? call_user_func([$resource->getSingleController(), $methodName], $request, $resource)
            : call_user_func([$resource->getIndexController(), $methodName], $request, $resource);
    }
}

/* EOF: ResourceRouteProvider.php */