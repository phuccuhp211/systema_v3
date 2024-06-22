<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Mail;
use App\Mail\resetpw;
use App\Models\User;
use App\Http\Controllers\Client\cart_controller;

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
                    $find = User::get_us($user);
                    if ($find) {
                        if ($find['lock'] == 1) return response()->json(['err' => 'Tài Khoản bị khóa !']);
                        else {
                            if (Hash::check($pass, $find['pass'])) {
                                session(['user_log' => $user]);
                                if (!is_null($find['cart'])) {
                                    $cart = json_decode($find['cart'], true);
                                    $cart_ctrl = new cart_controller();
                                    if (session()->has('cart')) $cart = $cart_ctrl->merge_cart($cart);
                                    else session(['cart' => $cart]);
                                } 
                                else User::upcart(session('user_log'));
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
                    $find = User::get_us($user);
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
                                User::add($user,Hash::make($pass1),$lname,$fname,$email,$addr,$phone);
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
                    User::fix($id,'','',$ln,$fn,$em,$ad,$pn);

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
                    $user = User::get_us(session('user_log'));
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
                    $user = User::get_us(session('user_log'));
                    User::fix($user['id'],$user['account'],Hash::make($pw1));
                }
                return response()->json($rs);
            }
            else return redirect()->route('home');
        }
        else if ($type == 'fgpass') {
            if ($rq->ajax()) {
                $data['status'] = false;
                $account = $rq->input('name');
                if ($account == '' || $account == null) $data['res'] = "Vui lòng nhập tên tài khoản";
                else {
                    $find = User::get_us($account);
                    if(!$find) $data['res'] = "Tên tài khoản không đúng";
                    else {
                        $data['status'] = true;
                        $code = mt_rand(100000,999999);
                        $data['res'] = "Đã gửi Mail, vui lòng kiểm tra";
                        session(['is_mail' => ['mail' => $find->email ,'code' => $code, 'timestamp' => time() ] ]);
                        Mail::mailer('smtp')->to($find->email)->send( new resetpw($find->id,$account,$code));
                    }
                }
                return response()->json($data);
            }
            else return redirect()->route('home');
        }
        else if ($type == 'checkc') {
            if ($rq->ajax()) {
                $data['status'] = false;
                $code = $rq->input('code');
                if (!session('is_mail')) $data['res'] = "Mã hết đã hết hạn";
                else {
                    if ($code == '' || $code == null) $data['res'] = "Vui lòng nhập mã";
                    else if (session('is_mail')['code'] != $code) $data['res'] = "Mã không đúng";
                    else {
                        $data['status'] = true;
                        $data['res'] = "Tiến hành nhập mật khẩu mới";
                    }
                }
                return response()->json($data);
            }
            else return redirect()->route('home');    
        }
        else if ($type == 'newpw') {
            if ($rq->ajax()) {
                $data['status'] = false;
                $pass1 = $rq->input('pass1');
                $pass2 = $rq->input('pass2');
                
                if ($pass1 == '' || $pass2 == '') $data['res'] = 'Vui lòng nhập mật khẩu';
                else if ($pass1 != $pass2) $data['res'] = 'Mật khẩu không khớp';
                else if (strlen($pass1) < 7) $data['res'] = 'Mật khẩu tối thiểu 8 kí tự';
                else {
                    $data['status'] = true;
                    $data['res'] = "Đổi mật khẩu thành công <br> bạn sẽ chuyển về trang chủ sau 3 giây";
                    User::newpw(session('is_mail')['mail'],Hash::make($pass2));
                }
                return response()->json($data);
            }
            else return redirect()->route('home');    
        }
    }

    function admin_lls(Request $rq, $type) {
        if ($type == 'login') {
            if ($rq->ajax()) {
                $user = $rq->input('user');
                $pass = $rq->input('pass');
                $data['status'] = false;

                if ($user == '') $data['res'] = 'Vui lòng nhập tên tài khoản!';
                else if ($pass == '') $data['res'] = 'Vui lòng nhập mật khẩu!';
                else {
                    $find = User::get_ad($user);
                    if ($find) {
                        if ($find['lock'] == 1) $data['res'] = 'Tài khoản bị khóa!';
                        else {
                            if (Hash::check($pass, $find['pass'])) {
                                $data['status'] = true;
                                $data['res'] = route('manager');
                                session(['admin_log' => $user]);
                            }
                            else $data['res'] = 'Mật khẩu không đúng!';
                        }
                    }
                    else $data['res'] = 'Tài khoản không tồn tại!';
                }
                return response()->json($data);
            }
            else return redirect()->route('alog');   
        }
        else if ($type == 'logout') {
            if (session()->has('admin_log')) session()->forget('admin_log');
            return redirect()->route('alog');
        }
    }
}
