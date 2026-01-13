<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixNilaiRataRataNull extends Migration
{
    public function up()
    {
        // Modify nilai_rata_rata column to allow NULL
        $this->forge->modifyColumn('applicants_dapodik', [
            'nilai_rata_rata' => [
                'type' => 'DECIMAL',
                'constraint' => [3, 2],
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('applicants_dapodik', [
            'nilai_rata_rata' => [
                'type' => 'DECIMAL',
                'constraint' => [3, 2],
            ],
        ]);
    }
}
