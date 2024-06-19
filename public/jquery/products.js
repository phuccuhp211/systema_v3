$(function() {
	$('.boloc-act').on('change', function() {
		var randomParam = Math.random().toString(36).substring(7);
		var data_type = $(this).attr("data-type");
		var dulieu = $(this).attr("data");
		var phanloai = $(this).val();

		var duongdan_fix = duongdan+url_sub+`/${data_type}${dulieu ? `/${dulieu}` : ''}`;
		var data_trave = {
			xacthuc2: randomParam,
	        type: data_type,
	        filters1: phanloai
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
	$('#list-pt').on('click', '.a-move', function() {
		var randomParam = Math.random().toString(36).substring(7);
		var data_type = $(this).attr('data-type');
		var data = $(this).attr('data');
		var page = $(this).attr('page');
		var phanloai = $(this).attr('type');

		var duongdan_fix = duongdan+url_sub+`/${data_type}${data ? `/${data}` : ''}`;

		var requestData = { 
			type: data_type,
			page: page,
			filters1: phanloai
		};
		
	    if (data) requestData.data = data;

	    if (phanloai) {
	    	requestData.loai = phanloai;
	    	requestData.xacthuc2 = randomParam;
	    }
	    else {
	    	requestData.loai = phanloai;
	    	requestData.xacthuc1 = randomParam;
	    }

		$.ajax({
	        type: "POST",
	        url: duongdan_fix,
	        dataType: phanloai ? 'json' : null,
	        data: requestData,
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