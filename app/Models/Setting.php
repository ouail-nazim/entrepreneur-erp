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
            'company_name' => config('app.name', 'Entrepreneur ERP'),
            'company_email' => 'info@' . strtolower(str_replace(' ', '', config('app.name', 'entrepreneur')) ) . '.com',
            'company_phone' => '+1 (123) 456-7890',
            'company_address' => "123 Business Road\nCity, State 12345",
            'currency' => '€',
            'default_language' => 'en',
            'working_days_per_month' => '22',
        ];

        return $defaults[$key] ?? $default;
    }

    public static function set($key, $value)
    {
        return self::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
