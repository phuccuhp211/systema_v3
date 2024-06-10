$(function() {
	$(document).on('submit', '#send-code',function(event) {
		event.preventDefault();
		$('.thongbao').removeClass('hide-tbtt');
		let form = $(this);
		let duongdan_fix = form.attr('action');
		let name = $('input[name="tendn"]').val();

		$.ajax({
			url: duongdan_fix,
			type: 'POST',
			dataType: 'JSON',
			data: {name: name},
			success: function (data) {
				$('.thongbao').addClass('hide-tbtt');
				if (!data.status) form.find('h5.popup').removeClass('bg-info').addClass('bg-danger').html(data.res);
				else {
					form.find('h5.popup').removeClass('bg-danger').addClass('bg-info').html(data.res);
					form.find('h3').text("XÁC THỰC");
					form.find('button').text("Xác Thực");
					form.find('label').text("Mã xác nhận:");
					form.find('label').attr('for', 'mxn');
					form.find('input').attr('name', 'mxn');
					form.find('input').val('');
					form.attr('id', 'check-code');
				}
			}
		});

	})
	$(document).on('submit', '#check-code',function(event) {
		event.preventDefault();
		$('.thongbao').removeClass('hide-tbtt');
		let form = $(this);
		let duongdan_fix = duongdan+url_sub+'/user/client/checkc';
		let code = form.find('input[name="mxn"]').val();

		$.ajax({
			url: duongdan_fix,
			type: 'POST',
			dataType: 'JSON',
			data: {code: code},
			success: function (data) {
				$('.thongbao').addClass('hide-tbtt');
				if (!data.status) form.find('h5.popup').removeClass('bg-info').addClass('bg-danger').html(data.res);
				else {
					form.find('h5.popup').removeClass('bg-danger').addClass('bg-info').html(data.res);
					form.find('h3').text("MẬT KHẨU MỚI");
					form.find('button').text("Đổi Mật Khẩu");
					form.find('label').remove();
					form.find('input').remove();
					let html = `
						<label for="pass1">Nhập mật khẩu:</label>
                        <input type="password" name="pass1">
                        <label for="pass2">Nhập lại mật khẩu:</label>
                        <input type="password" name="pass2">
					`;
					$(html).insertAfter(form.find('h3'));
					form.attr('id', 'new-pw');
				}
			}
		});
	})
	$(document).on('submit', '#new-pw',function(event) {
		event.preventDefault();
		$('.thongbao').removeClass('hide-tbtt');
		let form = $(this);
		let duongdan_fix = duongdan+url_sub+'/user/client/newpw';
		let pass1 = form.find('input[name="pass1"]').val();
		let pass2 = form.find('input[name="pass2"]').val();

		console.log(pass1);
		console.log(pass2);

		$.ajax({
			url: duongdan_fix,
			type: 'POST',
			dataType: 'JSON',
			data: {pass1: pass1, pass2: pass2},
			success: function (data) {
				$('.thongbao').addClass('hide-tbtt');
				if (!data.status) form.find('h5.popup').removeClass('bg-info').addClass('bg-danger').html(data.res);
				else {
					form.find('h5.popup').removeClass('bg-danger').addClass('bg-info').html(data.res);
					form.find('h3').text("MẬT KHẨU MỚI");
					form.find('label').remove();
					form.find('input').remove();
					form.find('button').remove();
					setTimeout(() => { window.location.href = duongdan+url_sub }, 3000);
				}
			}
		});
	})
})