<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateApplicantsDapodikTable extends Migration
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
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            // DATA PRIBADI PESERTA DIDIK
            'nis' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'nik' => [
                'type' => 'VARCHAR',
                'constraint' => 16,
                'unique' => true,
            ],
            'nama_lengkap' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'nama_panggilan' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'jenis_kelamin' => [
                'type' => 'ENUM',
                'constraint' => ['laki-laki', 'perempuan'],
            ],
            'tanggal_lahir' => [
                'type' => 'DATE',
            ],
            'tempat_lahir' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'agama' => [
                'type' => 'ENUM',
                'constraint' => ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu', 'Lainnya'],
            ],
            'status_keluarga' => [
                'type' => 'ENUM',
                'constraint' => ['anak_kandung', 'anak_tiri', 'anak_angkat'],
                'default' => 'anak_kandung',
            ],
            'anak_ke' => [
                'type' => 'INT',
                'constraint' => 3,
            ],
            'jumlah_saudara' => [
                'type' => 'INT',
                'constraint' => 3,
            ],
            // ALAMAT
            'alamat_jalan' => [
                'type' => 'TEXT',
            ],
            'dusun' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'kelurahan' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'kecamatan' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'kabupaten' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'provinsi' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'kode_pos' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
            ],
            'nomor_telepon' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'nomor_hp' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            // DATA SEKOLAH ASAL
            'asal_sekolah' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'npsn_sekolah_asal' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'nilai_rata_rata' => [
                'type' => 'DECIMAL',
                'constraint' => [3, 2],
                'null' => true,
            ],
            'nilai_un_indo' => [
                'type' => 'DECIMAL',
                'constraint' => [3, 2],
                'null' => true,
            ],
            'nilai_un_math' => [
                'type' => 'DECIMAL',
                'constraint' => [3, 2],
                'null' => true,
            ],
            'nilai_un_english' => [
                'type' => 'DECIMAL',
                'constraint' => [3, 2],
                'null' => true,
            ],
            'nilai_un_science' => [
                'type' => 'DECIMAL',
                'constraint' => [3, 2],
                'null' => true,
            ],
            // DATA ORANG TUA/WALI
            'nama_ayah' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'nik_ayah' => [
                'type' => 'VARCHAR',
                'constraint' => 16,
                'null' => true,
            ],
            'pendidikan_ayah' => [
                'type' => 'ENUM',
                'constraint' => ['SD', 'SMP', 'SMA', 'Diploma', 'S1', 'S2', 'S3', 'Lainnya'],
                'null' => true,
            ],
            'pekerjaan_ayah' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'penghasilan_ayah' => [
                'type' => 'ENUM',
                'constraint' => ['< 500rb', '500rb-1jt', '1jt-2jt', '2jt-5jt', '> 5jt'],
                'null' => true,
            ],
            'nomor_hp_ayah' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            
            'nama_ibu' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'nik_ibu' => [
                'type' => 'VARCHAR',
                'constraint' => 16,
                'null' => true,
            ],
            'pendidikan_ibu' => [
                'type' => 'ENUM',
                'constraint' => ['SD', 'SMP', 'SMA', 'Diploma', 'S1', 'S2', 'S3', 'Lainnya'],
                'null' => true,
            ],
            'pekerjaan_ibu' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'penghasilan_ibu' => [
                'type' => 'ENUM',
                'constraint' => ['< 500rb', '500rb-1jt', '1jt-2jt', '2jt-5jt', '> 5jt'],
                'null' => true,
            ],
            'nomor_hp_ibu' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            
            'nama_wali' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'hubungan_wali' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'nomor_hp_wali' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            // PRESTASI
            'prestasi_akademik' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'prestasi_non_akademik' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            // KEBUTUHAN KHUSUS
            'kelainan_fisik' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'kebutuhan_khusus_lainnya' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            // STATUS PENDAFTARAN
            'nomor_pendaftaran' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'unique' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['draft', 'submitted', 'verified', 'lulus', 'tidak_lulus', 'diterima', 'ditolak'],
                'default' => 'draft',
            ],
            'tanggal_submit' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'dokumen_upload' => [
                'type' => 'BOOLEAN',
                'default' => 0,
            ],
            'catatan_verifikasi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            // TIMESTAMP
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
        $this->forge->addKey('user_id');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('applicants_dapodik');
    }

    public function down()
    {
        $this->forge->dropTable('applicants_dapodik');
    }
}
