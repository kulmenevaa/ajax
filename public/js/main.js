$(document).ready(function () {
	$(".nav .nav-link").each(function () {
		var location2 = window.location.protocol + '//' + window.location.host + window.location.pathname;
		var link = this.href;
		if (link == location2) {
			$(this).addClass('active');
		}
	});
});