// Contents of functions.js
;(function($) {
	'use strict';
	
	var $body = $('html, body'),

	content = $('#wrapper').smoothState({

		// Runs when a link has been activated
		// on hover fire ajax call
		prefetch: true,
		// store the pages in cache so multiple ajax calls aren't needed
		pageCacheSize: 1,
		// when the page is done, change the background back to white
		callback : function(url, $container, $content) {
			$body.css("background-color", "#FFF");
		},

		onStart: {
			duration: 950, // Duration of our animation
			render: function (url, $container) {
				// toggleAnimationClass() is a public method
				// for restarting css animations with a class
				
				content.toggleAnimationClass('animated slideOutRight');
				// Scroll user to the top
				$body.css('transition', '0.6s linear').css('background-color', '#80afbf');
				$body.animate({
					scrollTop: 0,
				});

		},
	}
}).data('smoothState');
//.data('smoothState') makes public methods available
})(jQuery);