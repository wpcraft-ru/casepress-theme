jQuery(document).ready(function($) {

	/**
	 * Кнопки скрытия/открытия блоков cases
	 */
	$('.cases-box-toggle').on('click', function(event) {
		var box = $(this).parent('h3').parent('.cases-box-header').parent('.cases-box');
		if ( box.hasClass('cases-box-closed') ) box.removeClass('cases-box-closed').addClass('cases-box-open');
		else if ( box.hasClass('cases-box-open') ) box.removeClass('cases-box-open').addClass('cases-box-closed');
		event.preventDefault();
	});

	/**
	 * Комментарии: ссылка ответить
	 */
	$('.comment-action-reply').on('click', function(event) {

		var // Prepare vars
		new_content = '',
		respond = $('#respond').position();

		// WYSIWYG editor
		if ( typeof tinyMCE == 'object' ) {
			new_content = '<p><a href="' + $(this).parent('.comment-actions').parent('.comment-meta').find('a:first').attr('href') + '"><strong>' + $(this).parent('.comment-actions').parent('.comment-meta').parent('.comment-author').children('cite.fn').text() + '</strong></a></p><p></p>';
			tinyMCE.execCommand('mceInsertContent', false, new_content);
			tinyMCE.execCommand('mceFocus', false, 'comment');
			$(window).scrollTop(respond.top);
		}

		// Textarea HTML editor
		else {
			new_content = '<a href="' + $(this).parent('.comment-actions').parent('.comment-meta').find('a:first').attr('href') + '"><strong>' + $(this).parent('.comment-actions').parent('.comment-meta').parent('.comment-author').children('cite.fn').text() + '</strong></a>' + "\n";
			$('textarea#comment').val($('textarea#comment').val() + new_content);
			$('textarea#comment').trigger('focus');
			$(window).scrollTop(respond.top);
		}
		event.preventDefault();
	});

});