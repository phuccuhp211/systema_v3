@if ($mng == 'products')
	<div class="thongke">
		@foreach ($grap as $value => $item)
		<div hidden class="dsdm-ten" data-soluong="{{ $item->num }}" >{{ $item->name }}</div>
		@endforeach
		<div id="bieudo"></div>
	</div>
@endif