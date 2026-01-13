<?php
namespace App\Controllers;

use CodeIgniter\TestCase;

// Simple test to check if applicants page works

echo "Testing AdminController::applicants()\n";

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap CodeIgniter
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/admin/applicants';
$_SERVER['HTTP_HOST'] = 'localhost:8080';
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/public/index.php';
$_SERVER['DOCUMENT_ROOT'] = __DIR__ . '/public';

// Create CodeIgniter instance
$app = \Config\Services::codeigniter();

try {
    // Simulate admin login by setting session
    $session = \Config\Services::session();
    $session->set([
        'user_id' => 1,
        'username' => 'admin',
        'email' => 'admin@ppdb.local',
        'role' => 'admin',
        'is_admin' => true,
        'is_logged_in' => true,
    ]);
    
    // Create controller
    $controller = new \App\Controllers\AdminController();
    
    // Call applicants method
    $result = $controller->applicants();
    
    echo "✓ applicants() method executed successfully\n";
    
} catch (\Throwable $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    echo "  File: " . $e->getFile() . "\n";
    echo "  Line: " . $e->getLine() . "\n";
}
