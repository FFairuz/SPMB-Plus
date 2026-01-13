<?php

namespace App\Controllers;

use App\Models\HomeContent;

class ContentController extends BaseController
{
    protected $homeContentModel;

    public function __construct()
    {
        $this->homeContentModel = new HomeContent();
    }

    /**
     * Display list of home content
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
            'title' => 'Kelola Konten Home',
            'contents' => $this->homeContentModel->orderBy('section', 'ASC')->orderBy('display_order', 'ASC')->findAll()
        ];

        return view('admin/content/index', $data);
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
            'title' => 'Tambah Konten Home',
            'validation' => \Config\Services::validation()
        ];

        return view('admin/content/create', $data);
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
            'section' => 'required|max_length[100]',
            'title' => 'required|max_length[255]',
            'subtitle' => 'permit_empty|max_length[255]',
            'content' => 'permit_empty',
            'button_text' => 'permit_empty|max_length[100]',
            'button_link' => 'permit_empty|max_length[255]',
            'display_order' => 'permit_empty|integer',
            'is_active' => 'permit_empty|in_list[0,1]',
            'image' => [
                'rules' => 'permit_empty|uploaded[image]|max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Gambar harus diupload',
                    'max_size' => 'Ukuran gambar maksimal 2MB',
                    'is_image' => 'File harus berupa gambar',
                    'mime_in' => 'Format gambar harus JPG, JPEG, atau PNG'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'section' => $this->request->getPost('section'),
            'title' => $this->request->getPost('title'),
            'subtitle' => $this->request->getPost('subtitle'),
            'content' => $this->request->getPost('content'),
            'button_text' => $this->request->getPost('button_text'),
            'button_link' => $this->request->getPost('button_link'),
            'display_order' => $this->request->getPost('display_order') ?? 0,
            'is_active' => $this->request->getPost('is_active') ?? 1,
        ];

        // Handle image upload
        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $image->move(WRITEPATH . 'uploads/content', $newName);
            $data['image'] = $newName;
        }

        if ($this->homeContentModel->insert($data)) {
            return redirect()->to('/admin/content-management')->with('success', 'Konten berhasil ditambahkan');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan konten');
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

        $content = $this->homeContentModel->find($id);
        if (!$content) {
            return redirect()->to('/admin/content-management')->with('error', 'Konten tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Konten Home',
            'content' => $content,
            'validation' => \Config\Services::validation()
        ];

        return view('admin/content/edit', $data);
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

        $content = $this->homeContentModel->find($id);
        if (!$content) {
            return redirect()->to('/admin/content-management')->with('error', 'Konten tidak ditemukan');
        }

        // Validation rules
        $rules = [
            'section' => 'required|max_length[100]',
            'title' => 'required|max_length[255]',
            'subtitle' => 'permit_empty|max_length[255]',
            'content' => 'permit_empty',
            'button_text' => 'permit_empty|max_length[100]',
            'button_link' => 'permit_empty|max_length[255]',
            'display_order' => 'permit_empty|integer',
            'is_active' => 'permit_empty|in_list[0,1]',
            'image' => [
                'rules' => 'permit_empty|uploaded[image]|max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar maksimal 2MB',
                    'is_image' => 'File harus berupa gambar',
                    'mime_in' => 'Format gambar harus JPG, JPEG, atau PNG'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'section' => $this->request->getPost('section'),
            'title' => $this->request->getPost('title'),
            'subtitle' => $this->request->getPost('subtitle'),
            'content' => $this->request->getPost('content'),
            'button_text' => $this->request->getPost('button_text'),
            'button_link' => $this->request->getPost('button_link'),
            'display_order' => $this->request->getPost('display_order') ?? 0,
            'is_active' => $this->request->getPost('is_active') ?? 1,
        ];

        // Handle image upload
        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            // Delete old image if exists
            if ($content['image']) {
                $oldImagePath = WRITEPATH . 'uploads/content/' . $content['image'];
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $newName = $image->getRandomName();
            $image->move(WRITEPATH . 'uploads/content', $newName);
            $data['image'] = $newName;
        }

        if ($this->homeContentModel->update($id, $data)) {
            return redirect()->to('/admin/content-management')->with('success', 'Konten berhasil diperbarui');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui konten');
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

        $content = $this->homeContentModel->find($id);
        if (!$content) {
            return redirect()->to('/admin/content-management')->with('error', 'Konten tidak ditemukan');
        }

        // Delete image file if exists
        if ($content['image']) {
            $imagePath = WRITEPATH . 'uploads/content/' . $content['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        if ($this->homeContentModel->delete($id)) {
            return redirect()->to('/admin/content-management')->with('success', 'Konten berhasil dihapus');
        } else {
            return redirect()->to('/admin/content-management')->with('error', 'Gagal menghapus konten');
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

        if ($this->homeContentModel->toggleStatus($id)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Status berhasil diubah']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal mengubah status']);
        }
    }
}
