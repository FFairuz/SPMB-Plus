<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'applicant_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'registration_fee' => [
                'type' => 'DECIMAL',
                'constraint' => [10, 2],
                'default' => 250000.00,
            ],
            'payment_status' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'submitted', 'confirmed', 'rejected'],
                'default' => 'pending',
            ],
            'payment_method' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'default' => 'transfer',
            ],
            'bank_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'account_number' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'account_holder' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'transfer_proof_path' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'transfer_date' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'transfer_amount' => [
                'type' => 'DECIMAL',
                'constraint' => [10, 2],
                'null' => true,
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'confirmed_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'confirmed_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
                'update' => 'CURRENT_TIMESTAMP',
            ],
        ]);

        $this->forge->addKey('id', false, true);
        $this->forge->addForeignKey('applicant_id', 'applicants', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('confirmed_by', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('payments');
    }

    public function down()
    {
        $this->forge->dropTable('payments');
    }
}
