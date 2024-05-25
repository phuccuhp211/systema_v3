$(function() {
	slsp = document.getElementsByName('slsp');
	full_sldssp = document.getElementsByName('sanpham');
	$(window).on('load' ,function() {
		slsp = document.getElementsByName('slsp');
		full_sldssp = document.getElementsByName('sanpham');
		var duongdan_fix = duongdan+url_sub+"/updatecart/";
		for (var j=0; j<slsp.length; j++) {
			var quantity = parseInt($(slsp)[j].value);
			var price = parseInt($(slsp[j]).parent().siblings("#giasp").text().replace(/\./g, ''));
			var total = quantity * price;
			$(slsp[j]).parent().siblings("#thanhtien").text(total.toLocaleString('vi-VN'));
			totalp = updateTT();
			$.ajax({
				type: "POST",
				url: duongdan_fix,
				data: { totalp: totalp },
				success: function(response) {
					console.log("thanh cong");
				},
				error: function() {
					console.log("Có lỗi xảy ra.");
				}
			});
		}
	})
	for (var j=0; j<slsp.length; j++) {
		slsp[j].addEventListener('change', function() {
			var duongdan_fix = duongdan+url_sub+"/updatecart/";
			quantity = parseInt(this.value);
			keysp = parseInt($(this).parent().siblings("#keysp").text());
			price = parseInt($(this).parent().siblings("#giasp").text().replace(/\./g, ''));
			total = quantity * price;
			$(this).parent().siblings("#thanhtien").text(total.toLocaleString('vi-VN'));
			totalp = updateTT();

			$.ajax({
				type: "POST",
				url: duongdan_fix,
				data: { quantity: quantity, keysp: keysp, total: total, totalp: totalp },
				success: function(response) {
					console.log("thanh cong");
				},
				error: function() {
					console.log("Có lỗi xảy ra.");
				}
			});
		});
	}
	var xoasp = document.getElementsByName('xoasp');
  	for (var k=0; k<xoasp.length; k++) {
	    xoasp[k].addEventListener('click', function() {
	    	var duongdan_fix = duongdan+url_sub+"/delcart/";
	    	$(this).closest('tr').remove();
	    	var delspcart = $(this).data('idsp');
	    	updateTT();
	    	$.ajax({
				type: "POST",
				url: duongdan_fix,
				data: { delspcart: delspcart },
				success: function(response) {
					updateCart();
				},
				error: function() {
					console.log("Có lỗi xảy ra.");
				}
			});
	    });
	}
	$('.delallcart').on('click', function() {
		$('[id="sanpham"]').each(function() {
	        $(this).remove();
	    });
		var emtycart = `<tr id="emptycart"><th colspan="7">Bạn không có sản phẩm nào trong giỏ hàng</th></tr>`;
		$('#listcart').append(emtycart);	
		

		var duongdan_fix = duongdan+url_sub+"/delallcart/";

		$.ajax({
			type: "POST",
			url: duongdan_fix,
			success: function(response) {
				console.log('thanh cong');
			},
			error: function() {
				console.log("Có lỗi xảy ra.");
			}
		});
	})
})