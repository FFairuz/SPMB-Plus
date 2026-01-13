<?php
// Simple test script to test applicants page with simulated admin session

// Start session
session_start();

// Set admin session
$_SESSION['user_id'] = 1;
$_SESSION['username'] = 'admin';
$_SESSION['email'] = 'admin@ppdb.local';
$_SESSION['role'] = 'admin';
$_SESSION['is_admin'] = true;
$_SESSION['is_logged_in'] = true;

// Load CI4
require_once 'vendor/autoload.php';

// Create app instance
$app = new \CodeIgniter\App();

// Load request and set it to /admin/applicants
$_SERVER['REQUEST_URI'] = '/admin/applicants';
$_SERVER['REQUEST_METHOD'] = 'GET';

// Run the app
echo "Testing /admin/applicants with admin session...\n";
try {
    $app->run();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
}
