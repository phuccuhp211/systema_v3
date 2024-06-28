<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ajax extends Model
{
    use HasFactory;

    public static function filter($db, $page, $fil, $rcs, $sch, $ord, $target)
    {
        $table = [
            'bn' => 'banners',
            'br' => 'brands',
            'c1' => 'catalog_1',
            'c2' => 'catalog_2',
            'cm' => 'comments',
            'in' => 'invoices',
            'pd' => 'products',
            'ss' => 'sections',
            'us' => 'users',
            'cp' => 'Vouchers'
        ];

        $rule = [
            'pd' => [
                1 => ['column' => 'id'],
                2 => ['column' => 'saled'],
                3 => ['column' => 'viewed'],
                4 => ['column' => 'id', 'condition' => ['sale' => '!= '.null]],
                5 => ['column' => 'id', 'condition' => ['hidden' => 1]]
            ],
            'us' => [
                1 => ['column' => 'id'],
                2 => ['column' => 'id', 'condition' => ['lock' => 1]],
                3 => ['column' => 'id', 'condition' => ['lock' => 0]],
                4 => ['column' => 'id', 'condition' => ['role' => 0]],
                5 => ['column' => 'id', 'condition' => ['role' => 1]]
            ],
            'in' => [
                1 => ['column' => 'id'],
                2 => ['column' => 'id', 'condition' => ['status' => 'Đang chờ xác nhận']],
                3 => ['column' => 'id', 'condition' => ['status' => 'Chuẩn Bị']],
                4 => ['column' => 'id', 'condition' => ['status' => 'Đang Giao']],
                5 => ['column' => 'id', 'condition' => ['status' => 'Hoàn Thành']],
                6 => ['column' => 'id', 'condition' => ['status' => 'Đã Hủy']]
            ]
        ];

        $query = DB::table($table[$db]);
        if ($sch) $query->where('name', 'like', "%$sch%");

        if (isset($rule[$db])) {
            if (isset($rule[$db][$fil]['condition'])) $query->where($rule[$db][$fil]['condition']);
            $query->orderBy($rule[$db][$fil]['column'], $ord);
        }
        else $query->orderBy('id', 'DESC');

        if ($target == 'list') {
            $query->offset(($page*$rcs)-$rcs)->limit($rcs);
            return $query->get();
        }
        else return ceil($query->count() / $rcs);
        
    }
}
