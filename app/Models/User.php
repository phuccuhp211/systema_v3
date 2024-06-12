<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'Users';
    protected $primaryKey = 'id';
    protected $fillable = [ 'account', 'pass', 'l_name', 'f_name', 'email', 'address', 'number', 'img', 'cart', 'role', 'lock' ];
    public $timestamps = true;

    public static function get_us($name) {
        return self::where([['account', $name],['role', 0]])->first();
    }

    public static function get_ad($name) {
        return self::where([['account', $name],['role', 1]])->first();
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

    public static function newpw($mail,$pass) {
        self::where('email',$mail)->update(['pass' => $pass]);
    }

    public static function upcart($name) {
        self::where('account',$name)->update(['cart' => json_encode(session('cart'))]);
    }

    public static function count() {
        $sut = self::where('role', 0)->count();
        $suf = DB::table('invoices')->select('number')
                ->whereNotIn('number', function($query) {$query->select('number')->from('users');})
                ->groupBy('number')
                ->get()
                ->count();

        return [
            'sut' => $sut,
            'suf' => $suf,
        ];
    }

    public static function a_ajax($fil) {
        if ($fil == 1) return self::orderBy('id','DESC')->get();
        else if ($fil == 2) return self::where('lock',1)->orderBy('id','DESC')->get();
        else if ($fil == 3) return self::where('lock',0)->orderBy('id','DESC')->get();
        else if ($fil == 4) return self::where('role',0)->orderBy('id','DESC')->get();
        else if ($fil == 5) return self::where('role',1)->orderBy('id','DESC')->get();
    }
}
