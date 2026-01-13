<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['username', 'email', 'password', 'role', 'nama', 'is_active'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'email' => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[6]',
        'role' => 'required|in_list[admin,applicant,panitia,bendahara,sales]',
        'nama' => 'permit_empty|string',
        'username' => 'permit_empty|string',
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    public function getByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    public function getByNama($nama)
    {
        return $this->where('nama', $nama)->first();
    }

    /**
     * Get user by username
     */
    public function getByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    /**
     * Get users by role
     */
    public function getByRole($role)
    {
        return $this->where('role', $role)->findAll();
    }

    /**
     * Get all users with pagination
     */
    public function getAllUsers($page = 1, $limit = 15)
    {
        return $this->paginate($limit, 'default', $page);
    }
}
