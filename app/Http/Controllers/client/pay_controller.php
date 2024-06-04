<?php

namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class pay_controller extends Controller
{
    function vli(Request $rq) {
        $dtip = [
            'name' => $rq->input('name'),
            'email' => $rq->input('email'),
            'number' => $rq->input('number'),
            'address' => $rq->input('address'),
            'notice' => $rq->input('notice')
        ];

        $msg = [
            'name.required' => 'Tên là bắt buộc.',
            'name.min' => 'Tên yêu cầu ít nhất :min ký tự.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không đúng định dạng.',
            'email.regex' => 'Email không đúng định dạng.',
            'number.required' => 'Số điện thoại là bắt buộc.',
            'number.min' => 'Số điện thoại yêu cầu ít nhất :min ký tự.',
            'number.max' => 'Số điện thoại không thể dài quá :max ký tự.',
            'address.required' => 'Địa chỉ là bắt buộc.',
            'address.min' => 'Địa chỉ yêu cầu ít nhất :min ký tự.'
        ];

        $rule = [ 
            'name' => 'required|min:3',
            'email' => 'required|email|regex:/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/',
            'number' => 'required|min:8|max:10',
            'address' => 'required|min:6'
        ];

        $check = Validator::make($dtip, $rule, $msg);
        if ($check->fails()) return response()->json(['status' => false, 'res' => $check->errors()]);
        else return response()->json(['status' => true, 'res' => '']);
    }
    function dcp(Request $rq) {
        
    }
    function ord(Request $rq) {
        
    }
}
