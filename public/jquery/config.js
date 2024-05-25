$(function() {
	if ($('.box-qltk').length > 0) {
		var id = $('.cf-id').text();
		var old_ho = $('.cf-ho').text();
		var old_ten = $('.cf-ten').text();
		var old_sdt = $('.cf-sdt').text();
		var old_email = $('.cf-mail').text();
		var old_dc = $('.cf-dc').text();
		var check_on = 0;

		var ho_new=""; var ten_new=""; var sdt_new=""; var email_new=""; var dc_new="";

		$('.config_all').on('keyup', function() {
		    ho_new = $('.config_ho').val();
		    ten_new = $('.config_ten').val();
		    sdt_new = $('.config_sdt').val();
		    email_new = $('.config_mail').val();
		    dc_new = $('.config_diachi').val();
		    checkChanges();
		})

		function checkChanges() {
		    if (ho_new == old_ho && ten_new == old_ten && sdt_new == old_sdt && email_new == old_email && dc_new == old_dc) $('.cf-update').addClass('disabled');
		    else $('.cf-update').removeClass('disabled');
		}

		var duongdan_fix = duongdan+url_sub+"/config/";

		$('.cf-update').on('click',function() {
			$.ajax({
				type: "POST",
				url: duongdan_fix,
				data: {
					id: id,
					ho: ho_new,
					ten: ten_new,
					sdt: sdt_new,
					email: email_new,
					diachi: dc_new
				},
				success: function(response) {
					console.log('thanh cong');
					window.location.href = duongdan_fix;
				},
				error: function() {
					console.log("Có lỗi xảy ra khi update.");
				}
			})
		})
	}

	var cd_slide = $('.cf-slide').width();
	$('.box-qltk').width(cd_slide);
	$('.box-lsmh').width(cd_slide);

	var cr_slide = $('.box-qltk').height();
	$('.cf-slide').css({"height":cr_slide});

	$('.his-mh').on('click', function() {
		$(this).addClass('btn-hidden');
		$('.box-qltk').addClass('cf-left');
		$('.cf-acc').removeClass('btn-hidden');

		var cr_slide2 = $('.box-lsmh').height();
		$('.cf-slide').css({"height":"auto"});
	})
	$('.cf-acc').on('click', function() {
		$(this).addClass('btn-hidden');
		$('.box-qltk').removeClass('cf-left');
		$('.his-mh').removeClass('btn-hidden');

		var cr_slide2 = $('.box-qltk').height();
		$('.cf-slide').css({"height":cr_slide2});
	})
})