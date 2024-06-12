$(function() {
	const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': csrfToken
	    }
	});

	var ccmh = $(window).height();
	var cdmh = $(window).width();
	var duongdan = window.location.origin;
	var url_sub = ""; 

	tinymce.init({
        selector: '#ttct-sp',
        plugins: 'image link',
        toolbar: 'undo redo | bold italic | image link',
        height: '350px',
        image_caption: true
    });

	$(window).resize(function() {
		ccmh = $(window).height();
		cdmh = $(window).width();
	})

	$('.bg-admin-log').height(ccmh);

/*-------------------- BACK --------------------*/
	$(document).on('click', '.them', function() { $('.bg-add').removeClass('hide-bg-add'); })
	$(document).on('click', '.sua', function() { $('.bg-fix').removeClass('hide-bg-fix'); })
	$(document).on('click', '.xoa', function() { $('.bg-del').removeClass('hide-bg-del'); })
	$(document).on('click', '.qlai', function() { $('.bg-inf').addClass('hide-bg-inf'); })
	$(document).on('click', '.quaylai', function() {
		$('.bg-add').addClass('hide-bg-add');
		$('.bg-fix').addClass('hide-bg-fix');
		$('.bg-del').addClass('hide-bg-del');
		$('.bg-err').addClass('hide-bg-add-err');
	})
	$('.chitiet').on('click', function() {
		var id = $(this).data('id');
		var duongdan_fix = duongdan+url_sub+"/manager/cm/detail";
		$.ajax({
			type: "POST",
			url: duongdan_fix,
			data: { id: id },
			success: function(data) {
				show_cmt(data);
				data = "";
			},
			error: function() {
				console.log("Có lỗi xảy ra khi lấy DSBL.");
			}
		})
		console.log(id);
		$('.bg-inf').removeClass('hide-bg-inf');
	})
/*-------------------- BACK --------------------*/

	var id = 0;

	$(document).on('click', '.suabn', function() {
		id = $(this).data('id');
		let ae_td = $(this).parent().siblings("td:has(img)");
		let old_title = $(this).parent().siblings("#titbn").text();
		let old_text = $(this).parent().siblings("#txtbn").text();
		let old_img = ae_td.find("img").attr("src");

		$('#id_fix').val(id);
		$('#fix_tt_bn').val(old_title);
		$('#fix_tx_bn').val(old_text);
		$('#fix_img_bn').val(old_img);
	})
	$(document).on('click', '.xoabn', function() {
		id = $(this).data('id');
		let type = $(this).data('type');
		let duongdan_del = duongdan+url_sub+"/manager/"+type+"/del/"+id;
		$('#acp-del').attr("href", duongdan_del);
	})
	$(document).on('click', '.suabc', function() {
		id = $(this).data('id');
		let duongdan_fix = duongdan+url_sub+"/lay/fix/"+id+"/";
		let ae_td1 = $(this).parent().siblings("#posbc");
		let ae_td2 = $(this).parent().siblings("#bgrbc");

		let old_ten = $(this).parent().siblings("#tenbc").text();
		let old_pos = ae_td1.find("img").attr("src");
		let old_bgr = ae_td2.find("img").attr("src");
		let old_ref = $(this).parent().siblings("#refbc").text();
		let old_ord = $("#ordbc").text();
		let old_ido = $(this).parent().siblings("#idobc").text();

		$('#id_fix').val(id);
		$('#fix_name_bc').val(old_ten);
		$('#fix_num_bc').val(old_ido);
		$('#fix_pos_bc').val(old_pos);
		$('#fix_bgr_bc').val(old_bgr);
		$(`#fix_ord_bc option[value=${old_ord}]`).prop("selected", true);
		$(`#fix_ref_bc option[value=${old_ref}]`).prop("selected", true);
	})
	$(document).on('click', '.xoabc', function() {
		id = $(this).data('id');
		let type = $(this).data('type');
		let duongdan_del = duongdan+url_sub+"/manager/"+type+"/del/"+id;
		$('#acp-del').attr("href", duongdan_del);
		console.log(id);
	})
	$(document).on('click', '.suasp', function() {
		id = $(this).data('id');
		let ae_td = $(this).parent().siblings("td:has(img)");

		let old_name = $(this).parent().siblings("#tensp").text();
		let old_info = $(this).parent().siblings("#in4sp").text();
		let old_price_str = $(this).parent().siblings("#giasp").text();
		let old_sale_str = $(this).parent().siblings("#salesp").text();
		let old_type = $(this).parent().siblings("#id_caplth").data('pl');
		let old_cata = $(this).parent().siblings("#id_caplth").data('ca');
		let old_brand = $(this).parent().siblings("#id_caplth").data('th');
		let old_img = ae_td.find("img").attr("src");

		let old_price = parseInt(old_price_str.replace(/\./g, '').replace('.', ''));
		let old_sale = parseInt(old_sale_str.replace(/\./g, '').replace('.', ''));

		console.log(old_type);
		console.log(old_cata);
		console.log(old_brand);

		$('#id_fix').val(id);
		$('#fix_img_sp').val(old_img);
		$('#fix_name_sp').val(old_name);
		$('#fix_price_sp').val(old_price);
		$('#fix_sale_sp').val(old_sale);
		$('#fix_info_sp').val(old_info);

		if (old_type != '') $(`#fix_pl_sp option[value=${old_type}]`).prop("selected", true);
		if (old_cata != '') $(`#fix_catalog_sp option[value=${old_cata}]`).prop("selected", true);
		if (old_brand != '') $(`#fix_brand_sp option[value=${old_brand}]`).prop("selected", true);
	})
	$(document).on('click', '.xoasp', function() {
		id = $(this).data('id');
		let type = $(this).data('type');
		let duongdan_del = duongdan+url_sub+"/manager/"+type+"/del/"+id;
		$('#acp-del').attr("href", duongdan_del);
		console.log(id);
	})
	$(document).on('click', '.suadm', function() {
		id = $(this).data('id');
		let ae_td = $(this).parent().siblings("td:has(img)");
		let pldm = $(this).parent().siblings("#pldm").text();
		let old_name = $(this).parent().siblings("#tendm").text();
		let old_img = ae_td.find("img").attr("src");

		$('#id_fix').val(id);
		$('#fix_img_dm').val(old_img);
		$('#fix_name_dm').val(old_name);
		$('#fix_name_pldm').val(pldm);
		$('#fix_name_pl').val("");
	})
	$(document).on('click', '.xoadm', function() {
		id = $(this).data('id');
		let type = $(this).data('type');
		let duongdan_del = duongdan+url_sub+"/manager/"+type+"/del/"+id;
		$('#acp-del').attr("href", duongdan_del);
		console.log(id);
	})
	$(document).on('click', '.suapl', function() {
		id = $(this).data('id');

		let old_name = $(this).parent().siblings("#tenpl").text();

		$('#id_fix').val(id);
		$('#fix_name_pl').val(old_name);
		$('#fix_name_pldm').val("");
		$('#fix_name_dm').val("");
	})
	$(document).on('click', '.xoapl', function() {
		id = $(this).data('id');
		let type = $(this).data('type');
		let duongdan_del = duongdan+url_sub+"/manager/"+type+"/del/"+id;
		$('#acp-del').attr("href", duongdan_del);
		console.log(id);
	})
	$(document).on('click', '.suaus', function() {
		id = $(this).data('id');

		let old_name = $(this).parent().siblings("#tenus").text();
		let old_pass = $(this).parent().siblings("#pwus").text();
		let old_ho = $(this).parent().siblings("#htus").data('ho');
		let old_ten = $(this).parent().siblings("#htus").data('ten');
		let old_dc = $(this).parent().siblings("#htus").data('dc');
		let old_sdt = $(this).parent().siblings("#sdtus").text();
		let old_email = $(this).parent().siblings("#emailus").text();
		let old_role = $(this).parent().siblings("#roleus").text();

		$('#id_fix').val(id);
		$('#name_fix').val(old_name);
		$('#phone_fix').val(old_sdt);
		$('#email_fix').val(old_email);
		$('#ho_fix').val(old_ho);
		$('#ten_fix').val(old_ten);
		$('#dc_fix').val(old_ten);
		$('#pw_fix').val(old_pass);

		if(old_role == 0) {
			$("#role_fix_us option[value='0']").prop("selected", true);
		}
		if(old_role == 1) {
			$("#role_fix_us option[value='1']").prop("selected", true);
		}
	})
	$(document).on('click', '.xoaus', function() {
		id = $(this).data('id');
		let type = $(this).data('type');
		let duongdan_del = duongdan+url_sub+"/manager/"+type+"/del/"+id;
		$('#acp-del').attr("href", duongdan_del);
		console.log(id);
	})
	$(document).on('click', '.suagg', function() {
		id = $(this).data('id');
		let duongdan_fix = duongdan+url_sub+"/dis/fix/"+id+"/";

		let old_ten = $(this).parent().siblings("#tengg").text();
		let old_max = $(this).parent().siblings("#maxgg").text();
		let old_fgg = $(this).parent().siblings("#fdgg").text();
		let old_tgg = $(this).parent().siblings("#tdgg").text();
		let old_ptg = $(this).parent().siblings("#ptgg").data('discount');

		$('#id_fix').val(id);
		$('#fix_name_gg').val(old_ten);
		$('#soluong').val(old_max);
		$('#fix_fd_gg').val(old_fgg);
		$('#fix_td_gg').val(old_tgg);
		$('#fix_pt_gg').val(old_ptg);
	})
	$(document).on('click', '.xoagg', function() {
		id = $(this).data('id');
		let type = $(this).data('type');
		let duongdan_del = duongdan+url_sub+"/manager/"+type+"/del/"+id;
		$('#acp-del').attr("href", duongdan_del);
		console.log(id);
	})

	/*-------------------- BACK --------------------*/
	$(document).on('click', '.ban', function() {
		if ($(this).hasClass('banus')) {
			$(this).find("i").removeClass('fa-ban').addClass('fa-check');
			$(this).removeClass('btn-warning banus').addClass('btn-success unbanus');
			$('.popup-small').find("span").text("Đã Khóa Tài Khoản");
			$('.popup-small').find("i").removeClass('fa-check');
			if(!$('.popup-small').find("i").hasClass('fa-ban')) $('.popup-small').find("i").addClass('fa-ban');
		}
		else {
			$(this).find("i").removeClass('fa-check').addClass('fa-ban');
			$(this).removeClass('btn-success unbanus').addClass('btn-warning banus');
			$('.popup-small').find("span").text("Đã Mở Khóa Tài Khoản");
			$('.popup-small').find("i").removeClass('fa-ban');
			if(!$('.popup-small').find("i").hasClass('fa-check')) $('.popup-small').find("i").addClass('fa-check');
		}

		id = $(this).data('id');
		let hidden = $(this).data('lock');
		let duongdan_fix = duongdan+url_sub+"/manager/us/hid";
		$.ajax({
			type: "POST",
			url: duongdan_fix,
			data: { id: id, data: (hidden == 0) ? 1 : 0 },
			success: function(response) {
				console.log('thanh cong');
			},
			error: function() {
				console.log("Có lỗi xảy ra.");
			}
		});

		$('.popup-small').removeClass('hide-popup');
		setTimeout(function() {$('.popup-small').addClass('hide-popup');},1000);
	})
	$(document).on('click', '.hidden', function() {
		if ($(this).hasClass('hidsp')) {
			$(this).find("i").removeClass('fa-eye-slash').addClass('fa-eye');
			$(this).removeClass('btn-warning hidsp').addClass('btn-success unhidsp');
			$('.popup-small').find("span").text("Đã Ẩn Sản Phẩm");
			$('.popup-small').find("i").removeClass('fa-eye');
			if(!$('.popup-small').find("i").hasClass('fa-eye-slash')) $('.popup-small').find("i").addClass('fa-eye-slash');
		}
		else {
			$(this).find("i").removeClass('fa-eye').addClass('fa-eye-slash');
			$(this).removeClass('btn-success unhidsp').addClass('btn-warning hidsp');
			$('.popup-small').find("span").text("Đã Hiện Sản Phẩm");
			$('.popup-small').find("i").removeClass('fa-eye-slash');
			if(!$('.popup-small').find("i").hasClass('fa-eye')) $('.popup-small').find("i").addClass('fa-eye');
		}

		id = $(this).data('id');
		let hidden = $(this).data('hid');
		let duongdan_fix = duongdan+url_sub+"/manager/pd/hid";
		$.ajax({
			type: "POST",
			url: duongdan_fix,
			data: { id: id, data: (hidden == 0) ? 1 : 0 },
			success: function(response) {
				console.log('thanh cong');
			},
			error: function() {
				console.log("Có lỗi xảy ra.");
			}
		});

		$('.popup-small').removeClass('hide-popup');
		setTimeout(function() {$('.popup-small').addClass('hide-popup');},1000);
	})
	$(document).on('click', '.hd-update', function() {
		let trangthai = $(this).siblings("select").val();
		id = $(this).parent().siblings(".id-hd").text();
		let duongdan_fix = duongdan+url_sub+"/adbl/";

		$(this).parent().siblings(".stt-hd").text(trangthai);
		console.log(trangthai+" "+id);
		$.ajax({
			type: "POST",
			url: duongdan_fix,
			data: {id: id, stt: trangthai, data: "hoadon"},
			success: function(response) {

			},
			error: function() {

			}
		});
	})
	$('.boloc').on('click', '.btn-boloc', function() {
		let boloc = $(this).attr("boloc");
		let data_bl = $(this).attr("data");
		let duongdan_fix = duongdan+url_sub+"/adbl/";
		$.ajax({
			type: "POST",
			url: duongdan_fix,
			data: {boloc: boloc, data: data_bl},
			success: function(data) {
				$('.show-data').find('.'+data_bl).remove();
				$('.show-data').append(data);
			},
			error: function() {
				console.log("Có lỗi xảy ra");
			}
		});
	})
	$(document).on('click', '.xoabl', function() {
		$('.bg-del').removeClass('hide-bg-del');
		id = $(this).data('id');
		let type = $(this).data('type');
		let duongdan_del = duongdan+url_sub+"/manager/"+type+"/del/"+id;
		$('#acp-del').attr("href", duongdan_del);
		console.log(id);
	})
	/*-------------------- BACK --------------------*/
	

	function show_cmt(data) {
		let dulieu = data;
		let noidung = "";
		$(".tr-bl").remove();
		for (var i = 0; i < dulieu.length; i++) {
			noidung += `
			<tr class="tr-bl">
				<td>${dulieu[i].content}</td>
				<td>${dulieu[i].id_us}</td>
				<td>${dulieu[i].date}</td>
				<td><button class="btn btn-danger suaxoa xoabl" data-id="${dulieu[i].id}" data-type="cm"><i class="fa-solid fa-trash"></i></button></td>
			</tr>
			`;
		}
		$('#list-bl-start').append(noidung);
	}

	if($("#bieudo").length > 0) {
	    let qweqwe = document.getElementsByClassName("dsdm-ten");
		let xArray = [];
		let yArray = [];
		for (var i = 0; i < qweqwe.length; i++) {
			xArray[i] = qweqwe[i].innerHTML;
			yArray[i] = $(qweqwe[i]).data('soluong');
		}
		let layout = {title:"Thống kê các loại sản phẩm"};
		let data = [{labels:xArray, values:yArray, type:"pie"}];
		Plotly.newPlot("bieudo", data, layout);
	}	

	$(document).on('submit', '.log-f', function(event) {
		event.preventDefault();
		let form = $(this);
		let user = form.find('input[name="user"]').val();
		let pass = form.find('input[name="pass"]').val();
		let duongdan_fix = form.attr('action');

		$.ajax({
			url: duongdan_fix,
			type: 'POST',
			dataType: 'JSON',
			data: { user: user, pass: pass },
			success: function (data) {
				if (data.status) setTimeout(() => { location.href = data.res }, 1000);
				else $('.errlog').text(data.res);
			}
		});
	})

	$(document).on('submit', '.admin-add', function(event) {
	    event.preventDefault();
	    let form = $(this)[0];
	    let url = $(this).attr('action');
	    let formData = new FormData(form);

	    $.ajax({
	        url: url,
	        type: 'POST',
	        dataType: 'JSON',
	        data: formData,
	        contentType: false,
	        processData: false,
	        success: function(data) {
	            console.log(data);
	            if (!data.status) {
	                $('.bg-err').removeClass('hide-bg-add-err');
	                $('.bg-err').find('div').html('<ul>' + data.res + '</ul>');
	                setTimeout(function() { $('.bg-err').addClass('hide-bg-add-err') }, 5000);
	            } else {
	                $('.bg-err').removeClass('hide-bg-add-err');
	                $('.bg-err').find('div').html(data.res);
	                setTimeout(function() { location.reload(); }, 3000);
	            }
	        },
	        error: function(xhr, status, error) {
	            console.log(xhr.responseText);
	        }
	    });
	});



	$(document).on('submit', '.admin-fix', function(event) {
		event.preventDefault();
		let form = $(this)[0];
		let url = $(this).attr('action');
		let formData = new FormData(form);

		$.ajax({
	        url: url,
	        type: 'POST',
	        dataType: 'JSON',
	        data: formData,
	        contentType: false,
	        processData: false,
	        success: function(data) {
	            console.log(data);
	            if (!data.status) {
	                $('.bg-err').removeClass('hide-bg-add-err');
	                $('.bg-err').find('div').html('<ul>' + data.res + '</ul>');
	                setTimeout(function() { $('.bg-err').addClass('hide-bg-add-err') }, 5000);
	            } else {
	                $('.bg-err').removeClass('hide-bg-add-err');
	                $('.bg-err').find('div').html(data.res);
	                setTimeout(function() { location.reload(); }, 3000);
	            }
	        },
	        error: function(xhr, status, error) {
	            console.log(xhr.responseText);
	        }
	    });
	});
})