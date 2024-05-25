$(function() {
    $('body').scrollspy({ target: '#mnm', offset: 50 });

    $(document).on('click', '.click-pn', function(event) {
    	var cdai = $(this).parent().width();
        var slides = $(this).siblings("div");
        var margin = parseInt(slides.eq(0).css('margin-left')) || 0;

        if ($(this).hasClass('click-prev')) {
            margin = Math.min(0, margin + cdai);
        } else {
            margin = Math.max(-(cdai*4), margin - cdai);
        }
        slides.eq(0).css('margin-left', margin + 'px');
    });

    $('.index-cat').on('click', function() {
        var randomParam = Math.random().toString(36).substring(7);
        var data_type = $(this).attr("data-type");
        var dulieu = $(this).attr("data");

        var duongdan_fix = duongdan+url_sub+`/${data_type}${dulieu ? `/${dulieu}` : ''}/`;

        var data_trave = {
            xacthuc2: randomParam,
            type: data_type,
            data: dulieu,
            showsp: "col-20pt",
            limit: 10
        }

        $('.index-fil').attr("data", dulieu);
        $('.index-fil').attr("data-type", "sanpham/danhmuc");
        $('.stss-va').attr("href",`${duongdan}/${data_type}/${dulieu}/`);

        console.log(data_type+" "+(dulieu ? dulieu : "dl_null"));

        $.ajax({
            type: "POST",
            url: duongdan_fix,
            dataType: 'json',
            data: data_trave,
            success: function(data) {
                $('.stss-list').html(data.sanpham);
                console.log(data);
                reset_cc();
            },
            error: function() {
                console.log("Có lỗi xảy ra.");
            }
        });
    })
    $('.index-fil').on('click', function() {
        var randomParam = Math.random().toString(36).substring(7);
        var data_type = $(this).attr("data-type");
        var dulieu = $(this).attr("data");
        var phanloai = $(this).attr("data-phanloai");

        var duongdan_fix = duongdan+url_sub+`/${data_type}${dulieu ? `/${dulieu}` : ''}/`;
        var data_trave = {
            xacthuc2: randomParam,
            type: data_type,
            loai: phanloai,
            showsp: "col-20pt",
            limit: 10
        }

        if (dulieu) data_trave.data = dulieu;

        console.log(data_type+" "+(dulieu ? dulieu : "dl_null")+" "+phanloai);

        $.ajax({
            type: "POST",
            url: duongdan_fix,
            dataType: 'json',
            data: data_trave,
            success: function(data) {
                $('.stss-list').html(data.sanpham);
                console.log(data);
                reset_cc();
            },
            error: function() {
                console.log("Có lỗi xảy ra.");
            }
        });
    })
});
