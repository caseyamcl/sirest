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

use Symfony\Component\HttpFoundation\StreamedResponse;
use SiRest\RestOutput\RepresentationTypeInterface;
use SiRest\RestOutput\ErrorRendererInterface;

/**
 * Generic CSV Representation Type
 *
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 */
class Csv implements RepresentationTypeInterface, ErrorRendererInterface
{
    public function getMime()
    {
        return 'text/csv';
    }

    // --------------------------------------------------------------

    /**
     * @param array $params
     * @return StreamedResponse
     */
    public function render(array $params = [])
    {
        return $this->doRender($params);
    }

    // --------------------------------------------------------------

    public function renderError(\Exception $e, $httpCode, $debug = false)
    {
        $rows = array();

        $data = array(
            'message'  => $e->getMessage(),
            'httpCode' => $httpCode,
        );

        if ($e->getCode()) {
            $data['code'] = $e->getCode();
        }
        
        if ($debug) {
            $data['debug-code']  = $e->getCode();
            $data['debug-file']  = $e->getFile();
            $data['debugline']   = $e->getLine();            
        }

        $rows[] = $data;
        
        if ($debug) {
            $rows = array_merge($rows, $e->getTrace());
        }

        return $this->render($rows);
    }

    // --------------------------------------------------------------

    /**
     * Convert array to CSV
     * 
     * @param array $data
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    protected function doRender(array $data)
    {
        $streamer = function() use ($data) {
            
            // Do nothing with empty data
            if (empty($data)) {
                return;
            }
            
            // Get the headers from the array keys in the first item
            $headers = array_keys((array) current($data));

            // If there are no array keys for each row (no headers), skip it
            if ($headers == range(0, count((array) current($data)))) {
                $headers = false;
            }            
                        
            // Stream it
            $stream = fopen("php://output", 'w');
            if ($headers) {
                fputcsv($stream, $headers);
            }
            foreach ($data as $row) {
                fputcsv($stream, array_values($row));
            }            
            fclose($stream);
        };

        return new StreamedResponse($streamer);
    }
}

/* EOF: Csv.php */
