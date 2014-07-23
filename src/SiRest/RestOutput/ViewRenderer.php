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

namespace SiRest\RestOutput;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Negotiation\Negotiator;

/**
 * View Renderer
 *
 * Negotiates content type and returns the Symfony Response Object
 *
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 */
class ViewRenderer
{
    /**
     * @var Symfony\Component\HttpFoundation\Request
     */
    private $request;

    /**
     * @var Negotiation\FormatNegotiator
     */
    private $negotiator;

    // --------------------------------------------------------------

    /**
     * Constructor
     *
     * @param Symfony\Component\HttpFoundation\Request $request
     * @param Negotiation\FormatNegotiator $negotiator
     */
    public function __construct(Request $request = null, Negotiator $negotiator = null)
    {
        if ($request) {
            $this->setRequest($request);
        }

        $this->setNegotiator($negotiator ?: new Negotiator);
    }

    // --------------------------------------------------------------

    /**
     * Set Request
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    // --------------------------------------------------------------

    /**
     * Set the format negotiator
     *
     * @param \Negotiation\FormatNegotiator $negotiator
     */
    public function setNegotiator(Negotiator $negotiator)
    {
        $this->negotiator = $negotiator;
    }

    // --------------------------------------------------------------

    /**
     * Render the view
     *
     * Negotiates the correct representation based on the request and returns it
     *
     * @param \SiRest\RestOutput\ViewInterface $view
     * @param int $httpCode
     * @param array $extraHeaders
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render(ViewInterface $view, $httpCode = 200, array $extraHeaders = array())
    {
        // Get representations
        $reps = $view->getRepresentations();

        // Get the available MIMES
        $availMimes    = array_keys($reps);
        $acceptedMimes = $this->request->headers->get('Accept');

        // Determine the best format
        $format = $this->negotiator->getBest($acceptedMimes, $availMimes);

        // If we negotiated a format, then render it, else 415
        if ($format) {
            $formatData = $reps[$format->getValue()];

            $response = (is_callable($formatData))
                ? call_user_func($formatData)
                : $formatData;

            $resp = $this->finalize($response, $httpCode, $extraHeaders);
            $view->finalize($resp);
            return $resp;
        }
        else {
            return new Response('Could not negotiate Content-Type', 415, array('Content-Type' => 'text/plain'));
        }
    }

    // --------------------------------------------------------------

    /**
     * Finalize a response and send it
     *
     * @param \Symfony\Component\HttpFoundation\Response|string $response
     * @param int $httpCode
     * @param array $extraHeaders
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function finalize($response, $httpCode, array $extraHeaders)
    {
        if ( ! $response instanceOf Response) {
            $response = new Response($response, $httpCode, $extraHeaders);
        }
        else {
            $response->setStatusCode($httpCode);
            $response->headers->add($extraHeaders);
        }

        return $response;
    }
}

/* EOF: ViewRenderer.php */