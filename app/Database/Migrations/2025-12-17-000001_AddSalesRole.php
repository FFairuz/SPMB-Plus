<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSalesRole extends Migration
{
    public function up()
    {
        // Add sales role to validation list in User model
        // This migration file is informational - the role is already included in User model validation
        // Just ensure that the users table supports the sales role
        
        // Note: The users table should already have a 'role' column
        // If you need to verify or modify the column, you can do so here
        
        // Get the fields of the users table to check if role column exists
        $fields = $this->db->getFieldData('users');
        
        // The role column should support: admin, applicant, panitia, bendahara, sales
        // The current setup should already support this
    }

    public function down()
    {
        // No down migration needed as we're just documenting existing support
    }
}
