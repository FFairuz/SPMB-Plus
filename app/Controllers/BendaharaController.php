<?php

namespace App\Controllers;

use App\Models\PaymentModel;
use App\Models\Applicant;
use App\Models\KopSurat;
use App\Traits\RoleAuthTrait;
use App\Helpers\ReceiptHelper;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * Bendahara Controller
 * 
 * Controller untuk bendahara yang bertugas:
 * - Menerima dan memverifikasi pembayaran
 * - Mencetak kwitansi pembayaran
 * - Membuat laporan keuangan
 */
class BendaharaController extends BaseController
{
    use RoleAuthTrait;

    protected $paymentModel;
    protected $applicantModel;

    public function __construct()
    {
        $this->paymentModel = new PaymentModel();
        $this->applicantModel = new Applicant();
    }

    /**
     * Dashboard bendahara
     * 
     * Menampilkan ringkasan keuangan
     */
    public function dashboard()
    {
        $this->requireBendahara();

        $stats = [
            'total_pending' => $this->paymentModel->where('payment_status', 'submitted')->countAllResults(),
            'total_confirmed' => $this->paymentModel->where('payment_status', 'confirmed')->countAllResults(),
            'total_verified' => $this->paymentModel->where('verified_by_bendahara !=', null)->countAllResults(),
            'total_printed_receipt' => $this->paymentModel->where('receipt_printed_at !=', null)->countAllResults(),
        ];

        // Calculate total collected
        $result = $this->paymentModel
            ->selectSum('transfer_amount')
            ->where('payment_status', 'confirmed')
            ->get()
            ->getRow();
        $stats['total_collected'] = $result->transfer_amount ?? 0;

        // Get recent payments for verification
        $recent_payments = $this->paymentModel
            ->select('payments.*, users.username, users.nama, applicants_dapodik.nama_lengkap, applicants_dapodik.nomor_pendaftaran')
            ->join('users', 'users.id = payments.user_id', 'LEFT')
            ->join('applicants_dapodik', 'applicants_dapodik.id = payments.applicant_id', 'LEFT')
            ->where('payments.payment_status', 'confirmed')
            ->where('payments.verified_by_bendahara', null)
            ->orderBy('payments.confirmed_at', 'DESC')
            ->limit(10)
            ->findAll();

        return view('bendahara/dashboard', [
            'title' => 'Dashboard Bendahara PPDB',
            'stats' => $stats,
            'recent_payments' => $recent_payments,
        ]);
    }

    /**
     * Verifikasi pembayaran - list pembayaran yang sudah dikonfirmasi admin
     */
    public function verifikasi_pembayaran()
    {
        $this->requireBendahara();

        $page = $this->request->getVar('page') ?? 1;
        $perPage = 20;
        $status = $this->request->getVar('status') ?? 'pending';

        $query = $this->paymentModel
            ->select('payments.*, users.username, users.nama, applicants_dapodik.nama_lengkap, applicants_dapodik.nomor_pendaftaran')
            ->join('users', 'users.id = payments.user_id', 'LEFT')
            ->join('applicants_dapodik', 'applicants_dapodik.id = payments.applicant_id', 'LEFT');

        // Filter berdasarkan status verifikasi
        if ($status === 'verified') {
            $query = $query->where('payments.verified_by_bendahara !=', null);
        } elseif ($status === 'unverified') {
            $query = $query->where('payments.verified_by_bendahara', null)
                          ->where('payments.payment_status', 'confirmed');
        } elseif ($status === 'receipt_printed') {
            $query = $query->where('payments.receipt_printed_at !=', null);
        }

        $payments = $query
            ->orderBy('payments.confirmed_at', 'DESC')
            ->paginate($perPage);

        $pager = $this->paymentModel->pager;

        return view('bendahara/verifikasi_pembayaran', [
            'title' => 'Verifikasi Pembayaran',
            'payments' => $payments,
            'pager' => $pager,
            'current_status' => $status,
        ]);
    }

    /**
     * Detail pembayaran dan verifikasi
     */
    public function detail_pembayaran($payment_id)
    {
        $this->requireBendahara();

        $payment = $this->paymentModel
            ->select('payments.*, users.username, users.nama, users.email, applicants_dapodik.nama_lengkap, applicants_dapodik.nomor_pendaftaran, applicants_dapodik.asal_sekolah')
            ->join('users', 'users.id = payments.user_id', 'LEFT')
            ->join('applicants_dapodik', 'applicants_dapodik.id = payments.applicant_id', 'LEFT')
            ->where('payments.id', $payment_id)
            ->first();

        if (!$payment) {
            session()->setFlashdata('error', 'Data pembayaran tidak ditemukan.');
            return redirect()->to('/bendahara/verifikasi_pembayaran');
        }

        return view('bendahara/detail_pembayaran', [
            'title' => 'Detail Pembayaran',
            'payment' => $payment,
        ]);
    }

    /**
     * Verifikasi pembayaran (update status verified)
     */
    public function terima_pembayaran($payment_id)
    {
        $this->requireBendahara();

        $payment = $this->paymentModel->find($payment_id);

        if (!$payment) {
            session()->setFlashdata('error', 'Data pembayaran tidak ditemukan.');
            return redirect()->to('/bendahara/verifikasi_pembayaran');
        }

        // Hanya bisa verifikasi pembayaran yang sudah dikonfirmasi admin
        if ($payment['payment_status'] !== 'confirmed') {
            session()->setFlashdata('error', 'Hanya pembayaran yang sudah dikonfirmasi admin yang bisa diverifikasi.');
            return redirect()->back();
        }

        $user_id = session()->get('user_id');

        $data = [
            'verified_by_bendahara' => $user_id,
            'verified_at' => date('Y-m-d H:i:s'),
        ];

        try {
            $this->paymentModel->update($payment_id, $data);
            session()->setFlashdata('success', 'Pembayaran berhasil diverifikasi.');
            return redirect()->to('/bendahara/detail_pembayaran/' . $payment_id);
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Gagal memverifikasi pembayaran: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Laporan keuangan
     */
    public function laporan_keuangan()
    {
        $this->requireBendahara();

        $start_date = $this->request->getVar('start_date') ?? date('Y-m-01');
        $end_date = $this->request->getVar('end_date') ?? date('Y-m-t');

        // Get summary
        $total_confirmed = $this->paymentModel
            ->selectSum('transfer_amount')
            ->where('DATE(confirmed_at) >=', $start_date)
            ->where('DATE(confirmed_at) <=', $end_date)
            ->where('payment_status', 'confirmed')
            ->get()
            ->getRow()
            ->transfer_amount ?? 0;

        $total_verified = $this->paymentModel
            ->selectSum('transfer_amount')
            ->where('DATE(verified_at) >=', $start_date)
            ->where('DATE(verified_at) <=', $end_date)
            ->where('verified_by_bendahara !=', null)
            ->get()
            ->getRow()
            ->transfer_amount ?? 0;

        // Get detailed list
        $payments = $this->paymentModel
            ->select('payments.*, users.username, users.nama, applicants_dapodik.nama_lengkap, applicants_dapodik.nomor_pendaftaran')
            ->join('users', 'users.id = payments.user_id', 'LEFT')
            ->join('applicants_dapodik', 'applicants_dapodik.id = payments.applicant_id', 'LEFT')
            ->where('DATE(payments.confirmed_at) >=', $start_date)
            ->where('DATE(payments.confirmed_at) <=', $end_date)
            ->where('payments.payment_status', 'confirmed')
            ->orderBy('payments.confirmed_at', 'ASC')
            ->findAll();

        // Count statistics
        $total_transactions = count($payments);
        $total_verified_count = $this->paymentModel
            ->where('DATE(verified_at) >=', $start_date)
            ->where('DATE(verified_at) <=', $end_date)
            ->where('verified_by_bendahara !=', null)
            ->countAllResults();
        
        $total_pending_count = $this->paymentModel
            ->where('DATE(confirmed_at) >=', $start_date)
            ->where('DATE(confirmed_at) <=', $end_date)
            ->where('payment_status', 'confirmed')
            ->where('verified_by_bendahara', null)
            ->countAllResults();

        $stats = [
            'total_collected' => $total_confirmed,
            'total_transactions' => $total_transactions,
            'total_verified' => $total_verified_count,
            'total_pending' => $total_pending_count,
        ];

        return view('bendahara/laporan_keuangan', [
            'title' => 'Laporan Keuangan',
            'payments' => $payments,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'stats' => $stats,
            'total_confirmed' => $total_confirmed,
            'total_verified' => $total_verified,
        ]);
    }

    /**
     * Pembayaran offline/di tempat
     */
    public function pembayaran_offline()
    {
        $this->requireBendahara();

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'applicant_id' => 'required',
                'payment_amount' => 'required|numeric',
                'payment_date' => 'required|valid_date[Y-m-d]',
                'payment_method' => 'required',
                'payment_type' => 'required|in_list[lunas,cicilan]',
                'installment_number' => 'permit_empty|in_list[1,2,3,4,5,6,7,8,9,10]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $applicantId = $this->request->getPost('applicant_id');
            $paymentAmount = $this->request->getPost('payment_amount');
            $paymentDate = $this->request->getPost('payment_date');
            $paymentMethod = $this->request->getPost('payment_method');
            $paymentType = $this->request->getPost('payment_type');
            $installmentNumber = $this->request->getPost('installment_number');
            $notes = $this->request->getPost('notes');

            try {
                $payment = $this->paymentModel->where('applicant_id', $applicantId)->first();
                $now = date('Y-m-d H:i:s');
                $bendaharaId = session()->get('user_id');

                if (!$payment) {
                    $this->paymentModel->insert([
                        'applicant_id' => $applicantId,
                        'transfer_amount' => $paymentAmount,
                        'transfer_date' => $paymentDate,
                        'bank_name' => $paymentMethod,
                        'payment_type' => $paymentType,
                        'installment_number' => $installmentNumber,
                        'notes' => $notes,
                        'payment_status' => 'confirmed',
                        'confirmed_at' => $now,
                        'verified_by_bendahara' => $bendaharaId,
                        'verified_at' => $now,
                    ]);
                } else {
                    $this->paymentModel->update($payment['id'], [
                        'transfer_amount' => $paymentAmount,
                        'transfer_date' => $paymentDate,
                        'bank_name' => $paymentMethod,
                        'payment_type' => $paymentType,
                        'installment_number' => $installmentNumber,
                        'notes' => $notes,
                        'payment_status' => 'confirmed',
                        'confirmed_at' => $now,
                        'verified_by_bendahara' => $bendaharaId,
                        'verified_at' => $now,
                    ]);
                }

                session()->setFlashdata('success', 'Pembayaran offline berhasil dicatat.');
                return redirect()->to('/bendahara/verifikasi-pembayaran');
            } catch (\Exception $e) {
                session()->setFlashdata('error', 'Error: ' . $e->getMessage());
                return redirect()->back()->withInput();
            }
        }

        $applicants = $this->applicantModel->findAll();

        return view('bendahara/pembayaran_offline', [
            'applicants' => $applicants,
        ]);
    }

    /**
     * Cetak bukti pembayaran
     */
    public function cetak_bukti($paymentId = null)
    {
        $this->requireBendahara();

        if ($paymentId) {
            $payment = $this->paymentModel->find($paymentId);

            if (!$payment) {
                session()->setFlashdata('error', 'Data pembayaran tidak ditemukan.');
                return redirect()->to('/bendahara/verifikasi-pembayaran');
            }

            return view('bendahara/cetak_bukti_single', [
                'payment' => $payment,
            ]);
        }

        $payments = $this->paymentModel
            ->select('payments.*, applicants_dapodik.nama_lengkap, applicants_dapodik.nomor_pendaftaran')
            ->join('applicants_dapodik', 'applicants_dapodik.id = payments.applicant_id', 'LEFT')
            ->where('payments.payment_status', 'confirmed')
            ->orderBy('payments.created_at', 'DESC')
            ->findAll();

        return view('bendahara/cetak_bukti', [
            'payments' => $payments,
        ]);
    }

    /**
     * Cetak bukti pembayaran single dengan kop surat (setengah A4)
     */
    public function cetak_bukti_pembayaran($paymentId = null)
    {
        $this->requireBendahara();

        if (!$paymentId) {
            session()->setFlashdata('error', 'ID pembayaran tidak valid.');
            return redirect()->to('/bendahara/verifikasi-pembayaran');
        }

        $payment = $this->paymentModel
            ->select('payments.*, applicants_dapodik.nama_lengkap, applicants_dapodik.nomor_pendaftaran, applicants_dapodik.jenis_kelamin')
            ->join('applicants_dapodik', 'applicants_dapodik.id = payments.applicant_id', 'LEFT')
            ->where('payments.id', $paymentId)
            ->first();

        if (!$payment) {
            session()->setFlashdata('error', 'Data pembayaran tidak ditemukan.');
            return redirect()->to('/bendahara/verifikasi-pembayaran');
        }

        $kopSurat = (new KopSurat())->getKopSurat() ?? [
            'school_name' => 'SEKOLAH MENENGAH ATAS',
            'address' => 'Jalan Utama, Jakarta',
            'phone' => '(021) 123-4567',
            'email' => 'sekolah@example.com',
            'npsn' => '12345678',
            'logo_path' => null,
        ];

        return view('bendahara/cetak_bukti_pembayaran', [
            'payment' => $payment,
            'kopSurat' => $kopSurat,
        ]);
    }

    /**
     * Export Laporan Keuangan ke Excel
     */
    public function export_excel_keuangan()
    {
        $this->requireBendahara();

        $start_date = $this->request->getVar('start_date') ?? date('Y-m-01');
        $end_date = $this->request->getVar('end_date') ?? date('Y-m-t');

        // Get payments data
        $payments = $this->paymentModel
            ->select('payments.*, applicants_dapodik.nama_lengkap, applicants_dapodik.nomor_pendaftaran, applicants_dapodik.jenis_kelamin, applicants_dapodik.tempat_lahir, applicants_dapodik.tanggal_lahir')
            ->join('applicants_dapodik', 'applicants_dapodik.id = payments.applicant_id', 'LEFT')
            ->where('DATE(payments.confirmed_at) >=', $start_date)
            ->where('DATE(payments.confirmed_at) <=', $end_date)
            ->where('payments.payment_status', 'confirmed')
            ->orderBy('payments.confirmed_at', 'ASC')
            ->findAll();

        // Calculate totals
        $total_amount = 0;
        foreach ($payments as $p) {
            $total_amount += $p['transfer_amount'];
        }

        // Create spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Keuangan');

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(18);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(12);
        $sheet->getColumnDimension('G')->setWidth(18);
        $sheet->getColumnDimension('H')->setWidth(18);
        $sheet->getColumnDimension('I')->setWidth(15);

        // Header info
        $sheet->setCellValue('A1', 'LAPORAN KEUANGAN PENDAFTARAN SISWA BARU');
        $sheet->mergeCells('A1:I1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

        $periode = date('d-m-Y', strtotime($start_date)) . ' s/d ' . date('d-m-Y', strtotime($end_date));
        $sheet->setCellValue('A2', 'Periode: ' . $periode);
        $sheet->mergeCells('A2:I2');
        $sheet->getStyle('A2')->getFont()->setItalic(true);

        // Empty row
        $sheet->setCellValue('A3', '');

        // Table header
        $row = 4;
        $headers = ['No', 'Tanggal', 'No. Pendaftaran', 'Nama Siswa', 'Jenis Kelamin', 'Jumlah Bayar', 'Metode', 'Verifikasi', 'Keterangan'];
        
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . $row, $header);
            $sheet->getStyle($col . $row)->getFont()->setBold(true);
            $sheet->getStyle($col . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $sheet->getStyle($col . $row)->getFill()->getStartColor()->setARGB('FFD3D3D3');
            $col++;
        }

        // Data rows
        $row = 5;
        $no = 1;
        foreach ($payments as $payment) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, date('d-m-Y', strtotime($payment['confirmed_at'])));
            $sheet->setCellValue('C' . $row, $payment['nomor_pendaftaran'] ?? '-');
            $sheet->setCellValue('D' . $row, $payment['nama_lengkap'] ?? '-');
            $sheet->setCellValue('E' . $row, $payment['jenis_kelamin'] ?? '-');
            $sheet->setCellValue('F' . $row, $payment['transfer_amount']);
            $sheet->getStyle('F' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->setCellValue('G' . $row, $payment['bank_name'] ?? '-');
            $sheet->setCellValue('H' . $row, $payment['verified_by_bendahara'] ? 'Ya' : 'Belum');
            $sheet->setCellValue('I' . $row, 'Dikonfirmasi');
            
            $row++;
        }

        // Total row
        $row++;
        $sheet->setCellValue('A' . $row, 'TOTAL');
        $sheet->getStyle('A' . $row)->getFont()->setBold(true);
        $sheet->setCellValue('F' . $row, $total_amount);
        $sheet->getStyle('F' . $row)->getFont()->setBold(true);
        $sheet->getStyle('F' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('F' . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('F' . $row)->getFill()->getStartColor()->setARGB('FFFFFF00');

        // Auto-size columns
        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(false);
        }

        // Generate file
        $filename = 'Laporan_Keuangan_' . str_replace('/', '-', $periode) . '_' . date('His') . '.xlsx';
        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }
}

