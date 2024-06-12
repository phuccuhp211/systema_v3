<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model {
    use HasFactory;

    protected $table = 'Banners';
    protected $primaryKey = 'id';
    protected $fillable = [ 'img', 'tit', 'ctn'];
    public $timestamps = false;

    public static function get_bn() {
        return self::get();
    }
}
