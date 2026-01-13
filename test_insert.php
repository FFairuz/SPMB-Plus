<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Test database connection dan insert siswa
require_once 'vendor/autoload.php';

$config = new \Config\Database();
$db = $config->connect();

try {
    // Test data
    $data = [
        'nik' => '1234567890123456',
        'nama_lengkap' => 'Test Siswa Baru',
        'jenis_kelamin' => 'laki-laki',
        'tanggal_lahir' => '2008-01-15',
        'tempat_lahir' => 'Jakarta',
        'agama' => 'Islam',
        'anak_ke' => 1,
        'jumlah_saudara' => 2,
        'alamat_jalan' => 'Jl. Test No. 123',
        'kelurahan' => 'Test Kelurahan',
        'kecamatan' => 'Test Kecamatan',
        'kabupaten' => 'Test Kabupaten',
        'provinsi' => 'Test Provinsi',
        'kode_pos' => '12345',
        'nomor_hp' => '08123456789',
        'asal_sekolah' => 'SMP Test',
        'npsn_sekolah_asal' => '12345678',
        'nama_ayah' => 'Ayah Test',
        'nama_ibu' => 'Ibu Test',
        'nomor_pendaftaran' => 'REG-' . date('YmdHis'),
        'status' => 'submitted',
        'tanggal_submit' => date('Y-m-d H:i:s'),
        'nilai_rata_rata' => null,
    ];
    
    $result = $db->table('applicants_dapodik')->insert($data);
    echo "✓ Insert successful\n";
    echo "Last ID: " . $db->insertID() . "\n";
} catch (\Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    echo "Code: " . $e->getCode() . "\n";
}
?>
