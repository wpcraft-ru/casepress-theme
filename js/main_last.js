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
	$('.comment-action-reply').live('click', function(event) {

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

	/**
	 * Загрузка блока дочерних дел с задержкой после загрузки страницы
	 */
	$('#cases-box-childs').ready(function() {
		var box = $('#cases-box-childs'),
		content = box.find('.cases-box-content'),
		loading = box.find('.cases-box-loading'),
		post_id = box.data('post-id');

		// Show loading animation
		loading.show();

		window.setTimeout(function() {
			$.ajax({
				type: 'POST',
				url: ajaxurl,
				data: {
					action: 'cases_ajax_get_childs_datatable',
					post_id: post_id
				},
				success: function(data) {

					// Hide loading animation and clear content block
					loading.remove();

					// Put data to content block
					content.html(data);
				},
				dataType: 'html'
			});
		}, 1000);
	});

	/**
	 * Загрузка блока комментариев с задержкой после загрузки страницы
	 */
	$('#comments').ready(function() {
		var box = $('#comments'),
		content = box.find('.cases-box-content'),
		loading = box.find('.cases-box-loading'),
		post_id = box.data('post-id');

		// Show loading animation
		loading.show();

		window.setTimeout(function() {
			$.ajax({
				type: 'POST',
				url: ajaxurl,
				data: {
					action: 'cases_ajax_get_comments',
					post_id: post_id
				},
				success: function(data) {

					// Hide loading animation and clean content block
					loading.remove();

					// Put data to content block
					content.html(data);

					// Re-init fancybox
					$('a.fancybox-iframe').fancybox({
						'type' : 'iframe',
						'width' : '70%',
						'height' : '90%',
						'padding' : 0,
						'scrolling' : 'auto',
						'autoScale' : false,
						'titleShow' : false,
						'titlePosition' : 'float',
						'titleFromAlt' : true
					});

					var comment = ( $(window.location.hash).length > 0 ) ? $(window.location.hash).position() : false;
					if (comment) {
						$(window).scrollTop(comment.top - 30);
						$(window.location.hash).addClass('active-comment');
					}
				},
				dataType: 'html'
			});
		}, 2000);
	});

});