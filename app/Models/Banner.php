<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model {
    use HasFactory;

    protected $table = 'Banners';

    public static function get_bn() {
        return self::get();
    }
}
