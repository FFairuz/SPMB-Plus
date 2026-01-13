<?php

namespace App\Models;

use CodeIgniter\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['name', 'display_name', 'description'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Get role by name
     */
    public function getByName($name)
    {
        return $this->where('name', $name)->first();
    }

    /**
     * Get all roles as key-value pairs
     */
    public function getAllAsKeyValue()
    {
        $roles = $this->findAll();
        $result = [];
        foreach ($roles as $role) {
            $result[$role['name']] = $role['display_name'];
        }
        return $result;
    }

    /**
     * Get role names list
     */
    public function getRoleNames()
    {
        return $this->select('name')->findColumn('name');
    }
}
