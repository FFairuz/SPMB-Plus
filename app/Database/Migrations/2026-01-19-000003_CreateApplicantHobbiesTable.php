<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration: Create Applicant Hobbies Pivot Table
 * 
 * Tabel penghubung antara applicants_dapodik dan hobbies
 * Many-to-many relationship
 */
class CreateApplicantHobbiesTable extends Migration
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
                'comment' => 'ID dari applicants_dapodik',
            ],
            'hobby_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'comment' => 'ID dari hobbies',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->addKey(['applicant_id', 'hobby_id']); // Composite index
        $this->forge->addForeignKey('applicant_id', 'applicants_dapodik', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('hobby_id', 'hobbies', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('applicant_hobbies');
    }

    public function down()
    {
        $this->forge->dropTable('applicant_hobbies');
    }
}
