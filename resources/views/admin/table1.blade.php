<table class="show-data">
	@if ($mng == 'sections')
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
		<tr><td colspan="8" class="td-addsp"><button class="btn btn-primary btn-add them">Thêm Section +</button></td></tr>
		@foreach ($list as $value => $item)
		<tr class="bocuc">
			<td rowspan="2" class="text-center p-0">{{ $item->id }}</td>
			<td rowspan="2" class="text-center" id="tenbc">{{ $item->name }}</td>
			<td rowspan="2" class="text-center" id="posbc">
				@if ($item->poster != null)
				<img src="{{ asset('data').'/'.$item->poster }}">
				@else
				Chưa Thiết Lập
				@endif
			</td>
			<td rowspan="2" class="text-center" id="bgrbc">
				@if ($item->eb_img != null)
				<img src="{{ asset('data').'/'.$item->eb_img }}">
				@else
				Chưa Thiết Lập
				@endif
			</td>
			<td class="text-center" id="plbc">{{ $item->id_cata_1 }}</td>
			<td class="text-center" id="refbc">{{ $item->reference }}</td>
			<td rowspan="2" class="text-center" id="idobc">{{ $item->index }}</td>
			<td rowspan="2" class="text-center">
				<button class="btn btn-primary suaxoa sua suabc" data-idbc="{{ $item->id }}"><i class="fa-solid fa-gear"></i></button>
				<button class="btn btn-danger suaxoa xoa xoabc" data-idbc="{{ $item->id }}"><i class="fa-solid fa-trash"></i></button>
			</td>
		</tr>
		<tr>
			<td class="text-center" id="catbc">{{ $item->id_cata_2 }}</td>
			<td class="text-center" id="ordbc">{{ $item->orderby }}</td>
		</tr>
		@endforeach


	@elseif ($mng == 'slidebns')
		<tr>
			<th style="width: 50px;">ID</th>
			<th style="width: auto; padding: 0;">IMG</th>
			<th style="width: 200px;">Tiêu Đề</th>
			<th style="width: 150px;">Thao Tác</th>
		</tr>
		<tr>
			<td colspan="8" class="td-addsp"><button class="btn btn-primary btn-add them">Thêm Banner +</button></td>
		</tr>
		@foreach ($list as $value => $item)
		<tr class="sldbn">
			<td class="text-center p-0">{{ $item->id }}</td>
			<td class="text-center"><img src="{{ asset('data').'/'.$item->img }}" alt=""></td>
			<td class="text-center" id="titbn">{{ $item->tit }}</td>
			<td class="text-center" id="txtbn" hidden>{{ $item->ctn }}</td>
			<td class="text-center">
				<button class="btn btn-primary suaxoa sua suabn" data-idbn="{{ $item->id }}"><i class="fa-solid fa-gear"></i></button>
				<button class="btn btn-danger suaxoa xoa xoabn" data-idbn="{{ $item->id }}"><i class="fa-solid fa-trash"></i></button>
			</td>
		</tr>
		@endforeach


	@elseif ($mng == 'products')
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
			<td colspan="7" class="td-addsp"><button class="btn btn-primary btn-add them">Thêm sản phẩm +</button></td>
		</tr>
		@foreach ($list as $value => $item)
		<tr class="sanpham">
			<td rowspan="2" class="text-center">{{ $item->id }}</td>
			<td rowspan="2" class="text-center"><img src="{{ $item->img }}" alt=""></td>
			<td rowspan="2" id="tensp">{{ $item->name }}</td>
			<td rowspan="2" id="in4sp" style="overflow-hidden">{{ $item->detail }}</td>
			<td id="min4sp" hidden>{{ $item->info }}</td>
			<td id="id_caplth" data-pl="{{ $item->id_cata_1 }}" data-ca="{{ $item->id_cata_2 }}" data-th="{{ $item->id_brand }}" hidden></td>
			<td id="giasp" class="text-center">{{ gennum($item->price) }}</td>
			<td id="salesp" class="text-center">{{ gennum($item->sale) }}</td>
			<td rowspan="2" class="text-center">
				<button class="btn btn-primary suaxoa sua suasp" data-idsp="{{ $item->id }}"><i class="fa-solid fa-gear"></i></button>
				<button class="btn btn-danger suaxoa xoa xoasp" data-idsp="{{ $item->id }}"><i class="fa-solid fa-trash"></i></button>
				@if ($item->hidden == 0)
				<button class="btn btn-warning suaxoa hidden hidsp" data-idsp="{{ $item->id }}"><i class="fa-solid fa-eye-slash"></i></button>
				@else
				<button class="btn btn-success suaxoa hidden unhidsp" data-idsp="{{ $item->id }}"><i class="fa-solid fa-eye"></i></button>
				@endif
			</td>
		</tr>
		<tr class="sanpham">
			<td colspan="2">Đã bán : {{ $item->saled }}</td>
		</tr>
		@endforeach


	@elseif ($mng == 'catalogs')
		<tr>
			<th style="width: 50px;">ID</th>
			<th style="width: 200px;">Tên</th>
			<th style="width: 200px;">Mã Phân Loại</th>
			<th style="width: auto;">IMG</th>
			<th style="width: 120px;">Thao Tác</th>
		</tr>
		<tr>
			<td colspan="7" class="td-adddm"><button class="btn btn-primary btn-add them">Thêm danh mục +</button></td>
		</tr>
		@foreach ($list2 as $value => $item)
		<tr>
			<td style="text-align: center;">{{ $item->id }}</td>
			<td style="text-align: center;" id="tendm">{{ $item->name }}</td>
			<td style="text-align: center;" id="pldm">{{ $item->type }}</td>
			<td style="text-align: center;" id="imgdm">{{ $item->img }}</td>
			<td style="text-align: center;">
				<button class="btn btn-primary suaxoa sua suadm" data-iddm="{{ $item->id }}"><i class="fa-solid fa-gear"></i></button>
				<button class="btn btn-danger suaxoa xoa xoadm" data-iddm="{{ $item->id }}"><i class="fa-solid fa-trash"></i></button>
			</td>
		</tr>
		@endforeach


	@elseif ($mng == 'usersmng')
		<tr>
			<th style="width: 40px;">ID</th>
			<th style="width: 200px; padding: 0;">Tài Khoản</th>
			<th style="width: 250px;">Họ Tên</th>
			<th style="width: 125px;">SĐT</th>
			<th style="width: auto;">Email</th>
			<th style="width: 70px;">Role</th>
			<th style="width: 120px;">Thao Tác</th>
		</tr>
		<tr>
			<td colspan="7" class="td-adddm"><button class="btn btn-primary btn-add them">Thêm User +</button></td>
		</tr>
		@foreach ($list as $value => $item)
		<tr class="taikhoan">
			<td class="text-center">{{ $item->id }}</td>
			<td id="tenus">{{ $item->account }}</td>
			<td id="htus" data-ho="{{ $item->f_name }}" data-ten="{{ $item->l_name }}">{{ $item->f_name }} {{ $item->l_name }}</td>
			<td id="sdtus">{{ $item->number }}</td>
			<td id="emailus" class="text-center">{{ $item->email }}</td>
			<td id="roleus" class="text-center">{{ $item->role }}</td>
			<td class="text-center">
				<button class="btn btn-primary suaxoa sua suaus" data-idus="{{ $item->id }}"><i class="fa-solid fa-gear"></i></button>
				<button class="btn btn-danger suaxoa xoa xoaus" data-idus="{{ $item->id }}"><i class="fa-solid fa-trash"></i></button>
				@if ($item->lock == 0)
				<button class="btn btn-warning suaxoa ban banus" data-idus="{{ $item->id }}"><i class="fa-solid fa-ban"></i></button>
				@else
				<button class="btn btn-success suaxoa ban unbanus" data-idus="{{ $item->id }}"><i class="fa-solid fa-check"></i></button>
				@endif
			</td>
		</tr>
		@endforeach


	@elseif ($mng == 'comments')
		<tr>
			<th style="width: 70px;">ID SP</th>
			<th style="width: auto;">Tên SP</th>
			<th style="width: 125px;">Lượt CMT</th>
			<th style="width: 125px;">Lượng User</th>
			<th style="width: 125px;">Thao Tác</th>
		</tr>
		@foreach ($list as $value => $item)
		<tr>
			<td>{{ $item->id }}</td>
			<td style="text-align: left;">{{ $item->name }}</td>
			<td>{{ $item->cmts }}</td>
			<td>{{ $item->users }}</td>
			<td><button class="btn btn-success chitiet chitietbl" data-idbl="{{ $item->id }}">Chi tiết</button></td>
		</tr>
		@endforeach


	@elseif ($mng == 'invoices')
		<tr>
			<th style="width: 30px;">ID</th>
			<th style="width: 120px;">Tên</th>
			<th style="width: 20%;">Liên Hệ</th>
			<th style="width: auto;">Danh Sách Sản Phẩm</th>
			<th style="width: 100px;">Thành tiền</th>
			<th style="width: 100px;">Tình Trạng</th>
			<th style="width: 100px;">Thao tác</th>
		</tr>
		@foreach ($list as $value => $item)
			@php
				$list = json_decode($item->list,true);
				$rp = (is_array($list)) ? count($list) : 0;
				if ($item['offers'] != null) $price = gennum($item['offers'])."<br><span style=\"font-size: 10px; color: red;\">".$item['coupon']."</span>";
				else $price = gennum($item['price']);
			@endphp
			<tr class="hoadon">
				<td rowspan="<?php echo $rp ?>" class="text-center p-0 id-hd">{{ $item['id'] }}</td>
				<td rowspan="<?php echo $rp ?>" class="text-start">{{ $item['name'] }}</td>
				<td rowspan="<?php echo $rp ?>" class="text-start">
					Email: {{ $item['email'] }}<br>
					SĐT: {{ $item['number'] }}<br>
					Đ/C: {{ $item['address'] }}
				</td>
				<td class="text-start">SL: {{ $list[0]['num'] }} | {{ $list[0]['name'] }}</td>
				<td rowspan="{{ $rp }}" class="text-center p-0">{{ $price }}</td>
				<td rowspan="{{ $rp }}" class="text-center stt-hd">{{ $item['status'] }}</td>
				<td rowspan="{{ $rp }}" class="text-center">
					<select name="trangthai" class="hd-stt" id="hd-stt">
						<option value="Chuẩn Bị">Chuẩn Bị</option>
						<option value="Đang Giao">Đang Giao</option>
						<option value="Hoàn Thành">Hoàn Thành</option>
						<option value="Hủy">Hủy</option>
					</select>
					<button class="btn btn-success d-block mt-1 mx-auto hd-update" id="hd-update">Cập Nhật</button>
				</td>
			</tr>
			@for ($i = 1; $i < $rp; $i++)
			<tr class="hoadon">
				<td style="text-align: left;">SL: {{ $list[$i]['num'] }} | {{ $list[$i]['name'] }} </td>
			</tr>
			@endfor
		@endforeach


	@elseif ($mng == 'offers')
		<tr>
			<th style="width: 40px;">ID</th>
			<th style="width: auto;">Tên Mã</th>
			<th style="width: 100px;">S.Lượng</th>
			<th style="width: 100px;">Còn Lại</th>
			<th style="width: 125px;">Từ Ngày</th>
			<th style="width: 125px;">Đến Ngày</th>
			<th style="width: 200px;">Loại</th>
			<th style="width: 120px;">Thao Tác</th>
		</tr>
		<tr>
			<td colspan="8" class="td-adddm"><button class="btn btn-primary btn-add them">Thêm MGG +</button></td>
		</tr>
		@foreach ($list as $value => $item)
		<tr class="voucher">
			<td>{{ $item->id }}</td>
			<td id="tengg">{{ $item->name }}</td>
			<td id="maxgg">{{ $item->amount }}</td>
			<td id="remgg">{{ $item->remaining }}</td>
			<td hidden id="fdgg">{{ $item->f_date }}</td>
			<td hidden id="tdgg">{{ $item->t_date }}</td>
			<td>{{ date("d-m-Y",strtotime($item->f_date)) }}</td>
			<td>{{ date("d-m-Y",strtotime($item->t_date)) }}</td>
			<td id="ptgg">{{ $item->type }} | {{ gennum($item->discount) }}</td>
			<td>
				<button class="btn btn-primary suaxoa sua suagg" data-idgg="{{ $item->id }}"><i class="fa-solid fa-gear"></i></button>
				<button class="btn btn-danger suaxoa xoa xoagg" data-idgg="{{ $item->id }}"><i class="fa-solid fa-trash"></i></button>
			</td>
		</tr>
		@endforeach
	

	@endif
</table>