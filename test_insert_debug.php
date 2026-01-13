<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load CodeIgniter
require_once 'vendor/autoload.php';
require_once 'app/Config/Constants.php';

// Create the application
$app = new \Config\App();

// Create database connection
$db = \Config\Database::connect();

// Test data
$testData = [
    'nik' => '3173011234567890',
    'nama_lengkap' => 'Test Siswa Panitia',
    'jenis_kelamin' => 'laki-laki',
    'tanggal_lahir' => '2008-05-15',
    'tempat_lahir' => 'Jakarta',
    'agama' => 'Islam',
    'anak_ke' => 1,
    'jumlah_saudara' => 2,
    'alamat_jalan' => 'Jl. Test No. 123, RT 01, RW 02',
    'dusun' => 'Dusun Maju',
    'kelurahan' => 'Kelurahan Test',
    'kecamatan' => 'Kecamatan Test',
    'kabupaten' => 'Kabupaten Test',
    'provinsi' => 'DKI Jakarta',
    'kode_pos' => '12345',
    'nomor_hp' => '081234567890',
    'asal_sekolah' => 'SMP Negeri 1 Test',
    'npsn_sekolah_asal' => '20123456',
    'nama_ayah' => 'Ayah Test',
    'nama_ibu' => 'Ibu Test',
    'nomor_pendaftaran' => 'PPDB-' . date('Y') . date('m') . '-0001',
    'status' => 'submitted',
    'tanggal_submit' => date('Y-m-d H:i:s'),
];

echo "=== Test Insert Siswa ===\n";
echo "Data to insert:\n";
echo json_encode($testData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n\n";

try {
    $result = $db->table('applicants_dapodik')->insert($testData);
    echo "Insert Success!\n";
    echo "Last Insert ID: " . $db->insertID() . "\n";
    
    // Verify inserted data
    $inserted = $db->table('applicants_dapodik')->where('nik', '3173011234567890')->first();
    echo "\nVerifying inserted data:\n";
    echo json_encode($inserted, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n";
} catch (\Exception $e) {
    echo "Insert Failed!\n";
    echo "Error: " . $e->getMessage() . "\n";
    echo "Code: " . $e->getCode() . "\n";
}
?>
