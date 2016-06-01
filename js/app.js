// initialize foundation
$(document).foundation();

$(document).ready(function() {
	setInterval(function() {
		$('.callout').slideUp(1500);
	}, 4000);
}());
