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

use Symfony\Component\HttpFoundation\JsonResponse;
use SiRest\RestOutput\RepresentationTypeInterface;
use SiRest\RestOutput\ErrorRendererInterface;

/**
 * Generic JSON Representation Type
 *
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 */
class Json implements RepresentationTypeInterface, ErrorRendererInterface
{
    public function getMime()
    {
        return 'application/json';
    }

    // --------------------------------------------------------------

    public function render(array $params = [])
    {
        return new JsonResponse($params);
    }

    // --------------------------------------------------------------

    public function renderError(\Exception $e, $httpCode, $debug = false)
    {
        $data = array(
            'message'  => $e->getMessage(),
            'httpCode' => $httpCode,
        );

        if ($e->getCode()) {
            $data['code'] = $e->getCode();
        }


        if ($debug) {
            $data['debug'] = array(
                'code'  => $e->getCode(),
                'file'  => $e->getFile(),
                'line'  => $e->getLine(),
                'trace' => $e->getTrace()
            );
        }

        return new JsonResponse($data, $httpCode);
    }
}

/* EOF: Json.php */