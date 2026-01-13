<?php

namespace Tests\Unit\Services;

use App\Services\AuthService;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * AuthService Test
 * 
 * Example unit tests untuk AuthService
 * Run: vendor/bin/phpunit tests/unit/Services/AuthServiceTest.php
 */
class AuthServiceTest extends CIUnitTestCase
{
    protected $authService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authService = new AuthService();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * Test authenticate with valid credentials
     */
    public function testAuthenticateSuccess()
    {
        // Arrange
        $email = 'admin@ppdb.local';
        $password = 'password123';

        // Act
        $result = $this->authService->authenticate($email, $password);

        // Assert
        $this->assertTrue($result['success']);
        $this->assertNotNull($result['user']);
        $this->assertEquals($email, $result['user']['email']);
        $this->assertEquals('Login berhasil', $result['message']);
    }

    /**
     * Test authenticate with invalid password
     */
    public function testAuthenticateInvalidPassword()
    {
        // Arrange
        $email = 'admin@ppdb.local';
        $password = 'wrongpassword';

        // Act
        $result = $this->authService->authenticate($email, $password);

        // Assert
        $this->assertFalse($result['success']);
        $this->assertNull($result['user']);
        $this->assertEquals('Email atau password salah', $result['message']);
    }

    /**
     * Test authenticate with non-existent email
     */
    public function testAuthenticateNonExistentEmail()
    {
        // Arrange
        $email = 'nonexistent@example.com';
        $password = 'password123';

        // Act
        $result = $this->authService->authenticate($email, $password);

        // Assert
        $this->assertFalse($result['success']);
        $this->assertNull($result['user']);
    }

    /**
     * Test authenticate with empty credentials
     */
    public function testAuthenticateEmptyCredentials()
    {
        // Act
        $result = $this->authService->authenticate('', '');

        // Assert
        $this->assertFalse($result['success']);
        $this->assertEquals('Email dan password harus diisi', $result['message']);
    }

    /**
     * Test register new user
     */
    public function testRegisterNewUser()
    {
        // Arrange
        $userData = [
            'username' => 'testuser_' . time(),
            'email' => 'test_' . time() . '@example.com',
            'password' => 'password123',
            'role' => 'applicant',
        ];

        // Act
        $result = $this->authService->register($userData);

        // Assert
        $this->assertTrue($result['success']);
        $this->assertNotNull($result['user_id']);
        $this->assertEquals('Registrasi berhasil', $result['message']);
    }

    /**
     * Test register with duplicate email
     */
    public function testRegisterDuplicateEmail()
    {
        // Arrange - create first user
        $userData = [
            'username' => 'testuser1_' . time(),
            'email' => 'duplicate_' . time() . '@example.com',
            'password' => 'password123',
            'role' => 'applicant',
        ];
        $this->authService->register($userData);

        // Act - try to create second user with same email
        $userData['username'] = 'testuser2_' . time();
        $result = $this->authService->register($userData);

        // Assert
        $this->assertFalse($result['success']);
        $this->assertStringContainsString('email', strtolower($result['message']));
    }

    /**
     * Test getDashboardRoute for different roles
     */
    public function testGetDashboardRoute()
    {
        // Test admin route
        $route = $this->authService->getDashboardRoute('admin');
        $this->assertEquals('/admin/dashboard', $route);

        // Test panitia route
        $route = $this->authService->getDashboardRoute('panitia');
        $this->assertEquals('/panitia/dashboard', $route);

        // Test bendahara route
        $route = $this->authService->getDashboardRoute('bendahara');
        $this->assertEquals('/bendahara/dashboard', $route);

        // Test sales route
        $route = $this->authService->getDashboardRoute('sales');
        $this->assertEquals('/sales/dashboard', $route);

        // Test applicant route (default)
        $route = $this->authService->getDashboardRoute('applicant');
        $this->assertEquals('/applicant/dashboard', $route);

        // Test unknown role (should default to applicant)
        $route = $this->authService->getDashboardRoute('unknown');
        $this->assertEquals('/applicant/dashboard', $route);
    }

    /**
     * Test isLoggedIn when not logged in
     */
    public function testIsLoggedInWhenNotLoggedIn()
    {
        // Act
        $isLoggedIn = $this->authService->isLoggedIn();

        // Assert
        $this->assertFalse($isLoggedIn);
    }

    /**
     * Test password hashing in register
     */
    public function testRegisterHashesPassword()
    {
        // Arrange
        $plainPassword = 'password123';
        $userData = [
            'username' => 'testuser_' . time(),
            'email' => 'test_' . time() . '@example.com',
            'password' => $plainPassword,
            'role' => 'applicant',
        ];

        // Act
        $result = $this->authService->register($userData);

        // Assert
        $this->assertTrue($result['success']);
        
        // Verify password was hashed (not plain text)
        $userModel = new \App\Models\User();
        $user = $userModel->find($result['user_id']);
        $this->assertNotEquals($plainPassword, $user['password']);
        $this->assertTrue(password_verify($plainPassword, $user['password']));
    }
}
