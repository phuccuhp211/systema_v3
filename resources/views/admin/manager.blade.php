<!DOCTYPE html>
<html lang="en">
<head>
	@include('layouts.lib')
	<title>Trang Quản Trị</title>
	<link rel="stylesheet" href="{{ asset('css/admin.css')}}">
	<script style="text/javascript" src="{{ asset('jquery/admin.js') }}"></script>
	<script style="text/javascript" src="{{ asset('lib/js/tinymce/tinymce.min.js') }}" referrerpolicy="origin">
	</script>
	<script style="text/javascript" src="{{ asset('lib/js/plotly.min.js') }}" referrerpolicy="origin"></script>
</head>
<body style="padding: 0 !important;">
	<div class="menu">
		<a class="text-start btn w-100 btn-info" href="{{ route('manager') }}">Trang Chủ</a>
		<hr>
		<a class="text-start btn w-100 btn-success" href="{{ route('manager', ['type' => 'sections']) }}">Sections Home</a>
		<a class="text-start btn w-100 btn-success" href="{{ route('manager', ['type' => 'slidebns']) }}">Slide Banner</a>
		<hr>
		<a class="text-start btn w-100 btn-secondary text-white" href="{{ route('manager', ['type' => 'products']) }}">Quản Lý Sản Phẩm</a>
		<a class="text-start btn w-100 btn-secondary text-white" href="{{ route('manager', ['type' => 'catalogs']) }}">Quản Lý Danh Mục</a>
		<a class="text-start btn w-100 btn-secondary text-white" href="{{ route('manager', ['type' => 'usersmng']) }}">Quản Lý User</a>
		<a class="text-start btn w-100 btn-secondary text-white" href="{{ route('manager', ['type' => 'comments']) }}">Quản Lý Bình Luận</a>
		<hr>
		<a class="text-start btn w-100 btn-dark text-white" href="{{ route('manager', ['type' => 'invoices']) }}">Hóa Đơn Đặt Hàng</a>
		<a class="text-start btn w-100 btn-dark text-white" href="{{ route('manager', ['type' => 'offers']) }}">Mã Giảm Giá</a>
		<hr>
		<a class="text-start btn w-100 btn-danger text-white my-0" href="{{ route('admin',['type' => 'logout']) }}">Đăng Xuất</a>
	</div>

	<div class="container">
		<div class="row">
			@include('admin.stat1')
			@include('admin.stat2')

			@if ($mng != 'home')
			<div class="box-table">
				@include('admin.filter')
				@include('admin.table1')
				@include('admin.table2')
			</div>
			@endif
			
		</div>
	</div>
	@include('admin.apopup')
</body>
</html>