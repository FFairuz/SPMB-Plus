<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'setting_key' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'unique'     => true,
            ],
            'setting_value' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'setting_type' => [
                'type'       => 'ENUM',
                'constraint' => ['text', 'image', 'number', 'boolean'],
                'default'    => 'text',
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
        $this->forge->createTable('settings');

        // Insert default settings
        $data = [
            [
                'setting_key'   => 'app_name',
                'setting_value' => 'SPMB-Plus',
                'setting_type'  => 'text',
                'description'   => 'Nama Aplikasi',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key'   => 'app_logo',
                'setting_value' => 'default-logo.png',
                'setting_type'  => 'image',
                'description'   => 'Logo Aplikasi',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key'   => 'app_description',
                'setting_value' => 'Sistem Penerimaan Peserta Didik Baru Online',
                'setting_type'  => 'text',
                'description'   => 'Deskripsi Aplikasi',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key'   => 'school_name',
                'setting_value' => 'Sekolah ABC',
                'setting_type'  => 'text',
                'description'   => 'Nama Sekolah',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key'   => 'school_address',
                'setting_value' => 'Jl. Pendidikan No. 123',
                'setting_type'  => 'text',
                'description'   => 'Alamat Sekolah',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key'   => 'school_phone',
                'setting_value' => '021-1234567',
                'setting_type'  => 'text',
                'description'   => 'Telepon Sekolah',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'setting_key'   => 'school_email',
                'setting_value' => 'info@sekolah.com',
                'setting_type'  => 'text',
                'description'   => 'Email Sekolah',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('settings')->insertBatch($data);
    }

    public function down()
    {
        $this->forge->dropTable('settings');
    }
}
