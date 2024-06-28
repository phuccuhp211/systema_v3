var ccmh = $(window).height();
var cdmh = $(window).width();
var duongdan = window.location.origin;
var url_sub = ""; 
var id = 0;
var type = '';
var page = 1;
var filter = 1;
var search = '';
var records = 10;
var order = 'DESC';

function formatDate(dateString) {
    const date = new Date(dateString);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0'); // Tháng trong JavaScript bắt đầu từ 0
    const year = date.getFullYear();

    return `${day}/${month}/${year}`;
}

function fresh_data() {
	var datacb = {
    	page: page,
        type: type,
        search: search,
        records: records,
        filter: filter,
        order: order
    };
    let duongdan_fix = duongdan + url_sub + `/manager/filter/ajax`;

    $.ajax({
        type: "POST",
        dataType: "JSON",
        url: duongdan_fix,
        data: datacb,
        success: function(data) {
        	if (type == 'c1') {
        		$('.show-data1').find('.record').remove();
        		$('.show-data1').append(data.res);
        	}
        	else if (type == 'c2') {
        		$('.show-data2').find('.record').remove();
        		$('.show-data2').append(data.res);
        	}
        	else {
        		$('.show-data').find('.record').remove();
	            $('.show-data').append(data.res);
	            if ($('.box-pagin').length > 0) {
	            	$('.box-pagin').find('button').remove();
		            $('.box-pagin').append(data.pagin);
	            }
        	}
        },
        error: function() {
            console.log("Có lỗi xảy ra");
        }
    });
}

function show_cmt(data) {
	let dulieu = data;
	let noidung = "";
	$('.list-cm').find('.record').remove();
	for (let i = 0; i < dulieu.length; i++) {
		noidung += `
		<tr class="record ${dulieu[i].id}">
			<td>${dulieu[i].content}</td>
			<td>${dulieu[i].id_us}</td>
			<td>${formatDate(dulieu[i].date)}</td>
			<td><button class="btn btn-danger btn-mini btn-crud del" data-id="${dulieu[i].id}" data-type="cm"><i class="fa-solid fa-trash"></i></button></td>
		</tr>
		`;
	}
	$('.list-cm tbody').append(noidung);
}

function updateFormFields(hidden, fields) {
    Object.entries(fields).forEach(function([key, value]) {
        $(`#${value}`).val(hidden.data(key));
    });

    if (fields['c1']) $(`#f-c1 option[value=${hidden.data('c1')}]`).prop("selected", true);
    if (fields['c2']) $(`#f-c2 option[value=${hidden.data('c2')}]`).prop("selected", true);
    if (fields['rf']) $(`#f-rf option[value=${hidden.data('rf')}]`).prop("selected", true);
    if (fields['or']) $(`#f-or option[value=${hidden.data('or')}]`).prop("selected", true);
}

function fillformdata(dom) {
	id = dom.data('id');
	$(`#f-id`).val(id);
    let hidden = dom.parent().siblings('#hidden-data');

    if (dom.hasClass('suabn')) {
        updateFormFields(hidden, {
            'tt': 'f-tt',
            'im': 'f-im',
            'ct': 'f-ct'
        });
    }
    else if (dom.hasClass('suadm')) {
    	hidden = dom.parent().siblings('#hidden-data2');
    	$('#f-id2').val(id);
        updateFormFields(hidden, {
            'fn': 'f-fn2',
            'im': 'f-im2',
            'c1': 'f-c1'
        });
    } 
    else if (dom.hasClass('suapl')) {
    	hidden = dom.parent().siblings('#hidden-data1');
    	$('#f-id1').val(id);
        updateFormFields(hidden, {
            'fn': 'f-fn1'
        });
    } 
    else if (dom.hasClass('suabc')) {
        updateFormFields(hidden, {
            'fn': 'f-fn',
            'pt': 'f-pt',
            'ep': 'f-ep',
            'c1': 'f-c1',
            'c2': 'f-c2',
            'rf': 'f-rf',
            'or': 'f-or',
            'in': 'f-in'
        });
    } 
    else if (dom.hasClass('suasp')) {
        updateFormFields(hidden, {
            'fn': 'f-fn',
            'im': 'f-im',
            'if': 'f-if',
            'c1': 'f-c1',
            'c2': 'f-c2',
            'br': 'f-br',
            'pr': 'f-pr',
            'sl': 'f-sl',
            'sf': 'f-sf',
            'st': 'f-st'
        });
    } 
    else if (dom.hasClass('suaus')) {
        updateFormFields(hidden, {
            'ac': 'f-ac',
            'pw': 'f-pw',
            'fn': 'f-fn',
            'ad': 'f-ad',
            'nb': 'f-nb',
            'em': 'f-em',
            'rl': 'f-rl',
            'pm': 'f-pm'
        });
    } 
    else if (dom.hasClass('suagg')) {
        updateFormFields(hidden, {
            'fn': 'f-fn',
            'mx': 'f-mx',
            'rm': 'f-rm',
            'fd': 'f-fd',
            'td': 'f-td',
            'dc': 'f-dc',
            'tp': 'f-tp'
        });
    }
}

$(function() {
	const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': csrfToken
	    }
	});

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

/*-------------------- Other --------------------*/
	$(document).on('click', '.chitiet', function() {
		id = $(this).data('id');
		let duongdan_fix = duongdan+url_sub+"/manager/cm/detail";
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
		$('.bg-inf').removeClass('hide-bg');
	})

/*-------------------- Filter --------------------*/
	$(document).on('click keyup change', '.filter-gr', function() {
	    if ($(this).hasClass('btn-filter')) { 
	    	filter = $(this).data("filter");
	    	$(this).siblings('.btn-filter-act').removeClass('btn-filter-act');
	    	$(this).addClass('btn-filter-act');
	    }
	    else if ($(this).hasClass('search-records')) search = $(this).val();
	    else if ($(this).hasClass('range-records')) records = $(this).val();
	    else if ($(this).hasClass('sort-records')) order = $(this).val();
	    else if ($(this).hasClass('page-records')) page = $(this).data('page');
	    type = $(this).data('type');
	    fresh_data();
	});

/*-------------------- CRUD --------------------*/
	$(document).on('click', '.btn-crud', function() {
		type = $(this).attr('data-type');
		let duongdan_fix = duongdan+url_sub+"/manager/check/permission";
		let action = $(this);
		if (action.hasClass('getback')) $('.bg-add, .bg-fix, .bg-del, .bg-inf, .bg-err').addClass('hide-bg');
		else {
			type = $(this).data('type');
			$.ajax({
				type: "POST",
				url: duongdan_fix,
				data: { type: type },
				dataType: 'JSON',
				success: function(data) {
					if (data.status) {
						if (action.hasClass('add')) $('.bg-add').removeClass('hide-bg');
						if (action.hasClass('fix')) {
							fillformdata(action);
							$('.bg-fix').removeClass('hide-bg');
						}
						if (action.hasClass('del')) {
							id = action.data('id');
							$('.bg-del').removeClass('hide-bg');
							if (type == 'c1') $('#acp-del').attr('data-type', 'c1');
							else if (type == 'c2') $('#acp-del').attr('data-type', 'c2');
							let duongdan_del = duongdan+url_sub+"/manager/"+type+"/del/"+id;
							$('#acp-del').attr('data-url', duongdan_del);
						}
						if (action.hasClass('lock')) crud_lock(action);
						if (action.hasClass('hidden')) crud_hidden(action);
					}
					else {
						$('.bg-err').removeClass('hide-bg');
		                $('.bg-err').find('div').html('<ul>' + data.res + '</ul>');
		                setTimeout(function() { $('.bg-err').addClass('hide-bg') }, 2000);
					}
				},
				error: function() {
					console.log("Có lỗi xảy ra.");
				}
			});
		}	
	})

	function crud_lock (object) {
		if (object.hasClass('banus')) {
			object.find("i").removeClass('fa-ban').addClass('fa-check');
			object.removeClass('btn-warning banus').addClass('btn-success unbanus');
			$('.popup-small').find("span").text("Đã Khóa Tài Khoản");
			$('.popup-small').find("i").removeClass('fa-check');
			if(!$('.popup-small').find("i").hasClass('fa-ban')) $('.popup-small').find("i").addClass('fa-ban');
		}
		else {
			object.find("i").removeClass('fa-check').addClass('fa-ban');
			object.removeClass('btn-success unbanus').addClass('btn-warning banus');
			$('.popup-small').find("span").text("Đã Mở Khóa Tài Khoản");
			$('.popup-small').find("i").removeClass('fa-ban');
			if(!$('.popup-small').find("i").hasClass('fa-check')) $('.popup-small').find("i").addClass('fa-check');
		}

		id = object.data('id');
		let hidden = object.data('lock');
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
	}

	function crud_hidden(object) {
		if (object.hasClass('hidsp')) {
			object.find("i").removeClass('fa-eye-slash').addClass('fa-eye');
			object.removeClass('btn-warning hidsp').addClass('btn-success unhidsp');
			$('.popup-small').find("span").text("Đã Ẩn Sản Phẩm");
			$('.popup-small').find("i").removeClass('fa-eye');
			if(!$('.popup-small').find("i").hasClass('fa-eye-slash')) $('.popup-small').find("i").addClass('fa-eye-slash');
		}
		else {
			object.find("i").removeClass('fa-eye').addClass('fa-eye-slash');
			object.removeClass('btn-success unhidsp').addClass('btn-warning hidsp');
			$('.popup-small').find("span").text("Đã Hiện Sản Phẩm");
			$('.popup-small').find("i").removeClass('fa-eye-slash');
			if(!$('.popup-small').find("i").hasClass('fa-eye')) $('.popup-small').find("i").addClass('fa-eye');
		}

		id = object.data('id');
		let hidden = object.data('hid');
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
	}

	$(document).on('click', '.hd-update', function() {
		let trangthai = $('#hd-stt').val();
		let thanhtoan = $('#hd-pstt').val();
		id = $(this).parent().siblings(".id-hd").text();
		let duongdan_fix = duongdan+url_sub+"/manager/in/upd";

		$.ajax({
			type: "POST",
			url: duongdan_fix,
			data: {id: id, stt: trangthai, pstt: thanhtoan },
			success: function(response) {
				$('.popup-small').removeClass('hide-popup');
				setTimeout(() => { $('.popup-small').addClass('hide-popup') }, 1000);
			},
			error: function() {

			}
		});
	})

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
				if (data.status) setTimeout(() => { location.href = data.res }, 100);
				else $('.errlog').text(data.res);
			}
		});
	})

	$(document).on('submit', '.admin-add', function(event) {
	    event.preventDefault();
	    type = $(this).attr('data-type');
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
	                $('.bg-err').removeClass('hide-bg');
	                $('.bg-err').find('div').html('<ul>' + data.res + '</ul>');
	                setTimeout(function() { $('.bg-err').addClass('hide-bg') }, 5000);
	            } 
	            else {
	                $('.bg-add').addClass('hide-bg');
	            	$('.bg-err').removeClass('hide-bg');
	                $('.bg-err').find('div').html('<span class="color-info">Thêm Thành Công</span>');
	                setTimeout(function() { $('.bg-err').addClass('hide-bg') }, 2000);
	                if (type != '') fresh_data();
	            }
	        },
	        error: function(xhr, status, error) {
	            console.log(xhr.responseText);
	        }
	    });
	})

	$(document).on('submit', '.admin-fix', function(event) {
		event.preventDefault();
		type = $(this).attr('data-type');
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
	                $('.bg-err').removeClass('hide-bg');
	                $('.bg-err').find('div').html('<ul>' + data.res + '</ul>');
	                setTimeout(function() { $('.bg-err').addClass('hide-bg') }, 5000);
	            }
	            else {
	                $('.bg-fix').addClass('hide-bg');
	            	$('.bg-err').removeClass('hide-bg');
	                $('.bg-err').find('div').html('<span class="color-info">Sửa Thành Công</span>');
	                setTimeout(function() { $('.bg-err').addClass('hide-bg') }, 2000);
	                if (type != '') fresh_data();
	            }
	        },
	        error: function(xhr, status, error) {
	            console.log(xhr.responseText);
	        }
	    });
	})

	$(document).on('click', '.admin-del', function() {
		let url = $(this).attr('data-url');
		let btn = $(this).attr('data-type');
		type = $(this).attr('data-type');
		console.log(url);
		$.ajax({
	        url: url,
	        type: 'POST',
	        dataType: 'JSON',
	        data: {  },
	        success: function(data) {
	            if (data.status) {
	            	if (type == 'cm') $('.list-cm tbody').find(`.${id}`).remove();
            		$('.bg-del').addClass('hide-bg');
	            	$('.bg-err').removeClass('hide-bg');
	                $('.bg-err').find('div').html('<span class="color-info">Xóa Thành Công</span>');
	                setTimeout(function() { $('.bg-err').addClass('hide-bg') }, 2000);
	                fresh_data();
	            }
	        },
	        error: function(xhr, status, error) {
	            console.log(xhr.responseText);
	        }
	    });
	})
})