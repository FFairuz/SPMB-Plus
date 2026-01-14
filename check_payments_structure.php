<?php

require 'vendor/autoload.php';

// Load CodeIgniter
$pathsConfig = 'app/Config/Paths.php';
require realpath($pathsConfig) ?: $pathsConfig;

$paths = new Config\Paths();
$bootstrap = rtrim($paths->systemDirectory, '\\/ ') . '/bootstrap.php';
$app = require realpath($bootstrap) ?: $bootstrap;

$app->initialize();

// Get database connection
$db = \Config\Database::connect();

// Show table structure
echo "=== PAYMENTS TABLE STRUCTURE ===\n\n";
$query = $db->query('DESCRIBE payments');
$fields = $query->getResultArray();

foreach ($fields as $field) {
    echo "Field: {$field['Field']}\n";
    echo "  Type: {$field['Type']}\n";
    echo "  Null: {$field['Null']}\n";
    echo "  Key: {$field['Key']}\n";
    if (!empty($field['Default'])) {
        echo "  Default: {$field['Default']}\n";
    }
    if (!empty($field['Extra'])) {
        echo "  Extra: {$field['Extra']}\n";
    }
    echo "\n";
}

echo "\n=== INDEXES AND CONSTRAINTS ===\n\n";
$query = $db->query('SHOW INDEXES FROM payments');
$indexes = $query->getResultArray();

foreach ($indexes as $index) {
    echo "Index: {$index['Key_name']}\n";
    echo "  Column: {$index['Column_name']}\n";
    echo "  Non_unique: {$index['Non_unique']}\n";
    echo "  Type: {$index['Index_type']}\n";
    echo "\n";
}

echo "\n=== CREATE TABLE STATEMENT ===\n\n";
$query = $db->query('SHOW CREATE TABLE payments');
$result = $query->getRow();
echo $result->{'Create Table'};
echo "\n";
