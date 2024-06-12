<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'Invoices';
    protected $primaryKey = 'id';
    protected $fillable = ['name','number','email','address','list','price','created','submited','in_num','shipfee','coupon','offers','method'];
    public $timestamps = false;

    public static function get_list($number) {
        return self::where('number',$number)->orderBy('id','DESC')->get();
    }

    public static function get_inv($number) {
        return self::where('in_num',$number)->first();
    }

    public static function save_inv($name,$mail,$addr,$number,$notice,$mxn,$date,$list,$total,$pmmt,$sfee,$ntotal=null,$coupon=null) {
        $create = [
            'name' => $name,
            'number' => $number,
            'email' => $mail,
            'address' => $addr,
            'list' => $list,
            'price' => $total,
            'created' => $date,
            'in_num' => $mxn,
            'shipfee' => $sfee,
            'method' => $pmmt
        ];

        if ($ntotal != null) $create['offers'] = $ntotal;
        if ($coupon != null) $create['coupon'] = $coupon;

        self::create($create);
    }

    public static function ttrev() {
        $result = self::
                select(
                    DB::raw('SUM(CASE WHEN offers != 0 THEN offers ELSE price END) as expect'),
                    DB::raw('SUM(CASE WHEN status = "Hoàn Thành" THEN (CASE WHEN offers != 0 THEN offers ELSE price END) ELSE 0 END) as revenue')
                )
                ->first();

        return [
            'expect' => $result->expect,
            'total' => $result->revenue,
        ];
    }

    public static function ttord() {
        $sum = self::count();
        $done = self::where('status', 'Hoàn Thành')->count();

        return [
            'sum' => $sum,
            'done' => $done,
        ];
    }

    public static function a_ajax($fil) {
        if ($fil == 1) return self::orderBy('id','DESC')->get();
        else if ($fil == 2) return self::where('status', 'Đanh chờ xác nhận')->orderBy('id', 'desc')->get();
        else if ($fil == 3) return self::where('status', 'Chuẩn Bị')->orderBy('id','DESC')->get();
        else if ($fil == 4) return self::where('status', 'Đang Giao')->orderBy('id','DESC')->get();
        else if ($fil == 5) return self::where('status', 'Hoàn Thành')->orderBy('id','DESC')->get();
        else if ($fil == 6) return self::where('status', 'Đã Hủy')->orderBy('id','DESC')->get();
    }

    public static function up_stt($id,$stt) {
        $date = now()->format('Y-m-d');
        $hoadon = self::find($id);
        if ($hoadon->submited == "0000-00-00") {
            $hoadon->where('id', $id)->update([ 'status' => $stt, 'submited' => $date ]);
        } 
        else $hoadon->where('id', $id)->update(['status' => $stt]);
    }
}
