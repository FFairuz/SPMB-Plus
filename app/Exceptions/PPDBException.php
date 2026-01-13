<?php

namespace App\Exceptions;

use Exception;

/**
 * Base PPDB Exception
 * 
 * Base exception class untuk custom exceptions
 */
class PPDBException extends Exception
{
    /**
     * @var int HTTP status code
     */
    protected $statusCode = 500;

    /**
     * @var array Additional error data
     */
    protected $errorData = [];

    /**
     * Constructor
     * 
     * @param string $message Error message
     * @param int $statusCode HTTP status code
     * @param array $errorData Additional error data
     */
    public function __construct(string $message = "", int $statusCode = 500, array $errorData = [])
    {
        parent::__construct($message);
        $this->statusCode = $statusCode;
        $this->errorData = $errorData;
    }

    /**
     * Get HTTP status code
     * 
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Get error data
     * 
     * @return array
     */
    public function getErrorData(): array
    {
        return $this->errorData;
    }

    /**
     * Convert exception to array
     * 
     * @return array
     */
    public function toArray(): array
    {
        return [
            'success' => false,
            'message' => $this->getMessage(),
            'status_code' => $this->statusCode,
            'data' => $this->errorData,
        ];
    }
}
