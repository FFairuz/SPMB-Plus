<?php

namespace Tests\Unit\DTOs;

use App\DTOs\UserDTO;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * UserDTO Test
 * 
 * Example unit tests untuk UserDTO
 */
class UserDTOTest extends CIUnitTestCase
{
    /**
     * Test create DTO from array
     */
    public function testFromArray()
    {
        // Arrange
        $data = [
            'id' => 1,
            'username' => 'testuser',
            'email' => 'test@example.com',
            'role' => 'applicant',
        ];

        // Act
        $dto = UserDTO::fromArray($data);

        // Assert
        $this->assertEquals(1, $dto->id);
        $this->assertEquals('testuser', $dto->username);
        $this->assertEquals('test@example.com', $dto->email);
        $this->assertEquals('applicant', $dto->role);
    }

    /**
     * Test convert DTO to array
     */
    public function testToArray()
    {
        // Arrange
        $dto = new UserDTO();
        $dto->id = 1;
        $dto->username = 'testuser';
        $dto->email = 'test@example.com';
        $dto->role = 'applicant';

        // Act
        $array = $dto->toArray();

        // Assert
        $this->assertIsArray($array);
        $this->assertEquals(1, $array['id']);
        $this->assertEquals('testuser', $array['username']);
        $this->assertEquals('test@example.com', $array['email']);
        $this->assertEquals('applicant', $array['role']);
    }

    /**
     * Test validation with valid data
     */
    public function testValidateSuccess()
    {
        // Arrange
        $dto = new UserDTO();
        $dto->email = 'test@example.com';
        $dto->password = 'password123';
        $dto->role = 'applicant';

        // Act
        $errors = $dto->validate();

        // Assert
        $this->assertEmpty($errors);
    }

    /**
     * Test validation with invalid email
     */
    public function testValidateInvalidEmail()
    {
        // Arrange
        $dto = new UserDTO();
        $dto->email = 'invalid-email';
        $dto->password = 'password123';
        $dto->role = 'applicant';

        // Act
        $errors = $dto->validate();

        // Assert
        $this->assertNotEmpty($errors);
        $this->assertArrayHasKey('email', $errors);
    }

    /**
     * Test validation with empty required fields
     */
    public function testValidateEmptyRequiredFields()
    {
        // Arrange
        $dto = new UserDTO();

        // Act
        $errors = $dto->validate();

        // Assert
        $this->assertNotEmpty($errors);
        $this->assertArrayHasKey('email', $errors);
        $this->assertArrayHasKey('password', $errors);
        $this->assertArrayHasKey('role', $errors);
    }

    /**
     * Test validation with invalid role
     */
    public function testValidateInvalidRole()
    {
        // Arrange
        $dto = new UserDTO();
        $dto->email = 'test@example.com';
        $dto->password = 'password123';
        $dto->role = 'invalid_role';

        // Act
        $errors = $dto->validate();

        // Assert
        $this->assertNotEmpty($errors);
        $this->assertArrayHasKey('role', $errors);
    }

    /**
     * Test forRegistration factory method
     */
    public function testForRegistration()
    {
        // Arrange
        $data = [
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password123',
        ];

        // Act
        $dto = UserDTO::forRegistration($data);

        // Assert
        $this->assertEquals('testuser', $dto->username);
        $this->assertEquals('test@example.com', $dto->email);
        $this->assertEquals('password123', $dto->password);
        $this->assertEquals('applicant', $dto->role); // default role
        $this->assertEquals(1, $dto->is_active); // default active
    }

    /**
     * Test DTO with partial data
     */
    public function testPartialData()
    {
        // Arrange
        $dto = new UserDTO();
        $dto->email = 'test@example.com';
        // password and role are null

        // Act
        $array = $dto->toArray();

        // Assert
        $this->assertArrayHasKey('email', $array);
        $this->assertArrayNotHasKey('password', $array); // null values excluded
        $this->assertArrayNotHasKey('role', $array);
    }
}
