<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Us extends Model
{
    use HasFactory;

    protected $table = 'Uss';
    protected $primaryKey = 'id';
    protected $fillable = [ 'account', 'pass', 'l_name', 'f_name', 'email', 'address', 'number', 'img', 'role', 'lock' ];
    public $timestamps = false;

    public static function get_us($name) {
        return self::where('account', $name)->first();
    }

    public static function add($user,$pass,$lname,$fname,$email,$addr,$phone,$role=0,$lock=0) {
        self::create([
            'account' => $user,
            'pass' => $pass,
            'l_name' => $lname,
            'f_name' => $fname,
            'email' => $email,
            'address' => $addr,
            'number' => $phone,
            'role' => $role,
            'lock' => $lock
        ]);
    }
    public static function fix($id,$user,$pass,$lname,$fname,$email,$addr,$phone,$role=0,$lock=0) {
        self::where('id',$id)->update([
            'account' => $user,
            'pass' => $pass,
            'l_name' => $lname,
            'f_name' => $fname,
            'email' => $email,
            'address' => $addr,
            'number' => $phone,
            'role' => $role,
            'lock' => $lock
        ]);
    }
    public static function del($id) {
        self::destroy($id);
    }
}
