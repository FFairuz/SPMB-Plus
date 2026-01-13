<?php

namespace App\DTOs;

/**
 * PaymentDTO
 * 
 * Data Transfer Object untuk Payment data
 */
class PaymentDTO extends BaseDTO
{
    public ?int $id = null;
    public ?int $user_id = null;
    public ?int $applicant_id = null;
    public ?float $amount = null;
    public ?string $payment_method = null;
    public ?string $payment_date = null;
    public ?string $payment_proof = null;
    public ?string $payment_status = null;
    public ?string $notes = null;
    public ?string $verified_at = null;

    /**
     * Validate payment data
     * 
     * @return array
     */
    public function validate(): array
    {
        $errors = [];

        if ($this->amount === null || $this->amount <= 0) {
            $errors['amount'] = 'Jumlah pembayaran harus lebih dari 0';
        }

        if (empty($this->payment_method)) {
            $errors['payment_method'] = 'Metode pembayaran harus diisi';
        } elseif (!in_array($this->payment_method, ['transfer', 'cash', 'online'])) {
            $errors['payment_method'] = 'Metode pembayaran tidak valid';
        }

        if ($this->payment_status && !in_array($this->payment_status, ['pending', 'confirmed', 'rejected'])) {
            $errors['payment_status'] = 'Status pembayaran tidak valid';
        }

        return $errors;
    }

    /**
     * Create PaymentDTO from request data
     * 
     * @param array $data Request data
     * @param int $userId User ID
     * @return self
     */
    public static function fromRequest(array $data, int $userId): self
    {
        $dto = new self();
        $dto->user_id = $userId;
        $dto->amount = $data['amount'] ?? null;
        $dto->payment_method = $data['payment_method'] ?? null;
        $dto->payment_date = date('Y-m-d H:i:s');
        $dto->payment_status = 'pending';

        return $dto;
    }
}
