<?php

add_theme_support( 'post-thumbnails', array( 'page' ) );      

function change_post_menu_label() {
    global $menu;
    global $submenu;
    $menu[20][0] = 'Packages';
    $submenu['edit.php?post_type=page'][5][0] = 'Packages';
    $submenu['edit.php?post_type=page'][10][0] = 'Add Package';
    $submenu['edit.php?post_type=page'][15][0] = 'Status'; // Change name for categories
    $submenu['edit.php?post_type=page'][16][0] = 'Labels'; // Change name for tags
    echo '';
}

function change_post_object_label() {
    global $wp_post_types;
    $labels = &$wp_post_types['page']->labels;
    $labels->name = 'Packages';
    $labels->singular_name = 'Package';
    $labels->add_new = 'Add Package';
    $labels->add_new_item = 'Add Package';
    $labels->edit_item = 'Edit Packages';
    $labels->new_item = 'Package';
    $labels->view_item = 'View Package';
    $labels->search_items = 'Search Packages';
    $labels->not_found = 'No Packages found';
    $labels->not_found_in_trash = 'No Packages found in Trash';
}
add_action( 'init', 'change_post_object_label' );
add_action( 'admin_menu', 'change_post_menu_label' );

/* Additional boxes */
add_action( 'add_meta_boxes', 'artist_details_box' );
function artist_details_box() {
    add_meta_box( 
        'artist_details_box',
        __( 'Artist Details', '' ),
        'artist_details_box_content',
        'page',
        'normal',
        'high'
    );
}

function artist_details_box_content( $post ) {
	$custom = get_post_custom($post->ID);
	wp_nonce_field( plugin_basename( __FILE__ ), 'artist_details_box_content_nonce' );
    $artist = unserialize($custom['artist'][0]);
    echo '<div style="overflow: auto">';
    echo '<div style="width: 50%; float: left;">';
	echo '<p><strong>Artist Name</strong></p>';
	echo '<input id="artist_name" name="artist[name]" placeholder="Enter the artists name" type="text" value="'.$artist['name'].'" size="40">';
    echo '<br />';
	echo '<p><strong>Album / Package Name</strong></p>';
	echo '<input id="artist_album" name="artist[album]" placeholder="Enter the album/package name" type="text" value="'.$artist['album'].'" size="40">';
    echo '<br />';
	echo '<p><strong>Record Company</strong></p>';
	echo '<input id="artist_company" name="artist[company]" placeholder="Enter the record company" type="text" value="'.$artist['company'].'" size="40">';
    echo '<br />';
	echo '<p><strong>Feedback Email Address</strong></p>';
	echo '<input id="artist_company" name="artist[comment_email]" placeholder="Enter the email address for feedback" type="text" value="'.$artist['comment_email'].'" size="40">';
    echo '</div>';
    echo '<div style="width: 50%; float: left;">';
	echo '<p><strong>Artist Twitter</strong></p>';
	echo '<input id="artist_twitter" name="artist[twitter]" placeholder="Enter the artists twitter handle" type="text" value="'.$artist['twitter'].'" size="40">';
    echo '<br />';
	echo '<p><strong>Artist Facebook</strong></p>';
	echo '<input id="artist_facebook" name="artist[facebook]" placeholder="Enter the artists facebook URL" type="text" value="'.$artist['facebook'].'" size="40">';
    echo '<br />';
	echo '<p><strong>Artist Music</strong></p>';
	echo '<input id="artist_music" name="artist[music]" placeholder="Enter the artists music URL" type="text" value="'.$artist['music'].'" size="40">';
    echo '</div>';
    echo '</div>';
}


add_action( 'save_post', 'artist_details_box_save' );
function artist_details_box_save( $post_id ) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
	return;

	if ( !wp_verify_nonce( $_POST['artist_details_box_content_nonce'], plugin_basename( __FILE__ ) ) )
	return;

	if ( 'page' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ) )
		return;
	} else {
		if ( !current_user_can( 'edit_post', $post_id ) )
		return;
	}
	$product_price = $_POST['artist'];
	update_post_meta( $post_id, 'artist', $product_price );
}

function wpfstop_change_default_title( $title ){

    $screen = get_current_screen();

    if ( 'page' == $screen->post_type ){
        $title = 'Enter Package ID Here';
    }

    return $title;
}

add_filter( 'enter_title_here', 'wpfstop_change_default_title' );

add_filter( 'posts_where', 'wpse18703_posts_where', 10, 2 );
function wpse18703_posts_where( $where, &$wp_query )
{
    global $wpdb;
    if ( $wpse18703_title = $wp_query->get( 'wpse18703_title' ) ) {
        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'' . esc_sql( $wpdb->esc_like( $wpse18703_title ) ) . '%\'';
    }
    return $where;
}

?>