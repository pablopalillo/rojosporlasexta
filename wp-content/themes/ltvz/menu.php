<div class="col-sm-3" id="sidebar">
	<nav>
	<?php wp_nav_menu( 
	    	array( 
	    		'menu' => 'main_nav', /* menu name */
	    		'theme_location' => 'main_nav', /* where in the theme it's assigned */
	    		'container_id' => 'main_nav', 
	    		'container' => 'div', /* container class */
	    		'depth' => '3', /* suppress lower levels for now */
	    		//'walker' => new Bootstrap_Walker()
	    	)
	    ); 
	?>
    </nav>
    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar1') ) : ?><?php endif; ?>
</div>