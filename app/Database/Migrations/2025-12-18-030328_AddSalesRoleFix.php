<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSalesRoleFix extends Migration
{
    public function up()
    {
        // Fix sales user role - set it to 'sales'
        $this->db->table('users')->where('email', 'sales@ppdb.local')->update(['role' => 'sales']);
    }

    public function down()
    {
        // Revert: set role back to empty
        $this->db->table('users')->where('email', 'sales@ppdb.local')->update(['role' => '']);
    }
}
