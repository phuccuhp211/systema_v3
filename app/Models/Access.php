<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Access extends Model {
    use HasFactory;

    protected $table = 'Accesses';
    protected $fillable = ['homet', 'homef', 'sum'];

    public static function uphomet() {
        $check_data = self::first();
        if (!$check_data) $check_data = self::create(['homet' => 1, 'homef' => 0, 'sum' => 0]);
        else $check_data->increment('homet');
    }
    public static function uphomef() {
        $check_data = self::first();
        if (!$check_data) $check_data = self::create(['homet' => 0, 'homef' => 1, 'sum' => 0]);
        else $check_data->increment('homef');
    }

    public static function tttf() {
        return self::first();
    }
}
