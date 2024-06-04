$(function() {
	var base_pr = parseInt($('#giagoc').text().replace(/\./g, ""));
	var disc_pr = 0;
	var ship_pr = (base_pr > 1000000) ? 25000 : 35000;
	var prfn = Math.ceil(base_pr + ship_pr);

	$(document).on('keyup', '#sdtkh', function() {
		$(this).val($(this).val().replace(/[^0-9]/g, ''));
	})

	function check_input() {
		let data_trave = {
			name: $('#tenkh').val(),
			email: $('#emailkh').val(),
			number: $('#sdtkh').val(),
			address: $('#dckh').val(),
			notice: $('#memokh').val()
		}
		let duongdan_fix = duongdan+url_sub+'/payment/checkip'

		$.ajax({
			url: duongdan_fix,
			type: 'POST',
			dataType: 'JSON',
			data: data_trave,
			success: function (data) {
				if (!data.status) displayErrors(data.res);
				else $('#errorContainer').remove();
			},
			error: function () {

			}
		});
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

	$(window).on('load' ,function() {
		$('#phiship').text(ship_pr.toLocaleString('vi-VN'));
		$('#tongtien').text(prfn.toLocaleString('vi-VN'));

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
		let check_vl = check_input();

		if (check_vl) {
			var tenkh = $('#tenkh').val();
			var emailkh = $('#emailkh').val();
			var sdtkh = $('#sdtkh').val();
			var dckh = $('#dckh').val();
			var randomParam = Math.random().toString(36).substring(7);
			
			var d = new Date();
			var gio1 = String((d.getHours()));
			var phut1 = String((d.getMinutes()));
			var giay1 = String((d.getSeconds()));

			if (gio1.length == 1) var gio2 = "0"+gio1;
			else gio2 = gio1;
			if (phut1.length == 1) var phut2 = "0"+phut1;
			else phut2 = phut1;
			if (giay1.length == 1) var giay2 = "0"+giay1;
			else giay2 = giay1;

			var mxn = String((sdtkh.substring(4, 10)))+gio2+phut2+giay2;
			var time = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate();

			var data_trave = {
				tenkh: tenkh,
		        emailkh: emailkh,
		        sdtkh: sdtkh,
		        dckh: dckh,
		        mxn: mxn,
		        date:time,
		        randomParam: randomParam
			}

			if ($('#stt-gg').attr("trangthai") == "true") {
				data_trave.newtt = Number(($('#tongtien').text()).replace(/\./g, ""));
				data_trave.magg = $('#magiamgia').val();
			}

			$('.thongbao-thanhtoan').removeClass('hide-tbtt');

			if ($('input[name="bankCode"]:checked').val() != "COD") {
				var duongdan_fix1 = duongdan+url_sub+"/payment/vnpay/s1/";
				data_trave.pmmt = $('input[name="bankCode"]:checked').val();
				$.ajax({
					type: "POST",
					method: "POST",
					url: duongdan_fix1,
					data: data_trave,
					success: function(response) {
						
					},
					error: function() {
						console.log("Có lỗi xảy ra.");
					}
				});
				$('#frmCreateOrder').submit();
			}
			else {
				var duongdan_fix1 = duongdan+url_sub+"/sendmail/";
				var duongdan_fix2 = duongdan+url_sub+"/hoadon/";
				var duongdan_fix3 = duongdan+url_sub+"/hoantat/";

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
								window.location.href = duongdan_fix3;
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
		}
	})
	$('#apply-mgg').on('submit', function(event) {
		event.preventDefault();

		let mgg = $(this).find("input").val();
		let duongdan_fix = duongdan+url_sub+"/payment/appcp";

		$.ajax({
			type: "POST",
	        url: duongdan_fix,
	        dataType: 'json',
			data: { coupon: mgg },
			success: function(response) {
				if (response != "false" && response != "out" && response != "not" && response != "exp") {
					var dis = (Number(ttfn)*(100-Number(response.percent)))/100;
					var gg = (Number(ttfn)*Number(response.percent))/100;
					$('.giamgia').find('.p-gia').text("(-"+response.percent+"%) -"+gg.toLocaleString('vi-VN'));
					$('.giamgia').removeClass('hide-gg');
					$('#tongtien').text((dis+20000).toLocaleString('vi-VN'));
					$('#stt-gg').attr("trangthai", "true");
				}
				else {
					$('.giamgia').removeClass('hide-gg');
					$('#tongtien').text(tt.toLocaleString('vi-VN'));
					$('#stt-gg').attr("trangthai", "false");

					if (response == "false") $('.giamgia').find('.p-gia').text("Mã không tồn tại");
					else if (response == "out") $('.giamgia').find('.p-gia').text("Mã đã hết");
					else if (response == "not") $('.giamgia').find('.p-gia').text("Mã chưa khả dụng");
					else if (response == "exp") $('.giamgia').find('.p-gia').text("Đã hết hạn sử dụng");
				}
			},
			error: function(xhr, status, error) {
				console.log(xhr+" "+status+" "+error);
			}
		})
	})
})