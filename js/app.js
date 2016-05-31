$(document).ready(function() {
	// initialize foundation
	$(document).foundation();

	setInterval(function() {
		$('.callout').slideUp(1500);
	}, 4000);
}());
