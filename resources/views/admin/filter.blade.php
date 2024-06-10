<div class="boloc">
	@if ($mng == 'products')
	<button class="btn-boloc" data="sanpham" boloc="1">Tất Cả</button>
	<button class="btn-boloc" data="sanpham" boloc="2">Sản Phẩm Bán Chạy</button>
	<button class="btn-boloc" data="sanpham" boloc="3">Nhiều Lượt Xem</button>
	<button class="btn-boloc" data="sanpham" boloc="4">Đang Sale</button>
	<button class="btn-boloc" data="sanpham" boloc="5">Đã Ẩn</button>
	@elseif ($mng == 'usersmng')
	<button class="btn-boloc" data="taikhoan" boloc="1">Tất Cả</button>
	<button class="btn-boloc" data="taikhoan" boloc="2">TK Bị khóa</button>
	<button class="btn-boloc" data="taikhoan" boloc="3">TK Không khóa</button>
	<button class="btn-boloc" data="taikhoan" boloc="4">TK User</button>
	<button class="btn-boloc" data="taikhoan" boloc="5">TK Admin</button>
	@elseif ($mng == 'invoices')
	<button class="btn-boloc" data="hoadon" boloc="1">Tất Cả</button>
	<button class="btn-boloc" data="hoadon" boloc="2">Hóa đơn mới</button>
	<button class="btn-boloc" data="hoadon" boloc="3">Đang Chuẩn Bị</button>
	<button class="btn-boloc" data="hoadon" boloc="4">Đang Giao</button>
	<button class="btn-boloc" data="hoadon" boloc="5">Hoàn Thành</button>
	<button class="btn-boloc" data="hoadon" boloc="6">Đã Hủy</button>
	@endif
</div>