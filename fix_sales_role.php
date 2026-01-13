<?php
// Quick fix script to set sales user role

$db = mysqli_connect('localhost', 'root', '', 'ppdb_db');

if (!$db) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Update sales user role
$email = 'sales@ppdb.local';
$role = 'sales';

$sql = "UPDATE users SET role = '$role' WHERE email = '$email'";

if (mysqli_query($db, $sql)) {
    echo "✓ Sales user role updated successfully!\n";
    
    // Verify
    $result = mysqli_query($db, "SELECT id, email, role, nama FROM users WHERE email = '$email'");
    $user = mysqli_fetch_assoc($result);
    
    if ($user) {
        echo "\nUpdated User Details:\n";
        echo "ID: " . $user['id'] . "\n";
        echo "Email: " . $user['email'] . "\n";
        echo "Role: " . $user['role'] . "\n";
        echo "Name: " . $user['nama'] . "\n";
    }
} else {
    echo "✗ Error updating user: " . mysqli_error($db) . "\n";
}

mysqli_close($db);
?>
