<?php

namespace App\Models;

use CodeIgniter\Model;

class Applicant extends Model
{
    protected $table = 'applicants_dapodik';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    protected $allowedFields = [
        'user_id', 'nis', 'nik', 'nama_lengkap', 'nama_panggilan',
        'jenis_kelamin', 'tanggal_lahir', 'tempat_lahir', 'agama',
        'status_keluarga', 'anak_ke', 'jumlah_saudara',
        'alamat_jalan', 'dusun', 'kelurahan', 'kecamatan', 'kabupaten',
        'provinsi', 'kode_pos', 'nomor_telepon', 'nomor_hp',
        'asal_sekolah', 'npsn_sekolah_asal', 'nilai_rata_rata',
        'nilai_un_indo', 'nilai_un_math', 'nilai_un_english', 'nilai_un_science',
        'nama_ayah', 'nik_ayah', 'pendidikan_ayah', 'pekerjaan_ayah',
        'penghasilan_ayah', 'nomor_hp_ayah',
        'nama_ibu', 'nik_ibu', 'pendidikan_ibu', 'pekerjaan_ibu',
        'penghasilan_ibu', 'nomor_hp_ibu',
        'nama_wali', 'hubungan_wali', 'nomor_hp_wali',
        'prestasi_akademik', 'prestasi_non_akademik',
        'kelainan_fisik', 'kebutuhan_khusus_lainnya',
        'nomor_pendaftaran', 'status', 'tanggal_submit', 'dokumen_upload',
        'catatan_verifikasi'
    ];

    protected $validationRules = [
        'nik' => 'required|min_length[16]|max_length[16]',
        'nama_lengkap' => 'required|string|min_length[3]|max_length[255]',
        'jenis_kelamin' => 'required|in_list[laki-laki,perempuan]',
        'tanggal_lahir' => 'required|valid_date[Y-m-d]',
        'tempat_lahir' => 'required|string|min_length[3]',
        'agama' => 'required|in_list[Islam,Kristen,Katolik,Hindu,Buddha,Konghucu,Lainnya]',
        'anak_ke' => 'required|integer|greater_than[0]',
        'jumlah_saudara' => 'required|integer|greater_than_equal_to[0]',
        'alamat_jalan' => 'required|min_length[5]',
        'kelurahan' => 'required|string',
        'kecamatan' => 'required|string',
        'kabupaten' => 'required|string',
        'provinsi' => 'required|string',
        'kode_pos' => 'required|numeric|min_length[5]|max_length[5]',
        'nomor_hp' => 'required|numeric|min_length[10]|max_length[13]',
        'asal_sekolah' => 'required|min_length[5]',
        'nama_ayah' => 'required|string|min_length[3]',
        'nama_ibu' => 'required|string|min_length[3]',
    ];

    protected $validationMessages = [
        'nik' => [
            'required' => 'NIK harus diisi',
            'min_length' => 'NIK harus 16 digit',
            'max_length' => 'NIK harus 16 digit',
        ],
        'nama_lengkap' => [
            'required' => 'Nama lengkap harus diisi',
            'min_length' => 'Nama lengkap minimal 3 karakter',
        ],
        'nomor_hp' => [
            'required' => 'Nomor HP harus diisi',
            'numeric' => 'Nomor HP hanya boleh angka',
            'min_length' => 'Nomor HP minimal 10 digit',
        ],
    ];

    public function getByUser($userId)
    {
        return $this->where('user_id', $userId)->first();
    }

    public function getByNik($nik)
    {
        return $this->where('nik', $nik)->first();
    }

    public function getByNomorPendaftaran($nomor)
    {
        return $this->where('nomor_pendaftaran', $nomor)->first();
    }

    public function generateNomorPendaftaran()
    {
        $tahun = date('Y');
        $bulan = date('m');
        $count = $this->where('created_at >=', date('Y-01-01'))->countAllResults() + 1;
        return 'PPDB-' . $tahun . $bulan . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    public function getApplicantsByStatus($status)
    {
        return $this->where('status', $status)->findAll();
    }

    public function getApplicantsByProvince($provinsi)
    {
        return $this->where('provinsi', $provinsi)->findAll();
    }

    public function getStatistics()
    {
        return [
            'total' => $this->countAllResults(),
            'draft' => $this->where('status', 'draft')->countAllResults(),
            'submitted' => $this->where('status', 'submitted')->countAllResults(),
            'verified' => $this->where('status', 'verified')->countAllResults(),
            'accepted' => $this->where('status', 'diterima')->countAllResults(),
            'rejected' => $this->where('status', 'ditolak')->countAllResults(),
        ];
    }

    /**
     * Get applicant by user ID
     * 
     * @param int $userId User ID
     * @return array|null
     */
    public function getApplicantByUserId($userId)
    {
        return $this->getByUser($userId);
    }
}
