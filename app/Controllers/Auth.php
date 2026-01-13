<?php

namespace App\Controllers;

use App\Services\AuthService;

/**
 * Auth Controller
 * 
 * Handles user authentication (login, register, logout)
 * Menggunakan AuthService untuk business logic
 */
class Auth extends BaseController
{
    /**
     * @var AuthService
     */
    private $authService;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->authService = new AuthService();
    }

    /**
     * Display login page and handle login submission
     * 
     * @return mixed
     */
    public function login()
    {
        // Redirect if already logged in
        if ($this->authService->isLoggedIn()) {
            return $this->authService->redirectToDashboard();
        }

        // Handle POST request
        if ($this->request->getMethod() === 'post') {
            return $this->processLogin();
        }

        return view('auth/login');
    }

    /**
     * Process login form submission
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     */
    private function processLogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Authenticate user
        $result = $this->authService->authenticate($email, $password);

        if (!$result['success']) {
            session()->setFlashdata('error', $result['message']);
            return view('auth/login');
        }

        // Create session
        $this->authService->createSession($result['user']);

        // Redirect to dashboard
        return $this->authService->redirectToDashboard($result['user']['role']);
    }

    /**
     * Display registration page and handle registration submission
     * 
     * @return mixed
     */
    public function register()
    {
        // Redirect if already logged in
        if ($this->authService->isLoggedIn()) {
            return $this->authService->redirectToDashboard();
        }

        // Handle POST request
        if ($this->request->getMethod() === 'post') {
            return $this->processRegistration();
        }

        return view('auth/register');
    }

    /**
     * Process registration form submission
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     */
    private function processRegistration()
    {
        // Validation rules
        $rules = [
            'username' => 'required|alpha_numeric_space|min_length[3]|max_length[100]|is_unique[users.username]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return view('auth/register', ['errors' => $this->validator->getErrors()]);
        }

        // Prepare user data
        $userData = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'role' => 'applicant',
        ];

        // Register user
        $result = $this->authService->register($userData);

        if (!$result['success']) {
            session()->setFlashdata('error', $result['message']);
            return view('auth/register');
        }

        session()->setFlashdata('success', 'Registrasi berhasil! Silakan login.');
        return redirect()->to('/auth/login');
    }

    /**
     * Logout user
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function logout()
    {
        $this->authService->destroySession();
        session()->setFlashdata('success', 'Anda berhasil logout');
        return redirect()->to('/auth/login');
    }
}
