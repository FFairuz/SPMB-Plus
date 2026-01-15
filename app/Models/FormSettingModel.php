<?php

namespace App\Models;

use CodeIgniter\Model;

class FormSettingModel extends Model
{
    protected $table = 'form_settings';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $allowedFields = [
        'setting_key',
        'setting_value',
        'setting_type',
        'description'
    ];

    /**
     * Get setting value by key
     */
    public function getSetting($key, $default = null)
    {
        $setting = $this->where('setting_key', $key)->first();
        
        if (!$setting) {
            return $default;
        }

        return $this->parseValue($setting['setting_value'], $setting['setting_type']);
    }

    /**
     * Update setting value by key
     */
    public function updateSetting($key, $value)
    {
        $setting = $this->where('setting_key', $key)->first();
        
        if (!$setting) {
            return false;
        }

        $parsedValue = $this->formatValue($value, $setting['setting_type']);
        
        return $this->where('setting_key', $key)->set([
            'setting_value' => $parsedValue,
            'updated_at' => date('Y-m-d H:i:s')
        ])->update();
    }

    /**
     * Get all settings as associative array
     */
    public function getAllSettings()
    {
        $settings = $this->findAll();
        $result = [];

        foreach ($settings as $setting) {
            $result[$setting['setting_key']] = $this->parseValue(
                $setting['setting_value'],
                $setting['setting_type']
            );
        }

        return $result;
    }

    /**
     * Parse value based on type
     */
    private function parseValue($value, $type)
    {
        switch ($type) {
            case 'boolean':
                return (bool) $value;
            case 'number':
                return (int) $value;
            case 'json':
                return json_decode($value, true);
            case 'date':
                return $value;
            default:
                return $value;
        }
    }

    /**
     * Format value for storage
     */
    private function formatValue($value, $type)
    {
        switch ($type) {
            case 'boolean':
                return $value ? '1' : '0';
            case 'number':
                return (string) $value;
            case 'json':
                return is_array($value) ? json_encode($value) : $value;
            default:
                return $value;
        }
    }

    /**
     * Check if form is active
     */
    public function isFormActive()
    {
        $status = $this->getSetting('form_status', false);
        
        if (!$status) {
            return false;
        }

        // Check date range
        $startDate = $this->getSetting('form_start_date');
        $endDate = $this->getSetting('form_end_date');
        $today = date('Y-m-d');

        if ($startDate && $today < $startDate) {
            return false;
        }

        if ($endDate && $today > $endDate) {
            return false;
        }

        return true;
    }

    /**
     * Check if max applicants reached
     */
    public function isMaxApplicantsReached()
    {
        $maxApplicants = $this->getSetting('max_applicants', 0);
        
        if ($maxApplicants <= 0) {
            return false; // Unlimited
        }

        $applicantModel = new \App\Models\Applicant();
        $currentCount = $applicantModel->countAllResults();

        return $currentCount >= $maxApplicants;
    }
}
