$(function() {
	$(document).on('keyup', '.ftp', function() {
		$(this).val($(this).val().replace(/[^0-9]/g, ''));
	})
	$('.boloc-act').on('change', function() {
		let randomParam = Math.random().toString(36).substring(7);
		let data_type = $(this).attr("data-type");
		let dulieu = $(this).attr("data");
		let phanloai = $(this).val();

		let filters2 = {};
		let brand = $('#brand').val();
		let fp = $('#from-p').val();
		let tp = $('#to-p').val();

		filters2.brand = brand;
	    filters2.from = fp;
	    filters2.to = tp;

		let duongdan_fix = duongdan+url_sub+`/${data_type}${dulieu ? `/${dulieu}` : ''}`;
		let data_trave = {
			xacthuc2: randomParam,
	        type: data_type,
	        filters1: phanloai,
	        filters2: filters2
		};

		if (dulieu) data_trave.data = dulieu;

		$.ajax({
	        type: "POST",
			url: duongdan_fix,
			dataType: "JSON",
			data: data_trave,
	        success: function(data) {
	            $('#list-sanpham').html(data.res.prods);
	            $('#list-pt').html(data.res.pagin);
	            reset_cc();
	        },
	        error: function() {
	            console.log("Có lỗi xảy ra.");
	        }
	    });
	})
	$('.filter').on('click', function() {
		let randomParam = Math.random().toString(36).substring(7);
		let data_type = $('.boloc-act').attr("data-type");
		let dulieu = $('.boloc-act').attr("data");
		let phanloai = $('.boloc-act').val();

		let brand = $('#brand').val();
		let fp = $('#from-p').val();
		let tp = $('#to-p').val();

		let duongdan_fix = duongdan+url_sub+`/${data_type}${dulieu ? `/${dulieu}` : ''}`;
		let data_trave = {
			xacthuc2: randomParam,
	        type: data_type,
	        filters1: phanloai,
	        filters2: {brand: brand, to: tp, from: fp}
		};
		if (dulieu) data_trave.data = dulieu;

		$.ajax({
	        type: "POST",
	        url: duongdan_fix,
	        dataType: 'JSON',
	        data: data_trave,
	        success: function(data) {
	            $('#list-sanpham').html(data.res.prods);
	            $('#list-pt').html(data.res.pagin);
	            reset_cc();
	        },
	        error: function() {
	            console.log("Có lỗi xảy ra.");
	        }
	    });
	})
	$('#list-pt').on('click', '.a-move', function() {
		let randomParam = Math.random().toString(36).substring(7);
		let data_type = $(this).attr('data-type');
		let data = $(this).attr('data');
		let page = $(this).attr('page');
		let phanloai = $(this).attr('type');

		let filters2 = {};
		let brand = $('#brand').val();
		let fp = $('#from-p').val();
		let tp = $('#to-p').val();

		let duongdan_fix = duongdan+url_sub+`/${data_type}${data ? `/${data}` : ''}`;

		let data_trave = { 
			type: data_type,
			page: page,
			filters1: phanloai
		};
		
	    if (data) data_trave.data = data;
	    filters2.brand = brand;
	    filters2.from = fp;
	    filters2.to = tp;
	    data_trave.filters2 = filters2;

	    if (phanloai) {
	    	data_trave.loai = phanloai;
	    	data_trave.xacthuc2 = randomParam;
	    }
	    else {
	    	data_trave.loai = phanloai;
	    	data_trave.xacthuc1 = randomParam;
	    }

		$.ajax({
	        type: "POST",
	        url: duongdan_fix,
	        dataType: phanloai ? 'json' : null,
	        data: data_trave,
	        success: function(data) {
	            $('#list-sanpham').html(data.res.prods);
	            $('#list-pt').html(data.res.pagin);
	            reset_cc();
	        },
	        error: function() {
	            console.log("Có lỗi xảy ra.");
	        }
	    });
	})
})