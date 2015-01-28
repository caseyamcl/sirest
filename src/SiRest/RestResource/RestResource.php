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
 * HealthResource Definition
 * 
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 */
class RestResource
{
    /**
     * @var string - Set at construction - immutable
     */
    private $slug;
        
    /**
     * @var ResourceConfig
     */
    private $config;
    
    /**
     * @var ResourceRepositoryInterface
     */
    private $repository;    
    
    /**
     * @var ResourceControllerInterface
     */
    private $indexController;
    
    /**
     * @var ResourceControllerInterface
     */
    private $singleController;
        
    /**
     * @var ResourceRouteProvider
     */
    private $routeProvider;

    // --------------------------------------------------------------

    /**
     * Constructor
     * 
     * @param string $slug
     * @param array  $config
     * @param ResourceRepositoryInterface $repo
     */
    public function __construct($slug, array $config, ResourceRepositoryInterface $repo)
    {
        // Slug and configuration are immutable
        $this->slug   = $slug;
        $this->config = new ResourceConfig(array_merge(['slug' => $slug], $config));
        
        // Repository is mutable
        $this->setRepository($repo);
        
        // Set defaults
        $this->indexController = null;
        $this->singleController = null;
        $this->setRouteProvider(new ResourceRouteProvider());
    }
   
    // --------------------------------------------------------------
   
    /**
     * Get repository
     *
     * @return \SiRest\RestResource\ResourceRepositoryInterface
     */
    public function getRepository()
    {
        return $this->repository;
    }

    // --------------------------------------------------------------
  
    /**
     * Get slug
     * 
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
    
    // --------------------------------------------------------------
           
    /**
     * Get configuration
     *
     * @return ResourceConfig
     */
    public function getConfig()
    {
        return $this->config;
    }
    
    // --------------------------------------------------------------
    
    /**
     * Get index Controller
     * 
     * @return ResourceControllerInterface|null
     */
    public function getIndexController()
    {
        return $this->indexController;
    }
    
    // --------------------------------------------------------------
    
    /**
     * Get single controller
     * 
     * @return ResourceControllerInterface|null
     */
    public function getSingleController()
    {
        return $this->singleController;
    }
    
    // --------------------------------------------------------------
          
    /**
     * Set repository
     * 
     * @param ResourceRepositoryInterface $repo
     */
    public function setRepository(ResourceRepositoryInterface $repo)
    {
        $this->repository = $repo;
    }
    
    // --------------------------------------------------------------

    /**
     * Set index controller
     *
     * @param ResourceControllerInterface $controller
     */
    public function setIndexController(ResourceControllerInterface $controller)
    {
        $this->indexController = $controller;
    }

    // --------------------------------------------------------------

    /**
     * Set single controller
     * 
     * @param ResourceControllerInterface $controller
     */        
    public function setSingleController(ResourceControllerInterface $controller)
    {
        $this->singleController = $controller;
    }
    
    // --------------------------------------------------------------

    /**
     * Set route provider
     * 
     * @param ResourceRouteProvider $routeProvider
     */      
    public function setRouteProvider(ResourceRouteProvider $routeProvider)
    {
        $this->routeProvider = $routeProvider;
    }

    // --------------------------------------------------------------
    
    /**
     * Register the route with Silex
     * 
     * @param ControllerCollection $routes
     */
    public function register(ControllerCollection $routes)
    {
        $this->routeProvider->register($routes, $this);
    }
}

/* EOF: HealthResource.php */
