<?php

namespace App\Exceptions;

/**
 * AuthenticationException
 * 
 * Exception untuk authentication errors
 */
class AuthenticationException extends PPDBException
{
    /**
     * Constructor
     * 
     * @param string $message Error message
     */
    public function __construct(string $message = "Authentication failed")
    {
        parent::__construct($message, 401);
    }
}
