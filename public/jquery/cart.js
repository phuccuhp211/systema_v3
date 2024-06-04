$(function() {
	var slsp = document.getElementsByName('slsp');
	var full_sldssp = document.getElementsByName('sanpham');

	function updateTT() {
		let totalPrice = 0;
    	for (let l=0; l<full_sldssp.length; l++) {
	        let itemPrice = parseInt($(full_sldssp[l]).find('#thanhtien').text().replace(/\./g, ''));
	        totalPrice += itemPrice;
    	}
    	$('#ttfn').text(totalPrice.toLocaleString('vi-VN'));
    	return totalPrice;
	}

	for (var j=0; j<slsp.length; j++) {
		slsp[j].addEventListener('change', function() {
			let duongdan_fix = duongdan+url_sub+"/cart/fix";
			let num = parseInt(this.value);
			let id = parseInt($(this).parent().siblings('#id').text());
			let price = parseInt($(this).parent().siblings("#giasp").text().replace(/\./g, ''));
			let total = num * price;
			$(this).parent().siblings("#thanhtien").text(total.toLocaleString('vi-VN'));
			updateTT();

			console.log(id);

			$.ajax({
				type: "POST",
				url: duongdan_fix,
				data: { num: num, id: id },
				success: function(data) {
					console.log("thanh cong");
				},
				error: function() {
					console.log("Có lỗi xảy ra");
				}
			});
		});
	}

	var xoasp = document.getElementsByName('xoasp');
  	for (var k=0; k<xoasp.length; k++) {
	    xoasp[k].addEventListener('click', function() {
	    	let duongdan_fix = duongdan+url_sub+"/cart/del";
	    	$(this).closest('tr').remove();
	    	let key = $(this).data('key');
	    	updateTT();

	    	$.ajax({
				type: "POST",
				url: duongdan_fix,
				data: { key: key },
				success: function(data) {
					if (xoasp.length == 0) {
			    		let emtycart = `<tr id="emptycart"><th colspan="7">Bạn không có sản phẩm nào trong giỏ hàng</th></tr>`;
						$('#listcart').append(emtycart);
						$('.delallcart').remove();
						$('[id="sanpham"]').each(function() {
					        $(this).remove();
					    });
			    	}
				},
				error: function() {
					console.log("Có lỗi xảy ra.");
				}
			});
	    });
	}
	$('.delallcart').on('click', function() {
		let btn = $(this);
		$('[id="sanpham"]').each(function() {
	        $(this).remove();
	        btn.remove();
	    });
		let emtycart = `<tr id="emptycart"><th colspan="7">Bạn không có sản phẩm nào trong giỏ hàng</th></tr>`;
		$('#listcart').append(emtycart);	
	
		let duongdan_fix = duongdan+url_sub+"/cart/dac";

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