<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'user_id',
        'applicant_id',
        'registration_fee',
        'payment_status',
        'payment_method',
        'bank_name',
        'account_number',
        'account_holder',
        'transfer_proof_path',
        'transfer_date',
        'transfer_amount',
        'notes',
        'confirmed_by',
        'confirmed_at',
        'receipt_number',
        'verified_by_bendahara',
        'verified_at',
        'receipt_printed_at',
        'printed_by',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Get payment dengan data applicant
    public function getPaymentWithApplicant($paymentId)
    {
        return $this->select('payments.*, applicants.full_name, applicants.nomor_pendaftaran as registration_number, users.email')
            ->join('applicants', 'applicants.id = payments.applicant_id')
            ->join('users', 'users.id = applicants.user_id')
            ->where('payments.id', $paymentId)
            ->first();
    }

    // Get semua payment dengan filter status
    public function getPaymentsByStatus($status)
    {
        return $this->select('payments.*, applicants.full_name, applicants.nomor_pendaftaran as registration_number, users.email')
            ->join('applicants', 'applicants.id = payments.applicant_id')
            ->join('users', 'users.id = applicants.user_id')
            ->where('payments.payment_status', $status)
            ->orderBy('payments.created_at', 'DESC')
            ->findAll();
    }

    // Get payment by applicant
    public function getPaymentByApplicantId($applicantId)
    {
        return $this->where('applicant_id', $applicantId)->first();
    }

    // Get payment by user (for pre-registration payments)
    public function getPaymentByUserId($userId)
    {
        return $this->where('user_id', $userId)->first();
    }

    // Get ALL payments by user (support multiple payments)
    public function getPaymentsByUserId($userId)
    {
        return $this->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    // Get latest payment by user
    public function getLatestPaymentByUserId($userId)
    {
        return $this->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->first();
    }

    // Get confirmed payments by user
    public function getConfirmedPaymentsByUserId($userId)
    {
        return $this->where('user_id', $userId)
            ->where('payment_status', 'confirmed')
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    // Get ALL payments by applicant (support multiple payments/installments)
    public function getPaymentsByApplicantId($applicantId)
    {
        return $this->where('applicant_id', $applicantId)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    // Get total paid amount by user
    public function getTotalPaidByUserId($userId)
    {
        $result = $this->selectSum('transfer_amount')
            ->where('user_id', $userId)
            ->where('payment_status', 'confirmed')
            ->get()
            ->getRow();
        
        return $result ? (float)$result->transfer_amount : 0;
    }

    // Get total paid amount by applicant
    public function getTotalPaidByApplicantId($applicantId)
    {
        $result = $this->selectSum('transfer_amount')
            ->where('applicant_id', $applicantId)
            ->where('payment_status', 'confirmed')
            ->get()
            ->getRow();
        
        return $result ? (float)$result->transfer_amount : 0;
    }

    // Get payment count by user
    public function getPaymentCountByUserId($userId, $status = null)
    {
        $builder = $this->where('user_id', $userId);
        
        if ($status) {
            $builder->where('payment_status', $status);
        }
        
        return $builder->countAllResults();
    }

    // Update payment status
    public function updatePaymentStatus($paymentId, $status, $confirmedBy = null)
    {
        $data = [
            'payment_status' => $status,
        ];

        if ($confirmedBy) {
            $data['confirmed_by'] = $confirmedBy;
            $data['confirmed_at'] = date('Y-m-d H:i:s');
        }

        return $this->update($paymentId, $data);
    }

    // Get statistics
    public function getPaymentStats()
    {
        return [
            'total_payments' => $this->countAllResults(),
            'pending' => $this->where('payment_status', 'pending')->countAllResults(),
            'submitted' => $this->where('payment_status', 'submitted')->countAllResults(),
            'confirmed' => $this->where('payment_status', 'confirmed')->countAllResults(),
            'rejected' => $this->where('payment_status', 'rejected')->countAllResults(),
            'total_collected' => $this->selectSum('transfer_amount')
                ->where('payment_status', 'confirmed')
                ->get()
                ->getRow()
                ->transfer_amount ?? 0,
        ];
    }
}
