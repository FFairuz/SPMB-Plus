<?php

namespace App\Repositories;

use App\Models\Applicant;

/**
 * Applicant Repository
 * 
 * Repository untuk menangani data access layer dari tabel applicants_dapodik.
 * Menyediakan fungsi-fungsi khusus untuk query applicant.
 */
class ApplicantRepository extends BaseRepository
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(new Applicant());
    }

    /**
     * Mendapatkan applicant berdasarkan user ID
     * 
     * @param int $userId User ID
     * @return array|null
     */
    public function getByUser($userId)
    {
        return $this->findBy(['user_id' => $userId]);
    }

    /**
     * Mendapatkan applicant berdasarkan NIK
     * 
     * @param string $nik NIK
     * @return array|null
     */
    public function getByNik($nik)
    {
        return $this->findBy(['nik' => $nik]);
    }

    /**
     * Mendapatkan applicant berdasarkan nomor pendaftaran
     * 
     * @param string $nomor Nomor pendaftaran
     * @return array|null
     */
    public function getByNomorPendaftaran($nomor)
    {
        return $this->findBy(['nomor_pendaftaran' => $nomor]);
    }

    /**
     * Mendapatkan semua applicant dengan status tertentu
     * 
     * @param string $status Status applicant
     * @param array $options Opsi tambahan (limit, offset, orderBy)
     * @return array
     */
    public function getByStatus($status, array $options = [])
    {
        return $this->findAllBy(['status' => $status], $options);
    }

    /**
     * Mendapatkan semua applicant dari provinsi tertentu
     * 
     * @param string $provinsi Nama provinsi
     * @param array $options Opsi tambahan
     * @return array
     */
    public function getByProvince($provinsi, array $options = [])
    {
        return $this->findAllBy(['provinsi' => $provinsi], $options);
    }

    /**
     * Mendapatkan semua applicant dari kabupaten tertentu
     * 
     * @param string $kabupaten Nama kabupaten
     * @param array $options Opsi tambahan
     * @return array
     */
    public function getByRegency($kabupaten, array $options = [])
    {
        return $this->findAllBy(['kabupaten' => $kabupaten], $options);
    }

    /**
     * Mendapatkan applicant dengan berbagai filter
     * 
     * @param array $filters Filter conditions
     * @param array $options Opsi pagination dan sorting
     * @return array
     */
    public function getFiltered(array $filters = [], array $options = [])
    {
        $conditions = [];
        
        if (isset($filters['status'])) {
            $conditions['status'] = $filters['status'];
        }
        if (isset($filters['provinsi'])) {
            $conditions['provinsi'] = $filters['provinsi'];
        }
        if (isset($filters['kabupaten'])) {
            $conditions['kabupaten'] = $filters['kabupaten'];
        }
        if (isset($filters['agama'])) {
            $conditions['agama'] = $filters['agama'];
        }
        if (isset($filters['jenis_kelamin'])) {
            $conditions['jenis_kelamin'] = $filters['jenis_kelamin'];
        }

        // Default orderBy
        if (!isset($options['orderBy'])) {
            $options['orderBy'] = ['created_at' => 'DESC'];
        }

        return $this->findAllBy($conditions, $options);
    }

    /**
     * Generate nomor pendaftaran yang unik
     * 
     * @return string
     */
    public function generateNomorPendaftaran()
    {
        $tahun = date('Y');
        $bulan = date('m');
        $count = $this->countBy() + 1;
        return 'PPDB-' . $tahun . $bulan . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Mendapatkan statistik applicants
     * 
     * @return array
     */
    public function getStatistics()
    {
        return [
            'total' => $this->countBy(),
            'draft' => $this->countBy(['status' => 'draft']),
            'submitted' => $this->countBy(['status' => 'submitted']),
            'verified' => $this->countBy(['status' => 'verified']),
            'accepted' => $this->countBy(['status' => 'diterima']),
            'rejected' => $this->countBy(['status' => 'ditolak']),
        ];
    }

    /**
     * Mendapatkan statistik berdasarkan provinsi
     * 
     * @return array
     */
    public function getStatisticsByProvince()
    {
        return $this->model
            ->select('provinsi, COUNT(*) as total')
            ->groupBy('provinsi')
            ->orderBy('total', 'DESC')
            ->findAll();
    }

    /**
     * Update status applicant
     * 
     * @param int $id Applicant ID
     * @param string $status Status baru
     * @param string|null $catatan Catatan verifikasi (optional)
     * @return bool
     */
    public function updateStatus($id, $status, $catatan = null)
    {
        $data = [
            'status' => $status,
        ];

        if ($status === 'submitted') {
            $data['tanggal_submit'] = date('Y-m-d H:i:s');
        }

        if ($catatan !== null) {
            $data['catatan_verifikasi'] = $catatan;
        }

        return $this->update($id, $data);
    }

    /**
     * Mendapatkan applicants dengan nilai tertinggi
     * 
     * @param int $limit Jumlah record
     * @return array
     */
    public function getTopApplicants($limit = 10)
    {
        return $this->model
            ->where('status', 'submitted')
            ->orderBy('nilai_rata_rata', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    /**
     * Mendapatkan applicants berdasarkan range tanggal lahir (untuk grup usia)
     * 
     * @param string $startDate Format Y-m-d
     * @param string $endDate Format Y-m-d
     * @param array $options Opsi tambahan
     * @return array
     */
    public function getByBirthDateRange($startDate, $endDate, array $options = [])
    {
        $query = $this->model
            ->where('tanggal_lahir >=', $startDate)
            ->where('tanggal_lahir <=', $endDate);

        if (isset($options['orderBy'])) {
            foreach ($options['orderBy'] as $field => $direction) {
                $query = $query->orderBy($field, $direction);
            }
        }

        return $query->findAll();
    }

    /**
     * Cek apakah NIK sudah terdaftar
     * 
     * @param string $nik NIK yang dicek
     * @param int|null $excludeId Exclude ID tertentu (untuk update)
     * @return bool
     */
    public function isNikExists($nik, $excludeId = null)
    {
        $query = $this->model->where('nik', $nik);
        if ($excludeId) {
            $query = $query->where('id !=', $excludeId);
        }
        return $query->countAllResults() > 0;
    }

    /**
     * Cek apakah nomor pendaftaran exists
     * 
     * @param string $nomor Nomor pendaftaran
     * @return bool
     */
    public function isNomorPendaftaranExists($nomor)
    {
        return $this->model->where('nomor_pendaftaran', $nomor)->countAllResults() > 0;
    }

    /**
     * Mendapatkan data dengan relasi user
     * 
     * @param int $id Applicant ID
     * @return array|null
     */
    public function getWithUser($id)
    {
        // Ini bisa dikembangkan untuk join dengan tabel users jika diperlukan
        return $this->findById($id);
    }
}
