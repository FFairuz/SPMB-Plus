<?php

namespace App\Helpers;

/**
 * ResponseHelper
 * 
 * Helper untuk standardized HTTP responses
 */
class ResponseHelper
{
    /**
     * Success response format
     * 
     * @param mixed $data Response data
     * @param string $message Success message
     * @param int $statusCode HTTP status code
     * @return array
     */
    public static function success($data = null, string $message = 'Success', int $statusCode = 200): array
    {
        return [
            'success' => true,
            'message' => $message,
            'data' => $data,
            'status_code' => $statusCode,
        ];
    }

    /**
     * Error response format
     * 
     * @param string $message Error message
     * @param int $statusCode HTTP status code
     * @param mixed $errors Additional error details
     * @return array
     */
    public static function error(string $message = 'Error', int $statusCode = 400, $errors = null): array
    {
        $response = [
            'success' => false,
            'message' => $message,
            'status_code' => $statusCode,
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        return $response;
    }

    /**
     * Validation error response
     * 
     * @param array $errors Validation errors
     * @param string $message Error message
     * @return array
     */
    public static function validationError(array $errors, string $message = 'Validation failed'): array
    {
        return self::error($message, 422, $errors);
    }

    /**
     * Not found response
     * 
     * @param string $message Not found message
     * @return array
     */
    public static function notFound(string $message = 'Resource not found'): array
    {
        return self::error($message, 404);
    }

    /**
     * Unauthorized response
     * 
     * @param string $message Unauthorized message
     * @return array
     */
    public static function unauthorized(string $message = 'Unauthorized'): array
    {
        return self::error($message, 401);
    }

    /**
     * Forbidden response
     * 
     * @param string $message Forbidden message
     * @return array
     */
    public static function forbidden(string $message = 'Forbidden'): array
    {
        return self::error($message, 403);
    }

    /**
     * Server error response
     * 
     * @param string $message Error message
     * @return array
     */
    public static function serverError(string $message = 'Internal server error'): array
    {
        return self::error($message, 500);
    }

    /**
     * Paginated response format
     * 
     * @param array $data Items data
     * @param int $total Total items
     * @param int $page Current page
     * @param int $perPage Items per page
     * @param string $message Success message
     * @return array
     */
    public static function paginated(
        array $data,
        int $total,
        int $page,
        int $perPage,
        string $message = 'Success'
    ): array {
        return [
            'success' => true,
            'message' => $message,
            'data' => $data,
            'pagination' => [
                'total' => $total,
                'page' => $page,
                'per_page' => $perPage,
                'total_pages' => ceil($total / $perPage),
            ],
            'status_code' => 200,
        ];
    }
}
