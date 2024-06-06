$(function() {
	var base_price = parseInt($('#giagoc').text().replace(/\./g, ""));
	var discount = 0;
	var price_discount = 0;
 	var ship_price = (base_price > 1000000) ? 25000 : 35000;
	var total_price = Math.ceil(base_price + ship_price);

	$(document).on('keyup', '#sdtkh', function() {
		$(this).val($(this).val().replace(/[^0-9]/g, ''));
	})

	function check_input() {
		return new Promise((resolve, reject) => {
			let data_trave = {
				name: $('#tenkh').val(),
				email: $('#emailkh').val(),
				number: $('#sdtkh').val(),
				address: $('#dckh').val(),
				notice: $('#memokh').val()
			}
			let promise = { status: false };
			let duongdan_fix = duongdan+url_sub+'/payment/checkip';
			$.ajax({
				url: duongdan_fix,
				type: 'POST',
				dataType: 'JSON',
				data: data_trave,
				success: function (data) {
					if (!data.status) {
						displayErrors(data.res);
						promise.res = 'Thông tin xác thực thất bại';
						resolve(promise);
					}
					else {
						$('#errorContainer').remove();
						promise.status = true;
						promise.res = data_trave;
						resolve(promise);
					}
				},
				error: function () {
					reject(false);
				}
			})
		})
	}

	function displayErrors(data) {
    	$('#errorContainer').empty();
    	let errorElement = '';
	    $.each(data, function(key, value) {
	        $.each(value, function(index, error) {
	            errorElement += `<li class="error">${error}</li>`;
	        });
	    });
	    let strhtml = `<ul id="errorContainer">${errorElement}</ul>`;
	    $('.fip').prepend(strhtml);
	}

	function getnumber(price) {
		return price.toLocaleString('vi-VN');
	}

	$(window).on('load' ,function() {
		$('#phiship').text(getnumber(ship_price));
		$('#tongtien').text(getnumber(total_price));

		if ($('.pmsv').length > 0) {
			var duongdan_fix1 = duongdan+url_sub+"/hoadon/";
			var duongdan_fix2 = duongdan+url_sub+"/sendmail/";
			var randomParam = Math.random().toString(36).substring(7);

			var data_trave = {
				randomParam: randomParam
			}

			$.ajax({
				type: "POST",
				method: "POST",
				url: duongdan_fix1,
				data: data_trave,
				success: function(response) {
					$.ajax({
						type: "POST",
						method: "POST",
						url: duongdan_fix2,
						data: data_trave,
						success: function(response) {
						},
						error: function() {
							console.log("Có lỗi xảy ra.");
						}
					});
				},
				error: function() {
					console.log("Có lỗi xảy ra.");
				}
			});
		}
	})

	$('.thanhtoansp').on('click', function() {
		check_input().then((check_vl) => {
			if (check_vl.status) {
				let randomParam = Math.random().toString(36).substring(7);
				
				let d = new Date();
				let gio = String((d.getHours()));
				let phut = String((d.getMinutes()));
				let giay = String((d.getSeconds()));

				if (gio.length == 1) gio = "0"+gio;
				if (phut.length == 1) phut = "0"+phut;
				if (giay.length == 1) giay = "0"+giay;

				let mxn = String(check_vl.res.number)+gio+phut+giay;
				let time = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate();

				let data_trave = {
					name: check_vl.res.name,
					email: check_vl.res.email,
					number: check_vl.res.number,
					address: check_vl.res.address,
					notice: check_vl.res.notice,
			        mxn: mxn,
			        date:time,
			        randomParam: randomParam
				}

				if ($('#stt-gg').attr("trangthai") == "true") {
					data_trave.newtt = Number(($('#tongtien').text()).replace(/\./g, ""));
					data_trave.magg = $('#magiamgia').val();
				}

				console.log(data_trave);

				// $('.thongbao-thanhtoan').removeClass('hide-tbtt');

				// if ($('input[name="bankCode"]:checked').val() != "COD") {
				// 	var duongdan_fix1 = duongdan+url_sub+"/payment/vnpay/s1/";
				// 	data_trave.pmmt = $('input[name="bankCode"]:checked').val();
				// 	$.ajax({
				// 		type: "POST",
				// 		method: "POST",
				// 		url: duongdan_fix1,
				// 		data: data_trave,
				// 		success: function(response) {
							
				// 		},
				// 		error: function() {
				// 			console.log("Có lỗi xảy ra.");
				// 		}
				// 	});
				// 	$('#frmCreateOrder').submit();
				// }
				// else {
				// 	var duongdan_fix1 = duongdan+url_sub+"/sendmail/";
				// 	var duongdan_fix2 = duongdan+url_sub+"/hoadon/";
				// 	var duongdan_fix3 = duongdan+url_sub+"/hoantat/";

				// 	$.ajax({
				// 		type: "POST",
				// 		method: "POST",
				// 		url: duongdan_fix1,
				// 		data: data_trave,
				// 		success: function(response) {
				// 			$.ajax({
				// 				type: "POST",
				// 				method: "POST",
				// 				url: duongdan_fix2,
				// 				data: data_trave,
				// 				success: function(response) {
				// 					window.location.href = duongdan_fix3;
				// 				},
				// 				error: function() {
				// 					console.log("Có lỗi xảy ra.");
				// 				}
				// 			});
				// 		},
				// 		error: function() {
				// 			console.log("Có lỗi xảy ra.");
				// 		}
				// 	});
				// }
			}
			else console.log('thieu thong tin kia thang ngu');
		})
	})
	$('#apply-mgg').on('submit', function(event) {
		event.preventDefault();
		let mgg = $(this).find("input").val();
		let duongdan_fix = duongdan+url_sub+"/payment/addcp";

		$.ajax({
			type: "POST",
	        url: duongdan_fix,
	        dataType: 'json',
			data: { coupon: mgg },
			success: function(data) {
				console.log(data);
				if (!data.status) {
					ship_price = (base_price > 1000000) ? 25000 : 35000;
					total_price = Math.ceil(base_price + ship_price);
					$('.giamgia').removeClass('hide-gg');
					$('#tongtien').text(getnumber(total_price));
					$('#stt-gg').attr("trangthai", "false");
					$('.giamgia').find('.p-gia').text(data.res);
				}
				else {
					discount = data.disc;
					let msgmgg = '';
					if (data.type == 'number') {
						price_discount = discount;
						total_price = base_price - price_discount;
						msgmgg = `-${getnumber(price_discount)}`; 
					}
					else {
						price_discount = Math.ceil((base_price * ( discount / 100 )));
						total_price = base_price - price_discount;
						msgmgg = `(-${discount}%) -${getnumber(price_discount)}`; 
					}


					$('.giamgia').find('.p-gia').text(msgmgg);
					$('.giamgia').removeClass('hide-gg');
					$('#tongtien').text(getnumber(total_price));
					$('#stt-gg').attr("trangthai", "true");
				}
			},
			error: function(xhr, status, error) {
				console.log(xhr+" "+status+" "+error);
			}
		})
	})
})