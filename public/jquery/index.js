$(function() {
    $('body').scrollspy({ target: '#mnm', offset: 50 });

    $(document).on('click', '.click-pn', function(event) {
    	let cdai = $(this).parent().width();
        let num = $(this).parent().find('.col-3').length;
        let one_c = cdai/4;
        let mul_c = (one_c * num) - one_c;
        let slides = $(this).siblings("div");
        let margin = parseInt(slides.eq(0).css('margin-left')) || 0;

        if ($(this).hasClass('click-prev')) {
            margin = Math.min(0, margin + one_c);
        } else {
            margin = Math.max(-(one_c*(num-4)), margin - one_c);
        }
        slides.eq(0).css('margin-left', margin + 'px');
        console.log(num);
    });

    $('.index-cat').on('click', function() {
        let randomParam = Math.random().toString(36).substring(7);
        let data_type = $(this).attr("data-type");
        let dulieu = $(this).attr("data");

        let duongdan_fix = duongdan+url_sub+`/${data_type}${dulieu ? `/${dulieu}` : ''}`;

        let data_trave = {
            xacthuc2: randomParam,
            type: data_type,
            data: dulieu,
            showsp: "col-20pt",
            limit: 10
        }

        $('.index-fil').attr("data", dulieu);
        $('.index-fil').attr("data-type", "products/cat1");
        $('.stss-va').attr("href",`${duongdan}/${data_type}/${dulieu}/`);

        $.ajax({
            type: "POST",
            url: duongdan_fix,
            dataType: 'json',
            data: data_trave,
            success: function(data) {
                $('.stss-list').html(data.res.prods);
                console.log(data);
                reset_cc();
            },
            error: function() {
                console.log("Có lỗi xảy ra.");
            }
        });
    })
    $('.index-fil').on('click', function() {
        let randomParam = Math.random().toString(36).substring(7);
        let data_type = $(this).attr("data-type");
        let dulieu = $(this).attr("data");
        let phanloai = $(this).attr("data-phanloai");

        let duongdan_fix = duongdan+url_sub+`/${data_type}${dulieu ? `/${dulieu}` : ''}`;
        let data_trave = {
            xacthuc2: randomParam,
            type: data_type,
            filter: phanloai,
            showsp: "col-20pt",
            limit: 10
        }

        if (dulieu) data_trave.data = dulieu;

        console.log(duongdan_fix);

        $.ajax({
            type: "POST",
            url: duongdan_fix,
            dataType: 'json',
            data: data_trave,
            success: function(data) {
                $('.stss-list').html(data.res.prods);
                console.log(data);
                reset_cc();
            },
            error: function() {
                console.log("Có lỗi xảy ra.");
            }
        });
    })
});
