<div class="boloc">
	@if ($mng == 'products')
	<button class="btn-boloc" data-type="pd" data-full="sanpham" data-filter="1">Tất Cả</button>
	<button class="btn-boloc" data-type="pd" data-full="sanpham" data-filter="2">Sản Phẩm Bán Chạy</button>
	<button class="btn-boloc" data-type="pd" data-full="sanpham" data-filter="3">Nhiều Lượt Xem</button>
	<button class="btn-boloc" data-type="pd" data-full="sanpham" data-filter="4">Đang Sale</button>
	<button class="btn-boloc" data-type="pd" data-full="sanpham" data-filter="5">Đã Ẩn</button>
	@elseif ($mng == 'usersmng')
	<button class="btn-boloc" data-type="us" data-full="taikhoan" data-filter="1">Tất Cả</button>
	<button class="btn-boloc" data-type="us" data-full="taikhoan" data-filter="2">TK Bị khóa</button>
	<button class="btn-boloc" data-type="us" data-full="taikhoan" data-filter="3">TK Không khóa</button>
	<button class="btn-boloc" data-type="us" data-full="taikhoan" data-filter="4">TK User</button>
	<button class="btn-boloc" data-type="us" data-full="taikhoan" data-filter="5">TK Admin</button>
	@elseif ($mng == 'invoices')
	<button class="btn-boloc" data-type="in" data-full="hoadon" data-filter="1">Tất Cả</button>
	<button class="btn-boloc" data-type="in" data-full="hoadon" data-filter="2">Hóa đơn mới</button>
	<button class="btn-boloc" data-type="in" data-full="hoadon" data-filter="3">Đang Chuẩn Bị</button>
	<button class="btn-boloc" data-type="in" data-full="hoadon" data-filter="4">Đang Giao</button>
	<button class="btn-boloc" data-type="in" data-full="hoadon" data-filter="5">Hoàn Thành</button>
	<button class="btn-boloc" data-type="in" data-full="hoadon" data-filter="6">Đã Hủy</button>
	@endif
</div>