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
});
