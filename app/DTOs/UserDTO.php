<?php

namespace App\DTOs;

/**
 * UserDTO
 * 
 * Data Transfer Object untuk User data
 */
class UserDTO extends BaseDTO
{
    public ?int $id = null;
    public ?string $username = null;
    public ?string $email = null;
    public ?string $password = null;
    public ?string $role = null;
    public ?string $nama = null;
    public ?int $is_active = null;

    /**
     * Validate user data
     * 
     * @return array
     */
    public function validate(): array
    {
        $errors = [];

        if (empty($this->email)) {
            $errors['email'] = 'Email harus diisi';
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Format email tidak valid';
        }

        if (empty($this->password) && empty($this->id)) {
            $errors['password'] = 'Password harus diisi';
        }

        if (empty($this->role)) {
            $errors['role'] = 'Role harus diisi';
        } elseif (!in_array($this->role, ['admin', 'applicant', 'panitia', 'bendahara', 'sales'])) {
            $errors['role'] = 'Role tidak valid';
        }

        return $errors;
    }

    /**
     * Create UserDTO for registration
     * 
     * @param array $data Registration data
     * @return self
     */
    public static function forRegistration(array $data): self
    {
        $dto = new self();
        $dto->username = $data['username'] ?? null;
        $dto->email = $data['email'] ?? null;
        $dto->password = $data['password'] ?? null;
        $dto->role = $data['role'] ?? 'applicant';
        $dto->is_active = 1;

        return $dto;
    }
}
