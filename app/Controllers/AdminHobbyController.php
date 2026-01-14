<?php

namespace App\Controllers;

use App\Models\Hobby;
use App\Traits\RoleAuthTrait;

/**
 * Admin Hobby Controller
 * 
 * Controller untuk admin mengelola data hobi
 */
class AdminHobbyController extends BaseController
{
    use RoleAuthTrait;

    protected $hobbyModel;

    public function __construct()
    {
        $this->hobbyModel = new Hobby();
    }

    /**
     * Daftar hobi
     */
    public function index()
    {
        $this->requireAdmin();

        $hobbies = $this->hobbyModel->getHobbyWithStats();

        return view('admin/hobbies/index', [
            'title' => 'Kelola Hobi',
            'hobbies' => $hobbies,
        ]);
    }

    /**
     * Tambah hobi baru
     */
    public function create()
    {
        $this->requireAdmin();

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'nama_hobi' => 'required|min_length[3]|max_length[100]|is_unique[hobbies.nama_hobi]',
                'icon' => 'permit_empty|max_length[50]',
                'status' => 'required|in_list[aktif,nonaktif]',
            ];

            if (!$this->validate($rules)) {
                return view('admin/hobbies/create', [
                    'title' => 'Tambah Hobi',
                    'validation' => $this->validator,
                ]);
            }

            $data = [
                'nama_hobi' => $this->request->getPost('nama_hobi'),
                'icon' => $this->request->getPost('icon') ?: null,
                'status' => $this->request->getPost('status'),
            ];

            if ($this->hobbyModel->insert($data)) {
                session()->setFlashdata('success', 'Hobi berhasil ditambahkan');
                return redirect()->to('/admin/hobbies');
            } else {
                session()->setFlashdata('error', 'Gagal menambahkan hobi');
                return redirect()->back()->withInput();
            }
        }

        return view('admin/hobbies/create', [
            'title' => 'Tambah Hobi',
            'validation' => null,
        ]);
    }

    /**
     * Edit hobi
     */
    public function edit($id)
    {
        $this->requireAdmin();

        $hobby = $this->hobbyModel->find($id);
        if (!$hobby) {
            session()->setFlashdata('error', 'Hobi tidak ditemukan');
            return redirect()->to('/admin/hobbies');
        }

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'nama_hobi' => "required|min_length[3]|max_length[100]|is_unique[hobbies.nama_hobi,id,{$id}]",
                'icon' => 'permit_empty|max_length[50]',
                'status' => 'required|in_list[aktif,nonaktif]',
            ];

            if (!$this->validate($rules)) {
                return view('admin/hobbies/edit', [
                    'title' => 'Edit Hobi',
                    'hobby' => $hobby,
                    'validation' => $this->validator,
                ]);
            }

            $data = [
                'nama_hobi' => $this->request->getPost('nama_hobi'),
                'icon' => $this->request->getPost('icon') ?: null,
                'status' => $this->request->getPost('status'),
            ];

            if ($this->hobbyModel->update($id, $data)) {
                session()->setFlashdata('success', 'Hobi berhasil diupdate');
                return redirect()->to('/admin/hobbies');
            } else {
                session()->setFlashdata('error', 'Gagal mengupdate hobi');
                return redirect()->back()->withInput();
            }
        }

        return view('admin/hobbies/edit', [
            'title' => 'Edit Hobi',
            'hobby' => $hobby,
            'validation' => null,
        ]);
    }

    /**
     * Hapus hobi
     */
    public function delete($id)
    {
        $this->requireAdmin();

        $hobby = $this->hobbyModel->find($id);
        if (!$hobby) {
            session()->setFlashdata('error', 'Hobi tidak ditemukan');
            return redirect()->to('/admin/hobbies');
        }

        // Check if there are applicants using this hobby
        $applicantHobbyModel = new \App\Models\ApplicantHobby();
        $countApplicants = $applicantHobbyModel->where('hobby_id', $id)->countAllResults();

        if ($countApplicants > 0) {
            session()->setFlashdata('error', "Tidak dapat menghapus hobi karena masih ada {$countApplicants} pendaftar yang menggunakan hobi ini. Nonaktifkan saja jika tidak digunakan lagi.");
            return redirect()->to('/admin/hobbies');
        }

        if ($this->hobbyModel->delete($id)) {
            session()->setFlashdata('success', 'Hobi berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus hobi');
        }

        return redirect()->to('/admin/hobbies');
    }
}
