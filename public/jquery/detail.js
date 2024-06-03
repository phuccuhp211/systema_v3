$(function() {
	$(document).on('click', '.btn-stars', function() {
		$(this).addClass('select-star');
		$(this).siblings('.btn-stars.select-star').removeClass('select-star');
		let idsp = $(this).data('idsp');
		let star = $(this).data('rate');

		var duongdan_fix = duongdan+url_sub+"/rating";

		$.ajax({
			type: "POST",
			url: duongdan_fix,
			dataType: 'JSON',
			data: { idsp: idsp, rate: star },
			success: function(data) {
				
			},
			error: function() {
				console.log("Có lỗi xảy ra.");
			}
		});
	})

	var stt_ml = 0;
	var cc_tt = 0;
	
	if ($('.ttct-sp').height() > 499 ) {
		cc_tt = $('.ttct-sp').height();
		$('.ttct-sp').height(500);
	}
	else {
		$('.more-less').remove();
	}

	$('.more-less').on('click', function() {
		if (stt_ml == 0 ) {
			$('.ttct-sp').height(cc_tt);
			stt_ml = 1;
			$('.more-less').text('Thu gọn');
		}
		else if (stt_ml == 1 ) {
			$('.ttct-sp').height(500);
			$('html, body').animate({scrollTop: $('.phan-tt-duoi').offset().top},500);
			stt_ml = 0;
			$('.more-less').text('Xem thêm');
		}
	})

	$('.send-cmt').on('submit', function(event) {
		event.preventDefault();
		let ufn = document.getElementById('ufn').innerHTML;
		let uln = document.getElementById('uln').innerHTML;
		let uid = document.getElementById('uid').innerHTML;
		let idp = $('#uidsp').data('idsp');
		let ctn = $('#noidung-cmt').val();

		let d = new Date();
		let time = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate();

		let duongdan_fix = duongdan+url_sub+"/comment";

		$.ajax({
			type: "POST",
			url: duongdan_fix,
			data: {
				cmt: ctn,
				idp: idp,
				uid: uid,
				date: time
			},
			success: function(response) {
				let binhluan = `
				<div class="box-cmt">
	                <div class="avatar">
	                    <h5 class="avt-text">${ufn.charAt(0)}</h5>
	                </div>
	                <div class="user-cmt">
	                    <p class="uname-cmt">${ufn} ${uln}</p>
	                    <p class="date-cmt">${d.getDate() + "-" + (d.getMonth()+1) + "-" + d.getFullYear()}</p>
	                </div>
	                <div class="content-cmt">
		                <p>${ctn}</p>
		            </div>
		        </div>
				`;

				$('.list-cmt').prepend(binhluan);
			},
			error: function() {
				console.log("Có lỗi xảy ra khi comments.");
			}
		})
	})
})