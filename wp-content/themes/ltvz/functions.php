<?php
add_theme_support( 'post-thumbnails' ); 
add_theme_support( 'menus' );            // wp menus
register_nav_menus(                      // wp3+ menus
	array( 
		'main_nav' => 'Menu principal',   // main nav in header
	)
);

register_sidebar(array(
  'id' => 'sidebar1',
  'name' => 'Sidebar lateral',
  'description' => 'Barra del menú',
  'before_widget' => '<div id="%1$s" class="widget %2$s">',
  'after_widget' => '</div>',
  'before_title' => '<h4 class="widgettitle">',
  'after_title' => '</h4>',
));
register_sidebar(array(
  'id' => 'sidebar2',
  'name' => 'Widget Video Home',
  'description' => 'Widget del home para video',
  'before_widget' => '<div id="%1$s" class="widget %2$s">',
  'after_widget' => '</div>',
  'before_title' => '<h4 class="widgettitle">',
  'after_title' => '</h4>',
));
register_sidebar(array(
  'id' => 'sidebar3',
  'name' => 'Widget Social 1 Home',
  'description' => 'Widget del home para red social',
  'before_widget' => '<div id="%1$s" class="widget %2$s">',
  'after_widget' => '</div>',
  'before_title' => '<h4 class="widgettitle">',
  'after_title' => '</h4>',
));
register_sidebar(array(
  'id' => 'sidebar4',
  'name' => 'Widget Social 2 Home',
  'description' => 'Widget del home para red social',
  'before_widget' => '<div id="%1$s" class="widget %2$s">',
  'after_widget' => '</div>',
  'before_title' => '<h4 class="widgettitle">',
  'after_title' => '</h4>',
));
// enqueue styles
if( !function_exists("theme_styles") ) {  
    function theme_styles() { 
        // This is the compiled css file from LESS - this means you compile the LESS file locally and put it in the appropriate directory if you want to make any changes to the master bootstrap.css.
        wp_register_style( 'bootstrap', get_template_directory_uri() . '/css/libs/bootstrap.min.css', array(), '1.0', 'all' );
        wp_register_style( 'fonts', 'http://fonts.googleapis.com/css?family=Exo:400,500,700,800', array(), '1.0', 'all' );
        wp_register_style( 'main', get_template_directory_uri() . '/style.css', array(), '1.0', 'all' );
        
        wp_enqueue_style( 'bootstrap' );
        wp_enqueue_style( 'fonts' );
        wp_enqueue_style( 'main');
    }
}
add_action( 'wp_enqueue_scripts', 'theme_styles' );

if( !function_exists( "theme_js" ) ) {  
  function theme_js(){
    wp_register_script( 'bootstrap', 
      get_template_directory_uri() . '/js/libs/bootstrap.min.js', 
      array('jquery'), 
      '1.10.2' );

   	wp_register_script( 'main', 
      get_template_directory_uri() . '/js/main.js', 
      array('jquery'), 
      '1.10.2' );
  
    wp_enqueue_script('bootstrap');
    wp_enqueue_script('main');
    
  }
}
add_action( 'wp_enqueue_scripts', 'theme_js' );

?>