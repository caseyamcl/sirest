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

    /**
     * @return string
     */
    public function getMime()
    {
        return $this->mime;
    }

    // --------------------------------------------------------------

    /**
     * Get Twig
     * 
     * @return \Twig_Environment
     */
    public function getTwig()
    {
        return $this->twig;
    }
    
    // --------------------------------------------------------------

    /**
     * Render the output
     *
     * If the $params['template'] is an array, this will try all of the Twig
     * templates in order until it finds one that works.
     *
     * @param array $params  Must contain ['template'] key and optionally ['data'] key
     * @return string
     * @throws LogicException
     */
    public function render(array $params = array())
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

        return $this->tryMultipleTemplateNames((array) $templateName, $templateData);
    }

    // --------------------------------------------------------------

    /**
     * Render error, or return null
     *
     * @param \Exception $e
     * @param int        $code
     * @param boolean    $debug
     * @return string|null  Returns NULL if no error template was found
     */
    public function renderError(\Exception $e, $code, $debug = false)
    {
        // Return 'null' on debug to get Symfony default error handling
        if ($debug) {
            return null;
        }
        
        // Try the application error code, then the HTTP error code, then just 'error'
        $templatesToTry = array(
            $this->errorPrefix . $e->getcode() . $this->errorSuffix,
            $this->errorPrefix . $code . $this->errorSuffix,
            $this->errorPrefix . 'error' . $this->errorSuffix
        );

        try {

            $content = $this->tryMultipleTemplateNames(
              $templatesToTry,
              ['exception' => $e, 'httpCode' => $code, 'debug' => $debug]
            );
            return new Response($content, $code);

        }
        catch (Twig_Error_Loader $e) {
            return null;
        }
    }

    // ---------------------------------------------------------------

    /**
     * Try multiple templates
     *
     * @param array $templateNames
     * @param array $data
     * @return string
     * @throws Twig_Error_Loader  If none of the templates work
     */
    protected function tryMultipleTemplateNames(array $templateNames, array $data = [])
    {
        foreach ($templateNames as $file) {

            try {
                return $this->twig->render($file, $data);
            }
            catch (Twig_Error_Loader $e) {
                // pass
            }
        }

        throw new Twig_Error_Loader("Could not locate any of the following templates: " . implode(', ', $templateNames));
    }
}

/* EOF: Twig.php */
