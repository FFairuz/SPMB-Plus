<?php

namespace App\Traits;

use CodeIgniter\Exceptions\PageNotFoundException;

/**
 * Trait untuk authentication handling
 * 
 * Menyediakan method helper untuk check authentication dan authorization.
 */
trait AuthTrait
{
    /**
     * Check apakah user sudah login
     * 
     * @return bool
     */
    protected function isLoggedIn()
    {
        return session()->has('user_id');
    }

    /**
     * Get current user ID
     * 
     * @return int|null
     */
    protected function getUserId()
    {
        return session()->get('user_id');
    }

    /**
     * Get current user data
     * 
     * @return array|null
     */
    protected function getUser()
    {
        return session()->get('user');
    }

    /**
     * Get current user role
     * 
     * @return string|null
     */
    protected function getUserRole()
    {
        return session()->get('role');
    }

    /**
     * Check apakah user memiliki role tertentu
     * 
     * @param string $role Role yang dicek
     * @return bool
     */
    protected function hasRole($role)
    {
        $userRole = $this->getUserRole();
        return $userRole === $role;
    }

    /**
     * Check apakah user adalah admin
     * 
     * @return bool
     */
    protected function isAdmin()
    {
        return $this->hasRole('admin');
    }

    /**
     * Require login, redirect jika tidak login
     * 
     * @return void
     */
    protected function requireLogin()
    {
        if (!$this->isLoggedIn()) {
            return redirect()->to('/auth/login')->send();
        }
    }

    /**
     * Require admin role, throw 403 jika tidak admin
     * 
     * @return void
     * @throws PageNotFoundException
     */
    protected function requireAdmin()
    {
        if (!$this->isAdmin()) {
            throw new PageNotFoundException('Access Denied');
        }
    }

    /**
     * Require specific role
     * 
     * @param string $role Role yang dibutuhkan
     * @return void
     * @throws PageNotFoundException
     */
    protected function requireRole($role)
    {
        if (!$this->hasRole($role)) {
            throw new PageNotFoundException('Access Denied');
        }
    }
}
