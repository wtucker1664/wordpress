<?php

$dev = false;
$url = add_query_arg( NULL, NULL );
$url = explode('/', $url);
if($dev == true) {
    $pHash = $url[2];
} else {
    $pHash = $url[1];
}
$package = getPackage($pHash);




get_header();
	if(!isset($package->error)){
		$package_id = $package->package_id;
	    $post = get_page_by_title( $package_id );
	    if(is_object($post)){
	    	$template = explode('-', substr(get_post_field('page_template', $post->ID), 0, -4));
	   
	    	set_query_var( 'package_id', $package_id );
	    	set_query_var( 'package', $package );
	    	get_template_part( $template[0], $template[1] );
	    }else{
	    	print "No Package Found on web site";
	    }
	}else{
		print "No Package Found on audio lock";
	}
get_footer();

?>