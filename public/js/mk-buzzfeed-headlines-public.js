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

				// Find the content Class.
				var content = $(widget).find('.content');
				// Find data
				var headlines = response.data.headlines;
				console.log(headlines);
				// Create a empty output(o).
				var o = "";
				o += "<div class='buzzfeed-headlines'>";

				headlines.forEach(function (row) {
					// create output
					o += "<div class='buzzfeed-headline'>";
					o += "<h3>" + row.title + "</h3>";
					o += "<p>" + row.description + "</p>";
					o += "<a href=" + row.url + ">Read more</a>";
					o += "</div><!-- .buzzfeed-headlines -->";
					console.log(row.title);
				});

				o += "</div><!-- .buzzfeed-headline -->";
				// Write output in DOM.
				$(content).html(o);
			}).fail(function (error) {
				// If didn't work.
				console.log("Something went wrong", error);
			});
		});
	});

})(jQuery);