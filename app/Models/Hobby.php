<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Hobby Model
 * 
 * Model untuk tabel hobbies (master data hobi)
 * Digunakan untuk mengelola data hobi yang tersedia
 */
class Hobby extends Model
{
    protected $table = 'hobbies';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'nama_hobi',
        'icon',
        'status',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'nama_hobi' => 'required|min_length[3]|max_length[100]|is_unique[hobbies.nama_hobi,id,{id}]',
        'icon' => 'permit_empty|max_length[50]',
        'status' => 'required|in_list[aktif,nonaktif]',
    ];

    protected $validationMessages = [
        'nama_hobi' => [
            'required' => 'Nama hobi harus diisi',
            'is_unique' => 'Nama hobi sudah digunakan',
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    /**
     * Get active hobbies only
     * 
     * @return array
     */
    public function getActiveHobbies()
    {
        return $this->where('status', 'aktif')
            ->orderBy('nama_hobi', 'ASC')
            ->findAll();
    }

    /**
     * Get hobby with applicant count
     * 
     * @param int|null $id Optional hobby ID
     * @return array
     */
    public function getHobbyWithStats($id = null)
    {
        $builder = $this->db->table('hobbies')
            ->select('hobbies.*, COUNT(applicant_hobbies.id) as total_applicants')
            ->join('applicant_hobbies', 'applicant_hobbies.hobby_id = hobbies.id', 'left')
            ->groupBy('hobbies.id');

        if ($id) {
            $builder->where('hobbies.id', $id);
            return $builder->get()->getRowArray();
        }

        return $builder->get()->getResultArray();
    }

    /**
     * Check if hobby name is available
     * 
     * @param string $nama_hobi
     * @param int|null $excludeId
     * @return bool
     */
    public function isNamaAvailable($nama_hobi, $excludeId = null)
    {
        $builder = $this->where('nama_hobi', $nama_hobi);
        
        if ($excludeId) {
            $builder->where('id !=', $excludeId);
        }

        return $builder->countAllResults() === 0;
    }
}
