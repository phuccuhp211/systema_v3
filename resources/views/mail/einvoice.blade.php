<div style="width: 700px; margin: 0 auto; border: solid 1px #ccc;">
	<div style="width:600px; margin: 30px auto;">
		<h1 style="text-align: center; color: #745caf;">Hóa Đơn Điện Tử</h1>
		<h3 style="margin:0;">Mã Hóa Đơn :	<strong>{{$mxn}}</strong></h3>
		<h3 style="margin:0;">Ngày Tạo HD :	<strong>{{$date}}</strong></h3>
		<h3 style="margin:0;">Kính gửi : <strong>{{$name}}</strong></h3>
		<h3 style="margin:0;">Địa Chỉ :  <strong>{{$addr}}</strong></h3>
		<h3 style="text-align: center; margin: 30px 0 0;">CHÚNG TÔI GỬI ĐẾN QUÝ KHÁCH HÀNG HÓA ĐƠN MUA HÀNG</h3>
	</div>
    <table style="width: 600px; border-collapse: collapse; margin: 0 auto;">
        <tr style="color: white; background: #927ec4;">
            <th style="border: 1px solid black; text-align: center; padding: 5px 0; font-size: 18px;">STT</th>
            <th style="border: 1px solid black; text-align: center; padding: 5px 0; font-size: 18px;">Tên Sản Phẩm</th>
            <th style="border: 1px solid black; text-align: center; padding: 5px 0; font-size: 18px;">Số lượng</th>
            <th style="border: 1px solid black; text-align: center; padding: 5px 0; font-size: 18px;">Thành tiền</th>
        </tr>

        @foreach (session('cart')['list'] as $value => $item)
	    <tr>
	        <td style="padding: 3px; font-size: 15px; border: 1px solid black; width: 50px; text-align: center;">{{$value+1}}</td>
	        <td style="padding: 3px 5px; font-size: 15px; border: 1px solid black; width: 400px">{{$item['name']}}</td>
	        <td style="padding: 3px; font-size: 15px; border: 1px solid black; width: 100px; text-align: center;">{{$item['num']}}</td>
	        <td style="padding: 3px 10px; font-size: 15px; border: 1px solid black; width: 150px; text-align: right;">{{gennum($item['sum'])}}</td>
	    </tr>
		@endforeach


		<tr>
	        <td style="padding: 3px; font-size: 15px; border: 1px solid black; width: 50px; text-align: center;">X</td>
	        <td style="padding: 3px 5px; font-size: 15px; border: 1px solid black; width: 400px">Phí vận chuyển</td>
	        <td style="padding: 3px; font-size: 15px; border: 1px solid black; width: 100px; text-align: center;">X</td>
	        <td style="padding: 3px 10px; font-size: 15px; border: 1px solid black; width: 150px; text-align: right;">{{gennum($ship)}}</td>
	    </tr>

		@if ($ntotal != null && $coupon != null)
		<tr style="color: white; background: #927ec4;">
			<td style="border: 1px solid black; padding:3px; font-size: 20px; text-align: center;" colspan="3">Tạm Tính :</td>
		    <td style="border: 1px solid black; padding:3px; font-size: 20px; text-align: center;">{{gennum($total)}}</td>
		</tr>
		<tr style="color: white; background: #927ec4;">
			<td style="border: 1px solid black; padding:3px; font-size: 20px; text-align: center;" colspan="3">Giảm :</td>
		    <td style="border: 1px solid black; padding:3px; font-size: 20px; text-align: center;">{{gennum($total-$ntotal)}}</td>
	    </tr>
	    <tr style="color: white; background: #927ec4;">
		    <td style="border: 1px solid black; padding:3px; font-size: 20px; text-align: center;" colspan="3">Tổng Cộng :</td>
		    <td style="border: 1px solid black; padding:3px; font-size: 20px; text-align: center;">{{gennum($ntotal)}}</td>
		</tr>
		@else
		<tr style="color: white; background: #927ec4;">
		    <td style="border: 1px solid black; padding:3px; font-size: 20px; text-align: center;" colspan="3">Tổng Cộng :</td>
		    <td style="border: 1px solid black; padding:3px; font-size: 20px; text-align: center;">{{gennum($total)}}</td>
		</tr>
		@endif
	</table>
	<div style="width:600px; margin: 15px auto 0;">
		<h4>Chân thành cám ơn quý khách hàng đã tin tưởng dùng lựa chọn tại cửa hàng của chúng tôi. Chúng tôi sẽ chuẩn bị đơn hàng nhanh nhất có thể cho quý khách hàng.</h4>
	</div>
</div>