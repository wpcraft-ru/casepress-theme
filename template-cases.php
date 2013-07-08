<?php
	/**
	 * Template name: Дела
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
			<?php dynamic_sidebar( 'cases' ); ?>
		</div>
		<?php roots_sidebar_inside_after(); ?>
	</aside><!-- /#sidebar -->
	<?php roots_sidebar_after(); ?>
	<?php roots_main_before(); ?>
	<div id="main" class="<?php echo MAIN_CLASSES; ?>" role="main">
		<?php roots_loop_before(); ?>
		<?php /* Start loop */ ?>
		<?php if ( have_posts() ) : the_post(); ?>
				<?php roots_post_before(); ?>
				<?php roots_post_inside_before(); ?>
				<?php
				// Original page content
				if ( is_page() )
					while ( have_posts() ) {
						the_post();
						the_content();
					}

				// DataTable
				if(function_exists('datatable_generator')) datatable_generator(array('title'=>'Дела'));
				?>
				<?php roots_post_inside_after(); ?>
				<?php roots_post_after(); ?>
			<?php endif; /* End loop */ ?>
		<?php roots_loop_after(); ?>
	</div><!-- /#main -->
	<?php roots_main_after(); ?>
</div><!-- /#content -->
<?php
	roots_content_after();
	get_footer();
?>
<!-- <?php echo basename( __FILE__ ); ?> -->