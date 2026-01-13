<?php

namespace App\Models;

use CodeIgniter\Model;

class KopSurat extends Model
{
    protected $table = 'kop_surat';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['school_name', 'address', 'phone', 'email', 'npsn', 'logo_path'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'school_name' => 'required|string|max_length[255]',
        'address' => 'permit_empty|string|max_length[500]',
        'phone' => 'permit_empty|string|max_length[20]',
        'email' => 'permit_empty|valid_email',
        'npsn' => 'permit_empty|string|max_length[20]',
        'logo_path' => 'permit_empty|string|max_length[255]',
    ];

    protected $validationMessages = [
        'school_name' => [
            'required' => 'Nama sekolah harus diisi.',
            'max_length' => 'Nama sekolah maksimal 255 karakter.',
        ],
        'email' => [
            'valid_email' => 'Format email tidak valid.',
        ],
    ];

    public function getKopSurat()
    {
        return $this->first();
    }
}
