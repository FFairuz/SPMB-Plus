<?php

namespace App\Controllers;

use App\Models\PaymentModel;
use App\Models\Applicant;

class TestBendahara extends BaseController
{
    public function insert_test_payments()
    {
        $paymentModel = new PaymentModel();
        $db = \Config\Database::connect();
        
        // Get bendahara user ID
        $bendahara = $db->table('users')->where('username', 'bendahara')->get()->getRow();
        $bendaharaId = $bendahara->id ?? 1;

        // Get some applicants
        $applicants = $db->table('applicants_dapodik')->limit(3)->get()->getResultArray();

        if (empty($applicants)) {
            return view('test_results', [
                'title' => 'Test Pembayaran Offline',
                'results' => ['❌ No applicants found in database!'],
                'message' => 'Please seed applicants first.',
            ]);
        }

        $results = [];
        $errors = [];
        
        foreach ($applicants as $applicant) {
            $paymentDate = date('Y-m-d');
            $now = date('Y-m-d H:i:s');
            
            try {
                // Check if payment already exists
                $existingPayment = $paymentModel->where('applicant_id', $applicant['id'])->first();
                
                $paymentData = [
                    'applicant_id' => $applicant['id'],
                    'transfer_amount' => 250000,
                    'transfer_date' => $paymentDate,
                    'bank_name' => 'Offline/Tunai',
                    'payment_status' => 'confirmed',
                    'confirmed_at' => $now,
                    'verified_by_bendahara' => $bendaharaId,
                    'verified_at' => $now,
                ];
                
                if ($existingPayment) {
                    // Update existing payment
                    if ($paymentModel->update($existingPayment['id'], $paymentData)) {
                        $results[] = "✓ Updated payment for {$applicant['nama_lengkap']} (ID: {$applicant['id']})";
                    } else {
                        $errors[] = "✗ Failed to update payment for {$applicant['nama_lengkap']}: " . json_encode($paymentModel->errors());
                    }
                } else {
                    // Insert new payment
                    if ($paymentModel->insert($paymentData)) {
                        $results[] = "✓ Inserted payment for {$applicant['nama_lengkap']} (ID: {$applicant['id']})";
                    } else {
                        $errors[] = "✗ Failed to insert payment for {$applicant['nama_lengkap']}: " . json_encode($paymentModel->errors());
                    }
                }
            } catch (\Exception $e) {
                $errors[] = "❌ Error for {$applicant['nama_lengkap']}: " . $e->getMessage();
            }
        }
        
        // Verify after insert
        $totalAfter = $db->table('payments')->countAllResults();
        $results[] = "📊 Total payments in DB after insert: $totalAfter";
        
        return view('test_results', [
            'title' => 'Test Pembayaran Offline',
            'results' => array_merge($results, $errors),
            'message' => 'Check: /bendahara/cetak-bukti and /debug/payments-json | Login: bendahara / password123',
        ]);
    }
}
?>
