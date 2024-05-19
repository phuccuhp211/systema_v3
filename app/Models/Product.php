<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'Products';

    public static function get_st() {
        return self::where('hidden',1)->limit(10)->get();
    }

    public static function get_ps() {
        $casepcs = self::select('id','name','img','detail')
            ->where([['hidden','=',1],['id_cata_1','=',3]])
            ->inRandomOrder()
            ->limit(2)
            ->get();
        for ($i = 0; $i < 2; $i++) {
            $asd = $casepcs[$i]['detail'];
            $qwe = json_decode(stripslashes($asd));
            $casepcs[$i]['html'] = (is_array($qwe)) ? htmlspecialchars_decode($qwe[0]) : '';
        }
        return $casepcs;
    }

    public static function get_sp($cat1=null, $cat2=null,$ref,$ord) {
        $query = \App\Models\Product::query();

        if ($cat1 && !$cat2) $query->where('id_cata_1', $cat1);
        else if (!$cat1 && $cat2) $query->where('id_cata_2', $cat2);

        if ($ord == 1) $query->orderBy($ref, 'ASC');
        else if ($ord == 2) $query->orderBy($ref, 'DESC');
        else if ($ord == 3) $query->inRandomOrder();

        return $query->limit(20)->get();
    }
}
