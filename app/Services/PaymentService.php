<?php

namespace App\Services;

use App\Models\PaymentModel;
use App\Models\Applicant;

/**
 * PaymentService
 * 
 * Service untuk menangani business logic pembayaran
 */
class PaymentService
{
    /**
     * @var PaymentModel
     */
    private $paymentModel;

    /**
     * @var Applicant
     */
    private $applicantModel;

    /**
     * Payment statuses
     */
    public const STATUS_PENDING = 'pending';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_REJECTED = 'rejected';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->paymentModel = new PaymentModel();
        $this->applicantModel = new Applicant();
    }

    /**
     * Create payment record
     * 
     * @param array $paymentData Payment data
     * @return array ['success' => bool, 'message' => string, 'payment_id' => int|null]
     */
    public function createPayment(array $paymentData): array
    {
        // Set default status
        if (!isset($paymentData['payment_status'])) {
            $paymentData['payment_status'] = self::STATUS_PENDING;
        }

        // Set payment date if not provided
        if (!isset($paymentData['payment_date'])) {
            $paymentData['payment_date'] = date('Y-m-d H:i:s');
        }

        try {
            $paymentId = $this->paymentModel->insert($paymentData);

            if (!$paymentId) {
                $errors = $this->paymentModel->errors();
                $errorMessage = is_array($errors) ? implode(', ', $errors) : 'Gagal menyimpan pembayaran';
                return $this->failureResponse($errorMessage);
            }

            log_message('info', 'PAYMENT CREATED - Payment ID: ' . $paymentId . ' | User ID: ' . ($paymentData['user_id'] ?? 'N/A'));

            return [
                'success' => true,
                'message' => 'Pembayaran berhasil disimpan',
                'payment_id' => $paymentId,
            ];
        } catch (\Exception $e) {
            log_message('error', 'PAYMENT CREATION FAILED - ' . $e->getMessage());
            return $this->failureResponse('Terjadi kesalahan saat menyimpan pembayaran');
        }
    }

    /**
     * Upload payment proof
     * 
     * @param int $paymentId Payment ID
     * @param object $file Uploaded file
     * @return array ['success' => bool, 'message' => string, 'file_path' => string|null]
     */
    public function uploadPaymentProof(int $paymentId, $file): array
    {
        if (!$file->isValid()) {
            return $this->failureResponse('File tidak valid');
        }

        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
        if (!in_array($file->getMimeType(), $allowedTypes)) {
            return $this->failureResponse('Hanya file gambar (JPG, PNG) atau PDF yang diperbolehkan');
        }

        // Validate file size (max 2MB)
        if ($file->getSize() > 2048000) {
            return $this->failureResponse('Ukuran file maksimal 2MB');
        }

        try {
            // Generate unique filename
            $newName = 'payment_' . $paymentId . '_' . time() . '.' . $file->getExtension();
            
            // Move file to writable/uploads
            $file->move(WRITEPATH . 'uploads', $newName);
            
            $filePath = 'writable/uploads/' . $newName;

            // Update payment record with file path
            $updateResult = $this->paymentModel->update($paymentId, [
                'payment_proof' => $filePath,
            ]);

            if (!$updateResult) {
                return $this->failureResponse('Gagal menyimpan bukti pembayaran');
            }

            log_message('info', 'PAYMENT PROOF UPLOADED - Payment ID: ' . $paymentId . ' | File: ' . $newName);

            return [
                'success' => true,
                'message' => 'Bukti pembayaran berhasil diunggah',
                'file_path' => $filePath,
            ];
        } catch (\Exception $e) {
            log_message('error', 'PAYMENT PROOF UPLOAD FAILED - ' . $e->getMessage());
            return $this->failureResponse('Terjadi kesalahan saat mengunggah bukti pembayaran');
        }
    }

    /**
     * Verify payment (confirm/reject)
     * 
     * @param int $paymentId Payment ID
     * @param string $status New status (confirmed/rejected)
     * @param string|null $notes Optional notes
     * @return array ['success' => bool, 'message' => string]
     */
    public function verifyPayment(int $paymentId, string $status, ?string $notes = null): array
    {
        // Validate status
        if (!in_array($status, [self::STATUS_CONFIRMED, self::STATUS_REJECTED])) {
            return $this->failureResponse('Status tidak valid');
        }

        $updateData = [
            'payment_status' => $status,
            'verified_at' => date('Y-m-d H:i:s'),
        ];

        if ($notes) {
            $updateData['notes'] = $notes;
        }

        try {
            $updateResult = $this->paymentModel->update($paymentId, $updateData);

            if (!$updateResult) {
                return $this->failureResponse('Gagal memverifikasi pembayaran');
            }

            log_message('info', 'PAYMENT VERIFIED - Payment ID: ' . $paymentId . ' | Status: ' . $status);

            $message = $status === self::STATUS_CONFIRMED 
                ? 'Pembayaran berhasil dikonfirmasi' 
                : 'Pembayaran ditolak';

            return [
                'success' => true,
                'message' => $message,
            ];
        } catch (\Exception $e) {
            log_message('error', 'PAYMENT VERIFICATION FAILED - ' . $e->getMessage());
            return $this->failureResponse('Terjadi kesalahan saat memverifikasi pembayaran');
        }
    }

    /**
     * Get payment by user ID
     * 
     * @param int $userId User ID
     * @return array|null
     */
    public function getPaymentByUserId(int $userId): ?array
    {
        return $this->paymentModel->getPaymentByUserId($userId);
    }

    /**
     * Get payment by applicant ID
     * 
     * @param int $applicantId Applicant ID
     * @return array|null
     */
    public function getPaymentByApplicantId(int $applicantId): ?array
    {
        return $this->paymentModel->getPaymentByApplicantId($applicantId);
    }

    /**
     * Get payment by ID
     * 
     * @param int $paymentId Payment ID
     * @return array|null
     */
    public function getPaymentById(int $paymentId): ?array
    {
        return $this->paymentModel->find($paymentId);
    }

    /**
     * Check if user has confirmed payment
     * 
     * @param int $userId User ID
     * @return bool
     */
    public function hasConfirmedPayment(int $userId): bool
    {
        $payment = $this->getPaymentByUserId($userId);
        return $payment && $payment['payment_status'] === self::STATUS_CONFIRMED;
    }

    /**
     * Get all payments with filters
     * 
     * @param array $filters Filter criteria
     * @param int $page Page number
     * @param int $limit Items per page
     * @return array
     */
    public function getPayments(array $filters = [], int $page = 1, int $limit = 15): array
    {
        $builder = $this->paymentModel->builder();
        
        // Apply filters
        if (isset($filters['status']) && !empty($filters['status'])) {
            $builder->where('payment_status', $filters['status']);
        }

        if (isset($filters['date_from']) && !empty($filters['date_from'])) {
            $builder->where('payment_date >=', $filters['date_from']);
        }

        if (isset($filters['date_to']) && !empty($filters['date_to'])) {
            $builder->where('payment_date <=', $filters['date_to']);
        }

        // Get total count
        $total = $builder->countAllResults(false);

        // Apply pagination
        $offset = ($page - 1) * $limit;
        $data = $builder->limit($limit, $offset)
                       ->orderBy('payment_date', 'DESC')
                       ->get()
                       ->getResultArray();

        return [
            'data' => $data,
            'total' => $total,
            'pages' => ceil($total / $limit),
            'current_page' => $page,
            'per_page' => $limit,
        ];
    }

    /**
     * Get payment statistics
     * 
     * @return array
     */
    public function getPaymentStats(): array
    {
        $builder = $this->paymentModel->builder();

        $stats = [
            'total' => $builder->countAll(),
            'pending' => $builder->where('payment_status', self::STATUS_PENDING)->countAllResults(false),
            'confirmed' => $builder->where('payment_status', self::STATUS_CONFIRMED)->countAllResults(false),
            'rejected' => $builder->where('payment_status', self::STATUS_REJECTED)->countAllResults(false),
        ];

        // Get total amount
        $builder->select('SUM(amount) as total_amount');
        $builder->where('payment_status', self::STATUS_CONFIRMED);
        $result = $builder->get()->getRowArray();
        $stats['total_amount'] = $result['total_amount'] ?? 0;

        return $stats;
    }

    /**
     * Link payment to applicant
     * 
     * @param int $paymentId Payment ID
     * @param int $applicantId Applicant ID
     * @return array ['success' => bool, 'message' => string]
     */
    public function linkPaymentToApplicant(int $paymentId, int $applicantId): array
    {
        try {
            $updateResult = $this->paymentModel->update($paymentId, [
                'applicant_id' => $applicantId,
            ]);

            if (!$updateResult) {
                return $this->failureResponse('Gagal menghubungkan pembayaran dengan pendaftar');
            }

            log_message('info', 'PAYMENT LINKED - Payment ID: ' . $paymentId . ' | Applicant ID: ' . $applicantId);

            return [
                'success' => true,
                'message' => 'Pembayaran berhasil dihubungkan dengan pendaftar',
            ];
        } catch (\Exception $e) {
            log_message('error', 'PAYMENT LINKING FAILED - ' . $e->getMessage());
            return $this->failureResponse('Terjadi kesalahan saat menghubungkan pembayaran');
        }
    }

    /**
     * Create failure response
     * 
     * @param string $message Error message
     * @return array
     */
    private function failureResponse(string $message): array
    {
        return [
            'success' => false,
            'message' => $message,
        ];
    }
}
