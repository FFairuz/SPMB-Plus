<?php

namespace App\Traits;

use CodeIgniter\Router\Exceptions\RedirectException;

/**
 * Role Authorization Trait
 * 
 * Menyediakan method untuk mengecek dan memverifikasi role pengguna
 */
trait RoleAuthTrait
{
    /**
     * Check apakah user adalah admin
     * 
     * @return bool
     */
    protected function isAdmin(): bool
    {
        return session()->get('role') === 'admin';
    }

    /**
     * Check apakah user adalah panitia
     * 
     * @return bool
     */
    protected function isPanitia(): bool
    {
        return session()->get('role') === 'panitia';
    }

    /**
     * Check apakah user adalah bendahara
     * 
     * @return bool
     */
    protected function isBendahara(): bool
    {
        return session()->get('role') === 'bendahara';
    }

    /**
     * Check apakah user adalah sales
     * 
     * @return bool
     */
    protected function isSales(): bool
    {
        return session()->get('role') === 'sales';
    }

    /**
     * Check apakah user adalah applicant
     * 
     * @return bool
     */
    protected function isApplicant(): bool
    {
        return session()->get('role') === 'applicant';
    }

    /**
     * Require admin role, redirect jika tidak
     * 
     * @return void
     * @throws RedirectException
     */
    protected function requireAdmin()
    {
        if (!$this->isAdmin()) {
            session()->setFlashdata('error', 'Anda tidak memiliki akses ke halaman ini. Hanya admin yang diizinkan.');
            throw new RedirectException($this->fallbackDashboard());
        }
    }

    /**
     * Require panitia role, redirect jika tidak (admin bisa akses juga)
     * 
     * @return void
     * @throws RedirectException
     */
    protected function requirePanitia()
    {
        if (!$this->isPanitia() && !$this->isAdmin()) {
            session()->setFlashdata('error', 'Anda tidak memiliki akses ke halaman ini. Hanya panitia yang diizinkan.');
            throw new RedirectException($this->fallbackDashboard());
        }
    }

    /**
     * Require bendahara role, redirect jika tidak (admin bisa akses juga)
     * 
     * @return void
     * @throws RedirectException
     */
    protected function requireBendahara()
    {
        if (!$this->isBendahara() && !$this->isAdmin()) {
            session()->setFlashdata('error', 'Anda tidak memiliki akses ke halaman ini. Hanya bendahara yang diizinkan.');
            throw new RedirectException($this->fallbackDashboard());
        }
    }

    /**
     * Require sales role, redirect jika tidak (admin bisa akses juga)
     * 
     * @return void
     * @throws RedirectException
     */
    protected function requireSales()
    {
        if (!$this->isSales() && !$this->isAdmin()) {
            session()->setFlashdata('error', 'Anda tidak memiliki akses ke halaman ini. Hanya sales yang diizinkan.');
            throw new RedirectException($this->fallbackDashboard());
        }
    }

    /**
     * Require admin or panitia role
     * 
     * @return void
     * @throws RedirectException
     */
    protected function requireAdminOrPanitia()
    {
        if (!$this->isAdmin() && !$this->isPanitia()) {
            session()->setFlashdata('error', 'Anda tidak memiliki akses. Hanya admin atau panitia yang diizinkan.');
            throw new RedirectException($this->fallbackDashboard());
        }
    }

    /**
     * Require admin or bendahara role
     * 
     * @return void
     * @throws RedirectException
     */
    protected function requireAdminOrBendahara()
    {
        if (!$this->isAdmin() && !$this->isBendahara()) {
            session()->setFlashdata('error', 'Anda tidak memiliki akses. Hanya admin atau bendahara yang diizinkan.');
            throw new RedirectException($this->fallbackDashboard());
        }
    }

    /**
     * Determine fallback dashboard based on current role
     */
    private function fallbackDashboard(): string
    {
        $role = session()->get('role');

        switch ($role) {
            case 'admin':
                return '/admin/dashboard';
            case 'panitia':
                return '/panitia/dashboard';
            case 'bendahara':
                return '/bendahara/dashboard';
            case 'sales':
                return '/sales/dashboard';
            case 'applicant':
                return '/applicant/dashboard';
            default:
                return '/';
        }
    }
}
