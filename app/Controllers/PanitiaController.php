<?php

namespace App\Controllers;

use App\Models\Applicant;
use App\Models\PaymentModel;
use App\Traits\RoleAuthTrait;

/**
 * Panitia Controller
 * 
 * Controller untuk panitia yang bertugas mendaftarkan calon siswa.
 * Panitia dapat:
 * - Melihat daftar calon siswa yang akan didaftarkan
 * - Mendaftarkan calon siswa ke sistem
 * - Mengecek status pendaftaran
 */
class PanitiaController extends BaseController
{
    use RoleAuthTrait;

    protected $applicantModel;
    protected $paymentModel;

    public function __construct()
    {
        $this->applicantModel = new Applicant();
        $this->paymentModel = new PaymentModel();
    }

    /**
     * Dashboard panitia
     * 
     * Menampilkan ringkasan statistik pendaftaran
     */
    public function dashboard()
    {
        $this->requirePanitia();

        $stats = [
            'total_registered' => $this->applicantModel->countAllResults(),
            'total_pending_payment' => $this->paymentModel->where('payment_status', 'submitted')->countAllResults(),
            'total_confirmed_payment' => $this->paymentModel->where('payment_status', 'confirmed')->countAllResults(),
            'total_submitted' => $this->applicantModel->where('status', 'submitted')->countAllResults(),
            'total_accepted' => $this->applicantModel->where('status', 'accepted')->countAllResults(),
            'total_rejected' => $this->applicantModel->where('status', 'rejected')->countAllResults(),
        ];

        $recent_applicants = $this->applicantModel
            ->orderBy('created_at', 'DESC')
            ->limit(10)
            ->findAll();

        return view('panitia/dashboard', [
            'title' => 'Dashboard Panitia PPDB',
            'stats' => $stats,
            'recent_applicants' => $recent_applicants,
        ]);
    }

    /**
     * Daftar siswa - menampilkan daftar siswa yang sudah didaftarkan
     */
    public function daftar_siswa()
    {
        $this->requirePanitia();

        $page = $this->request->getVar('page') ?? 1;
        $perPage = 20;
        $status = $this->request->getVar('status') ?? '';

        $query = $this->applicantModel;
        
        if ($status && in_array($status, ['pending', 'submitted', 'accepted', 'rejected'])) {
            $query = $query->where('status', $status);
        }

        $applicants = $query
            ->orderBy('created_at', 'DESC')
            ->paginate($perPage);

        $pager = $this->applicantModel->pager;

        return view('panitia/daftar_siswa', [
            'title' => 'Daftar Siswa Terdaftar',
            'applicants' => $applicants,
            'pager' => $pager,
            'current_status' => $status,
        ]);
    }

    /**
     * Tambah siswa - form mendaftarkan calon siswa baru
     */
    public function tambah_siswa()
    {
        $this->requirePanitia();

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'nik' => 'required|numeric|min_length[16]|max_length[16]|is_unique[applicants_dapodik.nik]',
                'nama_lengkap' => 'required|min_length[3]|max_length[255]',
                'jenis_kelamin' => 'required|in_list[laki-laki,perempuan]',
                'tanggal_lahir' => 'required|valid_date[Y-m-d]',
                'tempat_lahir' => 'required|min_length[3]',
                'agama' => 'required|in_list[Islam,Kristen,Katolik,Hindu,Buddha,Konghucu,Lainnya]',
                'anak_ke' => 'required|integer|greater_than[0]',
                'jumlah_saudara' => 'required|integer|greater_than_equal_to[0]',
                'alamat_jalan' => 'required|min_length[5]',
                'kelurahan' => 'required',
                'kecamatan' => 'required',
                'kabupaten' => 'required',
                'provinsi' => 'required',
                'kode_pos' => 'required|numeric|min_length[5]|max_length[5]',
                'nomor_hp' => 'required|numeric|min_length[10]|max_length[13]',
                'asal_sekolah' => 'required|min_length[5]',
                'npsn_sekolah_asal' => 'numeric|min_length[8]|max_length[8]',
                'nama_ayah' => 'required|min_length[3]',
                'nama_ibu' => 'required|min_length[3]',
            ];

            if (!$this->validate($rules)) {
                // Get schools for dropdown
                $schoolModel = new \App\Models\School();
                $schools = $schoolModel->orderBy('nama', 'ASC')->findAll();
                
                return view('panitia/tambah_siswa', [
                    'title' => 'Tambah Siswa Baru',
                    'validation' => $this->validator,
                    'schools' => $schools,
                ]);
            }

            // Buat nomor pendaftaran
            $nomor_pendaftaran = $this->applicantModel->generateNomorPendaftaran();

            $data = [
                'nik' => $this->request->getPost('nik'),
                'nama_lengkap' => $this->request->getPost('nama_lengkap'),
                'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
                'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
                'tempat_lahir' => $this->request->getPost('tempat_lahir'),
                'agama' => $this->request->getPost('agama'),
                'anak_ke' => (int) $this->request->getPost('anak_ke'),
                'jumlah_saudara' => (int) $this->request->getPost('jumlah_saudara'),
                'alamat_jalan' => $this->request->getPost('alamat_jalan'),
                'dusun' => $this->request->getPost('dusun') ?: null,
                'kelurahan' => $this->request->getPost('kelurahan'),
                'kecamatan' => $this->request->getPost('kecamatan'),
                'kabupaten' => $this->request->getPost('kabupaten'),
                'provinsi' => $this->request->getPost('provinsi'),
                'kode_pos' => $this->request->getPost('kode_pos'),
                'nomor_hp' => $this->request->getPost('nomor_hp'),
                'asal_sekolah' => $this->request->getPost('asal_sekolah'),
                'npsn_sekolah_asal' => $this->request->getPost('npsn_sekolah_asal') ?: null,
                'nama_ayah' => $this->request->getPost('nama_ayah'),
                'nama_ibu' => $this->request->getPost('nama_ibu'),
                'nomor_pendaftaran' => $nomor_pendaftaran,
                'status' => 'submitted',
                'tanggal_submit' => date('Y-m-d H:i:s'),
            ];

            try {
                if ($this->applicantModel->insert($data)) {
                    // Ambil ID yang baru ditambahkan
                    $applicant_id = $this->applicantModel->insertID();
                    session()->setFlashdata('success', 'Calon siswa berhasil didaftarkan dengan nomor pendaftaran: ' . $nomor_pendaftaran);
                    
                    // Redirect berdasarkan role
                    $role = session()->get('role');
                    $redirectUrl = $role === 'admin' ? '/admin/daftar-siswa' : '/panitia/daftar-siswa';
                    return redirect()->to($redirectUrl);
                } else {
                    $errors = $this->applicantModel->errors();
                    $errorMsg = is_array($errors) ? implode(', ', $errors) : 'Gagal mendaftarkan siswa. Silakan coba lagi.';
                    session()->setFlashdata('error', $errorMsg);
                    return redirect()->back()->withInput();
                }
            } catch (\Exception $e) {
                session()->setFlashdata('error', 'Gagal mendaftarkan siswa: ' . $e->getMessage());
                return redirect()->back()->withInput();
            }
        }

        // Get schools for dropdown
        $schoolModel = new \App\Models\School();
        $schools = $schoolModel->orderBy('nama', 'ASC')->findAll();
        
        return view('panitia/tambah_siswa', [
            'title' => 'Tambah Siswa Baru',
            'validation' => null,
            'schools' => $schools,
        ]);
    }

    /**
     * Lihat detail siswa
     */
    public function lihat_siswa($applicant_id)
    {
        $this->requirePanitia();

        $applicant = $this->applicantModel->find($applicant_id);

        if (!$applicant) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan.');
            return redirect()->to('/panitia/daftar_siswa');
        }

        // Get payment info if exists
        $payment = $this->paymentModel->where('applicant_id', $applicant_id)->first();

        return view('panitia/lihat_siswa', [
            'title' => 'Detail Siswa',
            'applicant' => $applicant,
            'payment' => $payment,
        ]);
    }

    /**
     * Edit siswa
     */
    public function edit_siswa($applicant_id)
    {
        $this->requirePanitia();

        $applicant = $this->applicantModel->find($applicant_id);

        if (!$applicant) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan.');
            return redirect()->to('/panitia/daftar_siswa');
        }

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'nik' => 'required|numeric|min_length[16]|max_length[16]',
                'nama_lengkap' => 'required|min_length[3]|max_length[255]',
                'jenis_kelamin' => 'required|in_list[laki-laki,perempuan]',
                'tanggal_lahir' => 'required|valid_date[Y-m-d]',
                'tempat_lahir' => 'required|min_length[3]',
                'agama' => 'required|in_list[Islam,Kristen,Katolik,Hindu,Buddha,Konghucu,Lainnya]',
                'anak_ke' => 'required|integer|greater_than[0]',
                'jumlah_saudara' => 'required|integer|greater_than_equal_to[0]',
                'alamat_jalan' => 'required|min_length[5]',
                'kelurahan' => 'required',
                'kecamatan' => 'required',
                'kabupaten' => 'required',
                'provinsi' => 'required',
                'kode_pos' => 'required|numeric|min_length[5]|max_length[5]',
                'nomor_hp' => 'required|numeric|min_length[10]|max_length[13]',
                'asal_sekolah' => 'required|min_length[5]',
                'npsn_sekolah_asal' => 'numeric|min_length[8]|max_length[8]',
                'nama_ayah' => 'required|min_length[3]',
                'nama_ibu' => 'required|min_length[3]',
            ];

            if (!$this->validate($rules)) {
                return view('panitia/edit_siswa', [
                    'title' => 'Edit Data Siswa',
                    'applicant' => $applicant,
                    'validation' => $this->validator,
                ]);
            }

            $data = [
                'nik' => $this->request->getPost('nik'),
                'nama_lengkap' => $this->request->getPost('nama_lengkap'),
                'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
                'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
                'tempat_lahir' => $this->request->getPost('tempat_lahir'),
                'agama' => $this->request->getPost('agama'),
                'anak_ke' => $this->request->getPost('anak_ke'),
                'jumlah_saudara' => $this->request->getPost('jumlah_saudara'),
                'alamat_jalan' => $this->request->getPost('alamat_jalan'),
                'kelurahan' => $this->request->getPost('kelurahan'),
                'kecamatan' => $this->request->getPost('kecamatan'),
                'kabupaten' => $this->request->getPost('kabupaten'),
                'provinsi' => $this->request->getPost('provinsi'),
                'kode_pos' => $this->request->getPost('kode_pos'),
                'nomor_hp' => $this->request->getPost('nomor_hp'),
                'asal_sekolah' => $this->request->getPost('asal_sekolah'),
                'npsn_sekolah_asal' => $this->request->getPost('npsn_sekolah_asal') ?? null,
                'nama_ayah' => $this->request->getPost('nama_ayah'),
                'nama_ibu' => $this->request->getPost('nama_ibu'),
            ];

            try {
                $this->applicantModel->update($applicant_id, $data);
                session()->setFlashdata('success', 'Data siswa berhasil diperbarui.');
                return redirect()->to('/panitia/lihat_siswa/' . $applicant_id);
            } catch (\Exception $e) {
                session()->setFlashdata('error', 'Gagal mengupdate data: ' . $e->getMessage());
                return redirect()->back()->withInput();
            }
        }

        return view('panitia/edit_siswa', [
            'title' => 'Edit Data Siswa',
            'applicant' => $applicant,
        ]);
    }

    /**
     * Hapus siswa
     */
    public function hapus_siswa($applicant_id)
    {
        $this->requirePanitia();

        $applicant = $this->applicantModel->find($applicant_id);

        if (!$applicant) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan.');
            return redirect()->to('/panitia/daftar_siswa');
        }

        try {
            // Hapus payment terkait jika ada
            $this->paymentModel->where('applicant_id', $applicant_id)->delete();
            
            // Hapus siswa
            $this->applicantModel->delete($applicant_id);
            
            session()->setFlashdata('success', 'Data siswa berhasil dihapus.');
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Gagal menghapus data: ' . $e->getMessage());
        }

        return redirect()->to('/panitia/daftar_siswa');
    }

    /**
     * Verifikasi pendaftar online dan offline
     */
    public function verifikasi_pendaftar($applicant_id = null)
    {
        $this->requirePanitia();

        // Jika ada applicant_id di URL, berarti ingin verifikasi
        if ($applicant_id) {
            $applicant = $this->applicantModel->find($applicant_id);
            
            if (!$applicant) {
                session()->setFlashdata('error', 'Data pendaftar tidak ditemukan.');
                return redirect()->to('/panitia/verifikasi-pendaftar');
            }

            try {
                $this->applicantModel->update($applicant_id, [
                    'status' => 'verified',
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
                session()->setFlashdata('success', 'Pendaftar ' . $applicant['nama_lengkap'] . ' berhasil diverifikasi.');
            } catch (\Exception $e) {
                session()->setFlashdata('error', 'Gagal memverifikasi pendaftar: ' . $e->getMessage());
            }

            return redirect()->to('/panitia/verifikasi-pendaftar');
        }

        // Jika tidak ada applicant_id, tampilkan list semua pendaftar
        $applicants = $this->applicantModel->findAll();

        return view('panitia/verifikasi_pendaftar', [
            'applicants' => $applicants,
        ]);
    }

    /**
     * Batal verifikasi - revert status verified ke submitted
     */
    public function batal_verifikasi($applicant_id)
    {
        $this->requirePanitia();

        $applicant = $this->applicantModel->find($applicant_id);
        
        if (!$applicant) {
            session()->setFlashdata('error', 'Data pendaftar tidak ditemukan.');
            return redirect()->to('/panitia/verifikasi-pendaftar');
        }

        try {
            $this->applicantModel->update($applicant_id, [
                'status' => 'submitted',
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            session()->setFlashdata('success', 'Verifikasi untuk ' . $applicant['nama_lengkap'] . ' berhasil dibatalkan.');
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Gagal membatalkan verifikasi: ' . $e->getMessage());
        }

        return redirect()->to('/panitia/verifikasi-pendaftar');
    }

    /**
     * Cetak pendaftaran - tampilkan form cetak profesional
     */
    public function cetak_pendaftaran($applicant_id)
    {
        $this->requirePanitia();

        $applicant = $this->applicantModel->find($applicant_id);
        
        if (!$applicant) {
            session()->setFlashdata('error', 'Data pendaftar tidak ditemukan.');
            return redirect()->to('/panitia/daftar-siswa');
        }

        if ($applicant['status'] !== 'verified') {
            session()->setFlashdata('error', 'Hanya pendaftar yang sudah terverifikasi yang bisa dicetak.');
            return redirect()->to('/panitia/lihat_siswa/' . $applicant_id);
        }

        // Get kop surat data
        $kopSuratModel = new \App\Models\KopSurat();
        $kopSurat = $kopSuratModel->first() ?? [
            'school_name' => 'SEKOLAH MENENGAH ATAS NEGERI',
            'address' => 'Jl. Pendidikan No. 123, Jakarta Selatan 12000',
            'phone' => '(021) 1234-5678',
            'email' => 'info@sekolah.sch.id',
            'npsn' => '20123456',
            'logo_path' => null,
        ];

        return view('panitia/cetak_pendaftaran', [
            'title' => 'Cetak Formulir Pendaftaran',
            'applicant' => $applicant,
            'kopSurat' => $kopSurat,
        ]);
    }

    /**
     */
    public function grafik_siswa()
    {
        $this->requirePanitia();

        $stats = [
            'total_pendaftar' => $this->applicantModel->countAllResults(),
            'pending' => $this->applicantModel->where('status', 'pending')->countAllResults(),
            'verified' => $this->applicantModel->where('status', 'verified')->countAllResults(),
            'rejected' => $this->applicantModel->where('status', 'rejected')->countAllResults(),
        ];

        return view('panitia/grafik_siswa', [
            'stats' => $stats,
        ]);
    }

    /**
     * AJAX: Add new school
     */
    public function ajax_add_school()
    {
        $this->requirePanitia();
        
        // Ensure AJAX request
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request'
            ]);
        }

        $schoolModel = new \App\Models\School();
        
        $data = [
            'nama' => $this->request->getPost('nama'),
            'npsn' => $this->request->getPost('npsn'),
            'kota' => $this->request->getPost('kota'),
            'provinsi' => $this->request->getPost('provinsi'),
            'alamat' => $this->request->getPost('alamat'),
        ];

        try {
            if ($schoolModel->insert($data)) {
                $newId = $schoolModel->insertID();
                $newSchool = $schoolModel->find($newId);
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Sekolah berhasil ditambahkan',
                    'school' => $newSchool
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menyimpan data: ' . implode(', ', $schoolModel->errors())
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
}
