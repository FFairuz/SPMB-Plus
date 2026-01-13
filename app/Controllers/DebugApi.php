<?php

namespace App\Controllers;

use App\Models\PaymentModel;
use App\Models\Applicant;

class DebugApi extends BaseController
{
    public function payments_json()
    {
        header('Content-Type: application/json');
        
        $db = \Config\Database::connect();
        
        // Check total applicants
        $totalApplicants = $db->table('applicants_dapodik')->countAllResults();
        
        // Check total payments
        $totalPayments = $db->table('payments')->countAllResults();
        
        // Check confirmed payments
        $confirmedPayments = $db->table('payments')->where('payment_status', 'confirmed')->countAllResults();
        
        // Get all payments
        $allPayments = $db->table('payments')->get()->getResultArray();
        
        // Get confirmed with join
        $confirmedWithJoin = $db->table('payments')
            ->select('payments.*, applicants_dapodik.nama_lengkap')
            ->join('applicants_dapodik', 'applicants_dapodik.id = payments.applicant_id', 'LEFT')
            ->where('payments.payment_status', 'confirmed')
            ->get()
            ->getResultArray();
        
        return json_encode([
            'total_applicants' => $totalApplicants,
            'total_payments' => $totalPayments,
            'confirmed_count' => $confirmedPayments,
            'all_payments_sample' => array_slice($allPayments, 0, 3),
            'confirmed_with_join_count' => count($confirmedWithJoin),
            'confirmed_with_join_sample' => array_slice($confirmedWithJoin, 0, 3),
        ], JSON_PRETTY_PRINT);
    }
}
?>
