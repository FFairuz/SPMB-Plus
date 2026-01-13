<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateUserRoles extends Migration
{
    public function up()
    {
        // Modify the role ENUM to include panitia and bendahara
        $this->db->query("
            ALTER TABLE users 
            MODIFY COLUMN role ENUM('admin', 'applicant', 'panitia', 'bendahara') 
            DEFAULT 'applicant'
        ");
    }

    public function down()
    {
        // Revert to original roles
        $this->db->query("
            ALTER TABLE users 
            MODIFY COLUMN role ENUM('admin', 'applicant') 
            DEFAULT 'applicant'
        ");
    }
}
