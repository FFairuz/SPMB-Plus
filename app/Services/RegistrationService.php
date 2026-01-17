<?php

namespace App\Services;

use App\Repositories\ApplicantRepository;
use CodeIgniter\Validation\Validation;

/**
 * Registration Service
 * 
 * Service untuk menangani business logic dari proses pendaftaran applicant.
 * Menggabungkan repository, validation, dan business logic.
 */
class RegistrationService
{
    /**
     * @var ApplicantRepository
     */
    protected $applicantRepository;

    /**
     * @var Validation
     */
    protected $validation;

    /**
     * Constructor
     * 
     * @param ApplicantRepository $applicantRepository
     * @param Validation $validation
     */
    public function __construct(ApplicantRepository $applicantRepository = null, Validation $validation = null)
    {
        $this->applicantRepository = $applicantRepository ?? new ApplicantRepository();
        $this->validation = $validation ?? \Config\Services::validation();
    }

    /**
     * Mendapatkan form registrasi untuk user
     * 
     * @param int $userId User ID
     * @return array|null
     */
    public function getRegistrationForm($userId)
    {
        return $this->applicantRepository->getByUser($userId);
    }

    /**
     * Menyimpan form registrasi (create atau update)
     * 
     * @param int $userId User ID
     * @param array $data Data form
     * @return array ['success' => bool, 'message' => string, 'data' => array|null, 'errors' => array]
     */
    public function saveRegistration($userId, array $data)
    {
        try {
            // Check existing applicant
            $existingApplicant = $this->applicantRepository->getByUser($userId);
            
            // Prepare data
            $data['user_id'] = $userId;
            
            // Validate data
            if (!$this->validateRegistration($data, $existingApplicant ? true : false)) {
                return [
                    'success' => false,
                    'message' => 'Validasi data gagal',
                    'errors' => $this->validation->getErrors(),
                ];
            }

            // Check NIK uniqueness (exclude current record if exists)
            if (isset($data['nik'])) {
                if ($this->applicantRepository->isNikExists($data['nik'], $existingApplicant ? $existingApplicant['id'] : null)) {
                    return [
                        'success' => false,
                        'message' => 'NIK sudah terdaftar dalam sistem',
                        'errors' => ['nik' => 'NIK sudah terdaftar'],
                    ];
                }
            }

            if ($existingApplicant) {
                // Update existing
                $id = $existingApplicant['id'];
                if (!$this->applicantRepository->update($id, $data)) {
                    return [
                        'success' => false,
                        'message' => 'Gagal menyimpan data',
                    ];
                }
                $message = 'Data berhasil diperbarui';
            } else {
                // Create new
                $data['nomor_pendaftaran'] = $this->applicantRepository->generateNomorPendaftaran();
                $data['status'] = 'draft';
                
                $id = $this->applicantRepository->create($data);
                if (!$id) {
                    return [
                        'success' => false,
                        'message' => 'Gagal membuat pendaftaran baru',
                    ];
                }
                $message = 'Pendaftaran berhasil dibuat';
            }

            $applicant = $this->applicantRepository->findById($id);

            return [
                'success' => true,
                'message' => $message,
                'data' => $applicant,
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Submit registrasi
     * 
     * @param int $userId User ID
     * @return array ['success' => bool, 'message' => string, 'data' => array|null]
     */
    public function submitRegistration($userId)
    {
        try {
            $applicant = $this->applicantRepository->getByUser($userId);

            if (!$applicant) {
                return [
                    'success' => false,
                    'message' => 'Data registrasi tidak ditemukan. Silahkan isi form terlebih dahulu.',
                ];
            }

            // Validate required fields before submit
            if (!$this->validateCompleteness($applicant)) {
                return [
                    'success' => false,
                    'message' => 'Semua field wajib harus diisi sebelum submit',
                ];
            }

            // Update status to submitted
            $result = $this->applicantRepository->updateStatus(
                $applicant['id'],
                'submitted'
            );

            if (!$result) {
                return [
                    'success' => false,
                    'message' => 'Gagal melakukan submit registrasi',
                ];
            }

            $updatedApplicant = $this->applicantRepository->findById($applicant['id']);

            return [
                'success' => true,
                'message' => 'Registrasi berhasil disubmit. Tunggu verifikasi dari panitia.',
                'data' => $updatedApplicant,
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Get preview data
     * 
     * @param int $userId User ID
     * @return array|null
     */
    public function getPreviewData($userId)
    {
        return $this->applicantRepository->getByUser($userId);
    }

    /**
     * Validate registration data
     * 
     * @param array $data Data to validate
     * @param bool $isUpdate Is update operation
     * @return bool
     */
    protected function validateRegistration(array $data, $isUpdate = false)
    {
        $rules = [
            'nik' => 'required|string|min_length[16]|max_length[16]',
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
            'nilai_rata_rata' => 'required|decimal|greater_than_equal_to[0]|less_than_equal_to[100]',
            'nama_ayah' => 'required|string|min_length[3]',
            'nama_ibu' => 'required|string|min_length[3]',
        ];

        return $this->validation->setRules($rules)->run($data);
    }

    /**
     * Validate completeness of registration
     * 
     * @param array $applicant Applicant data
     * @return bool
     */
    protected function validateCompleteness(array $applicant)
    {
        $requiredFields = [
            'nik', 'nama_lengkap', 'jenis_kelamin', 'tanggal_lahir', 'tempat_lahir',
            'agama', 'anak_ke', 'jumlah_saudara', 'alamat_jalan', 'kelurahan',
            'kecamatan', 'kabupaten', 'provinsi', 'kode_pos', 'nomor_hp',
            'asal_sekolah', 'nama_ayah', 'nama_ibu'
        ];

        foreach ($requiredFields as $field) {
            if (empty($applicant[$field])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get registration progress
     * 
     * @param array $applicant Applicant data
     * @return int Progress percentage (0-100)
     */
    public function getProgress(array $applicant)
    {
        $totalFields = 0;
        $filledFields = 0;

        $applicantFields = [
            'nik', 'nama_lengkap', 'nama_panggilan', 'jenis_kelamin', 'tanggal_lahir',
            'tempat_lahir', 'agama', 'status_keluarga', 'anak_ke', 'jumlah_saudara',
            'alamat_jalan', 'dusun', 'kelurahan', 'kecamatan', 'kabupaten', 'provinsi',
            'kode_pos', 'nomor_telepon', 'nomor_hp', 'asal_sekolah', 'npsn_sekolah_asal',
            'nilai_rata_rata', 'nilai_un_indo', 'nilai_un_math', 'nilai_un_english',
            'nilai_un_science', 'nama_ayah', 'nik_ayah', 'pendidikan_ayah', 'pekerjaan_ayah',
            'penghasilan_ayah', 'nomor_hp_ayah', 'nama_ibu', 'nik_ibu', 'pendidikan_ibu',
            'pekerjaan_ibu', 'penghasilan_ibu', 'nomor_hp_ibu', 'nama_wali', 'hubungan_wali',
            'nomor_hp_wali', 'prestasi_akademik', 'prestasi_non_akademik', 'kelainan_fisik',
            'kebutuhan_khusus_lainnya'
        ];

        foreach ($applicantFields as $field) {
            $totalFields++;
            if (!empty($applicant[$field])) {
                $filledFields++;
            }
        }

        return $totalFields > 0 ? (int) (($filledFields / $totalFields) * 100) : 0;
    }

    /**
     * Get registration summary
     * 
     * @param int $userId User ID
     * @return array|null
     */
    public function getSummary($userId)
    {
        $applicant = $this->applicantRepository->getByUser($userId);

        if (!$applicant) {
            return null;
        }

        return [
            'nomor_pendaftaran' => $applicant['nomor_pendaftaran'],
            'nama' => $applicant['nama_lengkap'],
            'status' => $applicant['status'],
            'tanggal_daftar' => $applicant['created_at'],
            'tanggal_submit' => $applicant['tanggal_submit'],
            'progress' => $this->getProgress($applicant),
        ];
    }
}
