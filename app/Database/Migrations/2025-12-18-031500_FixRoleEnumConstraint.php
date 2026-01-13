<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixRoleEnumConstraint extends Migration
{
    public function up()
    {
        // Modify the role column to include all roles
        $this->forge->modifyColumn('users', [
            'role' => [
                'type' => 'ENUM',
                'constraint' => ['admin', 'applicant', 'panitia', 'bendahara', 'sales'],
                'default' => 'applicant',
            ],
        ]);
    }

    public function down()
    {
        // Revert to original ENUM
        $this->forge->modifyColumn('users', [
            'role' => [
                'type' => 'ENUM',
                'constraint' => ['admin', 'applicant'],
                'default' => 'applicant',
            ],
        ]);
    }
}
