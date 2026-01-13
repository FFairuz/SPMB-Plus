<?php

namespace App\Controllers;

use App\Models\PaymentModel;
use App\Models\Applicant;

class DebugPayment extends BaseController
{
    public function check_payments()
    {
        $db = \Config\Database::connect();
        
        // Check total applicants
        $totalApplicants = $db->table('applicants_dapodik')->countAllResults();
        
        // Check total payments (simple count)
        $totalPayments = $db->table('payments')->countAllResults();
        
        // Check payment statuses
        $builder = $db->table('payments');
        $allPaymentStatuses = $builder->selectCount('*', 'count')
            ->selectRaw("payment_status")
            ->groupBy('payment_status')
            ->get()
            ->getResultArray();
        
        // Get all payments (no filter)
        $allPayments = $db->table('payments')->orderBy('id', 'DESC')->limit(20)->get()->getResultArray();
        
        // Check confirmed payments
        $confirmedPayments = $db->table('payments')->where('payment_status', 'confirmed')->countAllResults();
        
        // Get confirmed payments with applicant data
        $payments = $db->table('payments')
            ->select('payments.*, applicants_dapodik.nama_lengkap, applicants_dapodik.nomor_pendaftaran')
            ->join('applicants_dapodik', 'applicants_dapodik.id = payments.applicant_id', 'LEFT')
            ->where('payments.payment_status', 'confirmed')
            ->orderBy('payments.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'total_applicants' => $totalApplicants,
            'total_payments' => $totalPayments,
            'payment_statuses' => $allPaymentStatuses,
            'all_payments' => $allPayments,
            'confirmed_payments' => $confirmedPayments,
            'payments' => $payments,
        ];

        return view('debug_payment', $data);
    }
}
?>
