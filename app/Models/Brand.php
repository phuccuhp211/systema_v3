<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $table = 'Brands';

    public static function get_br($data) {
        return self::select('name')->where('id',$data)->value('name');
    }
}
