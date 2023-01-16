<?php
namespace App\Models;

use DB;

class Base
{

	public function saveSettings($type, $data)
    {
        $setting_key = 'general_settings';

        switch ($type) {
            case 'contact':
                $setting_key = 'contact_settings';
                break;
            case 'seo':
                $setting_key = 'seo_settings';
                break;
        }

        return DB::table('settings')->where('settings_key', '=', $setting_key)->update([
            'settings_value' => json_encode($data)
        ]);
    }

    public function getSetting($type)
    {
        $setting_key = 'general_settings';

        switch ($type) {
            case 'contact':
                $setting_key = 'contact_settings';
                break;
            case 'seo':
                $setting_key = 'seo_settings';
                break;
        }

        return DB::table('settings')->where('settings_key', '=', $setting_key)->getRow();
    }

    public function getUser(int $userId)
    {
        return DB::table('admin')
            ->where('ID', '=', $userId)
            ->getRow();
    }

    public function updateUser(int $userId, array $data): int
    {
        return DB::table('admin')
            ->where('ID', '=', $userId)
            ->update($data);
    }

}
