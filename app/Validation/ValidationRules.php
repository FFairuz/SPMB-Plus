<?php

namespace App\Validation;

/**
 * ValidationRules
 * 
 * Centralized validation rules untuk reusability
 */
class ValidationRules
{
    /**
     * User registration validation rules
     * 
     * @return array
     */
    public static function userRegistration(): array
    {
        return [
            'username' => [
                'label' => 'Username',
                'rules' => 'required|alpha_numeric_space|min_length[3]|max_length[100]|is_unique[users.username]',
                'errors' => [
                    'required' => 'Username harus diisi',
                    'alpha_numeric_space' => 'Username hanya boleh mengandung huruf, angka, dan spasi',
                    'min_length' => 'Username minimal 3 karakter',
                    'max_length' => 'Username maksimal 100 karakter',
                    'is_unique' => 'Username sudah digunakan',
                ],
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => 'Email harus diisi',
                    'valid_email' => 'Format email tidak valid',
                    'is_unique' => 'Email sudah terdaftar',
                ],
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'Password harus diisi',
                    'min_length' => 'Password minimal 6 karakter',
                ],
            ],
            'password_confirm' => [
                'label' => 'Konfirmasi Password',
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Konfirmasi password harus diisi',
                    'matches' => 'Password tidak cocok',
                ],
            ],
        ];
    }

    /**
     * User login validation rules
     * 
     * @return array
     */
    public static function userLogin(): array
    {
        return [
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Email harus diisi',
                    'valid_email' => 'Format email tidak valid',
                ],
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password harus diisi',
                ],
            ],
        ];
    }

    /**
     * Applicant registration validation rules
     * 
     * @return array
     */
    public static function applicantRegistration(): array
    {
        return [
            'full_name' => [
                'label' => 'Nama Lengkap',
                'rules' => 'required|min_length[3]|max_length[255]',
                'errors' => [
                    'required' => 'Nama lengkap harus diisi',
                    'min_length' => 'Nama minimal 3 karakter',
                    'max_length' => 'Nama maksimal 255 karakter',
                ],
            ],
            'date_of_birth' => [
                'label' => 'Tanggal Lahir',
                'rules' => 'required|valid_date[Y-m-d]',
                'errors' => [
                    'required' => 'Tanggal lahir harus diisi',
                    'valid_date' => 'Format tanggal tidak valid (gunakan YYYY-MM-DD)',
                ],
            ],
            'gender' => [
                'label' => 'Jenis Kelamin',
                'rules' => 'required|in_list[laki-laki,perempuan]',
                'errors' => [
                    'required' => 'Jenis kelamin harus dipilih',
                    'in_list' => 'Jenis kelamin harus laki-laki atau perempuan',
                ],
            ],
            'phone' => [
                'label' => 'Nomor Telepon',
                'rules' => 'required|numeric|min_length[10]|max_length[15]',
                'errors' => [
                    'required' => 'Nomor telepon harus diisi',
                    'numeric' => 'Nomor telepon harus berupa angka',
                    'min_length' => 'Nomor telepon minimal 10 digit',
                    'max_length' => 'Nomor telepon maksimal 15 digit',
                ],
            ],
            'address' => [
                'label' => 'Alamat',
                'rules' => 'required|min_length[10]',
                'errors' => [
                    'required' => 'Alamat harus diisi',
                    'min_length' => 'Alamat minimal 10 karakter',
                ],
            ],
            'city' => [
                'label' => 'Kota/Kabupaten',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kota/Kabupaten harus diisi',
                ],
            ],
            'province' => [
                'label' => 'Provinsi',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Provinsi harus diisi',
                ],
            ],
            'postal_code' => [
                'label' => 'Kode Pos',
                'rules' => 'required|numeric|exact_length[5]',
                'errors' => [
                    'required' => 'Kode pos harus diisi',
                    'numeric' => 'Kode pos harus berupa angka',
                    'exact_length' => 'Kode pos harus 5 digit',
                ],
            ],
            'school_origin' => [
                'label' => 'Asal Sekolah',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Asal sekolah harus diisi',
                ],
            ],
            'gpa' => [
                'label' => 'Nilai Rata-rata',
                'rules' => 'required|numeric|greater_than[0]|less_than_equal_to[100]',
                'errors' => [
                    'required' => 'Nilai rata-rata harus diisi',
                    'numeric' => 'Nilai rata-rata harus berupa angka',
                    'greater_than' => 'Nilai rata-rata harus lebih dari 0',
                    'less_than_equal_to' => 'Nilai rata-rata maksimal 100',
                ],
            ],
        ];
    }

    /**
     * Payment validation rules
     * 
     * @return array
     */
    public static function payment(): array
    {
        return [
            'amount' => [
                'label' => 'Jumlah Pembayaran',
                'rules' => 'required|numeric|greater_than[0]',
                'errors' => [
                    'required' => 'Jumlah pembayaran harus diisi',
                    'numeric' => 'Jumlah pembayaran harus berupa angka',
                    'greater_than' => 'Jumlah pembayaran harus lebih dari 0',
                ],
            ],
            'payment_method' => [
                'label' => 'Metode Pembayaran',
                'rules' => 'required|in_list[transfer,cash,online]',
                'errors' => [
                    'required' => 'Metode pembayaran harus dipilih',
                    'in_list' => 'Metode pembayaran tidak valid',
                ],
            ],
        ];
    }

    /**
     * Document upload validation rules
     * 
     * @return array
     */
    public static function documentUpload(): array
    {
        return [
            'document_type' => [
                'label' => 'Jenis Dokumen',
                'rules' => 'required|in_list[ijazah,kartu_keluarga,akta_kelahiran,foto,rapor]',
                'errors' => [
                    'required' => 'Jenis dokumen harus dipilih',
                    'in_list' => 'Jenis dokumen tidak valid',
                ],
            ],
            'document_file' => [
                'label' => 'File Dokumen',
                'rules' => 'uploaded[document_file]|max_size[document_file,5120]|ext_in[document_file,pdf,jpg,jpeg,png]',
                'errors' => [
                    'uploaded' => 'File dokumen harus diunggah',
                    'max_size' => 'Ukuran file maksimal 5MB',
                    'ext_in' => 'File harus berformat PDF, JPG, JPEG, atau PNG',
                ],
            ],
        ];
    }

    /**
     * Get validation rules by key
     * 
     * @param string $key Rules key (e.g., 'userRegistration', 'applicantRegistration')
     * @return array
     */
    public static function get(string $key): array
    {
        $method = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $key))));
        
        if (method_exists(self::class, $method)) {
            return self::$method();
        }

        return [];
    }

    /**
     * Extract simple rules from detailed rules
     * 
     * @param array $detailedRules Detailed rules with labels and errors
     * @return array Simple rules array
     */
    public static function extractRules(array $detailedRules): array
    {
        $rules = [];
        
        foreach ($detailedRules as $field => $config) {
            $rules[$field] = $config['rules'] ?? '';
        }

        return $rules;
    }
}
