<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalog_1 extends Model
{
    use HasFactory;

    protected $table = 'Catalog_1';
    protected $primaryKey = 'id';
    protected $fillable = [ 'name' ];
    public $timestamps = false;

    public static function full_cat($id=null) {
        if($id) return self::where('id', $id)->get();
        else return self::all();
    }
    public static function get_dedi($id=null) {
        return self::where('id', $id)->value('name');  
    }
}
