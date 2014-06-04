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

namespace SiRest\RestOutput\Type;

use Symfony\Component\HttpFoundation\Response;
use SiRest\RestOutput\RepresentationTypeInterface;
use SiRest\RestOutput\ErrorRendererInterface;

use Twig_Error_Loader, Twig_Environment;
use LogicException;

/**
 * Twig Rest Outpt Type
 */
class Twig implements RepresentationTypeInterface, ErrorRendererInterface
{
    /**
     * @var string
     */
    private $mime;

    /**
     * @var Twig_Environment
     */ 
    private $twig;

    /**
     * @var string
     */
    private $errorPrefix;

    /**
     * @var string
     */
    private $errorSuffix;
    
    // --------------------------------------------------------------

    /**
     * Constructor
     * 
     * @param Twig_Environment $twig
     * @param string $mime
     * @param string $errorPrefix
     * @param string $errorSuffix
     */
    public function __construct(Twig_Environment $twig, $mime = 'text/html', $errorPrefix = 'errors/', $errorSuffix = '.html.twig')
    {
        $this->twig = $twig;
        $this->mime = $mime;

        $this->errorPrefix = $errorPrefix;
        $this->errorSuffix = $errorSuffix;
    }

    // --------------------------------------------------------------

    public function getMime()
    {
        return $this->mime;
    }

    // --------------------------------------------------------------

    /**
     * @param array $params  Must contain ['template'] key and optionally ['data'] key
     * @return string
     * @throws LogicException
     */
    public function render(array $params)
    {        
        // Validate template key
        if ( ! isset($params['template'])) {
            throw new \InvalidArgumentException(sprintf("Data params for %s::render() must contain 'template' key", __CLASS__));
        }        
        
        // Set variables
        $templateName = $params['template'];
        $templateData = (isset($params['data'])) ? $params['data'] : array();
        
        // Further validation
        unset($params['template'], $params['data']);
        if (count($params) > 0) {
            throw new \InvalidArgumentException(sprintf("Data params for %s::render() can only contain 'template' and 'data' keys", __CLASS__));
        }
        
        return $this->twig->render($templateName, $templateData);
    }

    // --------------------------------------------------------------

    /**
     * Render error, or return null
     *
     * @param Exception $e
     * @param int       $code
     * @param boolean   $debug
     * @return string|null  Returns NULL if no error template was found
     */
    public function renderError(\Exception $e, $code, $debug = false)
    {                
        if ($debug) {
            return null;
        }
        
        // Try the application error code, then the HTTP error code, then just 'error'
        $templatesToTry = array(
            $this->errorPrefix . $e->getcode() . $this->errorSuffix,
            $this->errorPrefix . $code . $this->errorSuffix,
            $this->errorPrefix . 'error' . $this->errorSuffix
        );

        foreach ($templatesToTry as $file) {
            try {
                $content = $this->twig->render(
                    $file,
                    array('exception' => $e, 'httpCode' => $code, 'debug' => $debug)
                );
                return new Response($content, $code);
            }
            catch (Twig_Error_Loader $e) {
                // pass
            }
        }
        
        // If made it here..
        return null;
    }
}

/* EOF: Twig.php */