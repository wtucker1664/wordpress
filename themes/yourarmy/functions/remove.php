<?php

function remove_menus(){
  
    remove_menu_page( 'edit.php' );                   //Posts
  
}
add_action( 'admin_menu', 'remove_menus' );

?>