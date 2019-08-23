(function ($) {
	'use strict';

	$(document).ready(function () {
		// Target class .widget_mk_buzzfeed_headlines in DOM.
		$('.widget_mk_buzzfeed_headlines').each(function (i, widget) {
			// Chceck if targeted correctly.
			console.log("Widget" + i + ":", widget);
			// Post URL
			$.post(
				mk_buzzfeed_headlines_ajax_obj.ajax_url, // URL
				{
					action: 'buzzfeed_headlines__get',
				} // DATA
			).done(function (response) {
				// If worked.
				console.log("Got response", response);
			}).fail(function (error) {
				// If didn't work.
				console.log("Something went wrong", error);
			});
		});
	});

})(jQuery);