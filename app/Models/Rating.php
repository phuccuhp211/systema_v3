<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Rating extends Model
{
    use HasFactory;

    protected $table = 'Ratings';
    protected $primaryKey = 'id';
    protected $fillable = ['id_pd', 'stars', 'turns'];
    public $timestamps = false;

    public static function rate($pd, $stars, $isNew, $old) {
        $rating = self::firstOrNew(['id_pd' => $pd]);

        if ($isNew) {
            $rating->stars += $stars;
            $rating->turns += 1;
        } else {
            $rating->stars = $rating->stars - $old + $stars;
        }

        $rating->save();
    }

    public function rating($idus=null, $idsp=null, $exist=null, $rate=null, $old_rt=null) {
        if (!isset($exist)) return $this->getdata("SELECT * FROM turnrt WHERE idus = $idus AND idsp = $idsp");
        
        else if ($exist == "plus") {
            $this->iuddata("INSERT INTO turnrt VALUES('','$idus','$idsp','$rate')");
            $ketqua = $this->getdata("SELECT * FROM rating WHERE idsp = $idsp");

            if (!isset($ketqua[0])) $this->iuddata("INSERT INTO rating VALUES('','$idsp','$rate',1)");
            else $this->iuddata("UPDATE rating SET stars = stars + $rate, turn = turn + 1 WHERE idsp = $idsp");
        }

        else if ($exist == "rert") {
            $this->iuddata("UPDATE turnrt SET stars = $rate");
            $this->iuddata("UPDATE rating SET stars = stars - $old_rt + $rate WHERE idsp = $idsp");
        }
    }

    public static function get_rt ($id_pd) {
        return self::where('id_pd',$id_pd)->first();
    }
}
