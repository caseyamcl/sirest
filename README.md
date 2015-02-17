SiRest Silex REST Libraries

This is a collection of framework-agnostic PHP libraries to make writing
RESTful services easier.  Unlike other REST libraries, these are flexible
and unopinionated about how they are implemented.

## At A Glance

* RestInput provides a common interface for gathering request body data
  * Interprets input based on request `Content-Type` header.  
  * Includes `json`, `yaml`, `HttpFormUrlEncoded` decoders.
  * Allow your app to accept one content-type, or you can accept multiple content types.
* RestOutput provides a framework for generating different representations of resources
  * Handles negotiation
  * Provides Controller-agnostic layer for generating representations of resources
  * Makes it easy to represent HTTP errors in your chosen output format
  * Includes output types for `Twig` (HTML or other) and `JSON`
  * Provides [ApiProblem]() implementation, but this optional
  
## RestInput

add that here..

## RestOutput

