var chieucao=0;
var chieucao_cu = 0;
var duongdan = window.location.origin;
var url_sub = "";

$(document).ready(function () {
  $('#carousel-id').carousel();
  	if ($('.popup-cart').data("user") == "yes") {
		$('.popup-cart').removeClass('off-pocart');
		setTimeout(function() {
			$('.popup-cart').addClass('off-pocart');
		}, 5000);
	}
});

function reset_cc() {
	$(".tensp").each(function() {
		chieucao = $(this).height();
		if (chieucao > chieucao_cu) {
		  chieucao_cu = chieucao;
		}
	});
	$(".tensp").height(chieucao_cu);
}

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': csrfToken
    }
});

function updateCart() {
	var totalp = updateTT();
	var duongdan_fix = duongdan+url_sub+"/updatecart/";
	$.ajax({
		type: "POST",
		url: duongdan_fix,
		data: { totalp: totalp },
		success: function(response) {
			console.log("thanh cong");
		},
		error: function() {
			console.log("Có lỗi xảy ra.");
		}
	});
}
function updateTT() {
	var totalPrice = 0;
	for (var l=0; l<full_sldssp.length; l++) {
        var itemPrice = parseInt($(full_sldssp[l]).find('#thanhtien').text().replace(/\./g, ''));
        totalPrice += itemPrice;
	}
	$('#ttfn').text(totalPrice.toLocaleString('vi-VN'));
	return totalPrice;
}
function ttgh() {
	$('.ttgh').removeClass('ttgh-hide');
	setTimeout(function() {
    	$('.ttgh').addClass('ttgh-hide');
  	}, 750);
}

$(function() {
	reset_cc();

	var cc_gia_sp = $('.giasp').height();
	$('.giasp').find("span").css({"line-height":cc_gia_sp+"px"});

	$(".tensp").height(chieucao_cu);

	$('.users').on('click', function() {$('.bg-dndk').removeClass('hide-bg-dndk');})
	$('.cf-dmk').on('click', function() {$('.bg-dmk').removeClass('hide-bg-dmk');})
	$('.ycdn-cmt').on('click', function() {$('.bg-dndk').removeClass('hide-bg-dndk');})
	$('.quaylai-dndk').on('click', function() {$('.bg-dndk').addClass('hide-bg-dndk');})
	$('.quaylai-dndk').on('click', function() {$('.bg-dndk-err').addClass('hide-bg-dndk-err');})
	$('.quaylai-dmk').on('click', function() {$('.bg-dmk').addClass('hide-bg-dmk');})
	$('.users2').on('click', function() {$('.bg-dndk2').removeClass('hide-bg-dndk2');})
	$('.quaylai-dndk2').on('click', function() {$('.bg-dndk2').addClass('hide-bg-dndk2');})

	/* Chịu trách nhiệm về giỏ hàng*/
	$('#list-sanpham').on('click', '.addcart', function() {
		ttgh();
		var idsp = $(this).data('idsp');
		console.log(idsp);
		var duongdan_fix = duongdan+url_sub+"/addcart/";
		$.ajax({
			type: "POST",
			url: duongdan_fix,
			data: { idsp: idsp },
			success: function(response) {
				console.log('thanh cong');
				updateCart();
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
							<a href="${duongdan+url_sub+'/products/detail/'+val.id+'/'}" class="srs">
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
	
	$('.popup').on('click', function() {
		$('.popup').slideUp(1000);
	})
})