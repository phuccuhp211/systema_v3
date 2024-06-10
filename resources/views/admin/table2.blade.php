<table>
	@if ($mng == "catalogs")
	<tr>
		<th style="width: 50px;">ID</th>
		<th style="width: auto;">Tên</th>
		<th style="width: 120px;">Thao Tác</th>
	</tr>
	<tr>
		<td colspan="7" class="td-adddm"><button class="btn btn-primary btn-add them">Thêm phân loại +</button></td>
	</tr>
	@foreach ($list1 as $value => $item)
	<tr>
		<td style="text-align: center;">{{ $item->id }}</td>
		<td style="text-align: center;" id="tenpl">{{ $item->name }}</td>
		<td style="text-align: center;">
			<button class="btn btn-primary suaxoa sua suapl" data-idpl="{{ $item->id }}"><i class="fa-solid fa-gear"></i></button>
			<button class="btn btn-danger suaxoa xoa xoapl" data-idpl="{{ $item->id }}"><i class="fa-solid fa-trash"></i></button>
		</td>
	</tr>
	@endforeach
	@endif
</table>