@extends('layouts.base')

@section('title', 'Kết Quả Thanh Toán')

@section('ownlib')
    <link rel="stylesheet" href="{{ asset('css/main.css')}}">
    <script type="text/javascript" src="{{ asset('jquery/main.js')}}"></script>
    <link rel="stylesheet" href="{{ asset('css/payment.css') }}">
    <script type="text/javascript" src="{{ asset('jquery/payment.js') }}"></script>
@endsection

@section('content')
    <div class="main-cont pmrs">
        <div class="dheader pmsv" pmsv="VNPAY">
            <h3 class="text-center m-0" style="color: #6246a8;">Cổng Thanh Toán Pay</h3>
        </div>
        <div class="dbody">
            <div class="form-group"><label >Mã đơn hàng: </label><label>{{ $inputData['vnp_TxnRef'] }}</label></div>
            <div class="form-group"><label >Số tiền: </label><label>{{ gennum($inputData['vnp_Amount']/100) }}</label></div>
            <div class="form-group"><label >Nội dung thanh toán: </label><label>{{ $inputData['vnp_OrderInfo'] }}</label></div>
            <div class="form-group"><label >Mã phản hồi (vnp_ResponseCode): </label><label>{{ $inputData['vnp_ResponseCode'] }}</label></div>
            <div class="form-group"><label >Mã GD Tại VNPAY: </label><label>{{ $inputData['vnp_TransactionNo'] }}</label></div>
            <div class="form-group"><label >Mã Ngân hàng: </label><label>{{ $inputData['vnp_BankCode'] }}</label></div>
            <div class="form-group"><label >Thời gian thanh toán: </label><label>{{ $inputData['vnp_PayDate'] }}</label></div>
            <div class="form-group"><label >Kết quả: </label>
                <label>
                    @if ($secureHash == $vnp_SecureHash)
                        @if ($inputData['vnp_ResponseCode'] == '00')
                        <span style='color:blue; font-weight:600;'>Giao Dịch Thành Công</span>
                        @else
                        <span style='color:red; font-weight:600;'>Giao Dịch Không Thành Công</span>
                        @endif
                    @else
                    <span style='color:red'>Chu ky khong hop le</span>
                    @endif
                </label>
            </div> 
        </div>
    </div>
    <a href="{{ route('home') }}" class="a-hoantat">Quay Về Tranh Chủ<a> 
@endsection