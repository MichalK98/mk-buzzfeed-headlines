(function ($) {
	'use strict';

	$(document).ready(function () {
		// Target class .widget_mk_buzzfeed_headlines in DOM.
		$('.widget_mk_buzzfeed_headlines').each(function (i, widget) {
			// Chceck if targeted correctly.
			console.log("Widget" + i + ":", widget);
		});
	});

})(jQuery);