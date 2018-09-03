<?php

function yourarmy_styles()
{
    wp_enqueue_style( 'stylesheet', get_template_directory_uri() . '/style.css', array(), '062015', 'all' );
    
    wp_enqueue_script("jquery");
 
}
add_action( 'wp_enqueue_scripts', 'yourarmy_styles' );

?>