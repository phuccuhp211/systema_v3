<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Rating;

class Turn_rating extends Model
{
    use HasFactory;

    protected $table = 'Turn_ratings';
    protected $primaryKey = 'id';
    protected $fillable = ['id_pd', 'id_us', 'stars'];
    public $timestamps = false;

    public static function rate($pd,$us,$stars) {
        $check = self::where([['id_us', $us], ['id_pd', $pd]])->first();
        $type = true;
        $old = 0;

        if (!$check) self::create([ 'id_pd' => $pd, 'id_us' => $us, 'stars' => $stars ]);
        else {
            $type = false;
            $old = $check->stars;
            $check->update(['stars' => $stars]);
        }
        Rating::rate($pd, $stars, $type, $old);
    }

    public static function get_rt ($id_us,$id_pd) {
        return self::where([['id_us',$id_us],['id_pd',$id_pd]])->first();
    }
}
