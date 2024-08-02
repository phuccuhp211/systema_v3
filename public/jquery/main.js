var chieucao=0;
var chieucao_cu = 0;
var duongdan = window.location.origin;
var url_sub = "";

$(document).ready(function () {
  	$('#carousel-id').carousel();
  	if ($('.popup-cart').data("user") == "yes" && $('.popup-cart').data("cart") == "yes") {
		$('.popup-cart').removeClass('off-pocart');
		setTimeout(function() {
			$('.popup-cart').addClass('off-pocart');
		}, 5000);
	}
});

function ttgh() {
	$('.ttgh').removeClass('ttgh-hide');
	setTimeout(function() { $('.ttgh').addClass('ttgh-hide') }, 750);
}

function reset_cc() {
	$(".tensp").each(function() {
		chieucao = $(this).height();
		if (chieucao > chieucao_cu) {
		  chieucao_cu = chieucao;
		}
	});
	$(".tensp").height(chieucao_cu);
}

$(function() {
	const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': csrfToken
	    }
	});
	
	reset_cc();

	var cc_gia_sp = $('.giasp').height();
	$('.giasp').find("span").css({"line-height":cc_gia_sp+"px"});

	$(".tensp").height(chieucao_cu);

	$('.users').on('click', function() {$('.bg-dndk').removeClass('hide-bg-dndk');})
	$('.ycdn-cmt').on('click', function() {$('.bg-dndk').removeClass('hide-bg-dndk');})
	$('.quaylai-dndk').on('click', function() {$('.bg-dndk').addClass('hide-bg-dndk');})
	$('.users2').on('click', function() {$('.bg-dndk2').removeClass('hide-bg-dndk2');})
	$('.quaylai-dndk2').on('click', function() {$('.bg-dndk2').addClass('hide-bg-dndk2');})

	/* Chịu trách nhiệm về giỏ hàng*/
	$(document).on('click', '.addcart', function() {
		ttgh();
		let idsp = $(this).data('idsp');
		let duongdan_fix = duongdan+url_sub+"/cart/add";
		$.ajax({
			type: "POST",
			url: duongdan_fix,
			data: { id: idsp },
			success: function(data) {
				console.log('thanh cong');
			},
			error: function() {
				console.log("Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng.");
			}
		});
	})
	/* --------------------------- */


	/* Chịu trách nhiệm xử lý menu & list DM*/
	var h_mnc2 = $('.menu-cap2').height();
	$('.menu-cap3').css({"min-height":h_mnc2});
	var w_mnc2 = $('.menu-cap2').width();
	$('.menu-cap3').css({"min-width":w_mnc2});

	$("#show-dmsp").on('mouseover', function() {
		$(this).css({"background":"#392b5c","padding":"18px 25px","margin":"0"});
		$('.menu-cap2').addClass('show-mnmn');
	})
	$("#show-dmsp").on('mouseout', function() {
		$(this).css({"background":"#6246A8","padding":"8px 15px","margin":"10px"});
		$('.menu-cap2').removeClass('show-mnmn');
	})
	$(".menu-cap2").on('mouseover', function() {
		$('.menu-cap2').addClass('show-mnmn');
		$('#show-dmsp').css({"background":"#392b5c","color":"white","padding":"18px 25px","margin":"0"});
	})
	$(".menu-cap2").on('mouseout', function() {
		$('.menu-cap2').removeClass('show-mnmn');
		$('#show-dmsp').css({"background":"#6246A8","color":"white","padding":"8px 15px","margin":"10px"});
	})
	$(".menu-cap3").on('mouseover', function() {
		$(this).siblings("li").find('a').addClass('a-mnmn-hv');
		$('.menu-cap2').addClass('show-mnmn');
		$('#show-dmsp').css({"background":"#392b5c","color":"white","padding":"18px 25px","margin":"0"});
	})
	$(".menu-cap3").on('mouseout', function() {
		$(this).siblings("li").find('a').removeClass('a-mnmn-hv');
		$('.menu-cap2').removeClass('show-mnmn');
		$('#show-dmsp').css({"background":"#6246A8","color":"white","padding":"8px 15px","margin":"10px"});
	})
	$(".li-mnmn").on('mouseover', function() {
		$(this).find("a").addClass('a-mnmn-hv');
	})
	$(".li-mnmn").on('mouseout', function() {
		$(this).find("a").removeClass('a-mnmn-hv');
	})
	$(".show-list-btn").on('click', function() {
	    var listCap2 = $(this).siblings(".list-cap2");
	    if (listCap2.is(":visible")) {
	        listCap2.slideUp(400,'linear');
	        $(this).text("+");
	    } else {
	        listCap2.slideDown(400,'linear');
	        $(this).text("-");
	    }
	});
	/* -------------------------- */

	$('.search-result').width($('.menu-khungtk').width());

	$('.search-box').on('keyup', function() {
		var dulieu = $(this).val();

		if (dulieu.length > 0) {
			var randomParam = Math.random().toString(36).substring(7);
			var data_type = $(this).attr("data-type");
			var duongdan_fix = duongdan+url_sub+"/products/search";

			var format_prc = new Intl.NumberFormat('vi-VN', {
			  style: 'currency',
			  currency: 'VND'
			});

			var data_trave = {
				xacthuc2: randomParam,
				type: data_type,
				search_data: dulieu,
		        limit: 5
			};

			$.ajax({
				type: "POST",
				url: duongdan_fix,
				dataType: "JSON",
				data: data_trave,
				success: function(data) {
					var dssp = "";
					$.each(data.res, function(index, val) {
						dssp += `
							<a href="${duongdan+url_sub+'/detail/'+val.id+'/'}" class="srs">
								<div class="srs-img">
	                                <img src="${duongdan+url_sub+'/data/'+val.img}" alt="">
	                            </div>
	                            <div class="srs-in4">
	                                <p class="p-srs srs-name">${val.name}</p>
	                                <p class="p-srs srs-price">${ val.sale > 0 ? format_prc.format(val.sale) : format_prc.format(val.price)}</p>
	                            </div>
                            </a><hr>
						`;
					});
					$('.search-result').html(dssp);
				},
				error: function() {

				}

			})
		}
		else $('.search-result').html('');	
	})

	$(document).on('submit', '.client_login', function(event) {
		event.preventDefault();
		let form = $(this);
		let user = form.find('input[name="acc"]').val();
		let pass = form.find('input[name="pass"]').val();
		let randomParam = Math.random().toString(36).substring(7);

		let duongdan_fix = duongdan+url_sub+'/user/client/login';

		let data_trave = {
			xacthuc2: randomParam,
			user: user,
			pass: pass
		};	

		$.ajax({
			url: duongdan_fix,
			type: 'POST',
			dataType: 'JSON',
			data: data_trave,
			success: function (data) {
				console.log(data);
				if (data.status != true) form.find('h4.sisu-err').text(data.res);
				else window.location.reload();
			},
			error: function(xhr, status) { 
				console.log(xhr);
				console.log(status);
			}
		});
	})

	$(document).on('submit', '.client_regis', function(event) {
		event.preventDefault();
		let form = $(this);
		let user = form.find('input[name="acc"]').val();
		let pass1 = form.find('input[name="pass1"]').val();
		let pass2 = form.find('input[name="pass2"]').val();
		let fname = form.find('input[name="fname"]').val();
		let lname = form.find('input[name="lname"]').val();
		let email = form.find('input[name="email"]').val();
		let phone = form.find('input[name="phone"]').val();
		let addr = form.find('input[name="addr"]').val();

		let randomParam = Math.random().toString(36).substring(7);

		let duongdan_fix = duongdan+url_sub+'/user/client/regis';

		let data_trave = {
			xacthuc2: randomParam,
			user: user, addr: addr,
			pass1: pass1, pass2: pass2,
			lname: lname, fname: fname,
			email: email, phone: phone
		};	

		$.ajax({
			url: duongdan_fix,
			type: 'POST',
			dataType: 'JSON',
			data: data_trave,
			success: function (data) {
				if (data.status != true) form.find('h4.sisu-err').text(data.res);
				else {
					console.log('xong');
					form.find('h4.sisu-err').removeClass('bg-danger').addClass('bg-info');
					form.find('h4.sisu-err').html(`Tạo tài khoản thành công <br> trang web sẽ tự động tải lại!`);
					setTimeout(() => {
						window.location.reload();
					}, 5000);
				}
			},
			error: function() {

			}
		});
	})
})