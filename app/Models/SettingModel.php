<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table            = 'settings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'setting_key',
        'setting_value',
        'setting_type',
        'description'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'setting_key'   => 'required|max_length[100]',
        'setting_type'  => 'required|in_list[text,image,number,boolean]',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Get setting value by key
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        $setting = $this->where('setting_key', $key)->first();
        
        if (!$setting) {
            return $default;
        }

        return $setting['setting_value'];
    }

    /**
     * Set setting value by key
     *
     * @param string $key
     * @param mixed $value
     * @param string $type
     * @return bool
     */
    public function setSetting($key, $value, $type = 'text')
    {
        $existing = $this->where('setting_key', $key)->first();

        if ($existing) {
            return $this->update($existing['id'], [
                'setting_value' => $value,
                'setting_type'  => $type,
            ]);
        }

        return $this->insert([
            'setting_key'   => $key,
            'setting_value' => $value,
            'setting_type'  => $type,
        ]);
    }

    /**
     * Get all settings as key-value pairs
     *
     * @return array
     */
    public function getAllSettings()
    {
        $settings = $this->findAll();
        $result = [];

        foreach ($settings as $setting) {
            $result[$setting['setting_key']] = $setting['setting_value'];
        }

        return $result;
    }

    /**
     * Get settings by type
     *
     * @param string $type
     * @return array
     */
    public function getByType($type)
    {
        return $this->where('setting_type', $type)->findAll();
    }

    /**
     * Delete setting by key
     *
     * @param string $key
     * @return bool
     */
    public function deleteByKey($key)
    {
        return $this->where('setting_key', $key)->delete();
    }

    /**
     * Check if setting exists
     *
     * @param string $key
     * @return bool
     */
    public function exists($key)
    {
        return $this->where('setting_key', $key)->countAllResults() > 0;
    }
}
