@extends('layouts.base')

@section('title', 'Thanh Toán')

@section('ownlib')
    <link rel="stylesheet" href="{{ asset('css/payment.css') }}">
    <script type="text/javascript" src="{{ asset('jquery/payment.js') }}"></script>
@endsection

@section('content')
    <div class="thongbao-thanhtoan hide-tbtt">
        <div class="box-noidung">
            <h2>...Đang Xử Lý...</h2>
        </div>
    </div>

    <div class="container">
        <h2 class="ttgh-top">thông tin giỏ hàng</h2>          
        <div class="row">
            <!-- bentrai -->
            <div class="col-4">
                <div class="col-12 khungto-khttdh">
                    <div class="td-khttdh">thông tin khách hàng</div>
                    <div class="khung-khttdh">
                        @if (session()->has('user_log'))
                        <form action="" id="thongtin-kh">
                            <div class="khungchu">
                                <p>Họ tên :</p><input type="text" id="tenkh" name="tenkh" value="{{ $header['user']['name'] }}">
                            </div>
                            <div class="khungchu">
                                <p>Email :</p><input type="text" id="emailkh" name="emailkh" value="{{ $header['user']['email'] }}">
                            </div>
                            <div class="khungchu">
                                <p>SĐT :</p><input type="text" id="sdtkh" name="sdtkh" value="{{ $header['user']['number'] }}">
                            </div>
                            <div class="khungchu">
                                <p>Địa Chỉ :</p><input type="text" id="dckh" name="dckh" value="{{ $header['user']['address'] }}">
                            </div>
                            <div class="khungchu">
                                <p>Ghi chú :</p><textarea id="memokh" name="memokh"></textarea>
                            </div>  
                        </form>
                        @else
                        <form action="" id="thongtin-kh">
                            <div class="khungchu">
                                <p>Họ tên :</p><input type="text" id="tenkh" name="tenkh">
                            </div>
                            <div class="khungchu">
                                <p>Email :</p><input type="text" id="emailkh" name="emailkh">
                            </div>
                            <div class="khungchu">
                                <p>SĐT :</p><input type="text" id="sdtkh" name="sdtkh">
                            </div>
                            <div class="khungchu">
                                <p>Địa Chỉ :</p><input type="text" id="dckh" name="dckh">
                            </div>
                            <div class="khungchu">
                                <p>Ghi chú :</p><textarea id="memokh" name="memokh"></textarea>
                            </div>  
                        </form>
                        @endif
                    </div>
                </div>
                <div class="col-12 khungto-khttdh">
                    <div class="td-khttdh">hình thức thanh toán</div>
                    <div class="khung-khttdh">
                        <input class="giatien" data-val="true" id="amount" name="amount" type="number" hidden/>
                        <input type="radio" id="language" Checked="True" name="language" value="vn" hidden>
                        <p><input type="radio" id="bankCode" name="bankCode" value="INTCARD" class="nut-cb-giohang"> Thanh toán qua thẻ quốc tế.</p>
                        <p><input type="radio" id="bankCode" name="bankCode" value="VNBANK" class="nut-cb-giohang"> Thanh toán qua thẻ ATM/Tài khoản nội địa.</p>
                        <p><input type="radio" id="bankCode" name="bankCode" class="nut-cb-giohang" value="COD" checked>Thanh toán khi nhận hàng(COD).</p>
                        <p>+ Miễn phí giao hành trong phạm vi 10 Km (chỉ áp dụng với đơn hàng trên 1.000.000 đ).</p>
                    </div>     
                </div>
            </div>
            <!-- benphai -->
            <div class="col-8">
                <div class="td-khttdh td-giohang">giỏ hàng</div>
                <div class="giohang">
                    @foreach (session('cart')['list'] as $value => $item)
                    <div class="sp-giohang">
                        <div class="col-2 anh-giohang">
                            <img src="{{ genurl($item['img']) }}" class="hinhsp-giohang" alt="">
                        </div>
                        <div class="col-7 chu-giohang">
                            <p class="p-tt-giohang tensp-nho">{{ $item['name'] }}</p>
                            <p class="p-tt-giohang masp">{{ $item['info'] }}</p>
                        </div>
                        <div class="col-3 gia-giohang">
                            <p class="p-sl-giohang">Số lượng: {{ $item['num'] }}</p>
                            <p class="p-gia-giohanh">{{ gennum($item['sum']) }}</p>
                        </div>
                    </div><hr class="hr">
                    @endforeach
                    
                    <div class="box-mgg">
                        <p>Sử dụng mã giảm giá :</p>
                        <form id="apply-mgg">
                            <input type="text" id="magiamgia">
                            <button type="submit" class="btn btn-success">Áp Dụng</button>
                        </form>
                    </div><hr>
                    <div class="row thanhtoanh">
                        <div class="col-12 d-flex flex-column">
                            <div class="my-1 d-block w-100">
                                <p class="p-thanhtoan">tạm tính:</p>
                                <p class="p-gia" id="giagoc">
                                    {{ gennum(session('cart')['total']) }}
                                </p>
                            </div>
                            <div class="my-1 d-block w-100 giamgia hide-gg">
                                <p class="p-thanhtoan" id="stt-gg" trangtrai="">ưu đãi:</p>
                                <p class="p-gia tongcong"></p>
                            </div>
                            <div class="my-1 d-block w-100">
                                <p class="p-thanhtoan">phí vận chuyển :</p>
                                <p class="p-gia phiship"></p>
                            </div>
                            <div class="my-1 d-block w-100 div-tongcong">
                                <p class="p-thanhtoan">tổng cộng :</p>
                                <p class="p-gia tongcong" id="tongtien"></p>
                            </div>
                            <div>
                                <button class="btn nutsp thanhtoansp" id="thanhtoansp">Hoàn Tất Thanh Toán</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection