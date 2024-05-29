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

    public static function fix($id,$user=null,$pass=null,$lname=null,$fname=null,$email=null,$addr=null,$phone=null,$role=null,$lock=null) {
        $dt_update = [ ];

        if ($user != null) $dt_update['account'] = $user;
        if ($pass != null) $dt_update['pass'] = $pass;
        if ($lname != null) $dt_update['l_name'] = $lname;
        if ($fname != null) $dt_update['f_name'] = $fname;
        if ($email != null) $dt_update['email'] = $email;
        if ($addr != null) $dt_update['address'] = $addr;
        if ($phone != null) $dt_update['number'] = $phone;
        if ($role != null) $dt_update['role'] = $role;
        if ($lock != null) $dt_update['lock'] = $lock;

        self::where('id', $id)->update($dt_update);
    }

    public static function del($id) {
        self::destroy($id);
    }
}
