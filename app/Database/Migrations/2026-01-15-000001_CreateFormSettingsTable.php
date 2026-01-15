<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFormSettingsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'setting_key' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'unique' => true,
            ],
            'setting_value' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'setting_type' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'default' => 'text',
                'comment' => 'text, boolean, json, number',
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('form_settings');

        // Insert default settings
        $data = [
            [
                'setting_key' => 'form_status',
                'setting_value' => '1',
                'setting_type' => 'boolean',
                'description' => 'Status formulir pendaftaran (1=aktif, 0=nonaktif)',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key' => 'form_start_date',
                'setting_value' => date('Y-m-d'),
                'setting_type' => 'date',
                'description' => 'Tanggal mulai pendaftaran',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key' => 'form_end_date',
                'setting_value' => date('Y-m-d', strtotime('+30 days')),
                'setting_type' => 'date',
                'description' => 'Tanggal akhir pendaftaran',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key' => 'required_fields',
                'setting_value' => json_encode([
                    'nik', 'nama_lengkap', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir',
                    'agama', 'anak_ke', 'jumlah_saudara', 'alamat_jalan', 'kelurahan',
                    'kecamatan', 'kabupaten', 'provinsi', 'kode_pos', 'nomor_hp',
                    'asal_sekolah', 'nama_ayah', 'nama_ibu', 'jurusan_id'
                ]),
                'setting_type' => 'json',
                'description' => 'Field yang wajib diisi (required)',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key' => 'max_applicants',
                'setting_value' => '1000',
                'setting_type' => 'number',
                'description' => 'Maksimal jumlah pendaftar (0 = unlimited)',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key' => 'form_title',
                'setting_value' => 'Formulir Pendaftaran Siswa Baru',
                'setting_type' => 'text',
                'description' => 'Judul formulir',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key' => 'form_description',
                'setting_value' => 'Silakan lengkapi formulir pendaftaran di bawah ini dengan data yang sebenar-benarnya.',
                'setting_type' => 'text',
                'description' => 'Deskripsi formulir',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('form_settings')->insertBatch($data);
    }

    public function down()
    {
        $this->forge->dropTable('form_settings');
    }
}
