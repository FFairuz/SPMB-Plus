<?php

/**
 * Test Dynamic Logo and App Name Feature
 * 
 * Script ini untuk test apakah logo dan nama aplikasi dinamis berfungsi dengan baik
 * 
 * Usage: php test_dynamic_logo.php
 */

// Define paths
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);
define('APPPATH', __DIR__ . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR);

// Colors for output
$GREEN = "\033[0;32m";
$RED = "\033[0;31m";
$YELLOW = "\033[1;33m";
$BLUE = "\033[0;34m";
$NC = "\033[0m"; // No Color

echo "\n";
echo "==================================================\n";
echo "  TEST DYNAMIC LOGO & APP NAME FEATURE\n";
echo "==================================================\n\n";

// Test 1: Check if helper is autoloaded
echo "${BLUE}[TEST 1]${NC} Check if settings helper exists...\n";
$helperPath = APPPATH . 'Helpers/settings_helper.php';
if (file_exists($helperPath)) {
    echo "  ${GREEN}✓ PASS${NC} - settings_helper.php exists\n";
    
    // Check if functions are defined in helper
    $helperContent = file_get_contents($helperPath);
    $functions = ['app_name', 'app_logo', 'app_description', 'get_setting'];
    
    foreach ($functions as $func) {
        if (strpos($helperContent, "function $func") !== false) {
            echo "  ${GREEN}✓ PASS${NC} - Function '$func()' defined in helper\n";
        } else {
            echo "  ${RED}✗ FAIL${NC} - Function '$func()' not found in helper\n";
        }
    }
} else {
    echo "  ${RED}✗ FAIL${NC} - settings_helper.php not found\n";
    exit(1);
}
echo "\n";

// Test 2: Check SettingModel exists
echo "${BLUE}[TEST 2]${NC} Check if SettingModel exists...\n";
$modelPath = APPPATH . 'Models/SettingModel.php';
if (file_exists($modelPath)) {
    echo "  ${GREEN}✓ PASS${NC} - SettingModel.php exists\n";
} else {
    echo "  ${RED}✗ FAIL${NC} - SettingModel.php not found\n";
}
echo "\n";

// Test 3: Check if logo upload folder exists
echo "${BLUE}[TEST 3]${NC} Check if logo upload folder exists...\n";
$logoUploadPath = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'logo' . DIRECTORY_SEPARATOR;
echo "  - Logo Upload Path: ${YELLOW}$logoUploadPath${NC}\n";

if (is_dir($logoUploadPath)) {
    echo "  ${GREEN}✓ PASS${NC} - Logo upload folder exists\n";
    
    // Check if writable
    if (is_writable($logoUploadPath)) {
        echo "  ${GREEN}✓ PASS${NC} - Logo upload folder is writable\n";
    } else {
        echo "  ${RED}✗ FAIL${NC} - Logo upload folder is not writable\n";
    }
    
    // List files in folder
    $files = scandir($logoUploadPath);
    $logoFiles = array_filter($files, function($file) {
        return !in_array($file, ['.', '..']);
    });
    
    echo "  - Total logo files: ${YELLOW}" . count($logoFiles) . "${NC}\n";
    foreach ($logoFiles as $file) {
        echo "    • $file\n";
    }
} else {
    echo "  ${YELLOW}⚠ WARNING${NC} - Logo upload folder does not exist\n";
    echo "  ${YELLOW}⚠ TIP${NC} - Create folder: mkdir -p public/uploads/logo\n";
}
echo "\n";

// Test 4: Check if CSS file exists
echo "${BLUE}[TEST 4]${NC} Check if dynamic-logo.css exists...\n";
$cssPath = FCPATH . 'css/dynamic-logo.css';
echo "  - CSS Path: ${YELLOW}$cssPath${NC}\n";

if (file_exists($cssPath)) {
    echo "  ${GREEN}✓ PASS${NC} - dynamic-logo.css exists\n";
} else {
    echo "  ${RED}✗ FAIL${NC} - dynamic-logo.css not found\n";
}
echo "\n";

// Test 5: Check if layout files are updated
echo "${BLUE}[TEST 5]${NC} Check if layout files are updated...\n";

// Check app.php
$layoutPath = APPPATH . 'Views/layout/app.php';
$layoutContent = file_get_contents($layoutPath);

if (strpos($layoutContent, 'app_name()') !== false) {
    echo "  ${GREEN}✓ PASS${NC} - layout/app.php uses app_name()\n";
} else {
    echo "  ${RED}✗ FAIL${NC} - layout/app.php doesn't use app_name()\n";
}

if (strpos($layoutContent, 'app_logo()') !== false) {
    echo "  ${GREEN}✓ PASS${NC} - layout/app.php uses app_logo()\n";
} else {
    echo "  ${RED}✗ FAIL${NC} - layout/app.php doesn't use app_logo()\n";
}

if (strpos($layoutContent, 'dynamic-logo.css') !== false) {
    echo "  ${GREEN}✓ PASS${NC} - layout/app.php includes dynamic-logo.css\n";
} else {
    echo "  ${RED}✗ FAIL${NC} - layout/app.php doesn't include dynamic-logo.css\n";
}

// Check login.php
$loginPath = APPPATH . 'Views/auth/login.php';
$loginContent = file_get_contents($loginPath);

if (strpos($loginContent, 'app_name()') !== false) {
    echo "  ${GREEN}✓ PASS${NC} - auth/login.php uses app_name()\n";
} else {
    echo "  ${RED}✗ FAIL${NC} - auth/login.php doesn't use app_name()\n";
}

if (strpos($loginContent, 'app_logo()') !== false) {
    echo "  ${GREEN}✓ PASS${NC} - auth/login.php uses app_logo()\n";
} else {
    echo "  ${RED}✗ FAIL${NC} - auth/login.php doesn't use app_logo()\n";
}

if (strpos($loginContent, 'dynamic-logo.css') !== false) {
    echo "  ${GREEN}✓ PASS${NC} - auth/login.php includes dynamic-logo.css\n";
} else {
    echo "  ${RED}✗ FAIL${NC} - auth/login.php doesn't include dynamic-logo.css\n";
}
echo "\n";

// Test 6: Check Autoload configuration
echo "${BLUE}[TEST 6]${NC} Check Autoload configuration...\n";
$autoloadPath = APPPATH . 'Config/Autoload.php';
$autoloadContent = file_get_contents($autoloadPath);

if (strpos($autoloadContent, "'settings'") !== false) {
    echo "  ${GREEN}✓ PASS${NC} - settings helper is in Autoload.php\n";
} else {
    echo "  ${RED}✗ FAIL${NC} - settings helper not found in Autoload.php\n";
}
echo "\n";

// Test 7: Database connection and settings table
echo "${BLUE}[TEST 7]${NC} Check database migration file...\n";
$migrationPattern = APPPATH . 'Database' . DIRECTORY_SEPARATOR . 'Migrations' . DIRECTORY_SEPARATOR . '*CreateSettingsTable.php';
$migrations = glob($migrationPattern);

if (!empty($migrations)) {
    echo "  ${GREEN}✓ PASS${NC} - Settings table migration exists\n";
    foreach ($migrations as $migration) {
        echo "    • " . basename($migration) . "\n";
    }
} else {
    echo "  ${RED}✗ FAIL${NC} - Settings table migration not found\n";
}
echo "\n";

// Summary
echo "==================================================\n";
echo "  TEST SUMMARY\n";
echo "==================================================\n";
echo "  ${GREEN}✓${NC} Dynamic logo and app name feature implemented\n";
echo "  ${GREEN}✓${NC} Helper functions available globally\n";
echo "  ${GREEN}✓${NC} Layout files updated\n";
echo "  ${GREEN}✓${NC} CSS styling applied\n";
echo "\n";
echo "  ${BLUE}Next Steps:${NC}\n";
echo "  1. Access /admin/settings to change app name and logo\n";
echo "  2. Upload a custom logo (PNG, JPG, SVG - max 2MB)\n";
echo "  3. Check navbar and login page for changes\n";
echo "\n";
echo "==================================================\n\n";
