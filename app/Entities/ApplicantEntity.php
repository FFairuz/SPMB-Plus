<?php

namespace App\Entities;

/**
 * Applicant Entity
 * 
 * Represents an applicant entity dengan type-safe properties dan methods.
 * Digunakan untuk better type handling dan data integrity.
 */
class ApplicantEntity
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $user_id;

    /**
     * @var string
     */
    public $nomor_pendaftaran;

    /**
     * @var string
     */
    public $nik;

    /**
     * @var string
     */
    public $nis;

    /**
     * @var string
     */
    public $nama_lengkap;

    /**
     * @var string
     */
    public $nama_panggilan;

    /**
     * @var string
     */
    public $jenis_kelamin; // laki-laki, perempuan

    /**
     * @var string Date Y-m-d
     */
    public $tanggal_lahir;

    /**
     * @var string
     */
    public $tempat_lahir;

    /**
     * @var string
     */
    public $agama;

    /**
     * @var string
     */
    public $status_keluarga;

    /**
     * @var int
     */
    public $anak_ke;

    /**
     * @var int
     */
    public $jumlah_saudara;

    /**
     * @var string
     */
    public $alamat_jalan;

    /**
     * @var string
     */
    public $dusun;

    /**
     * @var string
     */
    public $kelurahan;

    /**
     * @var string
     */
    public $kecamatan;

    /**
     * @var string
     */
    public $kabupaten;

    /**
     * @var string
     */
    public $provinsi;

    /**
     * @var string
     */
    public $kode_pos;

    /**
     * @var string
     */
    public $nomor_telepon;

    /**
     * @var string
     */
    public $nomor_hp;

    /**
     * @var string
     */
    public $asal_sekolah;

    /**
     * @var string
     */
    public $npsn_sekolah_asal;

    /**
     * @var float
     */
    public $nilai_rata_rata;

    /**
     * @var float
     */
    public $nilai_un_indo;

    /**
     * @var float
     */
    public $nilai_un_math;

    /**
     * @var float
     */
    public $nilai_un_english;

    /**
     * @var float
     */
    public $nilai_un_science;

    /**
     * @var string
     */
    public $nama_ayah;

    /**
     * @var string
     */
    public $nik_ayah;

    /**
     * @var string
     */
    public $pendidikan_ayah;

    /**
     * @var string
     */
    public $pekerjaan_ayah;

    /**
     * @var string
     */
    public $penghasilan_ayah;

    /**
     * @var string
     */
    public $nomor_hp_ayah;

    /**
     * @var string
     */
    public $nama_ibu;

    /**
     * @var string
     */
    public $nik_ibu;

    /**
     * @var string
     */
    public $pendidikan_ibu;

    /**
     * @var string
     */
    public $pekerjaan_ibu;

    /**
     * @var string
     */
    public $penghasilan_ibu;

    /**
     * @var string
     */
    public $nomor_hp_ibu;

    /**
     * @var string
     */
    public $nama_wali;

    /**
     * @var string
     */
    public $hubungan_wali;

    /**
     * @var string
     */
    public $nomor_hp_wali;

    /**
     * @var string
     */
    public $prestasi_akademik;

    /**
     * @var string
     */
    public $prestasi_non_akademik;

    /**
     * @var string
     */
    public $kelainan_fisik;

    /**
     * @var string
     */
    public $kebutuhan_khusus_lainnya;

    /**
     * @var string Status: draft, submitted, verified, diterima, ditolak
     */
    public $status;

    /**
     * @var string
     */
    public $tanggal_submit;

    /**
     * @var string
     */
    public $dokumen_upload;

    /**
     * @var string
     */
    public $catatan_verifikasi;

    /**
     * @var string Timestamp
     */
    public $created_at;

    /**
     * @var string Timestamp
     */
    public $updated_at;

    /**
     * Constructor
     * 
     * @param array $data Data untuk initialize entity
     */
    public function __construct(array $data = [])
    {
        $this->fill($data);
    }

    /**
     * Fill entity dengan data array
     * 
     * @param array $data
     * @return self
     */
    public function fill(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }

        return $this;
    }

    /**
     * Convert entity to array
     * 
     * @return array
     */
    public function toArray()
    {
        $array = [];
        $reflection = new \ReflectionClass($this);

        foreach ($reflection->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            $array[$property->getName()] = $property->getValue($this);
        }

        return $array;
    }

    /**
     * Get nama lengkap dengan format
     * 
     * @return string
     */
    public function getNamaLengkap()
    {
        return $this->nama_lengkap;
    }

    /**
     * Get usia (calculated from tanggal_lahir)
     * 
     * @return int
     */
    public function getUsia()
    {
        if (!$this->tanggal_lahir) {
            return 0;
        }

        $birthDate = new \DateTime($this->tanggal_lahir);
        $today = new \DateTime();
        $age = $today->diff($birthDate);

        return $age->y;
    }

    /**
     * Get status label dalam bahasa Indonesia
     * 
     * @return string
     */
    public function getStatusLabel()
    {
        $labels = [
            'draft' => 'Draft',
            'submitted' => 'Sudah Disubmit',
            'verified' => 'Terverifikasi',
            'diterima' => 'Diterima',
            'ditolak' => 'Ditolak',
        ];

        return $labels[$this->status] ?? $this->status;
    }

    /**
     * Check if applicant is complete
     * 
     * @return bool
     */
    public function isComplete()
    {
        $requiredFields = [
            'nik', 'nama_lengkap', 'jenis_kelamin', 'tanggal_lahir', 'tempat_lahir',
            'agama', 'alamat_jalan', 'kelurahan', 'kecamatan', 'kabupaten',
            'provinsi', 'nomor_hp', 'asal_sekolah', 'nama_ayah', 'nama_ibu'
        ];

        foreach ($requiredFields as $field) {
            if (empty($this->$field)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get validation errors
     * 
     * @return array
     */
    public function getValidationErrors()
    {
        $errors = [];

        if (empty($this->nik) || strlen($this->nik) !== 16) {
            $errors['nik'] = 'NIK harus 16 digit';
        }

        if (empty($this->nama_lengkap) || strlen($this->nama_lengkap) < 3) {
            $errors['nama_lengkap'] = 'Nama lengkap minimal 3 karakter';
        }

        if (!in_array($this->jenis_kelamin, ['laki-laki', 'perempuan'])) {
            $errors['jenis_kelamin'] = 'Jenis kelamin tidak valid';
        }

        if (empty($this->tanggal_lahir) || !$this->isValidDate($this->tanggal_lahir)) {
            $errors['tanggal_lahir'] = 'Tanggal lahir tidak valid';
        }

        if (empty($this->nomor_hp) || !preg_match('/^[\d]{10,13}$/', $this->nomor_hp)) {
            $errors['nomor_hp'] = 'Nomor HP tidak valid (10-13 digit)';
        }

        return $errors;
    }

    /**
     * Check if date is valid
     * 
     * @param string $date Date string Y-m-d
     * @return bool
     */
    protected function isValidDate($date)
    {
        try {
            new \DateTime($date);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
