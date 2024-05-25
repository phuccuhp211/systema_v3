$(function() {
	$(document).on('click', '.btn-stars', function() {
		$(this).addClass('select-star');
		$(this).siblings('.btn-stars.select-star').removeClass('select-star');
		let idsp = $(this).data('idsp');
		let star = $(this).data('rate');

		var duongdan_fix = duongdan+url_sub+"/rating/";

		$.ajax({
			type: "POST",
			url: duongdan_fix,
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
		var ho = document.getElementById("uho").innerHTML;
		var ten = document.getElementById("uten").innerHTML;
		var idu = document.getElementById("uid").innerHTML;
		var idsp = $('#uidsp').data('idsp');
		var nd = $('#noidung-cmt').val();

		var d = new Date();
		var time = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate();

		console.log(time);

		var duongdan_fix = duongdan+url_sub+"/comments/";

		$.ajax({
			type: "POST",
			url: duongdan_fix,
			data: {
				noidung: nd,
				idpd: idsp,
				idu: idu,
				date: time
			},
			success: function(response) {
				console.log('thanh cong');
			},
			error: function() {
				console.log("Có lỗi xảy ra khi comments.");
			}
		})

		binhluan = `
		<div class="box-cmt">
            <div class="row" style="margin:0;">
                <div class="avatar">
                    <h5 class="avt-text">${ten.charAt(0)}</h5>
                </div>
                <div class="user-cmt">
                    <p class="uname-cmt">${ho} ${ten}</p>
                    <p class="date-cmt">${d.getDate() + "-" + (d.getMonth()+1) + "-" + d.getFullYear()}</p>
                </div>
            </div>
            <div class="content-cmt">
                <p>${nd}</p>
            </div>
        </div><hr>
		`;

		$('.list-cmt').prepend(binhluan);
	})

	$('#sp-tt').on('click', '.addcart', function() {
		ttgh();
		var idsp = $(this).data('idsp');
		var sl = $('.ctsp-sl').val();
		console.log(idsp);
		var duongdan_fix = duongdan+url_sub+"/addcart/";
		$.ajax({
			type: "POST",
			url: duongdan_fix,
			data: { idsp: idsp, slsp: sl },
			success: function(response) {
				console.log('thanh cong');
				updateCart();
			},
			error: function() {
				console.log("Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng.");
			}
		});
	})
	
	$('#sp-tt').on('click', '.buy', function(event) {
		event.preventDefault();
		var idsp = $(this).data('idsp');
		var sl = $('.ctsp-sl').val();

		var duongdan_fix1 = duongdan+url_sub+"/muangay/"+idsp+"/";
		var duongdan_fix2 = duongdan+url_sub+"/thanhtoan/";

		$.ajax({
			type: "POST",
			url: duongdan_fix1,
			data: { slsp: sl },
			success: function(response) {
				updateCart();
				window.location.href = duongdan_fix2;
			},
			error: function() {
				console.log("Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng.");
			}
		});
	})
})