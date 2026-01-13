<?php

namespace App\Helpers;

use App\Models\PaymentModel;

class ReceiptHelper
{
    /**
     * Generate unique receipt number (Nomor Kwitansi)
     * Format: KWT-YYYYMM-XXXX
     * Example: KWT-202412-0001
     */
    public static function generateReceiptNumber()
    {
        $paymentModel = new PaymentModel();
        
        // Get current year-month
        $prefix = 'KWT-' . date('Ym');
        
        // Find the highest sequence number for this month
        $db = \Config\Database::connect();
        $result = $db->query(
            "SELECT SUBSTRING(receipt_number, -4) as seq 
             FROM payments 
             WHERE receipt_number LIKE ? 
             ORDER BY CAST(SUBSTRING(receipt_number, -4) AS UNSIGNED) DESC 
             LIMIT 1",
            ["{$prefix}-%"]
        )->getRow();
        
        $nextSequence = 1;
        if ($result && $result->seq) {
            $nextSequence = (int)$result->seq + 1;
        }
        
        // Format as KWT-YYYYMM-0001
        return sprintf('%s-%04d', $prefix, $nextSequence);
    }

    /**
     * Generate payment reference for manual entry
     * Format: REF-YYYYMM-XXXX
     * Example: REF-202412-0001
     */
    public static function generatePaymentReference()
    {
        $paymentModel = new PaymentModel();
        
        // Get current year-month
        $prefix = 'REF-' . date('Ym');
        
        // Find the highest sequence number for this month
        $db = \Config\Database::connect();
        $result = $db->query(
            "SELECT MAX(CAST(SUBSTRING(id, -4) AS UNSIGNED)) as max_seq 
             FROM payments 
             WHERE created_at >= DATE_FORMAT(NOW(), '%Y-%m-01')",
            []
        )->getRow();
        
        $nextSequence = ($result && $result->max_seq) ? $result->max_seq + 1 : 1;
        
        return sprintf('%s-%04d', $prefix, $nextSequence);
    }

    /**
     * Format currency to Indonesian Rupiah
     */
    public static function formatCurrency($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }

    /**
     * Format date to Indonesian format
     */
    public static function formatDate($date, $format = 'long')
    {
        $timestamp = strtotime($date);
        $monthsIndo = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember',
        ];

        if ($format === 'short') {
            return date('d/m/Y', $timestamp);
        }

        $day = date('d', $timestamp);
        $month = $monthsIndo[date('F', $timestamp)];
        $year = date('Y', $timestamp);

        return "{$day} {$month} {$year}";
    }
}
