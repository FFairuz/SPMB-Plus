<?php

namespace App\Exceptions;

/**
 * NotFoundException
 * 
 * Exception untuk resource not found errors
 */
class NotFoundException extends PPDBException
{
    /**
     * Constructor
     * 
     * @param string $message Error message
     */
    public function __construct(string $message = "Resource not found")
    {
        parent::__construct($message, 404);
    }
}
