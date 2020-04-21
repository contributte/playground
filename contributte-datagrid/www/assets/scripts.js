var finishFlash = function() {
	if ($('.flash').length > 0) {
		setTimeout(
	  		function() {
	  			$('.flash').remove();
	  		},
	  		4000
	  	);
	}
};

$.nette.ext('flashes', {
  complete: function() {
  	finishFlash();
  }
});

finishFlash();
