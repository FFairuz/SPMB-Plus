<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * MajorQuota Model
 * 
 * Model untuk tabel major_quotas
 * Mengelola kuota jurusan per tahun ajaran dan jalur pendaftaran
 */
class MajorQuota extends Model
{
    protected $table = 'major_quotas';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'major_id',
        'tahun_ajaran',
        'kuota_total',
        'kuota_terisi',
        'jalur_reguler',
        'jalur_prestasi',
        'jalur_afirmasi',
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
        'major_id' => 'required|integer',
        'tahun_ajaran' => 'required|min_length[7]|max_length[20]',
        'kuota_total' => 'required|integer|greater_than_equal_to[0]',
        'jalur_reguler' => 'permit_empty|integer|greater_than_equal_to[0]',
        'jalur_prestasi' => 'permit_empty|integer|greater_than_equal_to[0]',
        'jalur_afirmasi' => 'permit_empty|integer|greater_than_equal_to[0]',
        'status' => 'required|in_list[aktif,nonaktif]',
    ];

    protected $validationMessages = [
        'major_id' => [
            'required' => 'Jurusan harus dipilih',
            'integer' => 'ID jurusan tidak valid',
        ],
        'tahun_ajaran' => [
            'required' => 'Tahun ajaran harus diisi',
            'min_length' => 'Format tahun ajaran tidak valid (misal: 2026/2027)',
        ],
        'kuota_total' => [
            'required' => 'Kuota total harus diisi',
            'integer' => 'Kuota total harus berupa angka',
            'greater_than_equal_to' => 'Kuota total tidak boleh negatif',
        ],
    ];

    /**
     * Get quota dengan informasi jurusan
     */
    public function getQuotaWithMajor($id = null)
    {
        $builder = $this->select('major_quotas.*, majors.nama_jurusan, majors.kode_jurusan')
            ->join('majors', 'majors.id = major_quotas.major_id');

        if ($id) {
            return $builder->where('major_quotas.id', $id)->first();
        }

        return $builder->orderBy('majors.nama_jurusan', 'ASC')
            ->orderBy('major_quotas.tahun_ajaran', 'DESC')
            ->findAll();
    }

    /**
     * Get quota by major dan tahun ajaran
     */
    public function getQuotaByMajorAndYear($majorId, $tahunAjaran)
    {
        return $this->where('major_id', $majorId)
            ->where('tahun_ajaran', $tahunAjaran)
            ->first();
    }

    /**
     * Get active quotas untuk tahun ajaran tertentu
     */
    public function getActiveQuotas($tahunAjaran = null)
    {
        $builder = $this->select('major_quotas.*, majors.nama_jurusan, majors.kode_jurusan')
            ->join('majors', 'majors.id = major_quotas.major_id')
            ->where('major_quotas.status', 'aktif')
            ->where('majors.status', 'aktif');

        if ($tahunAjaran) {
            $builder->where('major_quotas.tahun_ajaran', $tahunAjaran);
        }

        return $builder->orderBy('majors.nama_jurusan', 'ASC')->findAll();
    }

    /**
     * Get statistik kuota per jurusan
     */
    public function getQuotaStats($tahunAjaran = null)
    {
        $builder = $this->select('
                major_quotas.*,
                majors.nama_jurusan,
                majors.kode_jurusan,
                (major_quotas.kuota_total - major_quotas.kuota_terisi) as sisa_kuota,
                ROUND((major_quotas.kuota_terisi / major_quotas.kuota_total * 100), 2) as persentase_terisi
            ')
            ->join('majors', 'majors.id = major_quotas.major_id')
            ->where('major_quotas.status', 'aktif');

        if ($tahunAjaran) {
            $builder->where('major_quotas.tahun_ajaran', $tahunAjaran);
        }

        return $builder->orderBy('majors.nama_jurusan', 'ASC')->findAll();
    }

    /**
     * Increment kuota terisi
     */
    public function incrementQuotaTerisi($id, $amount = 1)
    {
        $quota = $this->find($id);
        if (!$quota) {
            return false;
        }

        $newTerisi = $quota['kuota_terisi'] + $amount;

        // Cek jangan sampai melebihi kuota total
        if ($newTerisi > $quota['kuota_total']) {
            return false;
        }

        return $this->update($id, ['kuota_terisi' => $newTerisi]);
    }

    /**
     * Decrement kuota terisi
     */
    public function decrementQuotaTerisi($id, $amount = 1)
    {
        $quota = $this->find($id);
        if (!$quota) {
            return false;
        }

        $newTerisi = max(0, $quota['kuota_terisi'] - $amount);
        return $this->update($id, ['kuota_terisi' => $newTerisi]);
    }

    /**
     * Cek apakah kuota masih tersedia
     */
    public function isQuotaAvailable($majorId, $tahunAjaran)
    {
        $quota = $this->getQuotaByMajorAndYear($majorId, $tahunAjaran);
        
        if (!$quota || $quota['status'] !== 'aktif') {
            return false;
        }

        return $quota['kuota_terisi'] < $quota['kuota_total'];
    }

    /**
     * Get daftar tahun ajaran yang tersedia
     */
    public function getAvailableYears()
    {
        return $this->select('tahun_ajaran')
            ->distinct()
            ->orderBy('tahun_ajaran', 'DESC')
            ->findColumn('tahun_ajaran');
    }
}
