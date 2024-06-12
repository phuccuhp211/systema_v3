<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model {
    use HasFactory;

    protected $table = 'Sections';
    protected $primaryKey = 'id';
    protected $fillable = [ 'name', 'poster', 'eb_img', 'id_cata_1', 'id_cata_2', 'index', 'reference', 'orderby'];
    public $timestamps = false;

    public static function get_ss() {
        return self::where('index', '>' ,0)->orderBy('id','ASC')->get();
    }
}
