<!DOCTYPE html>
<html lang="en">
<head>
	@include('layouts.lib')
	<title>Đăng Nhập Quản Trị</title>
	<link rel="stylesheet" href="{{ asset('css/admin.css')}}">
	<script style="text/javascript" src="{{ asset('jquery/admin.js')}}"></script>
	<script style="text/javascript" src="{{ asset('lib/js/tinymce/tinymce.min.js')}}" referrerpolicy="origin"></script>
</head>
<body style="padding: 0 !important;">
	<div class="bg-admin-log">
		<div class="errlog">
		@if(session('msg'))
			{{ session('msg') }}
		@endif
		</div>
		<form action="{{ route('admin', ['type' => 'login']) }}" method="POST" enctype="multipart/form-data" class="log-f">
			<h2 class="text-center">Đăng Nhập</h2>
			<div style="margin: 15px 0;">
				<label>Tài khoản :</label>
				<input type="text" name="user" class="input-f">
			</div>
			<div style="margin: 15px 0;">
				<label>Mật Khẩu :</label>
				<input type="password" name="pass" class="input-f">
			</div>
			<button type="submit">Đăng Nhập</button>
		</form>
	</div>
</body>
</html>