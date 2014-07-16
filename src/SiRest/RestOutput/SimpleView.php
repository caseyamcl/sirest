<?php

namespace SiRest\RestOutput;

/**
 * Simple View for specifying representations at runtime
 * 
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 */
class SimpleView implements ViewInterface
{
    private $representations;

    // --------------------------------------------------------------

    public function __construct($representations = [])
    {
        $this->setAll($representations);
    }
    
    // --------------------------------------------------------------
    
    public function setAll($representations)
    {
        $this->representations = array();
        $this->setMultiple($representations);
    }
    
    // --------------------------------------------------------------
    
    public function setMultiple($representations)
    {
        foreach ($representations as $mime => $rep) {
            $this->set($mime, $rep);
        }
    }
            
    // --------------------------------------------------------------
    
    /**
     * Set representation
     * 
     * @param string $mime
     * @param \Closure|string $responseOrCallback
     */
    public function set($mime, $responseOrCallback)
    {
        $this->representations[$mime] = $responseOrCallback;
    }
    
    // --------------------------------------------------------------
    
    /**
     * Get representations
     * 
     * @return array
     */
    public function getRepresentations()
    {
        return $this->representations;
    }
}

/* EOF: SimpleView.php */