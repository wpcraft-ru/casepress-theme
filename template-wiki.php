<?php
	/**
	 * Template name: Справочники
	 * Description: Шаблон архива
	 *
	 * Этот файл можно использовать как шаблон страницы или он будет
	 * автоматически использоваться на странице архива
	 */
	get_header();
?>

<?php roots_content_before(); ?>
<div id="content" class="<?php echo CONTAINER_CLASSES; ?>">
	<?php roots_sidebar_before(); ?>
	<aside id="sidebar" class="<?php echo SIDEBAR_CLASSES; ?>" role="complementary">
		<?php roots_sidebar_inside_before(); ?>
		<div class="well">
			<?php dynamic_sidebar( 'wiki' ); ?>
		</div>
		<?php roots_sidebar_inside_after(); ?>
	</aside><!-- /#sidebar -->
	<?php roots_sidebar_after(); ?>
	<?php roots_main_before(); ?>
	<div id="main" class="<?php echo MAIN_CLASSES; ?>" role="main">
		<div class="page-header">
			<h1><?php _e( 'Manuals', 'roots' ); ?></h1>
		</div>
		<?php
			// Original page content
			if ( is_page() )
				while ( have_posts() ) {
					the_post();
					the_content();
				}

			// Wiki's
			query_posts( 'post_type=wiki&posts_per_page=' . get_option( 'posts_per_page' ) );
			global $more;
			$more = 0;
			get_template_part( 'loop', 'index' );
			wp_reset_query();
		?>
	</div><!-- /#main -->
	<?php roots_main_after(); ?>
</div><!-- /#content -->
<?php roots_content_after(); ?>
<?php get_footer(); ?>
<!-- <?php echo basename( __FILE__ ); ?> -->