<?php

namespace App\Models;

use CodeIgniter\Model;

class School extends Model
{
    protected $table = 'schools';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['nama', 'npsn', 'kota', 'provinsi', 'alamat', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'nama' => 'required|string|max_length[100]',
        'npsn' => 'permit_empty|string|max_length[20]',
        'kota' => 'required|string|max_length[50]',
        'provinsi' => 'required|string|max_length[50]',
        'alamat' => 'permit_empty|string|max_length[255]',
    ];

    protected $validationMessages = [
        'nama' => [
            'required' => 'Nama sekolah harus diisi',
            'max_length' => 'Nama sekolah maksimal 100 karakter',
        ],
        'kota' => [
            'required' => 'Kota harus diisi',
            'max_length' => 'Kota maksimal 50 karakter',
        ],
        'provinsi' => [
            'required' => 'Provinsi harus diisi',
            'max_length' => 'Provinsi maksimal 50 karakter',
        ],
    ];

    // Get schools for dropdown
    public function getForDropdown()
    {
        return $this->select('id, nama, npsn, CONCAT(nama, " - ", kota, ", ", provinsi) as display, COALESCE(npsn, "-") as npsn_display')
            ->orderBy('provinsi')
            ->orderBy('kota')
            ->orderBy('nama')
            ->findAll();
    }

    // Get schools by province
    public function getByProvince($provinsi)
    {
        return $this->where('provinsi', $provinsi)
            ->orderBy('kota')
            ->orderBy('nama')
            ->findAll();
    }

    // Get all provinces
    public function getProvinces()
    {
        return $this->distinct()
            ->select('provinsi')
            ->orderBy('provinsi')
            ->findAll();
    }

    // Search schools
    public function search($keyword)
    {
        return $this->like('nama', $keyword)
            ->orLike('kota', $keyword)
            ->orLike('provinsi', $keyword)
            ->orderBy('provinsi')
            ->orderBy('kota')
            ->findAll();
    }

    // Get school info by id
    public function getSchoolInfo($id)
    {
        return $this->find($id);
    }
}
