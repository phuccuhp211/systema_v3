<?php

namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Models\Invoice;
use App\Mail\invoice as m_invoice;
use DateTime;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Mail;

class pay_controller extends Controller
{
    function validation(Request $rq) {
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

    function applycoupon(Request $rq) {
        $data = $rq->input('coupon');
        $response['status'] = false;
        $now = new DateTime;

        $coupon = Voucher::get_cp($data);

        if (!$coupon) $response['res'] = 'Mã không tồn tại!';
        else {
            $f_date = new DateTime($coupon->f_date);
            $t_date = new DateTime($coupon->t_date);

            if ($now < $f_date) $response['res'] = 'Mã không khả dụng vào lúc này!';
            else if ($now > $t_date) $response['res'] = 'Mã đã hết hạn sử dụng!';
            else if ($coupon->remaining == 0) $response['res'] = 'Mã đã hết lượt sử dụng!';
            else if (!session()->has('user_log')) $response['res'] = 'Vui lòng đăng nhập hoặc đăng ký để sử dụng khuyến mãi!';
            else {
                $response['status'] = true;
                $response['type'] = $coupon->type;
                $response['disc'] = $coupon->discount;
            }
        }
        return response()->json($response);
    }

    function order(Request $rq) {
        $name = ($rq->ajax()) ? $rq->input('name') : session('user-temp')['name'];
        $mail = ($rq->ajax()) ? $rq->input('mail') : session('user-temp')['mail'];
        $addr = ($rq->ajax()) ? $rq->input('addr') : session('user-temp')['addr'];
        $number = ($rq->ajax()) ? $rq->input('number') : session('user-temp')['number'];
        $notice = ($rq->ajax()) ? $rq->input('notice') : session('user-temp')['notice'];
        $mxn = ($rq->ajax()) ? $rq->input('mxn') : session('user-temp')['mxn'];
        $date = ($rq->ajax()) ? $rq->input('date') : session('user-temp')['date'];
        $pmmt = ($rq->ajax()) ? $rq->input('pmmt') : session('user-temp')['pmmt'];
        $sfee = ($rq->ajax()) ? $rq->input('ship') : session('user-temp')['ship'];

        $ntotal = ($rq->ajax()) ? (($rq->input('newtt')) ?? 0) : ((session('user-temp')['newtt']) ?? 0);
        $coupon = ($rq->ajax()) ? (($rq->input('magg')) ?? '') : ((session('user-temp')['magg']) ?? '');
        $p_stt = ($pmmt != 'COD') ? 1 : 0;

        $list = json_encode(session('cart')['list']);
        $total = ($rq->input('magg')) ? session('cart')['total'] : session('cart')['total']+$sfee;

        if ($coupon != '') Voucher::devine($coupon); 
        Invoice::save_inv($name,$mail,$addr,$number,$notice,$mxn,$date,$list,$total,$pmmt,$sfee,$ntotal,$coupon,$p_stt);
        Mail::mailer('smtp')->to($mail)->send( new m_invoice($name,$mail,$addr,$number,$notice,$mxn,$date,$pmmt,$sfee,$total,$ntotal,$coupon) );

        session()->forget('cart');
        if(session()->has('user_log')) User::upcart(session('user_log'));
        if(session()->has('user-temp')) session()->forget('user-temp');
        if ($rq->ajax()) return route('dord');
    }

    function store(Request $rq) {
        $data = $rq->all();
        unset($data['randomParam']);
        session(['user-temp'=> $data]);
        return true;
    }
}
