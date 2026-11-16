<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value', 
        'type'
    ];

    private const CACHE_KEY = 'site_settings.all';

    /** Salinan di memori untuk satu request, agar cache tidak dibaca berulang kali. */
    private static ?array $memo = null;

    protected static function booted(): void
    {
        // Setiap perubahan dari admin langsung menghapus cache
        static::saved(fn () => static::flushCache());
        static::deleted(fn () => static::flushCache());
    }

    public static function flushCache(): void
    {
        static::$memo = null;
        Cache::forget(self::CACHE_KEY);
    }

    /**
     * Semua setting dalam satu query, disimpan di cache: [key => ['value' => ..., 'type' => ...]].
     */
    public static function allCached(): array
    {
        return static::$memo ??= Cache::rememberForever(self::CACHE_KEY, function () {
            return static::query()
                ->get(['key', 'value', 'type'])
                ->mapWithKeys(fn ($s) => [$s->key => ['value' => $s->value, 'type' => $s->type]])
                ->all();
        });
    }

    public static function getValue($key, $default = null)
    {
        $setting = static::allCached()[$key] ?? null;

        if (!$setting) {
            return $default;
        }

        // Handle image type - return root-relative path for better compatibility with different domains
        if ($setting['type'] === 'image' && $setting['value']) {
            return '/storage/' . $setting['value'];
        }

        return $setting['value'] ?? $default;
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