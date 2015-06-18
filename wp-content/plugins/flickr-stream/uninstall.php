<?php 

if(defined('WP_UNINSTALL_PLUGIN'))
{

	global $wpdb;
							
	$opts = $wpdb->get_results('SELECT option_name FROM ' . $wpdb->prefix . 'options WHERE option_name LIKE "flickrstream_short_%"', ARRAY_A);
	
	foreach($opts as $value)
	{
	
		delete_option($value['option_name']);
	
	}
	
	delete_option('flickrstream_main_opts');
	delete_option('widget_flickrstream_widget');

}

?>