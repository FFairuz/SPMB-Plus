<?php

namespace App\Controllers;

use App\Models\Major;
use App\Models\MajorQuota;
use App\Traits\RoleAuthTrait;

/**
 * Admin Major Quota Controller
 * 
 * Controller untuk admin mengelola kuota jurusan per tahun ajaran
 */
class AdminMajorQuotaController extends BaseController
{
    use RoleAuthTrait;

    protected $majorModel;
    protected $quotaModel;

    public function __construct()
    {
        $this->majorModel = new Major();
        $this->quotaModel = new MajorQuota();
    }

    /**
     * Daftar kuota jurusan
     */
    public function index()
    {
        $this->requireAdmin();

        $tahunAjaran = $this->request->getGet('tahun_ajaran');
        
        if ($tahunAjaran) {
            $quotas = $this->quotaModel->getQuotaStats($tahunAjaran);
        } else {
            $quotas = $this->quotaModel->getQuotaWithMajor();
        }

        $availableYears = $this->quotaModel->getAvailableYears() ?? [];

        return view('admin/quotas/index', [
            'title' => 'Kelola Kuota Jurusan',
            'quotas' => $quotas ?? [],
            'availableYears' => $availableYears,
            'selectedYear' => $tahunAjaran,
        ]);
    }

    /**
     * Tambah kuota baru
     */
    public function create()
    {
        $this->requireAdmin();

        if ($this->request->getMethod() === 'post') {
            $data = [
                'major_id' => $this->request->getPost('major_id'),
                'tahun_ajaran' => $this->request->getPost('tahun_ajaran'),
                'kuota_total' => $this->request->getPost('kuota_total'),
                'jalur_reguler' => $this->request->getPost('jalur_reguler') ?? 0,
                'jalur_prestasi' => $this->request->getPost('jalur_prestasi') ?? 0,
                'jalur_afirmasi' => $this->request->getPost('jalur_afirmasi') ?? 0,
                'status' => $this->request->getPost('status') ?? 'aktif',
                'keterangan' => $this->request->getPost('keterangan'),
            ];

            // Validasi tambahan: pastikan jumlah jalur tidak melebihi total
            $totalJalur = $data['jalur_reguler'] + $data['jalur_prestasi'] + $data['jalur_afirmasi'];
            if ($totalJalur > $data['kuota_total']) {
                session()->setFlashdata('error', 'Total kuota per jalur tidak boleh melebihi kuota total!');
                return redirect()->back()->withInput();
            }

            // Cek apakah kombinasi major_id dan tahun_ajaran sudah ada
            $existing = $this->quotaModel->getQuotaByMajorAndYear($data['major_id'], $data['tahun_ajaran']);
            if ($existing) {
                session()->setFlashdata('error', 'Kuota untuk jurusan dan tahun ajaran ini sudah ada!');
                return redirect()->back()->withInput();
            }

            if ($this->quotaModel->insert($data)) {
                session()->setFlashdata('success', 'Kuota jurusan berhasil ditambahkan!');
                return redirect()->to('/admin/quotas');
            } else {
                session()->setFlashdata('error', 'Gagal menambahkan kuota jurusan!');
                session()->setFlashdata('validation', $this->quotaModel->errors());
                return redirect()->back()->withInput();
            }
        }

        $majors = $this->majorModel->getActiveMajors();

        return view('admin/quotas/create', [
            'title' => 'Tambah Kuota Jurusan',
            'majors' => $majors,
            'validation' => session()->getFlashdata('validation'),
        ]);
    }

    /**
     * Edit kuota
     */
    public function edit($id)
    {
        $this->requireAdmin();

        $quota = $this->quotaModel->getQuotaWithMajor($id);
        if (!$quota) {
            session()->setFlashdata('error', 'Kuota tidak ditemukan!');
            return redirect()->to('/admin/quotas');
        }

        if ($this->request->getMethod() === 'post') {
            $data = [
                'tahun_ajaran' => $this->request->getPost('tahun_ajaran'),
                'kuota_total' => $this->request->getPost('kuota_total'),
                'jalur_reguler' => $this->request->getPost('jalur_reguler') ?? 0,
                'jalur_prestasi' => $this->request->getPost('jalur_prestasi') ?? 0,
                'jalur_afirmasi' => $this->request->getPost('jalur_afirmasi') ?? 0,
                'status' => $this->request->getPost('status'),
                'keterangan' => $this->request->getPost('keterangan'),
            ];

            // Validasi tambahan
            $totalJalur = $data['jalur_reguler'] + $data['jalur_prestasi'] + $data['jalur_afirmasi'];
            if ($totalJalur > $data['kuota_total']) {
                session()->setFlashdata('error', 'Total kuota per jalur tidak boleh melebihi kuota total!');
                return redirect()->back()->withInput();
            }

            // Cek jangan sampai kuota total lebih kecil dari kuota terisi
            if ($data['kuota_total'] < $quota['kuota_terisi']) {
                session()->setFlashdata('error', 'Kuota total tidak boleh lebih kecil dari kuota yang sudah terisi (' . $quota['kuota_terisi'] . ')!');
                return redirect()->back()->withInput();
            }

            if ($this->quotaModel->update($id, $data)) {
                session()->setFlashdata('success', 'Kuota jurusan berhasil diperbarui!');
                return redirect()->to('/admin/quotas');
            } else {
                session()->setFlashdata('error', 'Gagal memperbarui kuota jurusan!');
                session()->setFlashdata('validation', $this->quotaModel->errors());
                return redirect()->back()->withInput();
            }
        }

        return view('admin/quotas/edit', [
            'title' => 'Edit Kuota Jurusan',
            'quota' => $quota,
            'validation' => session()->getFlashdata('validation'),
        ]);
    }

    /**
     * Hapus kuota
     */
    public function delete($id)
    {
        $this->requireAdmin();

        $quota = $this->quotaModel->find($id);
        if (!$quota) {
            session()->setFlashdata('error', 'Kuota tidak ditemukan!');
            return redirect()->to('/admin/quotas');
        }

        // Cek apakah kuota sudah terisi
        if ($quota['kuota_terisi'] > 0) {
            session()->setFlashdata('error', 'Tidak dapat menghapus kuota yang sudah terisi!');
            return redirect()->to('/admin/quotas');
        }

        if ($this->quotaModel->delete($id)) {
            session()->setFlashdata('success', 'Kuota jurusan berhasil dihapus!');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus kuota jurusan!');
        }

        return redirect()->to('/admin/quotas');
    }

    /**
     * Reset kuota terisi
     */
    public function resetQuotaTerisi($id)
    {
        $this->requireAdmin();

        $quota = $this->quotaModel->find($id);
        if (!$quota) {
            session()->setFlashdata('error', 'Kuota tidak ditemukan!');
            return redirect()->to('/admin/quotas');
        }

        if ($this->quotaModel->update($id, ['kuota_terisi' => 0])) {
            session()->setFlashdata('success', 'Kuota terisi berhasil direset!');
        } else {
            session()->setFlashdata('error', 'Gagal mereset kuota terisi!');
        }

        return redirect()->to('/admin/quotas');
    }

    /**
     * View statistik kuota
     */
    public function statistics()
    {
        $this->requireAdmin();

        $tahunAjaran = $this->request->getGet('tahun_ajaran');
        
        if (!$tahunAjaran) {
            // Ambil tahun ajaran terbaru
            $years = $this->quotaModel->getAvailableYears();
            $tahunAjaran = $years[0] ?? null;
        }

        $quotaStats = $this->quotaModel->getQuotaStats($tahunAjaran);
        $availableYears = $this->quotaModel->getAvailableYears();

        // Hitung total statistik
        $totalKuota = 0;
        $totalTerisi = 0;
        foreach ($quotaStats as $stat) {
            $totalKuota += $stat['kuota_total'];
            $totalTerisi += $stat['kuota_terisi'];
        }

        $persentaseKeseluruhan = $totalKuota > 0 ? round(($totalTerisi / $totalKuota * 100), 2) : 0;

        return view('admin/quotas/statistics', [
            'title' => 'Statistik Kuota Jurusan',
            'quotaStats' => $quotaStats,
            'availableYears' => $availableYears,
            'selectedYear' => $tahunAjaran,
            'totalKuota' => $totalKuota,
            'totalTerisi' => $totalTerisi,
            'totalSisa' => $totalKuota - $totalTerisi,
            'persentaseKeseluruhan' => $persentaseKeseluruhan,
        ]);
    }
}
