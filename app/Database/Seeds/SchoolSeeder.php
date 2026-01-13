<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SchoolSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // JAWA BARAT
            ['nama' => 'SMA Negeri 1 Bandung', 'kota' => 'Bandung', 'provinsi' => 'Jawa Barat'],
            ['nama' => 'SMA Negeri 3 Bandung', 'kota' => 'Bandung', 'provinsi' => 'Jawa Barat'],
            ['nama' => 'SMA Negeri 5 Bandung', 'kota' => 'Bandung', 'provinsi' => 'Jawa Barat'],
            ['nama' => 'SMA Negeri 1 Bogor', 'kota' => 'Bogor', 'provinsi' => 'Jawa Barat'],
            ['nama' => 'SMA Negeri 2 Bogor', 'kota' => 'Bogor', 'provinsi' => 'Jawa Barat'],
            ['nama' => 'SMA Negeri 1 Sukabumi', 'kota' => 'Sukabumi', 'provinsi' => 'Jawa Barat'],
            ['nama' => 'SMA Negeri 1 Cirebon', 'kota' => 'Cirebon', 'provinsi' => 'Jawa Barat'],
            ['nama' => 'SMA Negeri 1 Tasikmalaya', 'kota' => 'Tasikmalaya', 'provinsi' => 'Jawa Barat'],

            // JAWA TENGAH
            ['nama' => 'SMA Negeri 1 Semarang', 'kota' => 'Semarang', 'provinsi' => 'Jawa Tengah'],
            ['nama' => 'SMA Negeri 2 Semarang', 'kota' => 'Semarang', 'provinsi' => 'Jawa Tengah'],
            ['nama' => 'SMA Negeri 3 Semarang', 'kota' => 'Semarang', 'provinsi' => 'Jawa Tengah'],
            ['nama' => 'SMA Negeri 1 Yogyakarta', 'kota' => 'Yogyakarta', 'provinsi' => 'DI Yogyakarta'],
            ['nama' => 'SMA Negeri 2 Yogyakarta', 'kota' => 'Yogyakarta', 'provinsi' => 'DI Yogyakarta'],
            ['nama' => 'SMA Negeri 1 Solo', 'kota' => 'Solo', 'provinsi' => 'Jawa Tengah'],
            ['nama' => 'SMA Negeri 2 Solo', 'kota' => 'Solo', 'provinsi' => 'Jawa Tengah'],
            ['nama' => 'SMA Negeri 1 Magelang', 'kota' => 'Magelang', 'provinsi' => 'Jawa Tengah'],

            // JAWA TIMUR
            ['nama' => 'SMA Negeri 1 Surabaya', 'kota' => 'Surabaya', 'provinsi' => 'Jawa Timur'],
            ['nama' => 'SMA Negeri 2 Surabaya', 'kota' => 'Surabaya', 'provinsi' => 'Jawa Timur'],
            ['nama' => 'SMA Negeri 3 Surabaya', 'kota' => 'Surabaya', 'provinsi' => 'Jawa Timur'],
            ['nama' => 'SMA Negeri 1 Malang', 'kota' => 'Malang', 'provinsi' => 'Jawa Timur'],
            ['nama' => 'SMA Negeri 2 Malang', 'kota' => 'Malang', 'provinsi' => 'Jawa Timur'],
            ['nama' => 'SMA Negeri 1 Sidoarjo', 'kota' => 'Sidoarjo', 'provinsi' => 'Jawa Timur'],
            ['nama' => 'SMA Negeri 1 Jember', 'kota' => 'Jember', 'provinsi' => 'Jawa Timur'],
            ['nama' => 'SMA Negeri 1 Banyuwangi', 'kota' => 'Banyuwangi', 'provinsi' => 'Jawa Timur'],

            // DKI JAKARTA
            ['nama' => 'SMA Negeri 3 Jakarta Pusat', 'kota' => 'Jakarta Pusat', 'provinsi' => 'DKI Jakarta'],
            ['nama' => 'SMA Negeri 8 Jakarta Pusat', 'kota' => 'Jakarta Pusat', 'provinsi' => 'DKI Jakarta'],
            ['nama' => 'SMA Negeri 1 Jakarta Utara', 'kota' => 'Jakarta Utara', 'provinsi' => 'DKI Jakarta'],
            ['nama' => 'SMA Negeri 4 Jakarta Barat', 'kota' => 'Jakarta Barat', 'provinsi' => 'DKI Jakarta'],
            ['nama' => 'SMA Negeri 5 Jakarta Barat', 'kota' => 'Jakarta Barat', 'provinsi' => 'DKI Jakarta'],
            ['nama' => 'SMA Negeri 6 Jakarta Selatan', 'kota' => 'Jakarta Selatan', 'provinsi' => 'DKI Jakarta'],
            ['nama' => 'SMA Negeri 14 Jakarta Selatan', 'kota' => 'Jakarta Selatan', 'provinsi' => 'DKI Jakarta'],
            ['nama' => 'SMA Negeri 2 Jakarta Timur', 'kota' => 'Jakarta Timur', 'provinsi' => 'DKI Jakarta'],

            // BANTEN
            ['nama' => 'SMA Negeri 1 Tangerang', 'kota' => 'Tangerang', 'provinsi' => 'Banten'],
            ['nama' => 'SMA Negeri 1 Serang', 'kota' => 'Serang', 'provinsi' => 'Banten'],
            ['nama' => 'SMA Negeri 1 Cilegon', 'kota' => 'Cilegon', 'provinsi' => 'Banten'],
            ['nama' => 'SMA Negeri 1 Depok', 'kota' => 'Depok', 'provinsi' => 'Banten'],

            // SUMATERA UTARA
            ['nama' => 'SMA Negeri 1 Medan', 'kota' => 'Medan', 'provinsi' => 'Sumatera Utara'],
            ['nama' => 'SMA Negeri 2 Medan', 'kota' => 'Medan', 'provinsi' => 'Sumatera Utara'],
            ['nama' => 'SMA Negeri 1 Binjai', 'kota' => 'Binjai', 'provinsi' => 'Sumatera Utara'],
            ['nama' => 'SMA Negeri 1 Pematangsiantar', 'kota' => 'Pematangsiantar', 'provinsi' => 'Sumatera Utara'],

            // SUMATERA BARAT
            ['nama' => 'SMA Negeri 1 Padang', 'kota' => 'Padang', 'provinsi' => 'Sumatera Barat'],
            ['nama' => 'SMA Negeri 2 Padang', 'kota' => 'Padang', 'provinsi' => 'Sumatera Barat'],
            ['nama' => 'SMA Negeri 1 Bukittinggi', 'kota' => 'Bukittinggi', 'provinsi' => 'Sumatera Barat'],

            // RIAU
            ['nama' => 'SMA Negeri 1 Pekanbaru', 'kota' => 'Pekanbaru', 'provinsi' => 'Riau'],
            ['nama' => 'SMA Negeri 2 Pekanbaru', 'kota' => 'Pekanbaru', 'provinsi' => 'Riau'],

            // JAMBI
            ['nama' => 'SMA Negeri 1 Jambi', 'kota' => 'Jambi', 'provinsi' => 'Jambi'],
            ['nama' => 'SMA Negeri 2 Jambi', 'kota' => 'Jambi', 'provinsi' => 'Jambi'],

            // SUMATERA SELATAN
            ['nama' => 'SMA Negeri 1 Palembang', 'kota' => 'Palembang', 'provinsi' => 'Sumatera Selatan'],
            ['nama' => 'SMA Negeri 2 Palembang', 'kota' => 'Palembang', 'provinsi' => 'Sumatera Selatan'],

            // LAMPUNG
            ['nama' => 'SMA Negeri 1 Bandar Lampung', 'kota' => 'Bandar Lampung', 'provinsi' => 'Lampung'],
            ['nama' => 'SMA Negeri 2 Bandar Lampung', 'kota' => 'Bandar Lampung', 'provinsi' => 'Lampung'],

            // BANGKA BELITUNG
            ['nama' => 'SMA Negeri 1 Pangkal Pinang', 'kota' => 'Pangkal Pinang', 'provinsi' => 'Kepulauan Bangka Belitung'],

            // KALIMANTAN BARAT
            ['nama' => 'SMA Negeri 1 Pontianak', 'kota' => 'Pontianak', 'provinsi' => 'Kalimantan Barat'],

            // KALIMANTAN TENGAH
            ['nama' => 'SMA Negeri 1 Palangkaraya', 'kota' => 'Palangkaraya', 'provinsi' => 'Kalimantan Tengah'],

            // KALIMANTAN SELATAN
            ['nama' => 'SMA Negeri 1 Banjarmasin', 'kota' => 'Banjarmasin', 'provinsi' => 'Kalimantan Selatan'],
            ['nama' => 'SMA Negeri 2 Banjarmasin', 'kota' => 'Banjarmasin', 'provinsi' => 'Kalimantan Selatan'],

            // KALIMANTAN TIMUR
            ['nama' => 'SMA Negeri 1 Samarinda', 'kota' => 'Samarinda', 'provinsi' => 'Kalimantan Timur'],
            ['nama' => 'SMA Negeri 1 Balikpapan', 'kota' => 'Balikpapan', 'provinsi' => 'Kalimantan Timur'],

            // KALIMANTAN UTARA
            ['nama' => 'SMA Negeri 1 Tarakan', 'kota' => 'Tarakan', 'provinsi' => 'Kalimantan Utara'],

            // SULAWESI UTARA
            ['nama' => 'SMA Negeri 1 Manado', 'kota' => 'Manado', 'provinsi' => 'Sulawesi Utara'],
            ['nama' => 'SMA Negeri 2 Manado', 'kota' => 'Manado', 'provinsi' => 'Sulawesi Utara'],

            // SULAWESI TENGAH
            ['nama' => 'SMA Negeri 1 Palu', 'kota' => 'Palu', 'provinsi' => 'Sulawesi Tengah'],

            // SULAWESI SELATAN
            ['nama' => 'SMA Negeri 1 Makassar', 'kota' => 'Makassar', 'provinsi' => 'Sulawesi Selatan'],
            ['nama' => 'SMA Negeri 2 Makassar', 'kota' => 'Makassar', 'provinsi' => 'Sulawesi Selatan'],
            ['nama' => 'SMA Negeri 1 Parepare', 'kota' => 'Parepare', 'provinsi' => 'Sulawesi Selatan'],

            // SULAWESI TENGGARA
            ['nama' => 'SMA Negeri 1 Kendari', 'kota' => 'Kendari', 'provinsi' => 'Sulawesi Tenggara'],

            // GORONTALO
            ['nama' => 'SMA Negeri 1 Gorontalo', 'kota' => 'Gorontalo', 'provinsi' => 'Gorontalo'],

            // SULAWESI BARAT
            ['nama' => 'SMA Negeri 1 Mamuju', 'kota' => 'Mamuju', 'provinsi' => 'Sulawesi Barat'],

            // BALI
            ['nama' => 'SMA Negeri 1 Denpasar', 'kota' => 'Denpasar', 'provinsi' => 'Bali'],
            ['nama' => 'SMA Negeri 2 Denpasar', 'kota' => 'Denpasar', 'provinsi' => 'Bali'],
            ['nama' => 'SMA Negeri 1 Ubud', 'kota' => 'Ubud', 'provinsi' => 'Bali'],

            // NUSA TENGGARA BARAT
            ['nama' => 'SMA Negeri 1 Mataram', 'kota' => 'Mataram', 'provinsi' => 'Nusa Tenggara Barat'],
            ['nama' => 'SMA Negeri 1 Sumbawa', 'kota' => 'Sumbawa', 'provinsi' => 'Nusa Tenggara Barat'],

            // NUSA TENGGARA TIMUR
            ['nama' => 'SMA Negeri 1 Kupang', 'kota' => 'Kupang', 'provinsi' => 'Nusa Tenggara Timur'],

            // PAPUA BARAT
            ['nama' => 'SMA Negeri 1 Manokwari', 'kota' => 'Manokwari', 'provinsi' => 'Papua Barat'],

            // PAPUA
            ['nama' => 'SMA Negeri 1 Jayapura', 'kota' => 'Jayapura', 'provinsi' => 'Papua'],

            // MALUKU
            ['nama' => 'SMA Negeri 1 Ambon', 'kota' => 'Ambon', 'provinsi' => 'Maluku'],

            // MALUKU UTARA
            ['nama' => 'SMA Negeri 1 Ternate', 'kota' => 'Ternate', 'provinsi' => 'Maluku Utara'],
        ];

        // Using Query Builder
        $this->db->table('schools')->insertBatch($data);
    }
}
