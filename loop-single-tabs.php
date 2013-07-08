<?php while ( have_posts() ) : the_post(); ?>
		<?php roots_post_before(); ?>
		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<?php roots_post_inside_before(); ?>
			<header>
				<a href="<?php the_permalink(); ?>">#<?php the_ID(); ?></a>
				<h1 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
				<?php roots_entry_meta(); ?>
			</header>
			<div class="entry-content">
				<?php roots_entry_content_before(); ?>
				<div class="entry-content-inner">
					<?php the_content(); ?>
				</div>
			</div>

		<?php roots_post_inside_after(); ?>
		</article>
		<?php roots_post_after(); ?>
	<?php endwhile; /* End loop */ ?>