<?php

namespace Tests\Unit\Helpers;

use App\Helpers\ResponseHelper;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * ResponseHelper Test
 * 
 * Example unit tests untuk ResponseHelper
 */
class ResponseHelperTest extends CIUnitTestCase
{
    /**
     * Test success response
     */
    public function testSuccessResponse()
    {
        // Act
        $response = ResponseHelper::success(['id' => 1], 'Data retrieved');

        // Assert
        $this->assertTrue($response['success']);
        $this->assertEquals('Data retrieved', $response['message']);
        $this->assertEquals(['id' => 1], $response['data']);
        $this->assertEquals(200, $response['status_code']);
    }

    /**
     * Test error response
     */
    public function testErrorResponse()
    {
        // Act
        $response = ResponseHelper::error('Error occurred', 400);

        // Assert
        $this->assertFalse($response['success']);
        $this->assertEquals('Error occurred', $response['message']);
        $this->assertEquals(400, $response['status_code']);
    }

    /**
     * Test validation error response
     */
    public function testValidationErrorResponse()
    {
        // Arrange
        $errors = ['email' => 'Invalid email', 'password' => 'Too short'];

        // Act
        $response = ResponseHelper::validationError($errors);

        // Assert
        $this->assertFalse($response['success']);
        $this->assertEquals(422, $response['status_code']);
        $this->assertEquals($errors, $response['errors']);
    }

    /**
     * Test not found response
     */
    public function testNotFoundResponse()
    {
        // Act
        $response = ResponseHelper::notFound('User not found');

        // Assert
        $this->assertFalse($response['success']);
        $this->assertEquals('User not found', $response['message']);
        $this->assertEquals(404, $response['status_code']);
    }

    /**
     * Test unauthorized response
     */
    public function testUnauthorizedResponse()
    {
        // Act
        $response = ResponseHelper::unauthorized('Please login');

        // Assert
        $this->assertFalse($response['success']);
        $this->assertEquals('Please login', $response['message']);
        $this->assertEquals(401, $response['status_code']);
    }

    /**
     * Test forbidden response
     */
    public function testForbiddenResponse()
    {
        // Act
        $response = ResponseHelper::forbidden('Access denied');

        // Assert
        $this->assertFalse($response['success']);
        $this->assertEquals('Access denied', $response['message']);
        $this->assertEquals(403, $response['status_code']);
    }

    /**
     * Test server error response
     */
    public function testServerErrorResponse()
    {
        // Act
        $response = ResponseHelper::serverError('Database error');

        // Assert
        $this->assertFalse($response['success']);
        $this->assertEquals('Database error', $response['message']);
        $this->assertEquals(500, $response['status_code']);
    }

    /**
     * Test paginated response
     */
    public function testPaginatedResponse()
    {
        // Arrange
        $data = [
            ['id' => 1, 'name' => 'Item 1'],
            ['id' => 2, 'name' => 'Item 2'],
        ];
        $total = 50;
        $page = 2;
        $perPage = 15;

        // Act
        $response = ResponseHelper::paginated($data, $total, $page, $perPage);

        // Assert
        $this->assertTrue($response['success']);
        $this->assertEquals($data, $response['data']);
        $this->assertEquals(200, $response['status_code']);
        
        // Check pagination
        $this->assertArrayHasKey('pagination', $response);
        $this->assertEquals($total, $response['pagination']['total']);
        $this->assertEquals($page, $response['pagination']['page']);
        $this->assertEquals($perPage, $response['pagination']['per_page']);
        $this->assertEquals(4, $response['pagination']['total_pages']); // ceil(50/15) = 4
    }

    /**
     * Test paginated response calculates pages correctly
     */
    public function testPaginatedResponsePagesCalculation()
    {
        // Test 1: Exact division
        $response = ResponseHelper::paginated([], 30, 1, 10);
        $this->assertEquals(3, $response['pagination']['total_pages']);

        // Test 2: With remainder
        $response = ResponseHelper::paginated([], 35, 1, 10);
        $this->assertEquals(4, $response['pagination']['total_pages']);

        // Test 3: Less than one page
        $response = ResponseHelper::paginated([], 5, 1, 10);
        $this->assertEquals(1, $response['pagination']['total_pages']);
    }
}
