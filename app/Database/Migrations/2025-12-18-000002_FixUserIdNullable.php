<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixUserIdNullable extends Migration
{
    public function up()
    {
        // Drop foreign key first
        $this->forge->dropForeignKey('applicants_dapodik', 'applicants_dapodik_user_id_foreign');
        
        // Modify user_id to nullable
        $this->forge->modifyColumn('applicants_dapodik', [
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
        ]);
        
        // Re-add foreign key with SET NULL
        $this->forge->addForeignKey('user_id', 'users', 'id', 'SET NULL', 'CASCADE');
    }

    public function down()
    {
        $this->forge->dropForeignKey('applicants_dapodik', 'applicants_dapodik_user_id_foreign');
        
        $this->forge->modifyColumn('applicants_dapodik', [
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
        ]);
        
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
    }
}
