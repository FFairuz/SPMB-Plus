<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateApplicantsTable extends Migration
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
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'full_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'date_of_birth' => [
                'type' => 'DATE',
            ],
            'gender' => [
                'type' => 'ENUM',
                'constraint' => ['laki-laki', 'perempuan'],
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'address' => [
                'type' => 'TEXT',
            ],
            'city' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'province' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'postal_code' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
            ],
            'school_origin' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'gpa' => [
                'type' => 'DECIMAL',
                'constraint' => [3, 2],
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'verified', 'accepted', 'rejected'],
                'default' => 'pending',
            ],
            'registration_number' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'unique' => true,
            ],
            'documents_uploaded' => [
                'type' => 'BOOLEAN',
                'default' => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('applicants');
    }

    public function down()
    {
        $this->forge->dropTable('applicants');
    }
}
