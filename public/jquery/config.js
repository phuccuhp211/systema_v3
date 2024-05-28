$(function() {
	if ($('.box-qltk').length > 0) {
		let id = $('.cf-id').text();
		let old_fn = $('.old-fn').text();
		let old_ln = $('.old-ln').text();
		let old_pn = $('.old-pn').text();
		let old_em = $('.old-em').text();
		let old_ad = $('.old-ad').text();

		let fn_new=""; let ln_new=""; let pn_new=""; let em_new=""; let ad_new="";

		$('.cf_all').on('keyup', () => {
		    fn_new = $('.cf_fn').val();
		    ln_new = $('.cf_ln').val();
		    pn_new = $('.cf_pn').val();
		    em_new = $('.cf_em').val();
		    ad_new = $('.cf_ad').val();

		    if (fn_new == old_fn && ln_new == old_ln && pn_new == old_pn && em_new == old_em && ad_new == old_ad) $('.cf-update').addClass('disabled');
		    else $('.cf-update').removeClass('disabled');
		})

		let duongdan_fix = duongdan+url_sub+"/user/client/config";


		$('.cf-update').on('click',() => {
			$.ajax({
				type: "POST",
				url: duongdan_fix,
				dataType: 'JSON',
				data: {
					id: id, ad: ad_new,
					fn: fn_new, ln: ln_new,
					pn: pn_new, em: em_new,
				},
				success: (data) => {
					if (!data.status) $('.popup').removeClass('bg-info').addClass('bg-danger').html(data.res);
					else {
						$('.popup').removeClass('bg-danger').addClass('bg-info').html(data.res);
					}
				},
				error: () => {
					console.log("Có lỗi xảy ra khi update.");
				}
			})
		})
	}

	var cd_slide = $('.cf-slide').width();
	$('.box-qltk').width(cd_slide);
	$('.box-lsmh').width(cd_slide);

	$('.popup').on('click', () => { $('.popup').slideUp(1000); })

	var cr_slide = $('.box-qltk').height();
	$('.cf-slide').css({"height":cr_slide});

	$('.his-mh').on('click', () => {
		$(this).addClass('btn-hidden');
		$('.box-qltk').addClass('cf-left');
		$('.cf-acc').removeClass('btn-hidden');

		var cr_slide2 = $('.box-lsmh').height();
		$('.cf-slide').css({"height":"auto"});
	})
	$('.cf-acc').on('click', () => {
		$(this).addClass('btn-hidden');
		$('.box-qltk').removeClass('cf-left');
		$('.his-mh').removeClass('btn-hidden');

		var cr_slide2 = $('.box-qltk').height();
		$('.cf-slide').css({"height":cr_slide2});
	})
})