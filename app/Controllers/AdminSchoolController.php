<?php

namespace App\Controllers;

use App\Models\School;
use App\Traits\RoleAuthTrait;

class AdminSchoolController extends BaseController
{
    use RoleAuthTrait;

    protected $schoolModel;
    protected $helpers = ['form', 'url'];

    public function __construct()
    {
        $this->schoolModel = new School();
    }

    /**
     * Display list of schools
     */
    public function index()
    {
        $this->requireAdmin();

        $keyword = $this->request->getGet('keyword');
        $perPage = 20;

        if ($keyword) {
            $schools = $this->schoolModel->search($keyword);
            $total = count($schools);
            // Simple pagination for search results
            $schools = array_slice($schools, 0, $perPage);
        } else {
            $schools = $this->schoolModel->paginate($perPage);
            $total = $this->schoolModel->countAll();
        }

        $data = [
            'title' => 'Manajemen Asal Sekolah',
            'schools' => $schools,
            'total' => $total,
            'keyword' => $keyword ?? '',
            'pager' => !$keyword ? $this->schoolModel->pager : null,
        ];

        return view('admin/school_list', $data);
    }

    /**
     * Show form to add new school
     */
    public function add()
    {
        $this->requireAdmin();

        $data = [
            'title' => 'Tambah Sekolah Baru',
            'action' => 'add',
            'school' => [],
        ];

        return view('admin/school_form', $data);
    }

    /**
     * Save new school
     */
    public function save()
    {
        $this->requireAdmin();

        if (!$this->validate($this->schoolModel->validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->schoolModel->save([
            'nama' => $this->request->getPost('nama'),
            'npsn' => $this->request->getPost('npsn') ?? null,
            'kota' => $this->request->getPost('kota'),
            'provinsi' => $this->request->getPost('provinsi'),
            'alamat' => $this->request->getPost('alamat'),
        ]);

        session()->setFlashdata('success', 'Sekolah berhasil ditambahkan');
        return redirect()->to('admin/schools');
    }

    /**
     * Show form to edit school
     */
    public function edit($id = null)
    {
        $this->requireAdmin();

        $school = $this->schoolModel->find($id);
        if (!$school) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Sekolah tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Sekolah',
            'action' => 'edit',
            'school' => $school,
        ];

        return view('admin/school_form', $data);
    }

    /**
     * Update school data
     */
    public function update($id = null)
    {
        $this->requireAdmin();

        $school = $this->schoolModel->find($id);
        if (!$school) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Sekolah tidak ditemukan');
        }

        if (!$this->validate($this->schoolModel->validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->schoolModel->update($id, [
            'nama' => $this->request->getPost('nama'),
            'npsn' => $this->request->getPost('npsn') ?? null,
            'kota' => $this->request->getPost('kota'),
            'provinsi' => $this->request->getPost('provinsi'),
            'alamat' => $this->request->getPost('alamat'),
        ]);

        session()->setFlashdata('success', 'Sekolah berhasil diperbarui');
        return redirect()->to('admin/schools');
    }

    /**
     * Delete school
     */
    public function delete($id = null)
    {
        $this->requireAdmin();

        $school = $this->schoolModel->find($id);
        if (!$school) {
            return redirect()->to('admin/schools')->with('error', 'Sekolah tidak ditemukan');
        }

        $this->schoolModel->delete($id);

        session()->setFlashdata('success', 'Sekolah berhasil dihapus');
        return redirect()->to('admin/schools');
    }

    /**
     * Search schools (API endpoint for autocomplete)
     */
    public function searchApi()
    {
        $this->requireAdmin();

        $keyword = $this->request->getGet('q');
        $limit = 20;

        if (strlen($keyword) < 2) {
            return $this->response->setJSON(['results' => []]);
        }

        $schools = $this->schoolModel->select('id, nama, npsn, kota, provinsi')
            ->like('nama', $keyword)
            ->orLike('kota', $keyword)
            ->orLike('npsn', $keyword)
            ->orderBy('provinsi')
            ->orderBy('kota')
            ->orderBy('nama')
            ->limit($limit)
            ->findAll();

        $results = array_map(function ($school) {
            return [
                'id' => $school['id'],
                'text' => $school['nama'] . ' (' . $school['kota'] . ', ' . $school['provinsi'] . ')',
                'npsn' => $school['npsn'] ?? '-',
                'data' => $school,
            ];
        }, $schools);

        return $this->response->setJSON(['results' => $results]);
    }

    /**
     * Get school detail (API endpoint)
     */
    public function getDetail($id = null)
    {
        $this->requireAdmin();

        $school = $this->schoolModel->find($id);
        if (!$school) {
            return $this->response->setJSON(['error' => 'School not found'], 404);
        }

        return $this->response->setJSON($school);
    }

    /**
     * Show import Excel form for schools
     */
    public function importForm()
    {
        $this->requireAdmin();

        return view('admin/import_schools_excel', [
            'title' => 'Import Data Asal Sekolah dari Excel',
        ]);
    }

    /**
     * Process Excel file upload and import schools data
     */
    public function processImport()
    {
        $this->requireAdmin();

        $file = $this->request->getFile('excel_file');

        // Validate file
        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', 'File tidak valid atau tidak ada');
        }

        // Check file extension
        $allowedExtensions = ['xlsx', 'xls', 'csv'];
        if (!in_array(strtolower($file->getClientExtension()), $allowedExtensions)) {
            return redirect()->back()->with('error', 'Format file harus Excel (.xlsx, .xls) atau CSV');
        }

        try {
            $filePath = $file->getTempName();
            
            // Load Excel file
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            
            $rows = $worksheet->toArray();
            
            if (empty($rows)) {
                return redirect()->back()->with('error', 'File Excel kosong');
            }

            // Skip header row
            $headerRow = array_shift($rows);
            
            $successCount = 0;
            $errorCount = 0;
            $errors = [];

            // Process each row
            foreach ($rows as $index => $row) {
                // Skip empty rows
                if (empty(array_filter($row))) {
                    continue;
                }

                $rowNumber = $index + 2; // +2 because we removed header and arrays are 0-indexed

                // Map Excel columns to database fields
                $data = [
                    'nama' => isset($row[0]) ? (string)$row[0] : null,
                    'npsn' => isset($row[1]) ? (string)$row[1] : null,
                    'kota' => isset($row[2]) ? (string)$row[2] : null,
                    'provinsi' => isset($row[3]) ? (string)$row[3] : null,
                    'alamat' => isset($row[4]) ? (string)$row[4] : null,
                ];

                // Validate required fields
                if (empty($data['nama']) || empty($data['kota']) || empty($data['provinsi'])) {
                    $errorCount++;
                    $errors[] = "Baris {$rowNumber}: Nama, Kota, dan Provinsi harus diisi";
                    continue;
                }

                // Check if school already exists (by name and city)
                $existing = $this->schoolModel
                    ->where('nama', $data['nama'])
                    ->where('kota', $data['kota'])
                    ->first();

                if ($existing) {
                    $errorCount++;
                    $errors[] = "Baris {$rowNumber}: Sekolah '{$data['nama']}' di {$data['kota']} sudah terdaftar";
                    continue;
                }

                // Insert data
                if ($this->schoolModel->insert($data)) {
                    $successCount++;
                } else {
                    $errorCount++;
                    $errors[] = "Baris {$rowNumber}: Gagal menyimpan data ({$data['nama']})";
                }
            }

            // Prepare message
            $message = "Berhasil import {$successCount} data asal sekolah";
            if ($errorCount > 0) {
                $message .= " ({$errorCount} data gagal)";
                session()->setFlashdata('warning', $message);
                session()->setFlashdata('import_errors', $errors);
            } else {
                session()->setFlashdata('success', $message);
            }

            return redirect()->to('admin/schools');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error membaca file: ' . $e->getMessage());
        }
    }

    /**
     * Download template Excel for schools import
     */
    public function downloadTemplate()
    {
        $this->requireAdmin();

        try {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Set header row
            $headers = [
                'Nama Sekolah',
                'NPSN',
                'Kota',
                'Provinsi',
                'Alamat'
            ];
            
            // Write headers
            for ($col = 0; $col < count($headers); $col++) {
                $sheet->setCellValueByColumnAndRow($col + 1, 1, $headers[$col]);
                
                // Style header
                $cell = $sheet->getCellByColumnAndRow($col + 1, 1);
                $cell->getStyle()->getFont()->setBold(true);
                $cell->getStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $cell->getStyle()->getFill()->getStartColor()->setARGB('FF4472C4');
                $cell->getStyle()->getFont()->getColor()->setARGB('FFFFFFFF');
                $cell->getStyle()->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            }
            
            // Add example data
            $sheet->setCellValue('A2', 'SMA Negeri 1 Jakarta');
            $sheet->setCellValue('B2', '20123456');
            $sheet->setCellValue('C2', 'Jakarta Pusat');
            $sheet->setCellValue('D2', 'DKI Jakarta');
            $sheet->setCellValue('E2', 'Jl. Merdeka No. 1, Jakarta Pusat');
            
            $sheet->setCellValue('A3', 'SMA Negeri 2 Bandung');
            $sheet->setCellValue('B3', '20223456');
            $sheet->setCellValue('C3', 'Bandung');
            $sheet->setCellValue('D3', 'Jawa Barat');
            $sheet->setCellValue('E3', 'Jl. Pendidikan No. 45, Bandung');
            
            // Set column widths
            $sheet->getColumnDimension('A')->setWidth(30);
            $sheet->getColumnDimension('B')->setWidth(15);
            $sheet->getColumnDimension('C')->setWidth(20);
            $sheet->getColumnDimension('D')->setWidth(20);
            $sheet->getColumnDimension('E')->setWidth(35);
            
            // Create writer
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            
            // Send to browser
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Template_Import_Asal_Sekolah.xlsx"');
            header('Cache-Control: max-age=0');
            
            $writer->save('php://output');
            exit;
            
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Gagal membuat template: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}
