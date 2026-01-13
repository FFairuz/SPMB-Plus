<?php

namespace App\Models;

use CodeIgniter\Model;

class GuestBook extends Model
{
    protected $table = 'guest_books';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['nama', 'school_id', 'no_hp', 'sumber_info', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'nama' => 'required|string|max_length[100]',
        'school_id' => 'required|integer|is_not_unique[schools.id]',
        'no_hp' => 'required|string|max_length[15]',
        'sumber_info' => 'required|string|max_length[100]',
    ];

    protected $validationMessages = [
        'nama' => [
            'required' => 'Nama harus diisi',
            'max_length' => 'Nama maksimal 100 karakter',
        ],
        'school_id' => [
            'required' => 'Asal sekolah harus dipilih',
            'is_not_unique' => 'Sekolah tidak ditemukan',
        ],
        'no_hp' => [
            'required' => 'Nomor HP harus diisi',
            'max_length' => 'Nomor HP maksimal 15 karakter',
        ],
        'sumber_info' => [
            'required' => 'Sumber informasi harus diisi',
            'max_length' => 'Sumber informasi maksimal 100 karakter',
        ],
    ];

    // Get statistics for dashboard
    public function getStatistics()
    {
        $db = \Config\Database::connect();
        
        $todayResult = $db->query("SELECT COUNT(*) as count FROM guest_books WHERE DATE(created_at) = DATE(NOW())")->getRow();
        $todayCount = $todayResult ? $todayResult->count : 0;
        
        $thisMonthResult = $db->query("SELECT COUNT(*) as count FROM guest_books WHERE MONTH(created_at) = MONTH(NOW()) AND YEAR(created_at) = YEAR(NOW())")->getRow();
        $thisMonthCount = $thisMonthResult ? $thisMonthResult->count : 0;
        
        return [
            'total' => $this->countAll(),
            'today' => $todayCount,
            'this_month' => $thisMonthCount,
        ];
    }

    // Get data grouped by sumber_info
    public function getSourceStatistics()
    {
        return $this->select('sumber_info, COUNT(*) as count')
            ->groupBy('sumber_info')
            ->findAll();
    }

    // Get data grouped by school
    public function getSchoolStatistics()
    {
        return $this->select('schools.nama as asal_sekolah, COUNT(guest_books.id) as count')
            ->join('schools', 'guest_books.school_id = schools.id')
            ->groupBy('guest_books.school_id')
            ->orderBy('count', 'DESC')
            ->limit(10)
            ->findAll();
    }

    // Get all with pagination and school info
    public function getPaginated($perPage = 20)
    {
        return $this->select('guest_books.*, schools.nama as asal_sekolah, schools.kota, schools.provinsi')
            ->join('schools', 'guest_books.school_id = schools.id', 'left')
            ->paginate($perPage);
    }

    // Get all with school info
    public function getAllWithSchool()
    {
        return $this->select('guest_books.*, schools.nama as asal_sekolah, schools.kota, schools.provinsi')
            ->join('schools', 'guest_books.school_id = schools.id', 'left')
            ->findAll();
    }

    // Get total count
    public function getTotalCount()
    {
        return $this->countAll();
    }
}
