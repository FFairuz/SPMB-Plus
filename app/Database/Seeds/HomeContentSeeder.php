<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class HomeContentSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Hero Section
            [
                'section' => 'hero',
                'title' => 'Selamat Datang di SPMB Online',
                'subtitle' => 'Platform Pendaftaran Peserta Didik Baru yang Modern dan Terpercaya',
                'content' => 'Daftar dengan mudah, pantau status real-time, dan bergabung dengan ribuan siswa berprestasi. Proses pendaftaran 100% online, aman, dan transparan.',
                'image' => null,
                'button_text' => 'Daftar Sekarang',
                'button_link' => '/auth/register',
                'display_order' => 1,
                'is_active' => 1
            ],
            
            // Features
            [
                'section' => 'features',
                'title' => 'Pendaftaran Cepat & Mudah',
                'subtitle' => null,
                'content' => 'Isi formulir pendaftaran dalam hitungan menit dengan panduan lengkap dan validasi otomatis.',
                'image' => 'bi-lightning-charge',
                'button_text' => null,
                'button_link' => null,
                'display_order' => 2,
                'is_active' => 1
            ],
            [
                'section' => 'features',
                'title' => 'Data Aman Terjamin',
                'subtitle' => null,
                'content' => 'Data pribadi dilindungi dengan enkripsi tingkat enterprise dan sistem keamanan berlapis.',
                'image' => 'bi-shield-lock',
                'button_text' => null,
                'button_link' => null,
                'display_order' => 3,
                'is_active' => 1
            ],
            [
                'section' => 'features',
                'title' => 'Pantau Status Real-time',
                'subtitle' => null,
                'content' => 'Dashboard informatif untuk memantau setiap tahap proses pendaftaran Anda secara langsung.',
                'image' => 'bi-graph-up',
                'button_text' => null,
                'button_link' => null,
                'display_order' => 4,
                'is_active' => 1
            ],
            [
                'section' => 'features',
                'title' => 'Upload Dokumen Mudah',
                'subtitle' => null,
                'content' => 'Unggah dokumen dengan antarmuka intuitif dan dukungan berbagai format file.',
                'image' => 'bi-file-earmark-pdf',
                'button_text' => null,
                'button_link' => null,
                'display_order' => 5,
                'is_active' => 1
            ],
            [
                'section' => 'features',
                'title' => 'Notifikasi Otomatis',
                'subtitle' => null,
                'content' => 'Dapatkan pemberitahuan instan untuk setiap update status dan pengumuman penting.',
                'image' => 'bi-bell',
                'button_text' => null,
                'button_link' => null,
                'display_order' => 6,
                'is_active' => 1
            ],
            [
                'section' => 'features',
                'title' => 'Support 24/7',
                'subtitle' => null,
                'content' => 'Tim support siap membantu menjawab pertanyaan dan mengatasi kendala kapan saja.',
                'image' => 'bi-headset',
                'button_text' => null,
                'button_link' => null,
                'display_order' => 7,
                'is_active' => 1
            ],
            
            // Stats
            [
                'section' => 'stats',
                'title' => '2500+',
                'subtitle' => 'Peserta Didik Terdaftar',
                'content' => null,
                'image' => 'bi-people',
                'button_text' => null,
                'button_link' => null,
                'display_order' => 8,
                'is_active' => 1
            ],
            [
                'section' => 'stats',
                'title' => '100+',
                'subtitle' => 'Sekolah Mitra',
                'content' => null,
                'image' => 'bi-building',
                'button_text' => null,
                'button_link' => null,
                'display_order' => 9,
                'is_active' => 1
            ],
            [
                'section' => 'stats',
                'title' => '99.9%',
                'subtitle' => 'Uptime System',
                'content' => null,
                'image' => 'bi-speedometer2',
                'button_text' => null,
                'button_link' => null,
                'display_order' => 10,
                'is_active' => 1
            ],
            [
                'section' => 'stats',
                'title' => '100%',
                'subtitle' => 'Keamanan Data',
                'content' => null,
                'image' => 'bi-shield-check',
                'button_text' => null,
                'button_link' => null,
                'display_order' => 11,
                'is_active' => 1
            ],
            
            // CTA
            [
                'section' => 'cta',
                'title' => 'Siap Bergabung dengan Kami?',
                'subtitle' => null,
                'content' => 'Daftarkan diri Anda sekarang dan mulai perjalanan pendidikan yang lebih baik bersama kami.',
                'image' => null,
                'button_text' => 'Mulai Pendaftaran',
                'button_link' => '/auth/register',
                'display_order' => 12,
                'is_active' => 1
            ],
        ];

        // Truncate table first
        $this->db->table('home_content')->truncate();
        
        // Insert data
        $this->db->table('home_content')->insertBatch($data);
        
        echo "Home content seeded successfully!\n";
    }
}
