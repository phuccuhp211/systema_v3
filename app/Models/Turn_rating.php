<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Turn_rating extends Model
{
    use HasFactory;

    protected $table = 'Turn_ratings';

    public static function get_rt ($id_us=null, $id_pd=null) {
        if (isset($idus)) return self::where([['id_us',$id_us],['id_pd'],$id_pd])->get();
        else return DB::table('ratings')->where('id_pd',$id_pd)->get();
    }
}
