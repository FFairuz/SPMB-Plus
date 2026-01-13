<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixPaymentApplicantForeignKey extends Migration
{
    public function up()
    {
        // Drop the current foreign key
        $this->forge->dropForeignKey('payments', 'payments_applicant_id_foreign');
        
        // Add new foreign key pointing to applicants_dapodik
        $this->forge->addForeignKey('applicant_id', 'applicants_dapodik', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        // Drop the new foreign key
        $this->forge->dropForeignKey('payments', 'payments_applicant_id_foreign');
        
        // Restore the old foreign key (if it exists)
        $this->forge->addForeignKey('applicant_id', 'applicants', 'id', 'CASCADE', 'CASCADE');
    }
}
