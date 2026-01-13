<?php

namespace App\Controllers;

class SidebarTest extends BaseController
{
    public function index()
    {
        // Force admin role for testing
        session()->set([
            'user_id' => 1,
            'username' => 'admin',
            'email' => 'admin@ppdb.local',
            'role' => 'admin',
            'is_logged_in' => true,
        ]);

        return view('admin/kelola_akun', [
            'users' => [],
            'title' => 'Test Sidebar'
        ]);
    }

    public function inspect()
    {
        // Force admin role
        session()->set([
            'user_id' => 1,
            'username' => 'admin',
            'email' => 'admin@ppdb.local',
            'role' => 'admin',
            'is_logged_in' => true,
        ]);

        $html = view('admin/kelola_akun', [
            'users' => [],
            'title' => 'Test Sidebar'
        ]);

        // Count elements
        $sidebar_count = substr_count($html, 'class="sidebar"');
        $main_container_count = substr_count($html, 'class="main-container"');
        $navbar_count = substr_count($html, 'class="navbar');

        echo "<pre>";
        echo "HTML Length: " . strlen($html) . " characters\n";
        echo "Sidebar elements: " . $sidebar_count . "\n";
        echo "Main container elements: " . $main_container_count . "\n";
        echo "Navbar elements: " . $navbar_count . "\n";

        if ($sidebar_count > 1) {
            echo "\n⚠️  Multiple sidebars found!\n";
        } elseif ($sidebar_count === 1) {
            echo "\n✅ Sidebar appears exactly once\n";
        } else {
            echo "\n❌ No sidebar found\n";
        }
        echo "</pre>";

        // Show HTML snippet
        echo "<hr>";
        echo "<h3>First 2000 characters of body:</h3>";
        $body_start = strpos($html, '<body>');
        echo "<pre>" . htmlspecialchars(substr($html, $body_start, 2000)) . "</pre>";
    }
}
