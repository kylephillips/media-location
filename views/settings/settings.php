<div class="wrap">
	<h1><?php _e('Media Location Settings', 'media-location'); ?></h1>

	<h2 class="nav-tab-wrapper">
		<a class="nav-tab <?php if ( $tab == 'general' ) echo 'nav-tab-active'; ?>" href="options-general.php?page=wp_simple_locator"><?php _e('General', 'media-location'); ?></a>
	</h2>
	
	<form method="post" enctype="multipart/form-data" action="options.php">
	<?php
		$view = $tab . '.php';
		include($view);
		submit_button(); 
	?>
	</form>
</div>