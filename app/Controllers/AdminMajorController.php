<?php

namespace App\Controllers;

use App\Models\Major;
use App\Traits\RoleAuthTrait;

/**
 * Admin Major Controller
 * 
 * Controller untuk admin mengelola data jurusan
 */
class AdminMajorController extends BaseController
{
    use RoleAuthTrait;

    protected $majorModel;

    public function __construct()
    {
        $this->majorModel = new Major();
    }

    /**
     * Daftar jurusan
     */
    public function index()
    {
        $this->requireAdmin();

        $majors = $this->majorModel->getMajorWithStats();

        return view('admin/majors/index', [
            'title' => 'Kelola Jurusan',
            'majors' => $majors,
        ]);
    }

    /**
     * Tambah jurusan baru
     */
    public function create()
    {
        $this->requireAdmin();

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'kode_jurusan' => 'required|min_length[2]|max_length[20]|is_unique[majors.kode_jurusan]',
                'nama_jurusan' => 'required|min_length[3]|max_length[255]',
                'deskripsi' => 'permit_empty',
                'kuota' => 'permit_empty|integer|greater_than[0]',
                'status' => 'required|in_list[aktif,nonaktif]',
            ];

            if (!$this->validate($rules)) {
                return view('admin/majors/create', [
                    'title' => 'Tambah Jurusan',
                    'validation' => $this->validator,
                ]);
            }

            $data = [
                'kode_jurusan' => strtoupper($this->request->getPost('kode_jurusan')),
                'nama_jurusan' => $this->request->getPost('nama_jurusan'),
                'deskripsi' => $this->request->getPost('deskripsi') ?: null,
                'kuota' => $this->request->getPost('kuota') ?: null,
                'status' => $this->request->getPost('status'),
            ];

            if ($this->majorModel->insert($data)) {
                session()->setFlashdata('success', 'Jurusan berhasil ditambahkan');
                return redirect()->to('/admin/majors');
            } else {
                session()->setFlashdata('error', 'Gagal menambahkan jurusan');
                return redirect()->back()->withInput();
            }
        }

        return view('admin/majors/create', [
            'title' => 'Tambah Jurusan',
            'validation' => null,
        ]);
    }

    /**
     * Edit jurusan
     */
    public function edit($id)
    {
        $this->requireAdmin();

        $major = $this->majorModel->find($id);
        if (!$major) {
            session()->setFlashdata('error', 'Jurusan tidak ditemukan');
            return redirect()->to('/admin/majors');
        }

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'kode_jurusan' => "required|min_length[2]|max_length[20]|is_unique[majors.kode_jurusan,id,{$id}]",
                'nama_jurusan' => 'required|min_length[3]|max_length[255]',
                'deskripsi' => 'permit_empty',
                'kuota' => 'permit_empty|integer|greater_than[0]',
                'status' => 'required|in_list[aktif,nonaktif]',
            ];

            if (!$this->validate($rules)) {
                return view('admin/majors/edit', [
                    'title' => 'Edit Jurusan',
                    'major' => $major,
                    'validation' => $this->validator,
                ]);
            }

            $data = [
                'kode_jurusan' => strtoupper($this->request->getPost('kode_jurusan')),
                'nama_jurusan' => $this->request->getPost('nama_jurusan'),
                'deskripsi' => $this->request->getPost('deskripsi') ?: null,
                'kuota' => $this->request->getPost('kuota') ?: null,
                'status' => $this->request->getPost('status'),
            ];

            if ($this->majorModel->update($id, $data)) {
                session()->setFlashdata('success', 'Jurusan berhasil diupdate');
                return redirect()->to('/admin/majors');
            } else {
                session()->setFlashdata('error', 'Gagal mengupdate jurusan');
                return redirect()->back()->withInput();
            }
        }

        return view('admin/majors/edit', [
            'title' => 'Edit Jurusan',
            'major' => $major,
            'validation' => null,
        ]);
    }

    /**
     * Hapus jurusan
     */
    public function delete($id)
    {
        $this->requireAdmin();

        $major = $this->majorModel->find($id);
        if (!$major) {
            session()->setFlashdata('error', 'Jurusan tidak ditemukan');
            return redirect()->to('/admin/majors');
        }

        // Check if there are applicants using this major
        $applicantModel = new \App\Models\Applicant();
        $countApplicants = $applicantModel->where('jurusan_id', $id)->countAllResults();

        if ($countApplicants > 0) {
            session()->setFlashdata('error', "Tidak dapat menghapus jurusan karena masih ada {$countApplicants} pendaftar yang menggunakan jurusan ini. Nonaktifkan saja jika tidak digunakan lagi.");
            return redirect()->to('/admin/majors');
        }

        if ($this->majorModel->delete($id)) {
            session()->setFlashdata('success', 'Jurusan berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus jurusan');
        }

        return redirect()->to('/admin/majors');
    }

    /**
     * Toggle status jurusan (aktif/nonaktif)
     */
    public function toggleStatus($id)
    {
        $this->requireAdmin();

        $major = $this->majorModel->find($id);
        if (!$major) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Jurusan tidak ditemukan'
            ]);
        }

        $newStatus = $major['status'] === 'aktif' ? 'nonaktif' : 'aktif';
        
        if ($this->majorModel->update($id, ['status' => $newStatus])) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Status jurusan berhasil diubah',
                'new_status' => $newStatus
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Gagal mengubah status jurusan'
        ]);
    }
}
