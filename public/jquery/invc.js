$(function() {
	$('.check-bh').on('click', function() {
		var mahd = $(this).siblings('#mahd').val();
		var error ="";
		if (mahd === "" || mahd.length < 12) {
			error = `<h3 class="popup popup-do" id="log-bh">Mã hóa đơn không hợp lệ</h3>`;
			if ($('.popup-do').length == 0) $('.baohanh').prepend(error);
			else {
				document.getElementById("log-bh").remove();
				$('.baohanh').prepend(error);
			}
		}
		else {
			var duongdan_fix = duongdan+url_sub+"/invoice_check";
			$.ajax({
		        type: "POST",
		        url: duongdan_fix,
		        dataType: 'JSON',
		        data: {in_num: mahd},
		        success: function(data) {
		        	console.log(data);
		        	if (!data.status) {
		        		error = `<h3 class="popup popup-do" id="log-bh">Mã hóa đơn không tồn tại</h3>`;
						if ($('.popup-do').length == 0) $('.baohanh').prepend(error);
						else {
							document.getElementById("log-bh").remove();
							$('.baohanh').prepend(error);
						}
		        	}
		        	else $('#baohanh').html(data.res);
		        },
		        error: function() {
		            console.log("Có lỗi xảy ra.");
		        }
		    });
		}
	})
})