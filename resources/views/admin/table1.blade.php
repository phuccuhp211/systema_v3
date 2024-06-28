@if ($mng == 'sections')
	<table class="show-data">
		<thead>
			<tr>
				<th style="width: 50px;">ID</th>
				<th style="width: auto; padding: 0;">Tên Sections</th>
				<th style="width: 150px;">Poster</th>
				<th style="width: 150px;">Ảnh Nền</th>
				<th style="width: 100px;">PL - CAT</th>
				<th style="width: 100px;">TC - SX</th>
				<th style="width: 100px;">Vị Trí</th>
				<th style="width: 100px;">Thao Tác</th>
			</tr>
			<tr><td colspan="8" class="td-addsp"><button class="btn btn-primary btn-crud add" data-type="ss">Thêm Section +</button></td></tr>
		</thead>
		<tbody>
			@foreach ($list as $value => $item)
			<tr class="record">
				<td hidden id="hidden-data" data-fn="{{ $item->name }}" data-pt="{{ $item->poster }}" data-ep="{{ $item->eb_img }}" data-c1="{{ $item->id_cata_1 }}" data-c2="{{ $item->id_cata_2 }}" data-rf="{{ $item->reference }}" data-or="{{ $item->orderby }}" data-in="{{ $item->index }}"></td>
				<td rowspan="2" class="text-center p-0">{{ $item->id }}</td>
				<td rowspan="2" class="text-center">{{ $item->name }}</td>
				<td rowspan="2" class="text-center">
					@if ($item->poster != null)
					<img src="{{ genurl($item->poster) }}">
					@else
					Chưa Thiết Lập
					@endif
				</td>
				<td rowspan="2" class="text-center">
					@if ($item->eb_img != null)
					<img src="{{ genurl($item->eb_img) }}">
					@else
					Chưa Thiết Lập
					@endif
				</td>
				<td class="text-center">{{ $item->id_cata_1 }}</td>
				<td class="text-center">{{ $item->reference }}</td>
				<td rowspan="2" class="text-center">{{ $item->index }}</td>
				<td rowspan="2" class="text-center">
					<button class="btn btn-primary btn-mini btn-crud fix suabc" data-id="{{ $item->id }}" data-type="ss"><i class="fa-solid fa-gear"></i></button>
					<button class="btn btn-danger btn-mini btn-crud del" data-id="{{ $item->id }}" data-type="ss"><i class="fa-solid fa-trash"></i></button>
				</td>
			</tr>
			<tr class="record">
				<td class="text-center">{{ $item->id_cata_2 }}</td>
				<td class="text-center">{{ $item->orderby }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
@elseif ($mng == 'slidebns')
	<table class="show-data">
		<thead>
			<tr>
				<th style="width: 50px;">ID</th>
				<th style="width: auto; padding: 0;">IMG</th>
				<th style="width: 200px;">Tiêu Đề</th>
				<th style="width: 150px;">Thao Tác</th>
			</tr>
			<tr>
				<td colspan="8" class="td-addsp"><button class="btn btn-primary btn-crud add" data-type="bn">Thêm Banner +</button></td>
			</tr>
		</thead>
		<tbody>
			@foreach ($list as $value => $item)
			<tr class="record">
				<td hidden id="hidden-data" data-im="{{ $item->img }}" data-tt="{{ $item->tit }}" data-ct="{{ $item->ctn }}"></td>
				<td class="text-center p-0">{{ $item->id }}</td>
				<td class="text-center"><img src="{{ genurl($item->img) }}" alt=""></td>
				<td class="text-center">{{ $item->tit }}</td>
				<td class="text-center">
					<button class="btn btn-primary btn-mini btn-crud fix suabn" data-id="{{ $item->id }}" data-type="bn"><i class="fa-solid fa-gear"></i></button>
					<button class="btn btn-danger btn-mini btn-crud del" data-id="{{ $item->id }}" data-type="bn"><i class="fa-solid fa-trash"></i></button>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
@elseif ($mng == 'products')
	<table class="show-data">
		<thead>
			<tr>
				<th style="width: 50px;">ID</th>
				<th style="width: 150px; padding: 0;">IMG</th>
				<th style="width: 200px;">Tên</th>
				<th style="width: auto;">Thông Tin</th>
				<th style="width: 100px;">Giá</th>
				<th style="width: 100px;">Sale</th>
				<th style="width: 120px;">Thao Tác</th>
			</tr>
			<tr>
				<td colspan="7" class="td-addsp"><button class="btn btn-primary btn-crud add" data-type="pd">Thêm sản phẩm +</button></td>
			</tr>
		</thead>
		<tbody>
			@foreach ($list as $value => $item)
			<tr class="record">
				<td hidden id="hidden-data" data-fn="{{ $item->name }}" data-im="{{ $item->img }}" data-if="{{ $item->info }}" data-c1="{{ $item->id_cata_1 }}" data-c2="{{ $item->id_cata_2 }}" data-br="{{ $item->id_brand }}" data-pr="{{ $item->price }}" data-sl="{{ $item->sale }}" data-sf="{{ $item->f_date }}" data-st="{{ $item->t_date }}"></td>
				<td rowspan="2" class="text-center">{{ $item->id }}</td>
				<td rowspan="2" class="text-center"><img src="{{ genurl($item->img) }}" alt=""></td>
				<td rowspan="2">{{ $item->name }}</td>
				<td rowspan="2" style="overflow-hidden">{{ $item->info }}</td>
				<td class="text-center">{{ gennum($item->price) }}</td>
				<td class="text-center">{{ gennum($item->sale) }}</td>
				<td rowspan="2" class="text-center">
					<button class="btn btn-primary btn-mini btn-crud fix suasp" data-id="{{ $item->id }}" data-type="pd"><i class="fa-solid fa-gear"></i></button>
					<button class="btn btn-danger btn-mini btn-crud del" data-id="{{ $item->id }}" data-type="pd"><i class="fa-solid fa-trash"></i></button>
					@if ($item->hidden == 0)
					<button class="btn btn-warning btn-mini btn-crud hidden hidsp" data-hid="{{ $item->hidden }}" data-id="{{ $item->id }}" data-type="pd"><i class="fa-solid fa-eye-slash"></i></button>
					@else
					<button class="btn btn-success btn-mini btn-crud hidden unhidsp" data-hid="{{ $item->hidden }}" data-id="{{ $item->id }}" data-type="pd"><i class="fa-solid fa-eye"></i></button>
					@endif
				</td>
			</tr>
			<tr class="record">
				<td colspan="2">Đã bán : {{ $item->saled }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
@elseif ($mng == 'catalogs')
	<table class="show-data2">
		<thead>
			<tr>
				<th style="width: 50px;">ID</th>
				<th style="width: 200px;">Tên</th>
				<th style="width: 200px;">Mã Phân Loại</th>
				<th style="width: auto;">IMG</th>
				<th style="width: 120px;">Thao Tác</th>
			</tr>
			<tr>
				<td colspan="7" class="td-adddm"><button class="btn btn-primary btn-crud add" data-type="c2">Thêm danh mục +</button></td>
			</tr>
		</thead>
		<tbody>
			@foreach ($list2 as $value => $item)
			<tr class="record">
				<td hidden id="hidden-data2" data-fn="{{ $item->name }}" data-c1="{{ $item->type }}" data-im="{{ $item->img }}"></td>
				<td style="text-align: center;">{{ $item->id }}</td>
				<td style="text-align: center;">{{ $item->name }}</td>
				<td style="text-align: center;">{{ $item->type }}</td>
				<td style="text-align: center;">
					@if ($item->img != NULL)
					<img src="{{ genurl($item->img) }}" alt="">
					@endif
				</td>
				<td style="text-align: center;">
					<button class="btn btn-primary btn-mini btn-crud fix suadm" data-id="{{ $item->id }}" data-type="c2"><i class="fa-solid fa-gear"></i></button>
					<button class="btn btn-danger btn-mini btn-crud del" data-id="{{ $item->id }}" data-type="c2"><i class="fa-solid fa-trash"></i></button>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
@elseif ($mng == 'usersmng')
	<table class="show-data">
		<thead>
			<tr>
				<th style="width: 40px;">ID</th>
				<th style="width: 200px; padding: 0;">Tài Khoản</th>
				<th style="width: 250px;">Họ Tên</th>
				<th style="width: 125px;">Vai Trò</th>
				<th style="width: 120px;">Thao Tác</th>
			</tr>
			<tr>
				<td colspan="5" class="td-adddm"><button data-type="us" class="btn btn-primary btn-crud add" data-type="us">Thêm</button></td>
			</tr>
		</thead>
		<tbody>
			@foreach ($list as $value => $item)
			<tr class="record">
				<td hidden id="hidden-data" data-ac="{{ $item->account }}" data-fn="{{ $item->name }}" data-nb="{{ $item->number }}" data-em="{{ $item->email }}" data-ad="{{ $item->address }}" data-rl="{{ $item->role }}" data-pm="{{ $item->permission }}" data-pw="{{ $item->pass }}"></td>
				<td class="text-center">{{ $item->id }}</td>
				<td>{{ $item->account }}</td>
				<td>{{ $item->name }}</td>
				<td>
					@if ($item->role == 1)
						@if ($item->permission != NULL)
							{{ $item->permission }}
						@else
							noroot
						@endif
					@else
						Khách Hàng
					@endif
				</td>
				<td class="text-center">
					<button data-type="us" class="btn btn-primary btn-mini btn-crud fix suaus" data-id="{{ $item->id }}" data-type="us"><i class="fa-solid fa-gear"></i></button>
					<button data-type="us" class="btn btn-danger btn-mini btn-crud del" data-id="{{ $item->id }}" data-type="us"><i class="fa-solid fa-trash"></i></button>
					@if ($item->lock == 0)
					<button data-type="us" class="btn btn-warning btn-mini btn-crud lock banus" data-id="{{ $item->id }}" data-lock="{{ $item->lock }}" data-type="us"><i class="fa-solid fa-ban"></i></button>
					@else
					<button data-type="us" class="btn btn-success btn-mini btn-crud lock unbanus" data-id="{{ $item->id }}" data-lock="{{ $item->lock }}" data-type="us"><i class="fa-solid fa-check"></i></button>
					@endif
				</td>
			</tr>	
			@endforeach
		</tbody>
	</table>
@elseif ($mng == 'comments')
	<table class="show-data">
		<thead>
			<tr>
				<th style="width: 70px;">ID SP</th>
				<th style="width: auto;">Tên SP</th>
				<th style="width: 125px;">Lượt CMT</th>
				<th style="width: 125px;">Lượng User</th>
				<th style="width: 125px;">Thao Tác</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($list as $value => $item)
			<tr class="record">
				<td>{{ $item->id }}</td>
				<td style="text-align: left;">{{ $item->name }}</td>
				<td>{{ $item->cmts }}</td>
				<td>{{ $item->users }}</td>
				<td><button class="btn btn-success chitiet chitietbl" data-id="{{ $item->id }}">Chi tiết</button></td>
			</tr>
			@endforeach
		</tbody>
	</table>
@elseif ($mng == 'invoices')
	<table class="show-data">
		<thead>
			<tr>
				<th style="width: 30px;">ID</th>
				<th style="width: 20%;">Liên Hệ</th>
				<th style="width: auto;">Danh Sách Sản Phẩm</th>
				<th style="width: 12.5%;">Thành tiền</th>
				<th style="width: 25%;">Tình Trạng</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($list as $value => $item)
				@php
					$list = json_decode($item->list, true);
				    $rp = is_array($list) ? count($list) : 0;
				    $price = $item['offers'] !== null ? gennum($item['offers']) : gennum($item['price']);
				    $coupon = $item['coupon'];
				@endphp
				<tr class="record">
					<td hidden id="hidden-data" data-fn="{{ $item->name }}" data-em="{{ $item->email }}" data-nb="{{ $item->number }}" data-ad="{{ $item-address }}"></td>
					<td rowspan="{{ $rp }}" class="text-center p-0 id-hd">{{ $item['id'] }}</td>
					<td rowspan="{{ $rp }}" class="text-start" style="font-size:14px;">
						{{ $item['name'] }}<br>
						{{ $item['email'] }}<br>
						0{{ $item['number'] }}<br>
						{{ $item['address'] }}
					</td>
					<td class="text-start">SL: {{ $list[0]['num'] }} | {{ $list[0]['name'] }}</td>
					<td rowspan="{{ $rp }}" class="text-center p-0">
					    @if ($item['offers'] != null)
					        {!! $price !!}
					        <br>
					        <span style="font-size: 12px; color: red;">{{ $coupon }}</span>
					    @else
					        {!! $price !!}
					    @endif
					</td>
					<td rowspan="{{ $rp }}" class="text-center">
						<select name="trangthai" class="hd-stt form-control mb-1 btn-crud" id="hd-stt" data-type="in">
							<option {{ $item['status'] == 'Đanh chờ xác nhận' ? 'selected' : '' }} value="Đanh chờ xác nhận">Đanh chờ xác nhận</option>
							<option {{ $item['status'] == 'Chuẩn Bị' ? 'selected' : '' }} value="Chuẩn Bị">Chuẩn Bị</option>
							<option {{ $item['status'] == 'Đang Giao' ? 'selected' : '' }} value="Đang Giao">Đang Giao</option>
							<option {{ $item['status'] == 'Hoàn Thành' ? 'selected' : '' }} value="Hoàn Thành">Hoàn Thành</option>
							<option {{ $item['status'] == 'Hủy' ? 'selected' : '' }} value="Hủy">Hủy</option>
						</select>
						<select name="thanhtoan" class="hd-stt form-control mb-1 btn-crud" id="hd-pstt" data-type="in">
							<option {{ $item['p_status'] == 0 ? 'selected' : '' }} value="0">Chưa Thanh Toán</option>
							<option {{ $item['p_status'] == 1 ? 'selected' : '' }} value="1">Đã Thanh Toán</option>
						</select>
						<button class="btn btn-success d-block mt-1 mx-auto hd-update" id="hd-update">Cập Nhật</button>
					</td>
				</tr>
				@for ($i = 1; $i < $rp; $i++)
				<tr class="record">
					<td style="text-align: left;">SL: {{ $list[$i]['num'] }} | {{ $list[$i]['name'] }} </td>
				</tr>
				@endfor
			@endforeach
		</tbody>
	</table>
@elseif ($mng == 'offers')
	<table class="show-data">
		<thead>
			<tr>
				<th style="width: 40px;">ID</th>
				<th style="width: auto;">Tên Mã</th>
				<th style="width: 100px;">S.Lượng</th>
				<th style="width: 100px;">Còn Lại</th>
				<th style="width: 125px;">Từ Ngày</th>
				<th style="width: 125px;">Đến Ngày</th>
				<th style="width: 175px;">Giảm</th>
				<th style="width: 120px;">Thao Tác</th>
			</tr>
			<tr>
				<td colspan="8" class="td-adddm"><button class="btn btn-primary btn-crud add" data-type="cp">Thêm MGG +</button></td>
			</tr>
		</thead>
		<tbody>
			@foreach ($list as $value => $item)
				<tr class="record">
					<td hidden id="hidden-data" data-fn="{{ $item->name }}" data-mx="{{ $item->amount }}" data-rm="{{ $item->remaining }}" data-fd="{{ $item->f_date }}" data-td="{{ $item->t_date }}" data-dc="{{ $item->discount }}" data-tp="{{ $item->type }}"></td>
					<td>{{ $item->id }}</td>
					<td>{{ $item->name }}</td>
					<td>{{ $item->amount }}</td>
					<td>{{ $item->remaining }}</td>
					<td>{{ gendate($item->f_date) }}</td>
					<td>{{ gendate($item->t_date) }}</td>
					<td>
						@if ( $item->type == "number")
						{{ gennum($item->discount) }} đ
						@else
						{{ $item->discount }}%
						@endif
					</td>
					<td>
						<button class="btn btn-primary btn-mini btn-crud fix suagg" data-id="{{ $item->id }}" data-type="cp"><i class="fa-solid fa-gear"></i></button>
						<button class="btn btn-danger btn-mini btn-crud del" data-id="{{ $item->id }}" data-type="cp"><i class="fa-solid fa-trash"></i></button>
					</td>
				</tr>
			@endforeach
		</tbody>	
	</table>	
@endif

@if (isset($pagin))
	<div class="w-50 mx-auto d-flex justify-content-center box-pagin">
		{!! $pagin !!}
	</div>
@endif