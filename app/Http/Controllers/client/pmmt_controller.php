<?php

namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Client\user_controller;
use App\Http\Controllers\Client\pay_controller;
use Illuminate\Http\Request;

class pmmt_controller extends Controller {
    protected $vnp_TmnCode;
    protected $vnp_HashSecret;

    function __construct() {
        $this->vnp_TmnCode = "8NGMGKIN";
        $this->vnp_HashSecret = "USXUFCDMVGRSFYCCCQVFBJOMDAVVOZON";
    }

    function vnpay_payment(Request $rq) {
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('vnpay.result');
        
        $vnp_TxnRef = mt_rand(100000,999999);
        $vnp_OrderInfo = 'Thanh Toán Mua Hàng';
        $vnp_OrderType = 'Systema';
        $vnp_Amount = $rq->input('amount') * 100;
        $vnp_Locale = 'VN';
        $vnp_BankCode = $rq->input('bankCode');
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $this->vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
        );
        
        if (isset($vnp_BankCode) && $vnp_BankCode != "") $inputData['vnp_BankCode'] = $vnp_BankCode;
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        
        $vnp_Url = $vnp_Url . "?" . $query;
        $vnpSecureHash =   hash_hmac('sha512', $hashdata, $this->vnp_HashSecret);
        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
      
        $returnData = array('code' => '00' , 'message' => 'success' , 'data' => $vnp_Url);

        header('Location: ' . $vnp_Url);
        die();
    }

    function vnpay_result(Request $rq) {
        $u_ctrl = new user_controller; 
        $datarp = $u_ctrl->get_base();
        $datarp['vnp_SecureHash'] = $_GET['vnp_SecureHash'];
        $datarp['inputData'] = [];
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $datarp['inputData'][$key] = $value;
            }
        }
        unset($datarp['inputData']['vnp_SecureHash']);
        ksort($datarp['inputData']);
        $i = 0;
        $hashData = "";
        foreach ($datarp['inputData'] as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }
        $datarp['secureHash'] = hash_hmac('sha512', $hashData, $this->vnp_HashSecret);

        if (session()->has('user-temp')) {
            if ($datarp['secureHash'] == $datarp['vnp_SecureHash']) {
                $pay_ctrl = new pay_controller;
                $pay_ctrl->order($rq);
            }
        }
        return view('payment.vnpay_result', $datarp);
    }
}
