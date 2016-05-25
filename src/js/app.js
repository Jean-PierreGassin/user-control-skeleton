// Foundation JavaScript
// Documentation can be found at: http://foundation.zurb.com/docs
$(document).foundation();

$(document).ready(function() {
	setInterval(function() {
		$('.alert-box').slideUp(1500);
	}, 2000);
})();
