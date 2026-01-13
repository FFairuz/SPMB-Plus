<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KopSuratSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'school_name' => 'SEKOLAH MENENGAH ATAS NEGERI 1 JAKARTA',
                'address' => 'Jl. Pendidikan No. 123, Jakarta Selatan 12000',
                'phone' => '(021) 1234-5678',
                'email' => 'info@sman1jakarta.sch.id',
                'npsn' => '20101234',
                'logo_path' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('kop_surat')->insertBatch($data);
    }
}
