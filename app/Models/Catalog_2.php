<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalog_2 extends Model
{
    use HasFactory;

    protected $table = 'Catalog_2';
    protected $primaryKey = 'id';
    protected $fillable = [ 'name', 'type', 'img'];
    public $timestamps = false;
    protected $attributes = [ 'img' => '' ];

    public static function full_cat($id=null) {
        if($id) return self::where('id', $id)->get();
        else return self::all();
    }
    public static function get_dedi($id=null) {
        return self::where('id', $id)->value('name');
    }
}
