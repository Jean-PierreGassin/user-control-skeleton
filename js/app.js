$(document).ready(function() {
	// initialize foundation
	$(document).foundation();

	setInterval(function() {
		$('.alert-box').slideUp(1500);
	}, 2000);
}());
