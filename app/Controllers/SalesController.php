<?php

namespace App\Controllers;

use App\Models\Applicant;
use App\Models\PaymentModel;
use App\Models\GuestBook;
use App\Models\School;
use App\Models\SalesContent;
use App\Traits\RoleAuthTrait;

class SalesController extends BaseController
{
    use RoleAuthTrait;
    
    protected $applicantModel;
    protected $paymentModel;
    protected $guestBookModel;
    protected $schoolModel;
    protected $salesContentModel;
    protected $helpers = ['form', 'url'];

    public function __construct()
    {
        $this->applicantModel = new Applicant();
        $this->paymentModel = new PaymentModel();
        $this->guestBookModel = new GuestBook();
        $this->schoolModel = new School();
        $this->salesContentModel = new SalesContent();
    }

    /**
     * Sales Dashboard - Display registration statistics, brochure, and profile video
     */
    public function dashboard()
    {
        $this->requireSales();
        
        log_message('debug', 'SalesController::dashboard - User logged in, role: ' . session()->get('role'));

        // Get registration statistics
        $totalApplicants = $this->applicantModel->countAll();
        $approvedApplicants = 0;
        $rejectedApplicants = 0;
        $pendingApplicants = 0;

        // Get payment statistics
        $totalPayments = $this->paymentModel->countAll();
        $verifiedPayments = 0;
        $pendingPayments = 0;

        // Get registration statistics by month (last 6 months for graph)
        $registrationTrend = $this->getRegistrationTrend();

        $data = [
            'title' => 'Dashboard Sales',
            'totalApplicants' => $totalApplicants,
            'approvedApplicants' => $approvedApplicants,
            'rejectedApplicants' => $rejectedApplicants,
            'pendingApplicants' => $pendingApplicants,
            'totalPayments' => $totalPayments,
            'verifiedPayments' => $verifiedPayments,
            'pendingPayments' => $pendingPayments,
            'registrationTrend' => $registrationTrend,
        ];

        return view('sales/dashboard', $data);
    }

    /**
     * Get registration trend for the last 6 months
     */
    private function getRegistrationTrend()
    {
        $db = \Config\Database::connect();
        $query = $db->query("
            SELECT 
                DATE_FORMAT(created_at, '%Y-%m') as bulan,
                COUNT(*) as jumlah
            FROM applicants_dapodik
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
            GROUP BY DATE_FORMAT(created_at, '%Y-%m')
            ORDER BY bulan ASC
        ");

        $result = $query->getResultArray();
        
        // Ensure we have data for all 6 months
        $months = [];
        $counts = [];
        
        if (!empty($result)) {
            foreach ($result as $row) {
                $months[] = $row['bulan'];
                $counts[] = $row['jumlah'];
            }
        }

        return [
            'months' => $months,
            'counts' => $counts,
        ];
    }

    /**
     * View school brochure
     */
    public function brochure()
    {
        $this->requireSales();

        $data = [
            'title' => 'Brosur Sekolah',
            'brochures' => $this->salesContentModel->getByType('brochure'),
        ];

        return view('sales/brochure', $data);
    }

    /**
     * View school profile video
     */
    public function video()
    {
        $this->requireSales();

        $data = [
            'title' => 'Video Profil Sekolah',
            'videos' => $this->salesContentModel->getByType('video'),
        ];

        return view('sales/video', $data);
    }

    /**
     * Informasi biaya pendaftaran
     */
    public function informasi_biaya()
    {
        $this->requireSales();

        // Get fee info from database
        $feeInfoData = $this->salesContentModel->getByType('fee_info');
        
        // Build biaya array from database or use default
        $biaya = [];
        if (!empty($feeInfoData)) {
            foreach ($feeInfoData as $fee) {
                $category = strtolower($fee['fee_category'] ?? 'lainnya');
                $biaya[$category] = $fee['fee_amount'] ?? 0;
            }
        } else {
            // Default values if no data in database
            $biaya = [
                'pendaftaran' => 150000,
                'formulir' => 50000,
                'perpustakaan' => 100000,
                'lab' => 200000,
            ];
        }

        $data = [
            'title' => 'Informasi Biaya Pendaftaran',
            'biaya' => $biaya,
            'feeInfoList' => $feeInfoData,
        ];

        return view('sales/informasi_biaya', $data);
    }

    /**
     * Display buku tamu form
     */
    public function buku_tamu()
    {
        $this->requireSales();

        $data = [
            'title' => 'Buku Tamu',
            'schools' => $this->schoolModel->orderBy('provinsi')->orderBy('kota')->orderBy('nama')->findAll(),
        ];

        return view('sales/buku_tamu_form', $data);
    }

    /**
     * Save buku tamu entry
     */
    public function save_buku_tamu()
    {
        $this->requireSales();

        if (!$this->validate($this->guestBookModel->validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->guestBookModel->save([
            'nama' => $this->request->getPost('nama'),
            'school_id' => $this->request->getPost('school_id'),
            'no_hp' => $this->request->getPost('no_hp'),
            'sumber_info' => $this->request->getPost('sumber_info'),
        ]);

        session()->setFlashdata('success', 'Data buku tamu berhasil disimpan');
        return redirect()->to('sales/buku-tamu');
    }

    /**
     * Display tracking form list
     */
    public function tracking_form()
    {
        $this->requireSales();

        $perPage = 20;
        $data = [
            'title' => 'Tracking Form',
            'guestBooks' => $this->guestBookModel->getPaginated($perPage),
            'pager' => $this->guestBookModel->pager,
            'total' => $this->guestBookModel->countAll(),
        ];

        return view('sales/tracking_form', $data);
    }

    /**
     * Display buku tamu dashboard
     */
    public function buku_tamu_dashboard()
    {
        $this->requireSales();

        $data = [
            'title' => 'Dashboard Buku Tamu',
            'statistics' => $this->guestBookModel->getStatistics(),
            'sourceStats' => $this->guestBookModel->getSourceStatistics(),
            'schoolStats' => $this->guestBookModel->getSchoolStatistics(),
        ];

        return view('sales/buku_tamu_dashboard', $data);
    }

    /**
     * Display buku tamu map
     */
    public function buku_tamu_map()
    {
        $this->requireSales();

        $allData = $this->guestBookModel->getAllWithSchool();

        $data = [
            'title' => 'Peta Sekolah Asal',
            'guestBooks' => $allData,
        ];

        return view('sales/buku_tamu_map', $data);
    }

    /**
     * Export buku tamu data to CSV
     */
    public function export_buku_tamu()
    {
        $this->requireSales();

        $guestBooks = $this->guestBookModel->getAllWithSchool();

        // Create CSV header
        $output = "No,Nama,Asal Sekolah,Kota,Provinsi,No HP,Sumber Info,Tanggal\n";

        foreach ($guestBooks as $i => $guest) {
            $output .= ($i + 1) . ",";
            $output .= '"' . $guest['nama'] . '",';
            $output .= '"' . $guest['asal_sekolah'] . '",';
            $output .= '"' . $guest['kota'] . '",';
            $output .= '"' . $guest['provinsi'] . '",';
            $output .= '"' . $guest['no_hp'] . '",';
            $output .= '"' . $guest['sumber_info'] . '",';
            $output .= $guest['created_at'] . "\n";
        }

        // Return as downloadable CSV
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="buku_tamu_' . date('Y-m-d_H-i-s') . '.csv"');
        echo $output;
        exit;
    }
}
