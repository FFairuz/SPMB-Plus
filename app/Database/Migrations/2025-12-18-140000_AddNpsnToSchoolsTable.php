<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNpsnToSchoolsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('schools', [
            'npsn' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
                'default' => null,
                'after' => 'nama',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('schools', 'npsn');
    }
}
