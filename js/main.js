'use strict';

var app = {
	init: function(){
		$("[data-modal-open]").fancybox();
		$("form").validate();
		$('.list').DataTable({
			 searching : false
		});
	}
}

$(document).ready(function() {
	app.init();
});