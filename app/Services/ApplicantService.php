<?php

namespace App\Services;

use App\Models\Applicant;
use App\Models\Document;

/**
 * ApplicantService
 * 
 * Service untuk menangani business logic pendaftaran siswa (applicant)
 */
class ApplicantService
{
    /**
     * @var Applicant
     */
    private $applicantModel;

    /**
     * @var Document
     */
    private $documentModel;

    /**
     * @var PaymentService
     */
    private $paymentService;

    /**
     * Applicant statuses
     */
    public const STATUS_PENDING = 'pending';
    public const STATUS_SUBMITTED = 'submitted';
    public const STATUS_VERIFIED = 'verified';
    public const STATUS_ACCEPTED = 'accepted';
    public const STATUS_REJECTED = 'rejected';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->applicantModel = new Applicant();
        $this->documentModel = new Document();
        $this->paymentService = new PaymentService();
    }

    /**
     * Create new applicant registration
     * 
     * @param array $applicantData Applicant data
     * @param int $userId User ID
     * @return array ['success' => bool, 'message' => string, 'applicant_id' => int|null]
     */
    public function createApplicant(array $applicantData, int $userId): array
    {
        // Check if user already has applicant record
        $existing = $this->getApplicantByUserId($userId);
        if ($existing) {
            return $this->failureResponse('Anda sudah memiliki data pendaftaran');
        }

        // Check if payment is confirmed
        if (!$this->paymentService->hasConfirmedPayment($userId)) {
            return $this->failureResponse('Pembayaran harus dikonfirmasi terlebih dahulu');
        }

        // Generate registration number
        $registrationNumber = $this->applicantModel->generateRegistrationNumber();

        // Prepare data
        $applicantData['user_id'] = $userId;
        $applicantData['registration_number'] = $registrationNumber;
        $applicantData['status'] = self::STATUS_PENDING;
        $applicantData['documents_uploaded'] = 0;

        try {
            $applicantId = $this->applicantModel->insert($applicantData);

            if (!$applicantId) {
                $errors = $this->applicantModel->errors();
                $errorMessage = is_array($errors) ? implode(', ', $errors) : 'Gagal menyimpan data pendaftaran';
                return $this->failureResponse($errorMessage);
            }

            // Link payment to applicant
            $payment = $this->paymentService->getPaymentByUserId($userId);
            if ($payment) {
                $this->paymentService->linkPaymentToApplicant($payment['id'], $applicantId);
            }

            log_message('info', 'APPLICANT CREATED - Applicant ID: ' . $applicantId . ' | User ID: ' . $userId);

            return [
                'success' => true,
                'message' => 'Data pendaftaran berhasil disimpan',
                'applicant_id' => $applicantId,
            ];
        } catch (\Exception $e) {
            log_message('error', 'APPLICANT CREATION FAILED - ' . $e->getMessage());
            return $this->failureResponse('Terjadi kesalahan saat menyimpan data pendaftaran');
        }
    }

    /**
     * Update applicant data
     * 
     * @param int $applicantId Applicant ID
     * @param array $applicantData Updated applicant data
     * @return array ['success' => bool, 'message' => string]
     */
    public function updateApplicant(int $applicantId, array $applicantData): array
    {
        // Remove fields that shouldn't be updated
        unset($applicantData['id'], $applicantData['user_id'], $applicantData['registration_number'], $applicantData['created_at']);

        try {
            $updateResult = $this->applicantModel->update($applicantId, $applicantData);

            if (!$updateResult) {
                $errors = $this->applicantModel->errors();
                $errorMessage = is_array($errors) ? implode(', ', $errors) : 'Gagal memperbarui data pendaftaran';
                return $this->failureResponse($errorMessage);
            }

            log_message('info', 'APPLICANT UPDATED - Applicant ID: ' . $applicantId);

            return [
                'success' => true,
                'message' => 'Data pendaftaran berhasil diperbarui',
            ];
        } catch (\Exception $e) {
            log_message('error', 'APPLICANT UPDATE FAILED - ' . $e->getMessage());
            return $this->failureResponse('Terjadi kesalahan saat memperbarui data pendaftaran');
        }
    }

    /**
     * Change applicant status
     * 
     * @param int $applicantId Applicant ID
     * @param string $status New status
     * @return array ['success' => bool, 'message' => string]
     */
    public function changeStatus(int $applicantId, string $status): array
    {
        $validStatuses = [
            self::STATUS_PENDING,
            self::STATUS_SUBMITTED,
            self::STATUS_VERIFIED,
            self::STATUS_ACCEPTED,
            self::STATUS_REJECTED,
        ];

        if (!in_array($status, $validStatuses)) {
            return $this->failureResponse('Status tidak valid');
        }

        try {
            $updateResult = $this->applicantModel->update($applicantId, ['status' => $status]);

            if (!$updateResult) {
                return $this->failureResponse('Gagal mengubah status');
            }

            log_message('info', 'APPLICANT STATUS CHANGED - Applicant ID: ' . $applicantId . ' | Status: ' . $status);

            return [
                'success' => true,
                'message' => 'Status berhasil diubah menjadi ' . $status,
            ];
        } catch (\Exception $e) {
            log_message('error', 'STATUS CHANGE FAILED - ' . $e->getMessage());
            return $this->failureResponse('Terjadi kesalahan saat mengubah status');
        }
    }

    /**
     * Upload document
     * 
     * @param int $applicantId Applicant ID
     * @param string $documentType Document type (ijazah, kartu_keluarga, etc.)
     * @param object $file Uploaded file
     * @return array ['success' => bool, 'message' => string, 'document_id' => int|null]
     */
    public function uploadDocument(int $applicantId, string $documentType, $file): array
    {
        if (!$file->isValid()) {
            return $this->failureResponse('File tidak valid');
        }

        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
        if (!in_array($file->getMimeType(), $allowedTypes)) {
            return $this->failureResponse('Hanya file gambar (JPG, PNG) atau PDF yang diperbolehkan');
        }

        // Validate file size (max 5MB)
        if ($file->getSize() > 5120000) {
            return $this->failureResponse('Ukuran file maksimal 5MB');
        }

        try {
            // Generate unique filename
            $newName = 'doc_' . $applicantId . '_' . $documentType . '_' . time() . '.' . $file->getExtension();
            
            // Move file to writable/uploads
            $file->move(WRITEPATH . 'uploads', $newName);
            
            $filePath = 'writable/uploads/' . $newName;

            // Save document record
            $documentData = [
                'applicant_id' => $applicantId,
                'document_type' => $documentType,
                'file_path' => $filePath,
                'file_name' => $file->getClientName(),
                'uploaded_at' => date('Y-m-d H:i:s'),
            ];

            $documentId = $this->documentModel->insert($documentData);

            if (!$documentId) {
                return $this->failureResponse('Gagal menyimpan data dokumen');
            }

            // Update document count
            $this->updateDocumentCount($applicantId);

            log_message('info', 'DOCUMENT UPLOADED - Applicant ID: ' . $applicantId . ' | Type: ' . $documentType);

            return [
                'success' => true,
                'message' => 'Dokumen berhasil diunggah',
                'document_id' => $documentId,
            ];
        } catch (\Exception $e) {
            log_message('error', 'DOCUMENT UPLOAD FAILED - ' . $e->getMessage());
            return $this->failureResponse('Terjadi kesalahan saat mengunggah dokumen');
        }
    }

    /**
     * Update document count for applicant
     * 
     * @param int $applicantId Applicant ID
     * @return void
     */
    private function updateDocumentCount(int $applicantId): void
    {
        $count = $this->documentModel->where('applicant_id', $applicantId)->countAllResults();
        $this->applicantModel->update($applicantId, ['documents_uploaded' => $count]);
    }

    /**
     * Get applicant by user ID
     * 
     * @param int $userId User ID
     * @return array|null
     */
    public function getApplicantByUserId(int $userId): ?array
    {
        return $this->applicantModel->getApplicantByUserId($userId);
    }

    /**
     * Get applicant by ID
     * 
     * @param int $applicantId Applicant ID
     * @return array|null
     */
    public function getApplicantById(int $applicantId): ?array
    {
        return $this->applicantModel->find($applicantId);
    }

    /**
     * Get applicant with documents
     * 
     * @param int $applicantId Applicant ID
     * @return array|null
     */
    public function getApplicantWithDocuments(int $applicantId): ?array
    {
        $applicant = $this->getApplicantById($applicantId);
        
        if (!$applicant) {
            return null;
        }

        $documents = $this->documentModel->where('applicant_id', $applicantId)->findAll();
        $applicant['documents'] = $documents;

        return $applicant;
    }

    /**
     * Get applicants with filters and pagination
     * 
     * @param array $filters Filter criteria
     * @param int $page Page number
     * @param int $limit Items per page
     * @return array
     */
    public function getApplicants(array $filters = [], int $page = 1, int $limit = 15): array
    {
        $builder = $this->applicantModel->builder();
        
        // Apply filters
        if (isset($filters['status']) && !empty($filters['status'])) {
            $builder->where('status', $filters['status']);
        }

        if (isset($filters['province']) && !empty($filters['province'])) {
            $builder->where('province', $filters['province']);
        }

        if (isset($filters['city']) && !empty($filters['city'])) {
            $builder->where('city', $filters['city']);
        }

        if (isset($filters['search']) && !empty($filters['search'])) {
            $builder->groupStart()
                    ->like('full_name', $filters['search'])
                    ->orLike('registration_number', $filters['search'])
                    ->orLike('email', $filters['search'])
                    ->groupEnd();
        }

        // Get total count
        $total = $builder->countAllResults(false);

        // Apply pagination
        $offset = ($page - 1) * $limit;
        $data = $builder->limit($limit, $offset)
                       ->orderBy('created_at', 'DESC')
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
     * Get applicant statistics
     * 
     * @return array
     */
    public function getApplicantStats(): array
    {
        $builder = $this->applicantModel->builder();

        return [
            'total' => $builder->countAll(),
            'pending' => $builder->where('status', self::STATUS_PENDING)->countAllResults(false),
            'submitted' => $builder->where('status', self::STATUS_SUBMITTED)->countAllResults(false),
            'verified' => $builder->where('status', self::STATUS_VERIFIED)->countAllResults(false),
            'accepted' => $builder->where('status', self::STATUS_ACCEPTED)->countAllResults(false),
            'rejected' => $builder->where('status', self::STATUS_REJECTED)->countAllResults(false),
        ];
    }

    /**
     * Check if user can register (has confirmed payment)
     * 
     * @param int $userId User ID
     * @return bool
     */
    public function canRegister(int $userId): bool
    {
        // Check if already registered
        $existing = $this->getApplicantByUserId($userId);
        if ($existing) {
            return false;
        }

        // Check if payment is confirmed
        return $this->paymentService->hasConfirmedPayment($userId);
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
