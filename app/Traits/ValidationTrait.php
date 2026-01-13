<?php

namespace App\Traits;

/**
 * Trait untuk validation helper methods
 * 
 * Menyediakan method helper untuk validasi data.
 */
trait ValidationTrait
{
    /**
     * Validate NIK format
     * 
     * @param string $nik NIK string
     * @return bool
     */
    protected function validateNIK($nik)
    {
        // NIK Indonesia harus 16 digit
        return preg_match('/^\d{16}$/', $nik) === 1;
    }

    /**
     * Validate phone number format
     * 
     * @param string $phone Phone number
     * @return bool
     */
    protected function validatePhoneNumber($phone)
    {
        // Phone number harus angka, 10-13 digit
        return preg_match('/^\d{10,13}$/', str_replace(['+', '-', ' '], '', $phone)) === 1;
    }

    /**
     * Validate email format
     * 
     * @param string $email Email address
     * @return bool
     */
    protected function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Validate date format
     * 
     * @param string $date Date string (Y-m-d format)
     * @return bool
     */
    protected function validateDate($date)
    {
        try {
            new \DateTime($date);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Validate age dari tanggal lahir
     * 
     * @param string $tanggalLahir Tanggal lahir (Y-m-d format)
     * @param int $minAge Minimum age
     * @param int $maxAge Maximum age (optional)
     * @return bool
     */
    protected function validateAge($tanggalLahir, $minAge = 0, $maxAge = null)
    {
        try {
            $birthDate = new \DateTime($tanggalLahir);
            $today = new \DateTime();
            $age = $today->diff($birthDate)->y;

            if ($maxAge) {
                return $age >= $minAge && $age <= $maxAge;
            }

            return $age >= $minAge;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Validate postal code
     * 
     * @param string $postalCode Postal code
     * @return bool
     */
    protected function validatePostalCode($postalCode)
    {
        // Indonesia postal code adalah 5 digit
        return preg_match('/^\d{5}$/', $postalCode) === 1;
    }

    /**
     * Sanitize input string
     * 
     * @param string $input Input string
     * @return string
     */
    protected function sanitizeString($input)
    {
        return trim(htmlspecialchars($input, ENT_QUOTES, 'UTF-8'));
    }

    /**
     * Sanitize email
     * 
     * @param string $email Email address
     * @return string
     */
    protected function sanitizeEmail($email)
    {
        return filter_var(trim($email), FILTER_SANITIZE_EMAIL);
    }

    /**
     * Sanitize numeric
     * 
     * @param mixed $input Input
     * @return int|float
     */
    protected function sanitizeNumeric($input)
    {
        return filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }
}
