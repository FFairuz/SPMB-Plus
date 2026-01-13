<?php

namespace App\Exceptions;

/**
 * AuthorizationException
 * 
 * Exception untuk authorization/permission errors
 */
class AuthorizationException extends PPDBException
{
    /**
     * Constructor
     * 
     * @param string $message Error message
     */
    public function __construct(string $message = "You don't have permission to access this resource")
    {
        parent::__construct($message, 403);
    }
}
