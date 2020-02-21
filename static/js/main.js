$(document).ready(function(){
    $(".phone-nav").click(function(){
        $(".flex-nav ul").toggleClass('open');
    });
});

function showhide(id) {
    let e = document.getElementById(id);
    e.style.display = (e.style.display == 'block') ? 'none' : 'block';
}

$(document).ready(function(){
	// When user clicks on submit comment to add comment under post
	$(document).on('click', '#submit_comment', function(e) {
		e.preventDefault();
		let comment_text = $('#comment_text').val();
		let url = $('#comment_form').attr('action');
		// Stop executing if not value is entered
		if (comment_text === "" ) return;
		$.ajax({
			url: url,
			type: "POST",
			data: {
				comment_text: comment_text,
				comment_posted: 1
			},
			success: function(data){
				let response = JSON.parse(data);
				if (data === "error") {
					alert('Wystąpił błąd podczas dodawania komentarza. Spróbuj później');
				} else {
					$('#comments-wrapper').prepend(response.comment)
					$('#comments_count').text(response.comments_count); 
					$('#comment_text').val('');
				}
			}
		});
    });
    
	// When user clicks on submit reply to add reply under comment
	$(document).on('click', '.reply-btn', function(e){
		e.preventDefault();
		// Get the comment id from the reply button's data-id attribute
		let comment_id = $(this).data('id');
		// show/hide the appropriate reply form (from the reply-btn (this), go to the parent element (comment-details)
		// and then its siblings which is a form element with id comment_reply_form_ + comment_id)
		$(this).parent().siblings('form#comment_reply_form_' + comment_id).toggle(500);
		$(document).on('click', '.submit-reply', function(e){
			e.preventDefault();
			// elements
			let reply_textarea = $(this).siblings('textarea'); // reply textarea element
			let reply_text = $(this).siblings('textarea').val();
			let url = $(this).parent().attr('action');
			$.ajax({
				url: url,
				type: "POST",
				data: {
					comment_id: comment_id,
					reply_text: reply_text,
					reply_posted: 1
				},
				success: function(data){
					if (data === "error") {
						alert('There was an error adding reply. Please try again');
					} else {
						$('.replies_wrapper_' + comment_id).append(data);
						reply_textarea.val('');
					}
				}
			});
		});
	});
});