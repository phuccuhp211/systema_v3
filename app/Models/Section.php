<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model {
    use HasFactory;

    protected $table = 'Sections';

    public static function get_ss() {
        return self::where('index', '>' ,0)->orderBy('id','ASC')->get();
    }
}
