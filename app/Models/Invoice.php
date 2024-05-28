<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'Invoices';
    protected $primaryKey = 'id';
    protected $fillable = ['name','number','email','address','list','price','created','submited','in_num','coupon'];

    public static function get_list($name) {
        return self::where('name',$name)->orderBy('id','DESC')->get();
    }
}
