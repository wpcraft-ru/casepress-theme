
<div id="acf-form-template" class="acf_form">

	<a class="acf-button" href="#">Развернуть</a><a style="display:none;" class="acf-button" href="#">Свернуть</a>
	<?php acf_form(); ?>
	<script type='text/javascript'>
		jQuery('form#post').hide();
		jQuery(document).ready(function() {
			jQuery('.acf-button').click(function(e) {
				e.preventDefault();
				jQuery('form#post').toggle(400);
				jQuery('.acf-button').toggle();
			})
		});
	</script>
</div>