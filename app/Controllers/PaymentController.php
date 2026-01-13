<?php

namespace App\Controllers;

use App\Models\Applicant;
use App\Models\PaymentModel;
use App\Models\User;
use App\Helpers\ReceiptHelper;

class PaymentController extends BaseController
{
    protected $paymentModel;
    protected $applicantModel;
    protected $userModel;

    public function __construct()
    {
        $this->paymentModel = new PaymentModel();
        $this->applicantModel = new Applicant();
        $this->userModel = new User();
    }

    // Applicant - View payment status
    public function index()
    {
        if (!session()->get('user_id')) {
            return redirect()->to('/auth/login');
        }

        $userId = session()->get('user_id');
        $applicant = $this->applicantModel->where('user_id', $userId)->first();

        if (!$applicant) {
            return redirect()->to('/applicant/dashboard')->with('error', 'Data pendaftar tidak ditemukan');
        }

        $payment = $this->paymentModel->getPaymentByApplicantId($applicant['id']);

        if (!$payment) {
            // Buat payment record baru
            $this->paymentModel->insert([
                'applicant_id' => $applicant['id'],
                'registration_fee' => 250000,
                'payment_status' => 'pending',
            ]);
            $payment = $this->paymentModel->getPaymentByApplicantId($applicant['id']);
        }

        return view('payment/applicant_payment', [
            'payment' => $payment,
            'applicant' => $applicant,
        ]);
    }

    // Applicant - Upload bukti transfer
    public function uploadProof()
    {
        if (!session()->get('user_id')) {
            return redirect()->to('/auth/login');
        }

        $userId = session()->get('user_id');
        $applicant = $this->applicantModel->where('user_id', $userId)->first();

        if (!$applicant) {
            return json_encode(['success' => false, 'message' => 'Data pendaftar tidak ditemukan']);
        }

        $payment = $this->paymentModel->getPaymentByApplicantId($applicant['id']);

        if (!$payment) {
            return json_encode(['success' => false, 'message' => 'Data pembayaran tidak ditemukan']);
        }

        $file = $this->request->getFile('transfer_proof');

        if (!$file->isValid()) {
            return json_encode(['success' => false, 'message' => 'File tidak valid']);
        }

        // Validate file
        if (!$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads/payments/', $fileName);

            $this->paymentModel->update($payment['id'], [
                'transfer_proof_path' => $fileName,
                'transfer_date' => $this->request->getPost('transfer_date'),
                'transfer_amount' => $this->request->getPost('transfer_amount'),
                'account_holder' => $this->request->getPost('account_holder'),
                'bank_name' => $this->request->getPost('bank_name'),
                'payment_status' => 'submitted',
            ]);

            return json_encode([
                'success' => true,
                'message' => 'Bukti transfer berhasil diupload. Menunggu konfirmasi admin.',
            ]);
        }

        return json_encode(['success' => false, 'message' => 'Gagal mengupload file']);
    }

    // Admin - View all payments
    public function adminPayments()
    {
        if (!session()->get('is_admin')) {
            return redirect()->to('/auth/login');
        }

        $status = $this->request->getGet('status') ?? 'pending';
        $payments = $this->paymentModel->getPaymentsByStatus($status);
        $stats = $this->paymentModel->getPaymentStats();

        return view('admin/payments', [
            'payments' => $payments,
            'stats' => $stats,
            'current_status' => $status,
        ]);
    }

    // Admin - Confirm payment
    public function confirmPayment($paymentId)
    {
        if (!session()->get('is_admin')) {
            return json_encode(['success' => false, 'message' => 'Unauthorized']);
        }

        $payment = $this->paymentModel->find($paymentId);

        if (!$payment) {
            return json_encode(['success' => false, 'message' => 'Pembayaran tidak ditemukan']);
        }

        $this->paymentModel->updatePaymentStatus(
            $paymentId,
            'confirmed',
            session()->get('user_id')
        );

        // Update applicant status ke verified
        $this->applicantModel->update($payment['applicant_id'], [
            'status' => 'verified',
        ]);

        return json_encode([
            'success' => true,
            'message' => 'Pembayaran berhasil dikonfirmasi. Formulir pendaftaran dibuka untuk pendaftar.',
        ]);
    }

    // Admin - Reject payment
    public function rejectPayment($paymentId)
    {
        if (!session()->get('is_admin')) {
            return json_encode(['success' => false, 'message' => 'Unauthorized']);
        }

        $payment = $this->paymentModel->find($paymentId);

        if (!$payment) {
            return json_encode(['success' => false, 'message' => 'Pembayaran tidak ditemukan']);
        }

        $notes = $this->request->getPost('notes') ?? '';

        $this->paymentModel->update($paymentId, [
            'payment_status' => 'rejected',
            'notes' => $notes,
        ]);

        return json_encode([
            'success' => true,
            'message' => 'Pembayaran ditolak.',
        ]);
    }

    // Admin - View payment detail
    public function viewPayment($paymentId)
    {
        if (!session()->get('is_admin')) {
            return redirect()->to('/auth/login');
        }

        $payment = $this->paymentModel->getPaymentWithApplicant($paymentId);

        if (!$payment) {
            return redirect()->to('/admin/payments')->with('error', 'Pembayaran tidak ditemukan');
        }

        return view('admin/payment_detail', [
            'payment' => $payment,
        ]);
    }

    // Admin - Manual payment entry
    public function manualPaymentEntry()
    {
        if (!session()->get('is_admin')) {
            return redirect()->to('/auth/login');
        }

        if ($this->request->getMethod() === 'post') {
            $applicantId = $this->request->getPost('applicant_id');
            $transferAmount = $this->request->getPost('transfer_amount');
            $transferDate = $this->request->getPost('transfer_date');
            $bankName = $this->request->getPost('bank_name');
            $accountHolder = $this->request->getPost('account_holder');

            $existingPayment = $this->paymentModel->getPaymentByApplicantId($applicantId);

            if ($existingPayment) {
                $this->paymentModel->update($existingPayment['id'], [
                    'transfer_amount' => $transferAmount,
                    'transfer_date' => $transferDate,
                    'bank_name' => $bankName,
                    'account_holder' => $accountHolder,
                    'payment_status' => 'submitted',
                ]);
            } else {
                $this->paymentModel->insert([
                    'applicant_id' => $applicantId,
                    'registration_fee' => 250000,
                    'transfer_amount' => $transferAmount,
                    'transfer_date' => $transferDate,
                    'bank_name' => $bankName,
                    'account_holder' => $accountHolder,
                    'payment_status' => 'submitted',
                ]);
            }

            return redirect()->to('/admin/payments?status=submitted')->with(
                'success',
                'Data pembayaran berhasil ditambahkan'
            );
        }

        $applicants = $this->applicantModel->findAll();

        return view('admin/manual_payment_entry', [
            'applicants' => $applicants,
        ]);
    }
}
