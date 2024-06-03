<?php

namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class pay_controller extends Controller
{
    function vli(Request $rq) {
        $name = $rq->input('name');
        $email = $rq->input('email');
        $number = $rq->input('number');
        $address = $rq->input('address');
        $notice = $rq->input('notice');
    }
    function dcp(Request $rq) {
        
    }
    function ord(Request $rq) {
        
    }
}
