<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\Us;

class sisu_controller extends Controller {
    function client_login(Request $rq) {
        $user = $rq->input('user');
        $pass = $rq->input('pass');

        if ($user == '') return response()->json(['err' => 'Vui lòng nhập tài khoản !']);
        else if ($pass == '') return response()->json(['err' => 'Vui lòng nhập mật khẩu !']);
        else {
            $find = Us::get_us($user);
            if ($find) {
                if ($find['lock'] == 1) return response()->json(['err' => 'Tài Khoản bị khóa !']);
                else {
                    if (Hash::check($pass, $find['pass'])) {
                        session(['user_log' => $user]);
                        return true;
                    }
                    else return response()->json(['err' => 'Sai mật khẩu']);
                }
            }
            else return response()->json(['err' => 'Sai tên tài khoản !']);
        }
    }

    function client_logout() {
        session()->forget('user_log');
        return redirect()->route('index');
    }

    function client_regis(Request $rq) {
        
    }
}
