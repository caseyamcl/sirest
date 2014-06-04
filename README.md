SiRest Silex REST Libraries

This is a collection of libraries for Silex intended to make writing
RESTful services easier.  Unlike other REST libraries, these are flexible
and unopinionated about how they are implemented.

### Features

* RestInput provides common interface for gathering request body data
  * Common interface regardless of input encoding (HTTP Encoded form, JSON, etc)
* RestOutput provides a framework for generating different representations
  of resources
  * Handles negotiation
  * Provides Controller-agnostic layer for generating representations of resources
* RestResource is an implementation of RestInput and RestOutput with some unique qualitites..
