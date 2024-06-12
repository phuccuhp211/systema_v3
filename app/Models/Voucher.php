<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;
    protected $table = 'Vouchers';
    protected $primaryKey = 'id';
    protected $fillable = [ 'name', 'amount', 'remaining', 'f_date', 't_date', 'type', 'discount' ];
    public $timestamps = false;

    public static function get_cp($name)
    {
        return self::where('name',$name)->first();
    }

    public static function devine($name)
    {
        self::where('name', $name)->decrement('remaining', 1);
    }
}
