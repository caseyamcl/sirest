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

/**
 * Resource Definition
 * 
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 */
class Resource 
{
    /**
     * @var string - Set at construction - immutable
     */
    private $slug;
        
    /**
     * @var SiRest\RestResource\ResourceConfig
     */
    private $config;
    
    /**
     * @var SiRest\RestResource\ResourceRepositoryInterface
     */
    private $repository;    
    
    /**
     * @var SiRest\RestResource\ResourceControllerInterface
     */
    private $indexController;
    
    /**
     * @var SiRest\RestResource\ResourceControllerInterface
     */
    private $singleController;
        
    /**
     * @var SiRest\RestResource\ResourceRouteProvider
     */
    private $routeProvider;

    // --------------------------------------------------------------

    /**
     * Constructor
     * 
     * @param string $slug
     * @param array  $config
     * @param SiRest\RestResource\ResourceRepositoryInterface$repo
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
     * @return SiRest\RestResource\RestConfig
     */
    public function getConfig()
    {
        return $this->config;
    }
    
    // --------------------------------------------------------------
    
    /**
     * Get index Controller
     * 
     * @return SiRest\RestResource\RestControllerInterface|null
     */
    public function getIndexController()
    {
        return $this->indexController;
    }
    
    // --------------------------------------------------------------
    
    /**
     * Get single controller
     * 
     * @return SiRest\RestResource\RestControllerInterface|null
     */
    public function getSingleController()
    {
        return $this->singleController;
    }
    
    // --------------------------------------------------------------
          
    /**
     * Set repository
     * 
     * @param SiRest\RestResource\ResourceRepositoryInterface $repo
     */
    public function setRepository(ResourceRepositoryInterface $repo)
    {
        $this->repository = $repo;
    }
    
    // --------------------------------------------------------------
   
    /**
     * Set index controller
     * 
     * @param SiRest\RestResource\RestControllerInterface $controller
     */    
    public function setIndexController(ResourceControllerInterface $controller)
    {
        $this->indexController = $controller;
    }

    // --------------------------------------------------------------

    /**
     * Set single controller
     * 
     * @param SiRest\RestResource\RestControllerInterface $controller
     */        
    public function setSingleController(ResourceControllerInterface $controller)
    {
        $this->singleController = $controller;
    }
    
    // --------------------------------------------------------------

    /**
     * Set route provider
     * 
     * @param SiRest\RestResource\ResourceRouteProvider $routeProvider
     */      
    public function setRouteProvider(ResourceRouteProvider $routeProvider)
    {
        $this->routeProvider = $routeProvider;
    }

    // --------------------------------------------------------------
    
    /**
     * Register the route with Silex
     * 
     * @param \Silex\ControllerCollection $routes
     */
    public function register(\Silex\ControllerCollection $routes)
    {
        $this->routeProvider->register($routes, $this);
    }
}

/* EOF: Resource.php */
