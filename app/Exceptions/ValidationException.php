<?php

namespace App\Exceptions;

/**
 * ValidationException
 * 
 * Exception untuk validation errors
 */
class ValidationException extends PPDBException
{
    /**
     * Constructor
     * 
     * @param string $message Error message
     * @param array $errors Validation errors
     */
    public function __construct(string $message = "Validation failed", array $errors = [])
    {
        parent::__construct($message, 422, $errors);
    }
}
