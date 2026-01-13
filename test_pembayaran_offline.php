<?php
// Test pembayaran offline

// Set the path correctly
define('APPPATH', __DIR__ . '/app/');
define('ROOTPATH', __DIR__ . '/');

require_once ROOTPATH . 'vendor/autoload.php';

// Load config
$config = require_once APPPATH . 'Config/Database.php';

try {
    // Create DB connection
    $db = new \CodeIgniter\Database\ConnectionFactory();
    $connection = $db->connect($config);
    
    // Get bendahara user ID
    $bendahara = $connection->table('users')->where('username', 'bendahara')->first();
    $bendaharaId = $bendahara->id ?? 1;

    // Get some applicants
    $applicants = $connection->table('applicants_dapodik')->limit(3)->get()->getResultArray();

    echo "Total Applicants: " . count($applicants) . "\n";
    echo "Bendahara ID: $bendaharaId\n\n";

    // Insert test payments
    foreach ($applicants as $applicant) {
        $paymentDate = date('Y-m-d');
        $now = date('Y-m-d H:i:s');
        
        // Check if payment already exists
        $payment = $connection->table('payments')->where('applicant_id', $applicant['id'])->first();
        
        if ($payment) {
            // Update existing payment
            $connection->table('payments')->where('id', $payment->id)->update([
                'transfer_amount' => 250000,
                'transfer_date' => $paymentDate,
                'bank_name' => 'Offline/Tunai',
                'payment_status' => 'confirmed',
                'confirmed_at' => $now,
                'verified_by_bendahara' => $bendaharaId,
                'verified_at' => $now,
                'updated_at' => $now,
            ]);
            echo "✓ Updated payment for {$applicant['nama_lengkap']}\n";
        } else {
            // Insert new payment
            $connection->table('payments')->insert([
                'applicant_id' => $applicant['id'],
                'transfer_amount' => 250000,
                'transfer_date' => $paymentDate,
                'bank_name' => 'Offline/Tunai',
                'payment_status' => 'confirmed',
                'confirmed_at' => $now,
                'verified_by_bendahara' => $bendaharaId,
                'verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            echo "✓ Created payment for {$applicant['nama_lengkap']}\n";
        }
    }

    echo "\n✓ Test pembayaran offline completed!\n";
    echo "Check: http://localhost:8080/bendahara/verifikasi-pembayaran\n";
    echo "Login: bendahara / password123\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
