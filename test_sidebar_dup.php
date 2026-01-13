<?php
// Test script to check for sidebar duplication
require_once __DIR__ . '/vendor/autoload.php';

use CodeIgniter\Config\Autoload;

// Simple test to check for HTML structure
$html = file_get_contents('http://localhost:8080/admin/kelola-akun');

// Count sidebar occurrences
$sidebar_count = substr_count($html, 'class="sidebar"');
$main_container_count = substr_count($html, 'class="main-container"');
$nav_link_count = substr_count($html, 'class="nav-link');

echo "=== HTML Structure Analysis ===\n";
echo "Sidebar elements found: " . $sidebar_count . "\n";
echo "Main container elements found: " . $main_container_count . "\n";
echo "Nav links found: " . $nav_link_count . "\n";

if ($sidebar_count > 1) {
    echo "\n⚠️  WARNING: Multiple sidebar elements detected!\n";
    // Find where sidebars are
    preg_match_all('/<aside class="sidebar">/', $html, $matches, PREG_OFFSET_CAPTURE);
    echo "Sidebar locations: " . count($matches[0]) . "\n";
    foreach ($matches[0] as $index => $match) {
        echo "  Sidebar " . ($index + 1) . " at position " . $match[1] . "\n";
    }
} else {
    echo "\n✅ Sidebar appears only once - no duplication\n";
}

// Extract main-container section for inspection
preg_match('/<div class="main-container">.*?<\/div><!-- End main-container -->/s', $html, $container);
if (!empty($container)) {
    echo "\nMain container structure:\n";
    echo "Length: " . strlen($container[0]) . " characters\n";
    
    // Check for multiple sidebar includes
    $sidebar_in_container = substr_count($container[0], '<aside class="sidebar">');
    echo "Sidebars in main-container: " . $sidebar_in_container . "\n";
}
?>
