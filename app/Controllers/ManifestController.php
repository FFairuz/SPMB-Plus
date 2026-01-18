<?php

namespace App\Controllers;

use App\Models\SettingModel;

class ManifestController extends BaseController
{
    public function index()
    {
        $settingModel = new SettingModel();
        
        // Get settings from database
        $appName = $settingModel->getSetting('app_name', 'SPMB Plus');
        $schoolName = $settingModel->getSetting('school_name', 'Sekolah ABC');
        $appLogo = $settingModel->getSetting('app_logo', 'default-logo.png');
        
        // Determine icon base URL
        // If logo is uploaded and PWA icons exist, use them
        // Otherwise fallback to default PWA icons
        $pwaIconPath = FCPATH . 'pwa-icons/icon-192x192.png';
        if (file_exists($pwaIconPath)) {
            // Use PWA icons (will be generated from logo)
            $useCustomIcons = true;
        } else {
            // Use default PWA icons
            $useCustomIcons = false;
        }
        
        $manifest = [
            'name' => $appName . ' - ' . $schoolName,
            'short_name' => $appName,
            'description' => 'Aplikasi Sistem Penerimaan Mahasiswa Baru untuk mengelola pendaftaran siswa secara online',
            'start_url' => base_url('/'),
            'display' => 'standalone',
            'background_color' => '#ffffff',
            'theme_color' => '#3b82f6',
            'orientation' => 'portrait-primary',
            'scope' => base_url('/'),
            'lang' => 'id-ID',
            'dir' => 'ltr',
            'categories' => ['education', 'productivity'],
            'icons' => $this->generateIcons($useCustomIcons),
            'shortcuts' => [
                [
                    'name' => 'Dashboard',
                    'short_name' => 'Dashboard',
                    'description' => 'Buka Dashboard Admin',
                    'url' => base_url('/admin/dashboard'),
                    'icons' => [
                        [
                            'src' => base_url('pwa-icons/icon-96x96.png'),
                            'sizes' => '96x96'
                        ]
                    ]
                ],
                [
                    'name' => 'Pendaftar',
                    'short_name' => 'Pendaftar',
                    'description' => 'Kelola Data Pendaftar',
                    'url' => base_url('/admin/applicants'),
                    'icons' => [
                        [
                            'src' => base_url('pwa-icons/icon-96x96.png'),
                            'sizes' => '96x96'
                        ]
                    ]
                ]
            ],
            'screenshots' => [
                [
                    'src' => base_url('pwa-icons/screenshot-wide.png'),
                    'sizes' => '1280x720',
                    'type' => 'image/png',
                    'form_factor' => 'wide'
                ],
                [
                    'src' => base_url('pwa-icons/screenshot-mobile.png'),
                    'sizes' => '750x1334',
                    'type' => 'image/png',
                    'form_factor' => 'narrow'
                ]
            ]
        ];
        
        return $this->response
            ->setContentType('application/json')
            ->setJSON($manifest);
    }
    
    private function generateIcons($useCustom = true)
    {
        $sizes = ['72x72', '96x96', '128x128', '144x144', '152x152', '192x192', '384x384', '512x512'];
        $icons = [];
        
        foreach ($sizes as $size) {
            $icons[] = [
                'src' => base_url('pwa-icons/icon-' . $size . '.png'),
                'sizes' => $size,
                'type' => 'image/png',
                'purpose' => 'any maskable'
            ];
        }
        
        return $icons;
    }
}
