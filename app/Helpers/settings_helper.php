<?php

if (!function_exists('get_setting')) {
    /**
     * Get application setting value
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function get_setting($key, $default = null)
    {
        $settingModel = new \App\Models\SettingModel();
        return $settingModel->get($key, $default);
    }
}

if (!function_exists('get_all_settings')) {
    /**
     * Get all application settings
     *
     * @return array
     */
    function get_all_settings()
    {
        $settingModel = new \App\Models\SettingModel();
        return $settingModel->getAllSettings();
    }
}

if (!function_exists('app_name')) {
    /**
     * Get application name
     *
     * @return string
     */
    function app_name()
    {
        return get_setting('app_name', 'SPMB-Plus');
    }
}

if (!function_exists('app_logo')) {
    /**
     * Get application logo URL
     *
     * @return string
     */
    function app_logo()
    {
        $logo = get_setting('app_logo', 'default-logo.png');
        
        if ($logo === 'default-logo.png' || empty($logo)) {
            return base_url('assets/img/default-logo.png');
        }
        
        return base_url('uploads/logo/' . $logo);
    }
}

if (!function_exists('school_name')) {
    /**
     * Get school name
     *
     * @return string
     */
    function school_name()
    {
        return get_setting('school_name', 'Sekolah');
    }
}

if (!function_exists('app_description')) {
    /**
     * Get application description
     *
     * @return string
     */
    function app_description()
    {
        return get_setting('app_description', 'Sistem Penerimaan Peserta Didik Baru');
    }
}
