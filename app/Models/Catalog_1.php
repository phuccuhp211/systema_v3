<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalog_1 extends Model
{
    use HasFactory;

    protected $table = 'Catalog_1';

    public static function full_cat($id=null) {
        if($id) return self::where('id', $id)->get();
        else return self::all();
    }
}