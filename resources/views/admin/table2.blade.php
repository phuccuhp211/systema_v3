@if ($mng == "catalogs" && $permission == 'Admin' || $mng == "catalogs" && $permission == 'Seller')
<table class="show-data1">
	<thead>
		<tr>
			<th style="width: 50px;">ID</th>
			<th style="width: auto;">Tên</th>
			<th style="width: 120px;">Thao Tác</th>
		</tr>
		<tr>
			<td colspan="7" class="td-adddm"><button class="btn btn-primary btn-crud add" data-type="c1">Thêm phân loại +</button></td>
		</tr>
	</thead>
	<tbody>
		@foreach ($list1 as $value => $item)
		<tr class="record">
			<td hidden id="hidden-data1" data-fn="{{ $item->name }}"></td>
			<td style="text-align: center;">{{ $item->id }}</td>
			<td style="text-align: center;">{{ $item->name }}</td>
			<td style="text-align: center;">
				<button class="btn btn-primary btn-mini btn-crud fix suapl" data-id="{{ $item->id }}" data-type="c1"><i class="fa-solid fa-gear"></i></button>
				<button class="btn btn-danger btn-mini btn-crud del" data-id="{{ $item->id }}" data-type="c1"><i class="fa-solid fa-trash"></i></button>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
@endif