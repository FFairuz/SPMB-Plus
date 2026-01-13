<?php

namespace App\DTOs;

/**
 * ApplicantDTO
 * 
 * Data Transfer Object untuk Applicant data
 */
class ApplicantDTO extends BaseDTO
{
    public ?int $id = null;
    public ?int $user_id = null;
    public ?string $full_name = null;
    public ?string $date_of_birth = null;
    public ?string $gender = null;
    public ?string $phone = null;
    public ?string $address = null;
    public ?string $city = null;
    public ?string $province = null;
    public ?string $postal_code = null;
    public ?string $school_origin = null;
    public ?float $gpa = null;
    public ?string $registration_number = null;
    public ?string $status = null;
    public ?int $documents_uploaded = null;

    /**
     * Validate applicant data
     * 
     * @return array
     */
    public function validate(): array
    {
        $errors = [];

        if (empty($this->full_name)) {
            $errors['full_name'] = 'Nama lengkap harus diisi';
        }

        if (empty($this->date_of_birth)) {
            $errors['date_of_birth'] = 'Tanggal lahir harus diisi';
        }

        if (empty($this->gender)) {
            $errors['gender'] = 'Jenis kelamin harus diisi';
        } elseif (!in_array($this->gender, ['laki-laki', 'perempuan'])) {
            $errors['gender'] = 'Jenis kelamin tidak valid';
        }

        if (empty($this->phone)) {
            $errors['phone'] = 'Nomor telepon harus diisi';
        }

        if (empty($this->address)) {
            $errors['address'] = 'Alamat harus diisi';
        }

        if (empty($this->city)) {
            $errors['city'] = 'Kota harus diisi';
        }

        if (empty($this->province)) {
            $errors['province'] = 'Provinsi harus diisi';
        }

        if (empty($this->postal_code)) {
            $errors['postal_code'] = 'Kode pos harus diisi';
        }

        if (empty($this->school_origin)) {
            $errors['school_origin'] = 'Asal sekolah harus diisi';
        }

        if ($this->gpa === null) {
            $errors['gpa'] = 'Nilai rata-rata harus diisi';
        } elseif ($this->gpa < 0 || $this->gpa > 100) {
            $errors['gpa'] = 'Nilai rata-rata harus antara 0-100';
        }

        return $errors;
    }
}
