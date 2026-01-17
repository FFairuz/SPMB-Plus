<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * AcademicYear Model
 * 
 * Model untuk tabel academic_years
 * Mengelola data tahun ajaran
 */
class AcademicYear extends Model
{
    protected $table = 'academic_years';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'tahun_ajaran',
        'tahun_mulai',
        'tahun_selesai',
        'tanggal_mulai',
        'tanggal_selesai',
        'is_active',
        'status',
        'keterangan',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'tahun_ajaran' => 'required|min_length[7]|max_length[20]|is_unique[academic_years.tahun_ajaran,id,{id}]',
        'tahun_mulai' => 'required|exact_length[4]|numeric',
        'tahun_selesai' => 'required|exact_length[4]|numeric',
        'status' => 'required|in_list[aktif,nonaktif,selesai]',
    ];

    protected $validationMessages = [
        'tahun_ajaran' => [
            'required' => 'Tahun ajaran harus diisi',
            'is_unique' => 'Tahun ajaran sudah ada',
        ],
        'tahun_mulai' => [
            'required' => 'Tahun mulai harus diisi',
            'exact_length' => 'Tahun mulai harus 4 digit',
            'numeric' => 'Tahun mulai harus berupa angka',
        ],
        'tahun_selesai' => [
            'required' => 'Tahun selesai harus diisi',
            'exact_length' => 'Tahun selesai harus 4 digit',
            'numeric' => 'Tahun selesai harus berupa angka',
        ],
    ];

    /**
     * Get active academic year
     */
    public function getActiveYear()
    {
        return $this->where('is_active', true)->first();
    }

    /**
     * Set active academic year
     */
    public function setActiveYear($id)
    {
        // Set semua tahun ajaran menjadi tidak aktif
        $this->set('is_active', false)->update();
        
        // Set tahun ajaran tertentu menjadi aktif
        return $this->update($id, ['is_active' => true]);
    }

    /**
     * Get all active academic years
     */
    public function getActiveYears()
    {
        return $this->where('status', 'aktif')
            ->orderBy('tahun_mulai', 'DESC')
            ->findAll();
    }

    /**
     * Get academic years list for dropdown
     */
    public function getYearsList()
    {
        $years = $this->where('status', 'aktif')
            ->orderBy('tahun_mulai', 'DESC')
            ->findAll();
        
        $list = [];
        foreach ($years as $year) {
            $list[$year['id']] = $year['tahun_ajaran'];
        }
        
        return $list;
    }

    /**
     * Generate tahun ajaran string from years
     */
    public static function generateTahunAjaran($tahunMulai, $tahunSelesai)
    {
        return $tahunMulai . '/' . $tahunSelesai;
    }

    /**
     * Check if tahun ajaran overlaps with existing ones
     */
    public function checkOverlap($tahunMulai, $tahunSelesai, $excludeId = null)
    {
        $builder = $this->builder();
        
        $builder->groupStart()
            ->where('tahun_mulai <=', $tahunMulai)
            ->where('tahun_selesai >=', $tahunMulai)
            ->groupEnd()
            ->orGroupStart()
            ->where('tahun_mulai <=', $tahunSelesai)
            ->where('tahun_selesai >=', $tahunSelesai)
            ->groupEnd()
            ->orGroupStart()
            ->where('tahun_mulai >=', $tahunMulai)
            ->where('tahun_selesai <=', $tahunSelesai)
            ->groupEnd();
        
        if ($excludeId) {
            $builder->where('id !=', $excludeId);
        }
        
        return $builder->get()->getResultArray();
    }

    /**
     * Get statistics
     */
    public function getStatistics($yearId = null)
    {
        if (!$yearId) {
            $activeYear = $this->getActiveYear();
            if (!$activeYear) {
                return null;
            }
            $yearId = $activeYear['id'];
        }
        
        $year = $this->find($yearId);
        if (!$year) {
            return null;
        }

        // Count quotas for this year
        $quotaModel = new \App\Models\MajorQuota();
        $quotas = $quotaModel->where('tahun_ajaran', $year['tahun_ajaran'])
            ->where('status', 'aktif')
            ->findAll();
        
        $totalKuota = 0;
        $totalTerisi = 0;
        
        foreach ($quotas as $quota) {
            $totalKuota += $quota['kuota_total'];
            $totalTerisi += $quota['kuota_terisi'];
        }
        
        return [
            'year' => $year,
            'total_kuota' => $totalKuota,
            'total_terisi' => $totalTerisi,
            'total_sisa' => $totalKuota - $totalTerisi,
            'persentase' => $totalKuota > 0 ? round(($totalTerisi / $totalKuota) * 100, 2) : 0,
            'jumlah_jurusan' => count($quotas),
        ];
    }
}
