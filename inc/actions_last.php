<?php

	function roots_feed_link() {
		$count = wp_count_posts( 'post' );
		if ( $count->publish > 0 ) {
			echo "\n\t<link rel=\"alternate\" type=\"application/rss+xml\" title=\"" . get_bloginfo( 'name' ) . " Feed\" href=\"" . home_url() . "/feed/\">\n";
		}
	}

	add_action( 'roots_head', 'roots_feed_link' );

	function roots_google_analytics() {
		$roots_google_analytics_id = GOOGLE_ANALYTICS_ID;
		if ( $roots_google_analytics_id !== '' ) {
			echo "\n\t<script>\n";
			echo "\t\tvar _gaq=[['_setAccount','$roots_google_analytics_id'],['_trackPageview']];\n";
			echo "\t\t(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];\n";
			echo "\t\tg.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';\n";
			echo "\t\ts.parentNode.insertBefore(g,s)}(document,'script'));\n";
			echo "\t</script>\n";
		}
	}

	add_action( 'roots_footer', 'roots_google_analytics' );

	function cases_display_childs() {
		if ( is_single() && get_post_type() == 'cases' ) {
			if ( function_exists( 'datatable_generator' ) ) {
				$sub_task_link = admin_url( 'post-new.php?post_type=cases&csposter&csposter_parent_id=' . get_the_ID() );
				$call_bank_link = admin_url( 'post-new.php?post_type=cases&csposter&csposter_function=129&csposter_initiator=' . get_post_meta( get_the_ID(), 'initiator', true ) . '&csposter_parent_id=' . get_the_ID() . '&csposter_responsible=' . get_post_meta( get_the_ID(), 'responsible', true ) );
				?>
				<div id="cases-box-childs" class="cases-box cases-box-open" data-post-id="<?php the_ID(); ?>">
					<div class="cases-box-header">
						<h3>
							<a href="#" class="cases-box-toggle">Дела нижнего уровня</a>
							<a href="#childs" name="childs" class="cases-box-anchor">#</a>
							<span class="cases-box-sub-header">список подзадач</span>
						</h3>
						<div class="cases-box-actions">
							<a href="<?php echo $sub_task_link; ?>" class="fancybox-iframe btn btn-mini">Добавить подзадачу</a>
							<?php
							// Это договор по ипотеке, нужно вывести ссылку "Заявка в банк"
							if ( has_term( 411, 'functions' ) ) {
								?>
								<a href="<?php echo $call_bank_link; ?>" class="fancybox-iframe btn btn-mini">Заявка в банк</a>
								<?php
							}
							?>
						</div>
					</div>
					<div class="cases-box-content">
						<div class="cases-box-loading">Загрузка данных&hellip;</div>
					</div>
				</div>
				<!-- Action priority: 60 -->
				<?php
			}
			//get_template_part( 'template', 'acf-form' );
		}
	}

	add_action( 'roots_entry_content_after', 'cases_display_childs', 60 );

	/**
	 * Get datatable with current case childs
	 */
	function cases_ajax_get_childs_datatable() {
		datatable_generator( array( 'parent' => $_POST['post_id'], 'tree' => 'ID:post_parent', 'view' => 'id:dt_case_childs' ) );
		die();
	}

	add_action( 'wp_ajax_cases_ajax_get_childs_datatable', 'cases_ajax_get_childs_datatable' );

	/**
	 * Get comments by ajax
	 */
	function cases_ajax_get_comments() {
		global $wp_query;
		$comments = get_comments( array(
			'post_id' => $_POST['post_id'],
			'status' => 'approve',
			'order' => 'ASC'
			) );

		if ( count( $comments ) == 0 )
			die( '<p>Комментариев нет</p>' );
		?>
		<ol class="commentlist">
			<?php
			foreach ( $comments as $comment ) {
			if ($comment->comment_type!='notification')
			{
				?>
				<li <?php comment_class(); ?>>
					<article id="comment-<?php echo $comment->comment_ID; ?>">
						<header class="comment-author vcard">
							<?php echo get_avatar( $comment, $size = '32' ); ?>
							<?php printf( __( '<cite class="fn">%s</cite>', 'roots' ), get_comment_author_link( $comment->comment_ID ) ); ?>
							<div class="comment-meta">
								<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>"><time datetime="<?php echo comment_date( 'c' ); ?>"><?php echo get_comment_date( 'j F, Y, G:i', $comment->comment_ID ); ?></time> #</a>
								<div class="comment-actions">
									<a href="#" class="comment-action-reply">Ответить</a>
									<a href="<?php echo admin_url( 'post-new.php?post_type=cases&csposter&csposter_parent_id=' . get_the_ID() . '&content=' . urlencode( get_permalink() . '#comment-' . $comment->comment_ID ) ); ?>" class="fancybox-iframe">Отправить подзадачей</a>
									<?php
									if ( current_user_can( 'edit_post', $comment->comment_post_ID ) ) {
										$url = clean_url( wp_nonce_url( '/wp-admin/comment.php?action=trashcomment&c=' . $comment->comment_ID, 'delete-comment_' . $comment->comment_ID ) );
										echo '<a href="' . $url . '" style="color:red">Удалить</a>';
									}
									?>
								</div>
							</div>
						</header>

						<?php if ( $comment->comment_approved == '0' ) { ?>
							<div class="alert alert-block fade in">
								<a class="close" data-dismiss="alert">&times;</a>
								<p><?php _e( 'Your comment is awaiting moderation.', 'roots' ); ?></p>
							</div>
						<?php } ?>

						<section class="comment">
							<?php comment_text( $comment->comment_ID ); ?>
						</section>
					</article>
				</li>
				<?php
				}
			}
			?>
		</ol>
		<?php //wp_list_comments( array( 'type' => 'comment', 'callback' => 'roots_comment' ) ); ?>


		<?php
		if ( !comments_open() && !is_page() && post_type_supports( get_post_type(), 'comments' ) ) {
			?>
			<div class="alert alert-block fade in">
				<a class="close" data-dismiss="alert">&times;</a>
				<p><?php _e( 'Comments are closed.', 'roots' ); ?></p>
			</div>
			<?php
		}
		die();
	}

	add_action( 'wp_ajax_cases_ajax_get_comments', 'cases_ajax_get_comments' );