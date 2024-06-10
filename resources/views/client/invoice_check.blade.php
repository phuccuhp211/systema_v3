@extends('layouts.base')

@section('title', 'Tra Cứu Hóa Đơn')

@section('ownlib')
    <link rel="stylesheet" href="{{ asset('css/invc.css') }}">
    <script type="text/javascript" src="{{ asset('jquery/invc.js') }}"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row" id="baohanh">
            <div class="col-6 offset-3">
                <div class="khung f1 baohanh">
                    <h3>Tra Cứu Hóa Đơn</h3>
                    <label for="tendn">Mã số hóa đơn :</label>
                    <input type="number" name="mahd" id="mahd">
                    <p>Vui lòng nhập mã hóa đơn mua hàng của quý khách (gồm ít nhất 12 số), mã được đính kèm trong Hóa Đơn Điện Tử, hoặc xem trong lịch sử mua hàng của Quý Khách</p>
                    <button class="btn btn-success check-bh">Kiểm Tra</button>
                </div>
            </div>
        </div>
    </div>
@endsection