<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Models\Us;

class sisu_controller extends Controller {
    function __construct() {
        if (!session()->has('user_log')) return redirect()->route('home');
    }

    function client_lls(Request $rq, $type) {
        if ($type == 'login') {
            if ($rq->ajax()) {
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
            else return redirect()->route('home');
        }
        else if ($type == 'logout') {
            if (session()->has('user_log')) session()->forget('user_log');
            return redirect()->route('home');
        }
        else if ($type == 'regis') {
            if ($rq->ajax()) {
                $user = $rq->input('user');
                $addr = $rq->input('addr');
                $pass1 = $rq->input('pass1');
                $pass2 = $rq->input('pass2');
                $lname = $rq->input('lname');
                $fname = $rq->input('fname');
                $email = $rq->input('email');
                $phone = $rq->input('phone');

                if ($user==''||$addr==''||$pass1==''||$pass2==''||$lname==''||$fname==''||$phone==''|| $email=='') {
                    return response()->json(['err' => 'Vui lòng nhập đầy đủ thông tin !']);
                }
                else {
                    $find = Us::get_us($user);
                    if ($find) return response()->json(['err' => 'Tên tài khoản đã được sử dụng !']);
                    else {
                        if ($pass1 != $pass2) return response()->json(['err' => 'Mật khẩu không khớp !']);
                        else if (strlen($pass1) < 7) return response()->json(['err' => 'Mật khẩu tối thiểu 8 kí tự !']);
                        else {
                            $rule = [ 'email' => 'required|email|regex:/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/' ];
                            $c_email = Validator::make(['email' => $email], $rule );
                            if ($c_email->fails()) return response()->json(['err' => 'Email không hợp lệ !']);
                            else if (strlen($phone) < 7 || strlen($phone) > 11) return response()->json(['err' => 'Số điện thoại không hợp lệ !']);
                            else {
                                Us::add($user,Hash::make($pass1),$lname,$fname,$email,$addr,$phone);
                                return true;
                            }
                        }
                    }
                }
            }
            else return redirect()->route('home');
        }
        else if ($type == 'config') {
            if ($rq->ajax()) {
                $id = $rq->input('id');
                $fn = $rq->input('fn');
                $ln = $rq->input('ln');
                $pn = $rq->input('pn');
                $em = $rq->input('em');
                $ad = $rq->input('ad');

                $rs = [ 'status' => false ];
                $rule = [ 'email' => 'required|email|regex:/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/' ];
                $c_email = Validator::make(['email' => $em], $rule );

                if ($ln==''||$fn==''||$pn==''||$em==''||$ad=='') $rs['res'] = 'Vui lòng điền đẩy đủ thông tin !';
                else if($c_email->fails()) $rs['res'] = 'Email không hợp lệ !';
                else if(strlen($pn) < 7  || strlen($pn) > 11) $rs['res'] = 'Số điện thoại không hợp lệ !';
                else {
                    Us::fix($id,'','',$ln,$fn,$em,$ad,$pn);

                    $rs['status'] = true;
                    $rs['res'] = 'Cập nhật thông tin thành công ! <br> Trang web sẽ tự động tải lại sau 3 giây';   
                }
                return response()->json($rs);
            }
            else return redirect()->route('home');
        }
        else if ($type == 'checkp') {
            if ($rq->ajax()) {
                $rs = [ 'status' => false ];
                $pw = $rq->input('oldpw');
                
                if ($pw == '') $rs['res'] = 'Vui lòng nhập mật khẩu';
                else {
                    $user = Us::get_us(session('user_log'));
                    if (Hash::check($pw, $user->pass)) {
                        $rs['status'] = true;
                        $rs['res'] = 'Mật khẩu đúng';
                        return response()->json($rs);
                    }
                    else $rs['res'] = 'Sai mật khẩu';
                }
                return response()->json($rs);
            }
            else return redirect()->route('home');
        }
        else if ($type == 'fixpw') {
            if ($rq->ajax()) {
                $rs = [ 'status' => false ];
                $pw1 = $rq->input('newp1');
                $pw2 = $rq->input('newp2');
                
                if ($pw1 == '' || $pw2 == '') $rs['res'] = 'Vui lòng nhập mật khẩu';
                else if ($pw1 != $pw2) $rs['res'] = 'Mật khẩu không khớp';
                else if (strlen($pw1) < 7) $rs['res'] = 'Mật khẩu tối thiểu 8 kí tự';
                else {
                    $rs['status'] = true;
                    $rs['res'] = "Đổi mật khẩu thành công <br> trang web sẽ tự động tải lại sau 3 giây";
                    $user = Us::get_us(session('user_log'));
                    Us::fix($user['id'],$user['account'],Hash::make($pw1));
                }
                return response()->json($rs);
            }
            else return redirect()->route('home');
        }
    }
}
