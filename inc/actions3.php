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
				$childs = get_children( array(
					'post_parent' => get_the_ID(),
					'post_type' => 'post',
					'numberposts' => -1,
					'post_status' => 'publish'
					) );
				$box_class = ( count( $childs ) > 0 ) ? 'cases-box-open' : 'cases-box-closed';
				$sub_task_link = admin_url( 'post-new.php?post_type=cases&csposter&csposter_parent_id=' . get_the_ID() );
				$call_bank_link = admin_url( 'post-new.php?post_type=cases&csposter&csposter_function=129&csposter_initiator=' . get_post_meta( get_the_ID(), 'initiator', true ) . '&csposter_parent_id=' . get_the_ID() . '&csposter_responsible=' . get_post_meta( get_the_ID(), 'responsible', true ) );
				?>
				<div class="cases-box <?php echo $box_class; ?>">
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
						<?php datatable_generator( array( 'src' => 'global', 'tree' => 'ID:post_parent', 'view' => 'id:dt_case_childs' ) ); ?>
					</div>
				</div>
				<!-- Action priority: 60 -->
				<?php
			}
		//	get_template_part( 'template', 'acf-form' );
		}
	}

	add_action( 'roots_entry_content_after', 'cases_display_childs', 60 );