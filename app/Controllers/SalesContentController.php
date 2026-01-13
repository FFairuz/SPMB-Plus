<?php

namespace App\Controllers;

use App\Models\SalesContent;

class SalesContentController extends BaseController
{
    protected $salesContentModel;

    public function __construct()
    {
        $this->salesContentModel = new SalesContent();
    }

    /**
     * Display list of sales content
     *
     * @return mixed
     */
    public function index()
    {
        // Check admin authorization
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/auth/login')->with('error', 'Akses ditolak. Anda harus login sebagai admin.');
        }

        $data = [
            'title' => 'Kelola Konten Sales',
            'contents' => $this->salesContentModel->orderBy('type', 'ASC')->orderBy('display_order', 'ASC')->findAll()
        ];

        return view('admin/sales_content/index', $data);
    }

    /**
     * Show form to create new content
     *
     * @return mixed
     */
    public function create()
    {
        // Check admin authorization
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/auth/login')->with('error', 'Akses ditolak. Anda harus login sebagai admin.');
        }

        $data = [
            'title' => 'Tambah Konten Sales',
            'validation' => \Config\Services::validation()
        ];

        return view('admin/sales_content/create', $data);
    }

    /**
     * Store new content
     *
     * @return mixed
     */
    public function store()
    {
        // Check admin authorization
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/auth/login')->with('error', 'Akses ditolak.');
        }

        // Validation rules
        $rules = [
            'type' => 'required|in_list[video,brochure,fee_info,other]',
            'title' => 'required|max_length[255]',
            'description' => 'permit_empty',
            'video_url' => 'permit_empty|max_length[500]',
            'fee_amount' => 'permit_empty|decimal',
            'fee_category' => 'permit_empty|max_length[100]',
            'display_order' => 'permit_empty|integer',
            'is_active' => 'permit_empty|in_list[0,1]',
            'file' => [
                'rules' => 'permit_empty|uploaded[file]|max_size[file,5120]|ext_in[file,pdf,jpg,jpeg,png]',
                'errors' => [
                    'max_size' => 'Ukuran file maksimal 5MB',
                    'ext_in' => 'Format file harus PDF, JPG, JPEG, atau PNG'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'type' => $this->request->getPost('type'),
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'video_url' => $this->request->getPost('video_url'),
            'fee_amount' => $this->request->getPost('fee_amount'),
            'fee_category' => $this->request->getPost('fee_category'),
            'display_order' => $this->request->getPost('display_order') ?? 0,
            'is_active' => $this->request->getPost('is_active') ?? 1,
        ];

        // Handle file upload
        $file = $this->request->getFile('file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads/sales', $newName);
            $data['file_path'] = $newName;
        }

        if ($this->salesContentModel->insert($data)) {
            return redirect()->to('/admin/sales-content')->with('success', 'Konten sales berhasil ditambahkan');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan konten sales');
        }
    }

    /**
     * Show form to edit content
     *
     * @param int $id
     * @return mixed
     */
    public function edit($id)
    {
        // Check admin authorization
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/auth/login')->with('error', 'Akses ditolak.');
        }

        $content = $this->salesContentModel->find($id);
        if (!$content) {
            return redirect()->to('/admin/sales-content')->with('error', 'Konten tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Konten Sales',
            'content' => $content,
            'validation' => \Config\Services::validation()
        ];

        return view('admin/sales_content/edit', $data);
    }

    /**
     * Update content
     *
     * @param int $id
     * @return mixed
     */
    public function update($id)
    {
        // Check admin authorization
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/auth/login')->with('error', 'Akses ditolak.');
        }

        $content = $this->salesContentModel->find($id);
        if (!$content) {
            return redirect()->to('/admin/sales-content')->with('error', 'Konten tidak ditemukan');
        }

        // Validation rules
        $rules = [
            'type' => 'required|in_list[video,brochure,fee_info,other]',
            'title' => 'required|max_length[255]',
            'description' => 'permit_empty',
            'video_url' => 'permit_empty|max_length[500]',
            'fee_amount' => 'permit_empty|decimal',
            'fee_category' => 'permit_empty|max_length[100]',
            'display_order' => 'permit_empty|integer',
            'is_active' => 'permit_empty|in_list[0,1]',
            'file' => [
                'rules' => 'permit_empty|uploaded[file]|max_size[file,5120]|ext_in[file,pdf,jpg,jpeg,png]',
                'errors' => [
                    'max_size' => 'Ukuran file maksimal 5MB',
                    'ext_in' => 'Format file harus PDF, JPG, JPEG, atau PNG'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'type' => $this->request->getPost('type'),
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'video_url' => $this->request->getPost('video_url'),
            'fee_amount' => $this->request->getPost('fee_amount'),
            'fee_category' => $this->request->getPost('fee_category'),
            'display_order' => $this->request->getPost('display_order') ?? 0,
            'is_active' => $this->request->getPost('is_active') ?? 1,
        ];

        // Handle file upload
        $file = $this->request->getFile('file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Delete old file if exists
            if ($content['file_path']) {
                $oldFilePath = WRITEPATH . 'uploads/sales/' . $content['file_path'];
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads/sales', $newName);
            $data['file_path'] = $newName;
        }

        if ($this->salesContentModel->update($id, $data)) {
            return redirect()->to('/admin/sales-content')->with('success', 'Konten sales berhasil diperbarui');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui konten sales');
        }
    }

    /**
     * Delete content
     *
     * @param int $id
     * @return mixed
     */
    public function delete($id)
    {
        // Check admin authorization
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/auth/login')->with('error', 'Akses ditolak.');
        }

        $content = $this->salesContentModel->find($id);
        if (!$content) {
            return redirect()->to('/admin/sales-content')->with('error', 'Konten tidak ditemukan');
        }

        // Delete file if exists
        if ($content['file_path']) {
            $filePath = WRITEPATH . 'uploads/sales/' . $content['file_path'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        if ($this->salesContentModel->delete($id)) {
            return redirect()->to('/admin/sales-content')->with('success', 'Konten sales berhasil dihapus');
        } else {
            return redirect()->to('/admin/sales-content')->with('error', 'Gagal menghapus konten sales');
        }
    }

    /**
     * Toggle content status
     *
     * @param int $id
     * @return mixed
     */
    public function toggleStatus($id)
    {
        // Check admin authorization
        if (session()->get('role') !== 'admin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Akses ditolak']);
        }

        if ($this->salesContentModel->toggleStatus($id)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Status berhasil diubah']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal mengubah status']);
        }
    }
}
