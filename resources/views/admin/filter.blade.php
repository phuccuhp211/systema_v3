@php
	$type = '';
	if ($mng == 'products') $type = 'pd';
	else if ($mng == 'usersmng') $type = 'us';
	else if ($mng == 'invoices') $type = 'in';
@endphp
<div class="filter">
	<div class="d-flex justify-content-between">
		@if ($mng == 'products')
		<button class="filter-gr btn-filter mb-2 btn-filter-act" data-type="{{ $type }}" data-filter="1">Tất Cả</button>
		<button class="filter-gr btn-filter mb-2" data-type="{{ $type }}" data-filter="2">Sản Phẩm Bán Chạy</button>
		<button class="filter-gr btn-filter mb-2" data-type="{{ $type }}" data-filter="3">Nhiều Lượt Xem</button>
		<button class="filter-gr btn-filter mb-2" data-type="{{ $type }}" data-filter="4">Đang Sale</button>
		<button class="filter-gr btn-filter mb-2" data-type="{{ $type }}" data-filter="5">Đã Ẩn</button>
		@elseif ($mng == 'usersmng')
		<button class="filter-gr btn-filter mb-2" data-type="{{ $type }}" data-filter="1">Tất Cả</button>
		<button class="filter-gr btn-filter mb-2" data-type="{{ $type }}" data-filter="2">TK Bị khóa</button>
		<button class="filter-gr btn-filter mb-2" data-type="{{ $type }}" data-filter="3">TK Không khóa</button>
		<button class="filter-gr btn-filter mb-2" data-type="{{ $type }}" data-filter="4">TK User</button>
		<button class="filter-gr btn-filter mb-2" data-type="{{ $type }}" data-filter="5">TK Admin</button>
		@elseif ($mng == 'invoices')
		<button class="filter-gr btn-filter mb-2" data-type="{{ $type }}" data-filter="1">Tất Cả</button>
		<button class="filter-gr btn-filter mb-2" data-type="{{ $type }}" data-filter="2">Hóa đơn mới</button>
		<button class="filter-gr btn-filter mb-2" data-type="{{ $type }}" data-filter="3">Đang Chuẩn Bị</button>
		<button class="filter-gr btn-filter mb-2" data-type="{{ $type }}" data-filter="4">Đang Giao</button>
		<button class="filter-gr btn-filter mb-2" data-type="{{ $type }}" data-filter="5">Hoàn Thành</button>
		<button class="filter-gr btn-filter mb-2" data-type="{{ $type }}" data-filter="6">Đã Hủy</button>
		@endif
	</div>
	<div class="row">
		@if ($mng == 'products' || $mng == 'usersmng' || $mng == 'invoices')
		<div class="col-4">
			<label class="form-label">Tìm kiếm:</label>
			<input type="text" class="filter-gr form-control search-records" data-type="{{ $type }}">
		</div>
		<div class="col-4">
			<label class="form-label">Số lượng hiển thị:</label>
			<select class="filter-gr form-control range-records" data-type="{{ $type }}">
				<option value="10">10</option>
				<option value="20">20</option>
				<option value="50">50</option>
				<option value="100">100</option>
			</select>
		</div>
		<div class="col-4">
			<label class="form-label">Sắp Xếp:</label>
			<select class="filter-gr form-control sort-records" data-type="{{ $type }}">
				<option value="DESC">Mới Nhất</option>
				<option value="ASC">Cũ Nhất</option>
			</select>
		</div>
		@endif
	</div>
</div>