<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CheckPaymentsStructure extends BaseCommand
{
    protected $group       = 'Database';
    protected $name        = 'db:check-payments';
    protected $description = 'Check payments table structure';

    public function run(array $params)
    {
        $db = \Config\Database::connect();

        CLI::write('=== PAYMENTS TABLE STRUCTURE ===', 'yellow');
        CLI::newLine();

        $query = $db->query('DESCRIBE payments');
        $fields = $query->getResultArray();

        foreach ($fields as $field) {
            CLI::write("Field: {$field['Field']}", 'green');
            CLI::write("  Type: {$field['Type']}");
            CLI::write("  Null: {$field['Null']}");
            CLI::write("  Key: {$field['Key']}");
            if (!empty($field['Default'])) {
                CLI::write("  Default: {$field['Default']}");
            }
            if (!empty($field['Extra'])) {
                CLI::write("  Extra: {$field['Extra']}");
            }
            CLI::newLine();
        }

        CLI::write('=== INDEXES AND CONSTRAINTS ===', 'yellow');
        CLI::newLine();

        $query = $db->query('SHOW INDEXES FROM payments');
        $indexes = $query->getResultArray();

        foreach ($indexes as $index) {
            CLI::write("Index: {$index['Key_name']}", 'green');
            CLI::write("  Column: {$index['Column_name']}");
            CLI::write("  Non_unique: " . ($index['Non_unique'] ? 'YES' : 'NO (UNIQUE)'), $index['Non_unique'] ? 'white' : 'red');
            CLI::write("  Type: {$index['Index_type']}");
            CLI::newLine();
        }

        CLI::write('=== CREATE TABLE STATEMENT ===', 'yellow');
        CLI::newLine();

        $query = $db->query('SHOW CREATE TABLE payments');
        $result = $query->getRow();
        CLI::write($result->{'Create Table'}, 'white');
    }
}
