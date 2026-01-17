<?php

namespace App\Controllers;

use App\Models\AcademicYear;
use App\Models\MajorQuota;
use App\Traits\RoleAuthTrait;

/**
 * Admin Academic Year Controller
 * 
 * Controller untuk admin mengelola tahun ajaran
 */
class AdminAcademicYearController extends BaseController
{
    use RoleAuthTrait;

    protected $academicYearModel;
    protected $quotaModel;

    public function __construct()
    {
        $this->academicYearModel = new AcademicYear();
        $this->quotaModel = new MajorQuota();
    }

    /**
     * Daftar tahun ajaran
     */
    public function index()
    {
        $this->requireAdmin();

        $years = $this->academicYearModel->orderBy('tahun_mulai', 'DESC')->findAll();

        return view('admin/academic_years/index', [
            'title' => 'Kelola Tahun Ajaran',
            'years' => $years,
        ]);
    }

    /**
     * Tambah tahun ajaran baru
     */
    public function create()
    {
        $this->requireAdmin();

        if ($this->request->getMethod() === 'post') {
            $tahunMulai = $this->request->getPost('tahun_mulai');
            $tahunSelesai = $this->request->getPost('tahun_selesai');

            // Validasi tahun selesai harus lebih besar dari tahun mulai
            if ($tahunSelesai <= $tahunMulai) {
                session()->setFlashdata('error', 'Tahun selesai harus lebih besar dari tahun mulai!');
                return redirect()->back()->withInput();
            }

            // Cek overlap
            $overlaps = $this->academicYearModel->checkOverlap($tahunMulai, $tahunSelesai);
            if (!empty($overlaps)) {
                session()->setFlashdata('error', 'Tahun ajaran bertumpukan dengan tahun ajaran lain!');
                return redirect()->back()->withInput();
            }

            $data = [
                'tahun_ajaran' => AcademicYear::generateTahunAjaran($tahunMulai, $tahunSelesai),
                'tahun_mulai' => $tahunMulai,
                'tahun_selesai' => $tahunSelesai,
                'tanggal_mulai' => $this->request->getPost('tanggal_mulai'),
                'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),
                'is_active' => $this->request->getPost('is_active') ? true : false,
                'status' => $this->request->getPost('status') ?? 'aktif',
                'keterangan' => $this->request->getPost('keterangan'),
            ];

            // Jika di-set aktif, nonaktifkan yang lain
            if ($data['is_active']) {
                $this->academicYearModel->set('is_active', false)->update();
            }

            if ($this->academicYearModel->insert($data)) {
                session()->setFlashdata('success', 'Tahun ajaran berhasil ditambahkan!');
                return redirect()->to('/admin/academic-years');
            } else {
                session()->setFlashdata('error', 'Gagal menambahkan tahun ajaran!');
                session()->setFlashdata('validation', $this->academicYearModel->errors());
                return redirect()->back()->withInput();
            }
        }

        return view('admin/academic_years/create', [
            'title' => 'Tambah Tahun Ajaran',
            'validation' => session()->getFlashdata('validation'),
        ]);
    }

    /**
     * Edit tahun ajaran
     */
    public function edit($id)
    {
        $this->requireAdmin();

        $year = $this->academicYearModel->find($id);
        if (!$year) {
            session()->setFlashdata('error', 'Tahun ajaran tidak ditemukan!');
            return redirect()->to('/admin/academic-years');
        }

        if ($this->request->getMethod() === 'post') {
            $tahunMulai = $this->request->getPost('tahun_mulai');
            $tahunSelesai = $this->request->getPost('tahun_selesai');

            // Validasi tahun selesai harus lebih besar dari tahun mulai
            if ($tahunSelesai <= $tahunMulai) {
                session()->setFlashdata('error', 'Tahun selesai harus lebih besar dari tahun mulai!');
                return redirect()->back()->withInput();
            }

            // Cek overlap
            $overlaps = $this->academicYearModel->checkOverlap($tahunMulai, $tahunSelesai, $id);
            if (!empty($overlaps)) {
                session()->setFlashdata('error', 'Tahun ajaran bertumpukan dengan tahun ajaran lain!');
                return redirect()->back()->withInput();
            }

            $data = [
                'tahun_ajaran' => AcademicYear::generateTahunAjaran($tahunMulai, $tahunSelesai),
                'tahun_mulai' => $tahunMulai,
                'tahun_selesai' => $tahunSelesai,
                'tanggal_mulai' => $this->request->getPost('tanggal_mulai'),
                'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),
                'is_active' => $this->request->getPost('is_active') ? true : false,
                'status' => $this->request->getPost('status'),
                'keterangan' => $this->request->getPost('keterangan'),
            ];

            // Jika di-set aktif, nonaktifkan yang lain
            if ($data['is_active']) {
                $this->academicYearModel->where('id !=', $id)->set('is_active', false)->update();
            }

            if ($this->academicYearModel->update($id, $data)) {
                session()->setFlashdata('success', 'Tahun ajaran berhasil diperbarui!');
                return redirect()->to('/admin/academic-years');
            } else {
                session()->setFlashdata('error', 'Gagal memperbarui tahun ajaran!');
                session()->setFlashdata('validation', $this->academicYearModel->errors());
                return redirect()->back()->withInput();
            }
        }

        return view('admin/academic_years/edit', [
            'title' => 'Edit Tahun Ajaran',
            'year' => $year,
            'validation' => session()->getFlashdata('validation'),
        ]);
    }

    /**
     * Hapus tahun ajaran
     */
    public function delete($id)
    {
        $this->requireAdmin();

        $year = $this->academicYearModel->find($id);
        if (!$year) {
            session()->setFlashdata('error', 'Tahun ajaran tidak ditemukan!');
            return redirect()->to('/admin/academic-years');
        }

        // Cek apakah tahun ajaran sedang aktif
        if ($year['is_active']) {
            session()->setFlashdata('error', 'Tidak dapat menghapus tahun ajaran yang sedang aktif!');
            return redirect()->to('/admin/academic-years');
        }

        // Cek apakah ada kuota yang menggunakan tahun ajaran ini
        $quotas = $this->quotaModel->where('tahun_ajaran', $year['tahun_ajaran'])->findAll();
        if (!empty($quotas)) {
            session()->setFlashdata('error', 'Tidak dapat menghapus tahun ajaran yang masih memiliki kuota!');
            return redirect()->to('/admin/academic-years');
        }

        if ($this->academicYearModel->delete($id)) {
            session()->setFlashdata('success', 'Tahun ajaran berhasil dihapus!');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus tahun ajaran!');
        }

        return redirect()->to('/admin/academic-years');
    }

    /**
     * Set active year
     */
    public function setActive($id)
    {
        $this->requireAdmin();

        $year = $this->academicYearModel->find($id);
        if (!$year) {
            session()->setFlashdata('error', 'Tahun ajaran tidak ditemukan!');
            return redirect()->to('/admin/academic-years');
        }

        if ($this->academicYearModel->setActiveYear($id)) {
            session()->setFlashdata('success', 'Tahun ajaran ' . $year['tahun_ajaran'] . ' berhasil diaktifkan!');
        } else {
            session()->setFlashdata('error', 'Gagal mengaktifkan tahun ajaran!');
        }

        return redirect()->to('/admin/academic-years');
    }
}
