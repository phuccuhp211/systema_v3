<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Us extends Model
{
    use HasFactory;

    protected $table = 'Uss';

    public static function get_us($name) {
        return self::where('account', $name)->first();
    }
}
