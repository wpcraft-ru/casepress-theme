<?php
	/**
	 * Template name: sql_rep
	 * Description: Шаблон архива sql
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
			<?php dynamic_sidebar( 'report' ); ?>
		</div>
		<?php roots_sidebar_inside_after(); ?>
	</aside><!-- /#sidebar -->
	<?php roots_sidebar_after(); ?>
	<?php roots_main_before(); ?>
	<div id="main" class="<?php echo MAIN_CLASSES; ?>" role="main">
	<h2>
<?php the_title();	?>	
</h2>			
<?php query_posts(array( 'post_type'=>'report','posts_per_page'=>-1)); ?>
	<ul class="thumbnails">
	<?php while (have_posts()) : the_post(); ?>
	  <li class="span4" style="width:30%!important;">
			<div class="caption">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				<?php the_tags('<ul class="entry-tags"><li>','</li><li>','</li></ul>'); ?>
		 </div>
	  </li>

	  <?php endwhile; ?>
	</ul>
</div>

</div><!-- /#main -->
	<?php roots_main_after(); ?>
</div><!-- /#content -->
<?php
	roots_content_after();
	get_footer();
?>
<!-- <?php echo basename( __FILE__ ); ?> -->
