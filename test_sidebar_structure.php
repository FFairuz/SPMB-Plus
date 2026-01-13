<?php
/**
 * Script untuk meng-inspect struktur HTML dan mengecek sidebar duplication
 */

// Simulate session jika belum ada
@session_start();

// Set user sebagai admin untuk testing
$_SESSION['user_id'] = 1;
$_SESSION['username'] = 'admin';
$_SESSION['role'] = 'admin';
$_SESSION['is_logged_in'] = true;

// Load CodeIgniter
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/Config/Constants.php';

use Config\Database;
use CodeIgniter\Config\Services;

// Test the layout
echo "<!DOCTYPE html>\n<html>\n<head><title>Sidebar Test</title></head>\n<body>\n";
echo "<h1>Sidebar Duplication Test</h1>\n";
echo "<p>Testing Admin Sidebar Rendering</p>\n";

// Check session
echo "<h2>Session Data:</h2>";
echo "<pre>";
var_dump($_SESSION);
echo "</pre>";

// Display what should be rendered
echo "<h2>Expected Layout Structure:</h2>";
echo "<pre>";
echo "1. &lt;nav&gt; - navbar (included once)\n";
echo "2. &lt;div class='main-container'&gt;\n";
echo "   - &lt;aside class='sidebar'&gt; - admin_sidebar (included once)\n";
echo "   - &lt;div class='main-content'&gt; - content section\n";
echo "3. &lt;footer&gt;\n";
echo "</pre>";

// Check files exist
echo "<h2>Files Check:</h2>";
$files = [
    'app/Views/layout/app.php',
    'app/Views/layout/navbar.php',
    'app/Views/layout/admin_sidebar.php',
    'app/Views/layout/footer.php'
];

foreach ($files as $file) {
    $path = __DIR__ . '/' . $file;
    $exists = file_exists($path) ? '✓ EXISTS' : '✗ MISSING';
    echo "$file: $exists\n";
}

// Read app.php and check for duplicate sidebar includes
echo "<h2>app.php Sidebar Include Analysis:</h2>";
$app_php = file_get_contents(__DIR__ . '/app/Views/layout/app.php');

// Count sidebar includes
$sidebar_includes = substr_count($app_php, "include('layout/admin_sidebar')");
echo "Admin sidebar includes: " . $sidebar_includes . "\n";

// Find lines with sidebar includes
preg_match_all("/this->include\('layout\/.*?_sidebar'\)/", $app_php, $matches);
echo "\nAll sidebar includes found:\n";
foreach ($matches[0] as $match) {
    echo "  - " . $match . "\n";
}

// Check for syntax errors in conditional
echo "\n<h2>Conditional Logic Check:</h2>";
$lines = explode("\n", $app_php);
$in_main_container = false;
foreach ($lines as $idx => $line) {
    if (strpos($line, 'main-container') !== false) {
        echo "Line " . ($idx + 1) . ": " . trim($line) . "\n";
        $in_main_container = true;
    }
    if ($in_main_container && strpos($line, '<?php') !== false) {
        echo "Line " . ($idx + 1) . ": " . trim($line) . "\n";
    }
    if ($in_main_container && strpos($line, 'include') !== false && strpos($line, 'sidebar') !== false) {
        echo "Line " . ($idx + 1) . ": " . trim($line) . "\n";
    }
    if ($in_main_container && strpos($line, 'endif') !== false) {
        echo "Line " . ($idx + 1) . ": " . trim($line) . "\n";
        break;
    }
}

echo "\n<p style='color: green; font-weight: bold;'>✓ Analysis Complete</p>";
echo "</body>\n</html>";
?>
