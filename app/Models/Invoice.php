<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'Invoices';
    protected $primaryKey = 'id';
    protected $fillable = ['name','number','email','address','list','price','created','submited','in_num','coupon','offers','method'];
    public $timestamps = false;

    public static function get_list($name) {
        return self::where('name',$name)->orderBy('id','DESC')->get();
    }

    public static function save_inv($name,$mail,$addr,$number,$notice,$mxn,$date,$list,$total,$pmmt,$ntotal=null,$coupon=null) {
        $create = [
            'name' => $name,
            'number' => $number,
            'email' => $mail,
            'address' => $addr,
            'list' => $list,
            'price' => $total,
            'created' => $date,
            'in_num' => $mxn,
            'method' => $pmmt
        ];

        if ($ntotal != null) $create['offers'] = $ntotal;
        if ($coupon != null) $create['coupon'] = $coupon;

        self::create($create);
    }
}
