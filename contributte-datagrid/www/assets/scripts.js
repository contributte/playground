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

if (typeof naja !== "undefined") {
	function FlashesExtension(naja) {
	    naja.addEventListener('complete', finishFlash);

	    return this;
	}

	naja.registerExtension(FlashesExtension);
} else {
	$.nette.ext('flashes', {
	  complete: function() {
	  	finishFlash();
	  }
	});
}

finishFlash();
