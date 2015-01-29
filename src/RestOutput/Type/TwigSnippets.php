<?php

namespace SiRest\RestOutput\Type;

use Twig_Environment;


/**
 * Twig Snippets Class
 */
class TwigSnippets extends Json
{
    /**
     * @var Twig_Environment
     */
    private $twig;

    // --------------------------------------------------------------

    /**
     * Constructor
     *
     * @param Twig_Environment $twig
     */
    public function __construct(Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    // --------------------------------------------------------------

    /**
     * Render Twig Snippets
     *
     * Expects parameters to be in the following format:
     *
     * [
     *    'snippets' => [
     *       'snipname' => ['template' => '/path/to/template.html.twig'],
     *       'another'  => ['template' => '/path/to/template.html.twig', 'data' => [...]]
     *    ]
     * ]
     *
     * @param array $params
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \InvalidArgumentException
     */
    public function render(array $params = array())
    {
        // If no 'snippets' key, then add an empty one
        if ( ! isset($params['snippets'])) {
            $params['snippets'] = array();
        }

        // Validate snippets
        if ( ! is_array($params['snippets'])) {
            throw new \InvalidArgumentException(sprintf(
                "Data params for %s::render() must contain 'snippets' key, and it must be an array",
                get_called_class()
            ));
        }

        // Prepare snippets data
        foreach ($params['snippets'] as $key => $snippet) {
            $params['snippets'][$key] = $this->twig->render(
                $snippet['template'],
                isset($snippet['data']) ? $snippet['data'] : []
            );
        }

        // Return the data
        return parent::render($params);
    }

    // --------------------------------------------------------------

    /**
     * @return \Twig_Environment
     */
    public function getTwig()
    {
        return $this->twig;
    }

    // --------------------------------------------------------------

    public function getMime()
    {
        return 'application/vnd.html.snippets+json';
    }
}

/* EOF: TwigSnippets.php */