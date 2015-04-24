<?php

namespace Anar\BlogPanelBundle\Exception;

class BlogNotSelectedException extends \RuntimeException
{
    public function __construct($message = 'Access Denied', \Exception $previous = null)
    {
        parent::__construct($message, 403, $previous);
    }
}