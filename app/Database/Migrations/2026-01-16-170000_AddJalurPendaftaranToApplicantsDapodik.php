<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddJalurPendaftaranToApplicantsDapodik extends Migration
{
    public function up()
    {
        $this->forge->addColumn('applicants_dapodik', [
            'jalur_pendaftaran' => [
                'type' => 'ENUM',
                'constraint' => ['PPDB Bersama', 'Muhammadiyah', 'Non Muhammadiyah'],
                'default' => 'PPDB Bersama',
                'after' => 'nomor_pendaftaran',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('applicants_dapodik', 'jalur_pendaftaran');
    }
}
