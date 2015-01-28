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
 * Endpoint Configuration
 */
class ResourceConfig
{    
    /**
     * @var string
     */
    protected $slug;
    
    /**
     * @var string  Defaults to 'resource_{$slug}'
     */
    protected $routeName;
    
    /**
     * @var string
     */    
    protected $pluralName;

    /**
     * @var string
     */   
    protected $singleName;
    
    /**
     * @var string
     */    
    protected $description;

    // --------------------------------------------------------------
    
    /**
     * Constructor
     * 
     * @param array $configParams
     */
    public function __construct(array $configParams)
    {
        // Set properties based on passed options
        foreach ($this->resolveOptions($configParams) as $name => $val) {
            $this->$name = $val;
        }
    }

    // --------------------------------------------------------------

    public function __get($item)
    {
        if ($this->__isset($item)) {
            return $this->$item;
        }
    }

    // --------------------------------------------------------------
    
    public function __isset($item)
    {
        return isset($this->$item);
    }

    // --------------------------------------------------------------

    /**
     * Resolve options
     * 
     * @param array $options
     * @return array
     */
    private function resolveOptions(array $options)
    {
        $resolver = new OptionsResolver();
        $this->setRequiredOptions($resolver);
        $this->setAllowedOptions($resolver);        
        $this->setDefaultOptions($resolver);
        $this->setNormalizers($resolver);
        return $resolver->resolve($options);
    } 

    // --------------------------------------------------------------

    protected function setRequiredOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'slug',
            'routeName',
            'pluralName',
            'singleName',
            'description'
        ]);
    }

    // --------------------------------------------------------------

    protected function setAllowedOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setAllowedTypes([
            'slug'              => 'string',
            'routeName'         => 'string',
            'pluralName'        => 'string',
            'singleName'        => 'string',
            'description'       => 'string'
        ]);
    }       

    // --------------------------------------------------------------

    protected function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'routeName'         => null,
            'description'       => ''
        ]);
    }
    
    // --------------------------------------------------------------
    
    protected function setNormalizers(OptionsResolverInterface $resolver)
    {
        // Resolvers
        $normalizers = array();

        // Set routeName to be 'endpoint_{$slug}' if it is not already set
        $normalizers['routeName'] = function(Options $options, $value) {
            if (empty($value)) {
                return 'resource_' . $options->get('slug');
            }
            return $value;
        };

        $resolver->setNormalizers($normalizers);        
    }
}

/* EOF: ResourceConfig.php */
