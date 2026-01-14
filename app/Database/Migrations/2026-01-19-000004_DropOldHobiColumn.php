<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration: Drop Old Hobi Column from Applicants Dapodik
 * 
 * Menghapus kolom hobi lama (TEXT) karena sudah diganti dengan relasi many-to-many
 */
class DropOldHobiColumn extends Migration
{
    public function up()
    {
        // Drop old hobi column
        $this->forge->dropColumn('applicants_dapodik', 'hobi');
    }

    public function down()
    {
        // Restore old hobi column if needed
        $this->forge->addColumn('applicants_dapodik', [
            'hobi' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'kebutuhan_khusus_lainnya',
            ],
        ]);
    }
}
