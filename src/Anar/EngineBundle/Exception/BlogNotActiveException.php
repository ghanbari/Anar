<?php

namespace Anar\EngineBundle\Exception;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class BlogNotActiveException extends \RuntimeException implements HttpExceptionInterface
{
    public function __construct($message = 'Access Denied', \Exception $previous = null)
    {
        parent::__construct($message, 404, $previous);
    }

    /**
     * Returns the status code.
     *
     * @return int An HTTP response status code
     */
    public function getStatusCode()
    {
        return 404;
    }

    /**
     * Returns response headers.
     *
     * @return array Response headers
     */
    public function getHeaders()
    {
        return array();
    }
}