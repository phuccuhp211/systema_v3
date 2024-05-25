$(function() {
	$('#reset-session').on('click', function() {
		var duongdan_fix = duongdan+url_sub+"/reset/";
		var duongdan_fix2 = duongdan+url_sub+"/";

		$.ajax({
			type: "POST",
			url: duongdan_fix,
			success: function(response) {
				window.location.href = duongdan_fix2;
			},
			error: function() {
				console.log("Có lỗi xảy ra.");
			}
		});
	})
})