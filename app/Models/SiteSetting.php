<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value', 
        'type'
    ];

    public static function getValue($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        
        if (!$setting) {
            return $default;
        }

        // Handle image type - return root-relative path for better compatibility with different domains
        if ($setting->type === 'image' && $setting->value) {
            return '/storage/' . $setting->value;
        }

        return $setting->value ?? $default;
    }

    public static function setValue($key, $value, $type = 'text')
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'type' => $type]
        );
    }

    // Helper methods for common settings
    public static function getCompanyName()
    {
        return self::getValue('company_name', 'Company Name');
    }

    public static function getCompanySubName()
    {
        return self::getValue('company_subname', '');
    }

    public static function getNavbarCompanyName1()
    {
        return self::getValue('navbar_company_name_1', self::getCompanyName());
    }

    public static function getNavbarCompanyName2()
    {
        return self::getValue('navbar_company_name_2', '');
    }

    public static function getTagline() 
    {
        return self::getValue('tagline', 'Your Business Tagline');
    }

    public static function getLogo()
    {
        return self::getValue('logo');
    }

    public static function getFavicon()
    {
        return self::getValue('favicon');
    }

    public static function getAddress()
    {
        return self::getValue('address', 'Company Address');
    }

    public static function getPhone()
    {
        return self::getValue('phone', '+62 XXX XXXX');
    }

    public static function getEmail()
    {
        return self::getValue('email', 'info@company.com');
    }

    public static function getFacebookUrl()
    {
        return self::getValue('facebook_url');
    }

    public static function getTwitterUrl()
    {
        return self::getValue('twitter_url');
    }

    public static function getInstagramUrl()
    {
        return self::getValue('instagram_url');
    }

    public static function getFooterDescription()
    {
        return self::getValue('footer_description', 'Leading the way in sustainable technology and environmental solutions.');
    }
}