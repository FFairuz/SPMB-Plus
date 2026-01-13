<?php

namespace App\Services;

use App\Models\User;
use CodeIgniter\HTTP\RedirectResponse;

/**
 * AuthService
 * 
 * Service class untuk menangani business logic authentication
 * Mengikuti Single Responsibility Principle dengan memisahkan logic dari controller
 */
class AuthService
{
    /**
     * @var User
     */
    private $userModel;

    /**
     * @var array Role-based dashboard routes
     */
    private const ROLE_ROUTES = [
        'admin' => '/admin/dashboard',
        'panitia' => '/panitia/dashboard',
        'bendahara' => '/bendahara/dashboard',
        'sales' => '/sales/dashboard',
        'applicant' => '/applicant/dashboard',
    ];

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->userModel = new User();
    }

    /**
     * Authenticate user dengan email dan password
     * 
     * @param string $email User email
     * @param string $password Plain text password
     * @return array ['success' => bool, 'message' => string, 'user' => array|null]
     */
    public function authenticate(string $email, string $password): array
    {
        // Validate input
        if (empty($email) || empty($password)) {
            return $this->failureResponse('Email dan password harus diisi');
        }

        // Get user by email
        $user = $this->userModel->getByEmail($email);

        // Verify user exists
        if (!$user) {
            log_message('info', 'LOGIN FAILED - User not found: ' . $email);
            return $this->failureResponse('Email atau password salah');
        }

        // Verify password
        if (!password_verify($password, $user['password'])) {
            log_message('info', 'LOGIN FAILED - Invalid password: ' . $email);
            return $this->failureResponse('Email atau password salah');
        }

        // Normalize role to avoid whitespace/uppercase mismatch
        $user['role'] = $this->normalizeRole($user['role'] ?? 'applicant');

        // Check if account is active
        if (isset($user['is_active']) && !$user['is_active']) {
            log_message('info', 'LOGIN FAILED - Account inactive: ' . $email);
            return $this->failureResponse('Akun Anda tidak aktif. Hubungi administrator');
        }

        log_message('info', 'LOGIN SUCCESS - Email: ' . $email . ' | Role: ' . $user['role']);

        return [
            'success' => true,
            'message' => 'Login berhasil',
            'user' => $user,
        ];
    }

    /**
     * Create user session
     * 
     * @param array $user User data
     * @return void
     */
    public function createSession(array $user): void
    {
        $normalizedRole = $this->normalizeRole($user['role'] ?? 'applicant');

        $session = session();
        $session->set([
            'user_id' => $user['id'],
            'username' => $user['nama'] ?? $user['email'],
            'email' => $user['email'],
            'role' => $normalizedRole,
            'is_admin' => $normalizedRole === 'admin',
            'is_logged_in' => true,
        ]);
    }

    /**
     * Destroy user session (logout)
     * 
     * @return void
     */
    public function destroySession(): void
    {
        $session = session();
        $session->destroy();
    }

    /**
     * Register new user
     * 
     * @param array $userData User registration data
     * @return array ['success' => bool, 'message' => string, 'user_id' => int|null]
     */
    public function register(array $userData): array
    {
        // Hash password
        if (isset($userData['password'])) {
            $userData['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);
        }

        // Set default role if not provided
        if (!isset($userData['role'])) {
            $userData['role'] = 'applicant';
        }

        // Set default active status
        if (!isset($userData['is_active'])) {
            $userData['is_active'] = 1;
        }

        try {
            $userId = $this->userModel->insert($userData);

            if (!$userId) {
                $errors = $this->userModel->errors();
                $errorMessage = is_array($errors) ? implode(', ', $errors) : 'Gagal membuat akun';
                log_message('error', 'REGISTER FAILED - ' . $errorMessage);
                return $this->failureResponse($errorMessage);
            }

            log_message('info', 'REGISTER SUCCESS - Email: ' . $userData['email'] . ' | User ID: ' . $userId);

            return [
                'success' => true,
                'message' => 'Registrasi berhasil',
                'user_id' => $userId,
            ];
        } catch (\Exception $e) {
            log_message('error', 'REGISTER EXCEPTION - ' . $e->getMessage());
            return $this->failureResponse('Terjadi kesalahan saat registrasi');
        }
    }

    /**
     * Get dashboard route based on user role
     * 
     * @param string $role User role
     * @return string Dashboard route
     */
    public function getDashboardRoute(string $role): string
    {
        $normalizedRole = $this->normalizeRole($role);
        return self::ROLE_ROUTES[$normalizedRole] ?? self::ROLE_ROUTES['applicant'];
    }

    /**
     * Check if user is already logged in
     * 
     * @return bool
     */
    public function isLoggedIn(): bool
    {
        return session()->has('user_id') && session()->get('is_logged_in') === true;
    }

    /**
     * Get current logged in user data
     * 
     * @return array|null
     */
    public function getCurrentUser(): ?array
    {
        if (!$this->isLoggedIn()) {
            return null;
        }

        $userId = session()->get('user_id');
        return $this->userModel->find($userId);
    }

    /**
     * Get current user role
     * 
     * @return string|null
     */
    public function getCurrentUserRole(): ?string
    {
        return session()->get('role');
    }

    /**
     * Redirect to appropriate dashboard based on role
     * 
     * @param string|null $role User role (if null, get from session)
     * @return RedirectResponse
     */
    public function redirectToDashboard(?string $role = null): RedirectResponse
    {
        $userRole = $role ?? $this->getCurrentUserRole();
        $route = $this->getDashboardRoute($userRole ?? 'applicant');
        
        log_message('info', 'REDIRECT: ' . $route . ' for role: ' . $userRole);
        
        return redirect()->to($route);
    }

    /**
     * Create failure response array
     * 
     * @param string $message Error message
     * @return array
     */
    private function failureResponse(string $message): array
    {
        return [
            'success' => false,
            'message' => $message,
            'user' => null,
        ];
    }

    /**
     * Validate user has required role
     * 
     * @param string $requiredRole Required role
     * @return bool
     */
    public function hasRole(string $requiredRole): bool
    {
        $currentRole = $this->getCurrentUserRole();
        return $this->normalizeRole($currentRole ?? '') === $this->normalizeRole($requiredRole);
    }

    /**
     * Check if current user is admin
     * 
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Normalize role string (trim + lowercase)
     */
    private function normalizeRole(?string $role): string
    {
        return strtolower(trim($role ?? '')) ?: 'applicant';
    }
}
