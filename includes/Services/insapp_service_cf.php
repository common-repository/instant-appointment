<?php

function insapp_adding_services_custom_meta_boxes( $post_type, $post ) {
    $post_type = 'service';
    add_meta_box( 
        'service_box',
        __( "Details du service" ),
        'insapp_service_meta_box',
        $post_type,
        'normal',
        'high'
    );

 
}
add_action( 'add_meta_boxes', 'insapp_adding_services_custom_meta_boxes', 10, 2 );

/**
 * Prints the box content.
 *
 * @param WP_Post $post The object for the current post/page.
 */
function insapp_service_meta_box( $post ) {
 
wp_nonce_field(  plugin_basename( __FILE__ ) , 'service_box_nonce' );

$service_cap = get_post_meta( $post->ID, 'insapp_service_cap', true );
$service_time = get_post_meta( $post->ID, 'insapp_service_time', true );
$service_freq = get_post_meta( $post->ID, 'insapp_service_freq', true );
$service_price = get_post_meta( $post->ID, 'insapp_service_price', true );


include(TLPLUGIN_DIR . 'templates/metebox/service.php');

}

/**
 * Save a custom field of a post type 
 *
 * @param int $post_id The ID of the post being saved.
 */
 function insapp_service_save_data( $post_id ) {

  // Checks save status
  $is_autosave = wp_is_post_autosave( $post_id );
  $is_revision = wp_is_post_revision( $post_id );
  $is_valid_nonce = ( isset( $_POST[ 'service_box_nonce' ] ) && wp_verify_nonce( $_POST[ 'service_box_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

  // Exits script depending on save status
  if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
    return;
  }

  // Checks for input and sanitizes/saves if needed
  if( isset( $_POST[ 'insapp_service_cap' ]) ) {
    update_post_meta( $post_id, 'insapp_service_cap', sanitize_text_field( $_POST[ 'insapp_service_cap' ] ) );
  }
  if( isset( $_POST[ 'insapp_service_time' ]) ) {
    update_post_meta( $post_id, 'insapp_service_time', sanitize_text_field( $_POST[ 'insapp_service_time' ] ) );
  }
  if( isset( $_POST[ 'insapp_service_freq' ]) ) {
    update_post_meta( $post_id, 'insapp_service_freq', sanitize_text_field( $_POST[ 'insapp_service_freq' ] ) );
  }
   if( isset( $_POST[ 'insapp_service_price' ]) ) {
    update_post_meta( $post_id, 'insapp_service_price', sanitize_text_field( $_POST[ 'insapp_service_price' ] ) );
  }


 }
add_action( 'save_post', 'insapp_service_save_data' );




  function my_add_new_columns(array $columns) {
    $post_type = get_post_type();
    if ( $post_type == 'service' ) {
        $new_columns = array(
            'frequence' => 'Fréquence',
            'duree' => ' durée',
            'cout' => 'Cout du service',
            'nbr_place' => 'Nombre de personnes autorisées',
        );
        return array_merge($columns, $new_columns);
    }
}
add_filter( 'manage_service_posts_columns',  'my_add_new_columns' );

function custom_columns( $column, $post_id ) {
	switch ( $column ) {
		case 'frequence':
			echo get_post_meta( $post_id, 'insapp_service_freq', true );
			break;

		case 'duree':
      if(get_post_meta( $post_id, 'insapp_service_time', true )){
        echo get_post_meta( $post_id, 'insapp_service_time', true );
      }
       else {
        echo 'Durée non définie';
       }
			break;

    case 'cout':
			 if(get_post_meta( $post_id, 'insapp_service_price', true )){
        echo get_post_meta( $post_id, 'insapp_service_price', true ).' XAX';
      }
       else {
        echo '0 XAX';
       }
			break;

    case 'nbr_place':
      if(get_post_meta( $post_id, 'insapp_service_cap', true )){
        echo get_post_meta( $post_id, 'insapp_service_cap', true ).' personnes';
      }
       else {
        echo '0 personne';
       }
			break;
	}
}
add_action( 'manage_service_posts_custom_column' , 'custom_columns', 10, 2 );
?>