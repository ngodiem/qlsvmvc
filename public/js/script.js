$(".delete").click(function(event) {
	/* Act on the event */
	event.preventDefault();
	$("#deletingConfirmation").modal("show");
	var url = $(this).attr("href");
	$("#deletingConfirmation").find('a').attr("href", url);
	

});

