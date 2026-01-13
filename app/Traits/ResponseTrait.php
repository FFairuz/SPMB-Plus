<?php

namespace App\Traits;

/**
 * Trait untuk response handling
 * 
 * Menyediakan method helper untuk response JSON dan redirect dengan data.
 */
trait ResponseTrait
{
    /**
     * Return JSON response
     * 
     * @param bool $success Status success/error
     * @param string $message Message
     * @param array|null $data Additional data
     * @param int $statusCode HTTP status code
     * @return \CodeIgniter\HTTP\Response
     */
    protected function jsonResponse($success = true, $message = '', $data = null, $statusCode = 200)
    {
        return $this->response
            ->setStatusCode($statusCode)
            ->setContentType('application/json')
            ->setBody(json_encode([
                'success' => $success,
                'message' => $message,
                'data' => $data,
            ]));
    }

    /**
     * Return error response
     * 
     * @param string $message Error message
     * @param array|null $data Additional data
     * @param int $statusCode HTTP status code
     * @return \CodeIgniter\HTTP\Response
     */
    protected function errorResponse($message = 'An error occurred', $data = null, $statusCode = 400)
    {
        return $this->jsonResponse(false, $message, $data, $statusCode);
    }

    /**
     * Return success response
     * 
     * @param string $message Success message
     * @param array|null $data Additional data
     * @param int $statusCode HTTP status code
     * @return \CodeIgniter\HTTP\Response
     */
    protected function successResponse($message = 'Success', $data = null, $statusCode = 200)
    {
        return $this->jsonResponse(true, $message, $data, $statusCode);
    }
}
