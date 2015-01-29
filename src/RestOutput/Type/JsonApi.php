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

/**
 * JSON+API Representation Type
 *
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 */
class JsonApi extends Json
{
    public function getMime()
    {
        return 'application/vnd.api+json';
    }
}

/* EOF: Json.php */