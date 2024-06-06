<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;
    protected $table = 'Vouchers';

    public static function get_cp($name)
    {
        return self::where('name',$name)->first();
    }
}
