<?php
require_once 'vendor/autoload.php';
require_once 'app/Config/Constants.php';

$db = new mysqli('localhost', 'root', '', 'ppdb_db');
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Update status ke verified untuk testing
$result = $db->query("UPDATE applicants_dapodik SET status='verified' WHERE id=1");
if ($result) {
    echo "Success: ID 1 updated to verified status\n";
} else {
    echo "Error: " . $db->error . "\n";
}

// Check hasil
$check = $db->query("SELECT id, nama_lengkap, status FROM applicants_dapodik WHERE id=1");
if ($check && $check->num_rows > 0) {
    $row = $check->fetch_assoc();
    echo "Current data:\n";
    echo "ID: " . $row['id'] . "\n";
    echo "Nama: " . $row['nama_lengkap'] . "\n";
    echo "Status: " . $row['status'] . "\n";
}

$db->close();
?>
