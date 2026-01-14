<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Major Model
 * 
 * Model untuk tabel majors (jurusan)
 * Digunakan untuk mengelola data jurusan yang tersedia
 */
class Major extends Model
{
    protected $table = 'majors';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'kode_jurusan',
        'nama_jurusan',
        'deskripsi',
        'kuota',
        'status',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'kode_jurusan' => 'required|min_length[2]|max_length[20]|is_unique[majors.kode_jurusan,id,{id}]',
        'nama_jurusan' => 'required|min_length[3]|max_length[255]',
        'kuota' => 'permit_empty|integer|greater_than[0]',
        'status' => 'required|in_list[aktif,nonaktif]',
    ];

    protected $validationMessages = [
        'kode_jurusan' => [
            'required' => 'Kode jurusan harus diisi',
            'is_unique' => 'Kode jurusan sudah digunakan',
        ],
        'nama_jurusan' => [
            'required' => 'Nama jurusan harus diisi',
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
     * Get active majors only
     * 
     * @return array
     */
    public function getActiveMajors()
    {
        return $this->where('status', 'aktif')
            ->orderBy('nama_jurusan', 'ASC')
            ->findAll();
    }

    /**
     * Get major with applicant count
     * 
     * @param int|null $id Optional major ID
     * @return array
     */
    public function getMajorWithStats($id = null)
    {
        $builder = $this->db->table('majors')
            ->select('majors.*, COUNT(applicants_dapodik.id) as total_applicants')
            ->join('applicants_dapodik', 'applicants_dapodik.jurusan_id = majors.id', 'left')
            ->groupBy('majors.id');

        if ($id) {
            $builder->where('majors.id', $id);
            return $builder->get()->getRowArray();
        }

        return $builder->get()->getResultArray();
    }

    /**
     * Check if major code is available
     * 
     * @param string $kode_jurusan
     * @param int|null $excludeId
     * @return bool
     */
    public function isKodeAvailable($kode_jurusan, $excludeId = null)
    {
        $builder = $this->where('kode_jurusan', $kode_jurusan);
        
        if ($excludeId) {
            $builder->where('id !=', $excludeId);
        }

        return $builder->countAllResults() === 0;
    }

    /**
     * Get remaining quota for a major
     * 
     * @param int $majorId
     * @return int|null
     */
    public function getRemainingQuota($majorId)
    {
        $major = $this->find($majorId);
        if (!$major || !$major['kuota']) {
            return null;
        }

        $applicantModel = new \App\Models\Applicant();
        $totalApplicants = $applicantModel
            ->where('jurusan_id', $majorId)
            ->whereIn('status', ['submitted', 'verified', 'lulus', 'diterima'])
            ->countAllResults();

        return max(0, $major['kuota'] - $totalApplicants);
    }
}
