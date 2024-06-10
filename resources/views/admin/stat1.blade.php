@if ($mng == 'home')
<div class="col-6" style="margin: 10vh 0 0">
	<div class="ql-box">
		<h3 class="text-center">Tổng thu nhập</h3>
		<div class="box-icon">
			<i class="fa-solid fa-cash-register" style="background: #9933CC;"></i>
		</div>
		<div class="ql-mess">
			<h3 style="color: #ff6363; text-align: center;">{{ gennum($revenue['total']) }} VNĐ</h3>
			<h5 style="color: white; text-align: center;">Từ các hóa đơn đã được thanh toán</h5><hr>
			<p>Thu nhập dự tính nếu hoàn tất mọi HD : <span style="color:#ff6363;">{{ gennum($revenue['expect']) }} VNĐ</span></p>
			<p>Giá trị của các hóa đơn chưa thanh toán : <span style="color:#ff6363;">{{ gennum($revenue['expect'] - $revenue['total']) }} VNĐ</span></p>
		</div>
	</div>
</div>
<div class="col-6" style="margin: 10vh 0 0">
	<div class="ql-box">
		<h3 class="text-center">Lượng đơn hàng</h3>
		<div class="box-icon">
			<i class="fa-solid fa-file-invoice" style="background: #0d47a1;"></i>
		</div>
		<div class="ql-mess">
			<h3 style="color: #ff6363; text-align: center;">{{ $orders['sum'] }}</h3>
			<h5 style="color: white; text-align: center;">Tổng số các hóa đơn hiện có</h5><hr>
			<p>Đã hoàn thành : {{ $orders['done'] }}</p>
			<p>Chưa hoàn thành : {{ $orders['sum'] -$orders['done'] }}</p>
		</div>
	</div>
</div>
<div class="col-6">
	<div class="ql-box">
		<h3 class="text-center">Tổng số khách hàng</h3>
		<div class="box-icon">
			<i class="fa-regular fa-user" style="background: #00695c;"></i>
		</div>
		<div class="ql-mess">
			<h3 style="color: #ff6363; text-align: center;">{{ $members['sut'] }}</h3>
			<h5 style="color: white; text-align: center;">Tổng số khách hàng đã đăng ký</h5><hr>
			<p>Đã đăng ký : {{ $members['sut'] }}</p>
			<p>Chưa đăng ký : {{ $members['suf'] }}</p>
		</div>
	</div>
</div>
<div class="col-6">
	<div class="ql-box">
		<h3 class="text-center">Lưu lượng truy cập</h3>
		<div class="box-icon">
			<i class="fa-solid fa-globe" style="background: #0099cc;"></i>
		</div>
		<div class="ql-mess">
			<h3 style="color: #ff6363; text-align: center;">{{ gennum($accesses['homet'] + $accesses['homef']) }}</h3>
			<h5 style="color: white; text-align: center;">Lượt truy cập Web</h5><hr>
			<p>Trang chủ : {{ $accesses['homet'] }}</p>
			<p>Trang con : {{ $accesses['homef'] }}</p>
		</div>
	</div>
</div>
@endif