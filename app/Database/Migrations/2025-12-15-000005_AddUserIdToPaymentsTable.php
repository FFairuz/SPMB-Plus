<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUserIdToPaymentsTable extends Migration
{
    public function up()
    {
        // Add user_id column to payments table to support pre-registration payments
        $this->forge->addColumn('payments', [
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'id',
            ],
        ]);

        // Make applicant_id nullable since payment can exist before applicant is created
        $this->forge->modifyColumn('payments', [
            'applicant_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
        ]);

        // Add foreign key for user_id
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->forge->dropForeignKey('payments', 'payments_user_id_foreign');
        $this->forge->dropColumn('payments', 'user_id');
        
        // Revert applicant_id to non-nullable
        $this->forge->modifyColumn('payments', [
            'applicant_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
        ]);
    }
}
