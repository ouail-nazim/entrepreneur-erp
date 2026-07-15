<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value'];

    public static function get($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        if ($setting) {
            return $setting->value;
        }

        $defaults = [
            'app_name' => 'Moustafa Marouf',
            'company_name' => 'Promotion Immobilière Moustafa Marouf',
            'company_email' => 'moustafamarouf24@gmail.com',
            'company_phone' => '+213 770753232',
            'company_address' => 'Cité 8 aout 1954, Ain Mkhlouf Guelma',
            'currency' => 'DA',
            'default_language' => 'fr',
            'working_days_per_month' => '22',
        ];

        return $defaults[$key] ?? $default;
    }

    public static function set($key, $value)
    {
        return self::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
