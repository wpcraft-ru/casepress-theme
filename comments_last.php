<?php

/*	function roots_notification( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		?>
		<li <?php comment_class() ?>>
			<article id="comment-<?php comment_ID() ?>">
				<header class="comment-author vcard">
					<a class='url'><?php echo $comment->user_id ?></a>
					<div class="comment-meta"><time datetime="<?php echo comment_date( 'c' ) ?>"><?php echo get_comment_date( 'j F, Y' ) . ', ' . get_comment_time() ?></time></div>
				</header>
				<div>email: <?php echo get_comment_meta( $comment->comment_ID, 'email', true ) ?></div>
				<div>adminbar: <?php echo get_comment_meta( $comment->comment_ID, 'adminbar', true ) ?></div>
				<section class="comment"><pre><?php print_r( json_decode( $comment->comment_content, true ) ) ?></pre></section>
			</article>
			<?php
		}*/

		function roots_comment( $comment, $args, $depth ) {
			$GLOBALS['comment'] = $comment;
			?>
		<li <?php comment_class(); ?>>
			<article id="comment-<?php comment_ID(); ?>">
				<header class="comment-author vcard">
					<?php echo get_avatar( $comment, $size = '32' ); ?>
					<?php printf( __( '<cite class="fn">%s</cite>', 'roots' ), get_comment_author_link() ); ?>
					<div class="comment-meta">
						<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>"><time datetime="<?php echo comment_date( 'c' ); ?>"><?php echo get_comment_date( 'j F, Y' ) . ', ' . get_comment_time(); ?></time> #</a>
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
					<?php comment_text() ?>
				</section>
			</article>
		<?php }
	?>

	<?php if ( post_password_required() ) { ?>
			<section id="comments" class="cases-box cases-box-open">
				<div class="cases-box-header">
					<h3>
						<a href="#" class="cases-box-toggle"><?php comments_number( 'Комментарии', 'Комментарии (1)', 'Комментарии (%)' ); ?></a>
						<a href="#comments" name="comments" class="cases-box-anchor">#</a>
					</h3>
					<div class="cases-box-actions">
						<a href="#respond" class="btn btn-mini">Добавить комментарий</a>
					</div>
				</div>
				<div class="cases-box-content">
					<div class="alert alert-block fade in">
						<a class="close" data-dismiss="alert">&times;</a>
						<p><?php _e( 'This post is password protected. Enter the password to view comments.', 'roots' ); ?></p>
					</div>
				</div>
			</section><!-- /#comments -->
			<?php
			return;
		}
	?>

	<?php if ( have_comments() ) { ?>
	<?php /*
			<div class="cases-box cases-box-closed">
				<div class="cases-box-header">
					<h3>
						<a href="#" class="cases-box-toggle">Уведомления (<?php echo count( $wp_query->comments_by_type['notification'] ) ?>)</a>
						<a href="#notifications" name="comments" class="cases-box-anchor">#</a>
					</h3>
				</div>
				<div class="cases-box-content">
					<ol class="commentlist">
						<?php wp_list_comments( array( 'type' => 'notification', 'callback' => 'roots_notification' ) ); ?>
					</ol>
				</div>
			</div>*/ ?>

			<section id="comments" class="cases-box cases-box-open" data-post-id="<?php the_ID(); ?>">
				<div class="cases-box-header">
					<h3> <!-- here-->
						<a href="#" class="cases-box-toggle"><?php comments_number( 'Комментарии', 'Комментарии (1)', 'Комментарии (%)' ); ?></a>
						<a href="#comments" name="comments" class="cases-box-anchor">#</a>
					</h3>
					<div class="cases-box-actions">
						<a href="#respond" class="btn btn-mini">Добавить комментарий</a>
					</div>
				</div>
				<div class="cases-box-content">
					<div class="cases-box-loading">Загрузка комментариев&hellip;</div>
				</div> 
			</section><!-- /#comments -->
		<?php } ?>

	<?php if ( !have_comments() && !comments_open() && !is_page() && post_type_supports( get_post_type(), 'comments' ) ) { ?>
			<section id="comments" class="cases-box cases-box-open">
				<div class="cases-box-header">
					<h3>
						<a href="#" class="cases-box-toggle"><?php comments_number( 'Комментарии', 'Комментарии (1)', 'Комментарии (%)' ); ?></a>
						<a href="#comments" name="comments" class="cases-box-anchor">#</a>
					</h3>
					<div class="cases-box-actions">
						<a href="#respond" class="btn btn-mini">Добавить комментарий</a>
					</div>
				</div>
				<div class="cases-box-content">
					<div class="alert alert-block fade in">
						<a class="close" data-dismiss="alert">&times;</a>
						<p><?php _e( 'Comments are closed.', 'roots' ); ?></p>
					</div>
				</div>
			</section><!-- /#comments -->
		<?php } ?>

	<?php if ( comments_open() ) { ?>
			<section id="respond" class="cases-box cases-box-open">
				<div class="cases-box-header">
					<h3>
						<a href="#" class="cases-box-toggle"><?php comment_form_title( __( 'Leave a Reply', 'roots' ), __( 'Leave a Reply to %s', 'roots' ) ); ?></a>
						<a href="#respond" name="respond" class="cases-box-anchor">#</a>
					</h3>
					<?php if ( is_user_logged_in() ) { ?>
						<div class="cases-box-actions"><?php printf( __( '<a href="%s/wp-admin/profile.php">%s</a>.', 'roots' ), get_option( 'siteurl' ), $user_identity ); ?> <a href="<?php echo wp_logout_url( get_permalink() ); ?>" class="btn btn-mini btn-danger" title="<?php __( 'Log out of this account', 'roots' ); ?>"><?php _e( 'Log out &raquo;', 'roots' ); ?></a></div>
					<?php } ?>
				</div>
				<div class="cases-box-content">
					<p class="cancel-comment-reply"><?php cancel_comment_reply_link(); ?></p>
					<?php if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) { ?>
						<p><?php printf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'roots' ), wp_login_url( get_permalink() ) ); ?></p>
					<?php } else { ?>
						<form action="<?php echo get_option( 'siteurl' ); ?>/wp-comments-post.php" method="post" id="commentform">
							<?php if ( !is_user_logged_in() ) { ?>
								<label for="author"><?php
				_e( 'Name', 'roots' );
				if ( $req )
					_e( ' (required)', 'roots' );
								?></label>
								<input type="text" class="text" name="author" id="author" value="<?php echo esc_attr( $comment_author ); ?>" size="22" tabindex="1" <?php if ( $req ) echo "aria-required='true'"; ?>>
								<?php roots_comment_form_name_after(); ?>
								<label for="email">
									<?php
									_e( 'Email (will not be published)', 'roots' );
									if ( $req )
										_e( ' (required)', 'roots' );
									?>
								</label>
								<input type="email" class="text" name="email" id="email" value="<?php echo esc_attr( $comment_author_email ); ?>" size="22" tabindex="2" <?php if ( $req ) echo "aria-required='true'"; ?>>
								<?php roots_comment_form_email_after(); ?>
								<label for="url"><?php _e( 'Website', 'roots' ); ?></label>
								<input type="url" class="text" name="url" id="url" value="<?php echo esc_attr( $comment_author_url ); ?>" size="22" tabindex="3">
								<?php roots_comment_form_url_after(); ?>
							<?php } ?>
							<label for="comment"><?php _e( 'Comment', 'roots' ); ?></label>
							<textarea name="comment" id="comment" class="input-xlarge" tabindex="4"></textarea>
							<?php roots_comment_form_textarea_after(); ?>
							<input name="submit" class="btn btn-primary" type="submit" id="submit" tabindex="5" value="<?php _e( 'Submit Comment', 'roots' ); ?>">
							<?php roots_comment_form_submit_after(); ?>
							<?php ?>
							<?php comment_id_fields(); ?>
							<?php do_action( 'comment_form', $post->ID ); ?>
						</form>
					<?php } // if registration required and not logged in   ?>
				</div>
			</section><!-- /#respond -->
		<?php } ?>