<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $table = 'Products';
    protected $primaryKey = 'id';
    protected $fillable = [ 'name', 'img', 'info', 'detail', 'id_cata_1', 'id_cata_2', 'id_brand', 'price', 'sale', 'f_date', 't_date' ];
    public $timestamps = false;

    protected $attributes = [
        'img' => 'unko.jpg',
        'sale' => 0,
    ];

    public static function get_st() {
        return self::where('hidden',0)->limit(10)->get();
    }

    public static function get_sp($cat1=null, $cat2=null,$ref,$ord) {
        $query = self::query();

        if ($cat1 && !$cat2) $query->where([['hidden',0],['id_cata_1',$cat1]]);
        else if (!$cat1 && $cat2) $query->where([['hidden',0],['id_cata_2',$cat2]]);

        if ($ord == 1) $query->orderBy($ref, 'ASC');
        else if ($ord == 2) $query->orderBy($ref, 'DESC');
        else if ($ord == 3) $query->inRandomOrder();

        return $query->limit(20)->get();
    }

    public static function get_dt($data) {
        $prod = self::where('id',$data)->first();
        if ($prod['id_cata_1'] == 3) {
            $asd = $prod['detail'];
            $qwe = json_decode(stripslashes($asd));
            $prod['html'] = (is_array($qwe)) ? htmlspecialchars_decode($qwe[1]) : '';
        }
        else {
            $prod['html'] = htmlspecialchars_decode($prod['detail']);
        }
        return $prod;
    }

    public static function get_sc($id) {
        return self::select('id','name','img','price','sale','f_date','t_date')->where('id',$id)->first();
    }

    public static function get_rl($data) {
        $dt = self::where('id',$data)->first();
        return self::where([
                    ['id','!=',$data],
                    ['hidden',0],
                    ['id_cata_2',$dt['id_cata_2']]
                ])
            ->inRandomOrder()
            ->limit(5)
            ->get();
    }

    public static function get_ao($type=null,$data=null,$page,$ord,$filter,$limit) {
        $query = self::query();
        $where = '';

        if ($type == 'all') $query->where('hidden',0);
        else if ($type == 'cat1') $query->where([['id_cata_1',$data],['hidden',0]]);
        else if ($type == 'cat2') $query->where([['id_cata_2',$data],['hidden',0]]);
        else if ($type == 'search') $query->where([['name','like',"%$data%"],['hidden','=',0]]);

        if ($filter) {
            if ($filter['brand'] != '') $query->where('id_brand', $filter['brand']);
            if ($filter['to'] != '') $query->where('price', '<=', $filter['to']);
            if ($filter['from'] != '') $query->where('price', '>=', $filter['from']);
        }
            
        if ($ord) {
            if ($ord == 1) $query->orderBy('id', 'ASC');
            else if ($ord == 2) $query->orderBy('id', 'DESC');
            else if ($ord == 3) $query->orderBy('price','ASC');
            else if ($ord == 4) $query->orderBy('price','DESC');
        }
            

        return $query->offset(($page*$limit)-$limit)->limit($limit)->get();
    }

    public static function pagin($type=null,$data=null,$filter) {
        $query = self::query();
        
        if ($type == 'all') $query->where('hidden',0);
        else if ($type == 'cat1') $query->where([['id_cata_1',$data],['hidden',0]]);
        else if ($type == 'cat2') $query->where([['id_cata_2',$data],['hidden',0]]);
        else if ($type == 'search') $query->where([['name','like',"%$data%"],['hidden',0]]);
        else $query->get();

        if ($filter) {
            if ($filter['brand'] != '') $query->where('id_brand', $filter['brand']);
            if ($filter['to'] != '') $query->where('price', '<=', $filter['to']);
            if ($filter['from'] != '') $query->where('price', '>=', $filter['from']);
        }
        return ceil($query->count() / 16);
    }

    public static function grap() {
        $result = DB::table('catalog_1 as dm')
                ->leftJoin('products as pd', 'dm.id', '=', 'pd.id_cata_1')
                ->select('dm.name', DB::raw('COUNT(pd.id) as num'))
                ->groupBy('dm.name')
                ->get();
        return $result;
    }
}
