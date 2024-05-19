$(function() {
	var ccmh = $(window).height();
	var cdmh = $(window).width();
	//var duongdan = window.location.href;
	var duongdan = window.location.origin;
	var url_sub = ""; 
	//var duongdan_fix = duongdan.replace(/(\/systema\/).*/, "$1"+"ktbh/");

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
	console.log(ccmh , cdmh);

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
		var id_sp_cmt = $(this).data('idbl');
		var duongdan_fix = duongdan+url_sub+"/inf_cmt/";
		$.ajax({
			type: "POST",
			url: duongdan_fix,
			data: { spcmt: id_sp_cmt },
			success: function(data) {
				show_cmt(data);
				data = "";
			},
			error: function() {
				console.log("Có lỗi xảy ra khi lấy DSBL.");
			}
		})
		console.log(id_sp_cmt);
		$('.bg-inf').removeClass('hide-bg-inf');
	})
/*-------------------- BACK --------------------*/

	var id_bn_fix = 0;
	var id_bn_del = 0;
	var id_bc_fix = 0;
	var id_bc_del = 0;
	var id_sp_fix = 0;
	var id_sp_del = 0;
	var id_dm_fix = 0;
	var id_dm_del = 0;
	var id_pl_fix = 0;
	var id_pl_del = 0;
	var id_us_fix = 0;
	var id_us_del = 0;
	var id_bl_del = 0;
	var id_gg_fix = 0;
	var id_gg_del = 0;

	$(document).on('click', '.suabn', function() {
		id_bn_fix = $(this).data('idbn');
		var duongdan_fix = duongdan+url_sub+"/bnn/fix/"+id_bn_fix+"/";
		var ae_td = $(this).parent().siblings("td:has(img)");
		var old_title = $(this).parent().siblings("#titbn").text();
		var old_text = $(this).parent().siblings("#txtbn").text();
		var old_img = ae_td.find("img").attr("src");

		$('#fix_tt_bn').val(old_title);
		$('#fix_tx_bn').val(old_text);
		$('#fix_img_bn').val(old_img);


		$('#form_fix_bn').attr("action", duongdan_fix);
	})
	$(document).on('click', '.xoabn', function() {
		id_bn_del = $(this).data('idbn');
		var duongdan_del = duongdan+url_sub+"/bnn/del/"+id_bn_del+"/";
		$('#acp-del').attr("href", duongdan_del);
	})
	$(document).on('click', '.suabc', function() {
		id_bc_fix = $(this).data('idbc');
		var duongdan_fix = duongdan+url_sub+"/lay/fix/"+id_bc_fix+"/";
		var ae_td1 = $(this).parent().siblings("#posbc");
		var ae_td2 = $(this).parent().siblings("#bgrbc");

		var old_ten = $(this).parent().siblings("#tenbc").text();
		var old_pos = ae_td1.find("img").attr("src");
		var old_bgr = ae_td2.find("img").attr("src");
		var old_typ = $(this).parent().siblings("#plbc").text();
		var old_cat = $("#catbc").text();
		var old_ref = $(this).parent().siblings("#refbc").text();
		var old_ord = $("#ordbc").text();
		var old_ido = $(this).parent().siblings("#idobc").text();

		console.log(old_pos);
		console.log(old_bgr);

		$('#fix_name_bc').val(old_ten);
		$('#fix_num_bc').val(old_ido);
		$('#fix_pos_bc').val(old_pos);
		$('#fix_bgr_bc').val(old_bgr);
		$(`#fix_pl_bc option[value=${old_typ}]`).prop("selected", true);
		$(`#fix_dm_bc option[value=${old_cat}]`).prop("selected", true);
		$(`#fix_ord_bc option[value=${old_ord}]`).prop("selected", true);
		$(`#fix_ref_bc option[value=${old_ref}]`).prop("selected", true);

		$('#form_fix_bc').attr("action", duongdan_fix);
	})
	$(document).on('click', '.xoabc', function() {
		id_bc_del = $(this).data('idbc');
		var duongdan_del = duongdan+url_sub+"/lay/del/"+id_bc_del+"/";
		$('#acp-del').attr("href", duongdan_del);
		console.log(id_bc_del);
	})
	$(document).on('click', '.suasp', function() {
		id_sp_fix = $(this).data('idsp');
		var duongdan_fix = duongdan+url_sub+"/pro/fix/"+id_sp_fix+"/";
		var ae_td = $(this).parent().siblings("td:has(img)");

		var old_name = $(this).parent().siblings("#tensp").text();
		var old_info = $(this).parent().siblings("#in4sp").text();
		var old_price_str = $(this).parent().siblings("#giasp").text();
		var old_sale_str = $(this).parent().siblings("#salesp").text();
		var old_type = $(this).parent().siblings("#id_caplth").data('pl');
		var old_cata = $(this).parent().siblings("#id_caplth").data('ca');
		var old_brand = $(this).parent().siblings("#id_caplth").data('th');
		var old_img = ae_td.find("img").attr("src");

		var old_price = parseInt(old_price_str.replace(/\./g, '').replace('.', ''));
		var old_sale = parseInt(old_sale_str.replace(/\./g, '').replace('.', ''));

		$('#fix_img_sp').val(old_img);
		$('#fix_name_sp').val(old_name);
		$('#fix_price_sp').val(old_price);
		$('#fix_sale_sp').val(old_sale);
		$('#fix_info_sp').val(old_info);

		$(`#fix_pl_sp option[value=${old_type}]`).prop("selected", true);
		$(`#fix_catalog_sp option[value=${old_cata}]`).prop("selected", true);
		$(`#fix_brand_sp option[value=${old_brand}]`).prop("selected", true);

		$('#form_fix_pro').attr("action", duongdan_fix);
		console.log(old_price);
	})
	$(document).on('click', '.xoasp', function() {
		id_sp_del = $(this).data('idsp');
		var duongdan_del = duongdan+url_sub+"/pro/del/"+id_sp_del+"/";
		$('#acp-del').attr("href", duongdan_del);
		console.log(id_sp_del);
	})
	$(document).on('click', '.suadm', function() {
		id_dm_fix = $(this).data('iddm');
		var duongdan_fix = duongdan+url_sub+"/cat/fix/"+id_dm_fix+"/";
		var ae_td = $(this).parent().siblings("td:has(img)");
		var pldm = $(this).parent().siblings("#pldm").text();
		var old_name = $(this).parent().siblings("#tendm").text();
		var old_img = ae_td.find("img").attr("src");

		$('#fix_img_dm').val(old_img);
		$('#fix_name_dm').val(old_name);
		$('#fix_name_pldm').val(pldm);
		$('#fix_name_pl').val("");

		$('#form_fix_cat').attr("action", duongdan_fix);
	})
	$(document).on('click', '.xoadm', function() {
		id_dm_del = $(this).data('iddm');
		var duongdan_del = duongdan+url_sub+"/cat/del/"+id_dm_del+"/";
		$('#acp-del').attr("href", duongdan_del);
		console.log(id_sp_del);
	})
	$(document).on('click', '.suapl', function() {
		id_pl_fix = $(this).data('idpl');
		var duongdan_fix = duongdan+url_sub+"/top/fix/"+id_pl_fix+"/";

		var old_name = $(this).parent().siblings("#tenpl").text();

		$('#fix_name_pl').val(old_name);
		$('#fix_name_pldm').val("");
		$('#fix_name_dm').val("");

		$('#form_fix_pl').attr("action", duongdan_fix);
	})
	$(document).on('click', '.xoapl', function() {
		id_pl_del = $(this).data('idpl');
		var duongdan_del = duongdan+url_sub+"/top/del/"+id_pl_del+"/";
		$('#acp-del').attr("href", duongdan_del);
		console.log(id_sp_del);
	})
	$(document).on('click', '.suaus', function() {
		id_us_fix = $(this).data('idus');
		var duongdan_fix = duongdan+url_sub+"/unc/fix/"+id_us_fix+"/";

		var old_name = $(this).parent().siblings("#tenus").text();
		var old_ho = $(this).parent().siblings("#htus").data('ho');
		var old_ten = $(this).parent().siblings("#htus").data('ten');
		var old_sdt = $(this).parent().siblings("#sdtus").text();
		var old_email = $(this).parent().siblings("#emailus").text();
		var old_role = $(this).parent().siblings("#roleus").text();

		$('#name_fix_us').val(old_name);
		$('#phone_fix_us').val(old_sdt);
		$('#email_fix_us').val(old_email);
		$('#ho_fix_us').val(old_ho);
		$('#ten_fix_us').val(old_ten);

		if(old_role == 0) {
			$("#role_fix_us option[value='0']").prop("selected", true);
		}
		if(old_role == 1) {
			$("#role_fix_us option[value='1']").prop("selected", true);
		}


		$('#form_fix_us').attr("action", duongdan_fix);
	})
	$(document).on('click', '.xoaus', function() {
		id_us_del = $(this).data('idus');
		var duongdan_del = duongdan+url_sub+"/unc/del/"+id_us_del+"/";
		$('#acp-del').attr("href", duongdan_del);
		console.log(id_sp_del);
	})
	$(document).on('click', '.suagg', function() {
		id_gg_fix = $(this).data('idgg');
		var duongdan_fix = duongdan+url_sub+"/dis/fix/"+id_gg_fix+"/";

		var old_ten = $(this).parent().siblings("#tengg").text();
		var old_max = $(this).parent().siblings("#maxgg").text();
		var old_fgg = $(this).parent().siblings("#fdgg").text();
		var old_tgg = $(this).parent().siblings("#tdgg").text();
		var old_ptg = $(this).parent().siblings("#ptgg").text();

		$('#fix_name_gg').val(old_ten);
		$('#soluong').val(old_max);
		$('#fix_fd_gg').val(old_fgg);
		$('#fix_td_gg').val(old_tgg);
		$('#fix_pt_gg').val(old_ptg);

		$('#form_fix_gg').attr("action", duongdan_fix);
	})
	$(document).on('click', '.xoagg', function() {
		id_gg_del = $(this).data('idgg');
		var duongdan_del = duongdan+url_sub+"/dis/del/"+id_gg_del+"/";
		$('#acp-del').attr("href", duongdan_del);
		console.log(id_sp_del);
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

		var idtk = $(this).data('idus');
		var duongdan_fix = duongdan+url_sub+"/adbl/";
		$.ajax({
			type: "POST",
			url: duongdan_fix,
			data: { idtk: idtk, data: "taikhoan" },
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

		var idsp = $(this).data('idsp');
		var duongdan_fix = duongdan+url_sub+"/adbl/";
		$.ajax({
			type: "POST",
			url: duongdan_fix,
			data: { idsp: idsp, data: "sanpham" },
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
		var trangthai = $(this).siblings("select").val();
		var id = $(this).parent().siblings(".id-hd").text();
		var duongdan_fix = duongdan+url_sub+"/adbl/";

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
		var boloc = $(this).attr("boloc");
		var data_bl = $(this).attr("data");
		var duongdan_fix = duongdan+url_sub+"/adbl/";
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
		id_bl_del = $(this).data('idbl');
		var duongdan_del = duongdan+url_sub+"/delbl/"+id_bl_del+"/";
		$('#acp-del').attr("href", duongdan_del);
		console.log(id_sp_del);
	})
	/*-------------------- BACK --------------------*/
	

	function show_cmt(data) {
		var dulieu = JSON.parse(data);
		var noidung = "";
		$(".tr-bl").remove();
		for (var i = 0; i < dulieu.length; i++) {
			noidung += `
			<tr class="tr-bl">
				<td>${dulieu[i].noidung}</td>
				<td>${dulieu[i].id_user}</td>
				<td>${dulieu[i].date}</td>
				<td><button class="btn btn-danger suaxoa xoabl" data-idbl="${dulieu[i].id_cmt}"><i class="fa-solid fa-trash"></i></button></td>
			</tr>
			`;
		}
		$('#list-bl-start').append(noidung);
	}

	if($("#bieudo").length > 0) {
	    var qweqwe = document.getElementsByClassName("dsdm-ten");
		var xArray = [];
		var yArray = [];
		for (var i = 0; i < qweqwe.length; i++) {
			xArray[i] = qweqwe[i].innerHTML;
			yArray[i] = $(qweqwe[i]).data('soluong');
		}
		var layout = {title:"Thống kê các loại sản phẩm"};
		var data = [{labels:xArray, values:yArray, type:"pie"}];
		Plotly.newPlot("bieudo", data, layout);
	}	
})