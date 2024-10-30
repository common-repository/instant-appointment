<?php

function insapp_adding_event_custom_meta_boxes( $post_type, $post ) {
    $post_type = 'evenement';
    add_meta_box( 
        'event_box',
        __( "Details de l'evenement" ),
        'insapp_event_meta_box',
        $post_type,
        'normal',
        'high'
    );

 
}
add_action( 'add_meta_boxes', 'insapp_adding_event_custom_meta_boxes', 10, 2 );

/**
 * Prints the box content.
 *
 * @param WP_Post $post The object for the current post/page.
 */
function insapp_event_meta_box( $post ) {
 
wp_nonce_field(  plugin_basename( __FILE__ ) , 'event_box_nonce' );

$e_price_event = get_post_meta( $post->ID, 'insapp_price_event', true );
$e_nbr_participant = get_post_meta( $post->ID, 'insapp_nbr_participant', true );
$e_statut_event = get_post_meta( $post->ID, 'insapp_statut_event', true );
$e_started_date = get_post_meta( $post->ID, 'insapp_started_date', true );
$e_end_date = get_post_meta( $post->ID, 'insapp_end_date', true );


include(TLPLUGIN_DIR . 'templates/metebox/event.php');

}

/**
 * Save a custom field of a post type 
 *
 * @param int $post_id The ID of the post being saved.
 */
 function insapp_event_save_data( $post_id ) {

    // Checks save status
         $is_autosave = wp_is_post_autosave( $post_id );
         $is_revision = wp_is_post_revision( $post_id );
         $is_valid_nonce = ( isset( $_POST[ 'event_box_nonce' ] ) && wp_verify_nonce( $_POST[ 'event_box_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

         // Exits script depending on save status
         if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
             return;
         }

         // Checks for input and sanitizes/saves if needed
          if( isset( $_POST[ 'insapp_price_event' ]) ) {
            update_post_meta( $post_id, 'insapp_price_event', sanitize_text_field( $_POST[ 'insapp_price_event' ] ) );
          }
           if( isset( $_POST[ 'insapp_nbr_participant' ]) ) {
            update_post_meta( $post_id, 'insapp_nbr_participant', sanitize_text_field( $_POST[ 'insapp_nbr_participant' ] ) );
          }
          if( isset( $_POST[ 'insapp_statut_event' ]) ) {
            update_post_meta( $post_id, 'insapp_statut_event', sanitize_text_field( $_POST[ 'insapp_statut_event' ] ) );
          }
           if( isset( $_POST[ 'insapp_started_date' ]) ) {
            update_post_meta( $post_id, 'insapp_started_date', sanitize_text_field( $_POST[ 'insapp_started_date' ] ) );
          }
           if( isset( $_POST[ 'insapp_end_date' ]) ) {
            update_post_meta( $post_id, 'insapp_end_date', sanitize_text_field( $_POST[ 'insapp_end_date' ] ) );
          }


 }
add_action( 'save_post', 'insapp_event_save_data' );




  function my_add_event_columns(array $columns) {
    $post_type = get_post_type();
    if ( $post_type == 'evenement' ) {
        $new_columns = array(
            'status' => "Statut de l'evenement",
            'dde' => "Date de debut de l'evenement",
            'dfe' => "Date de fin de l'evenement",
            'prix' => "Cout de l'evenement",
            'nbre_place' => 'Nombre de personnes autorisées',
        );
        return array_merge($columns, $new_columns);
    }
}
add_filter( 'manage_evenement_posts_columns',  'my_add_event_columns' );

function event_columns( $column, $post_id ) {
	switch ( $column ) {
		case 'status':
			$status = get_post_meta( $post_id, 'insapp_statut_event', true );
      if($status == 'Rejeté'){
        echo "<small class='d-inline-flex mb-3 px-2 py-1 fw-semibold text-danger bg-danger bg-opacity-10 border border-danger border-opacity-10 rounded-2'>$status</small>";
      }
      if($status == 'Attente'){
        echo "<small class='d-inline-flex mb-3 px-2 py-1 fw-semibold text-warning bg-warning bg-opacity-10 border border-warning border-opacity-10 rounded-2'>$status</small>";
      }
      if($status == 'Validé'){
        echo "<small class='d-inline-flex mb-3 px-2 py-1 fw-semibold text-success bg-success bg-opacity-10 border border-success border-opacity-10 rounded-2'>$status</small>";
      }
			break;

		case 'dde':
			$dde = get_post_meta( $post_id, 'insapp_started_date', true ) ? get_post_meta( $post_id, 'insapp_started_date', true ) : 'Non définie'; 
      echo $dde;
			break;

    case 'dfe':
			$dfe = get_post_meta( $post_id, 'insapp_end_date', true ) ? get_post_meta( $post_id, 'insapp_end_date', true ) : 'Non définie'; 
      echo $dfe; 
			break;

    case 'prix':
			$p = get_post_meta( $post_id, 'insapp_price_event', true ) ? get_post_meta( $post_id, 'insapp_price_event', true ) : 0; 
      echo $p.' XAX';
			break;

    case 'nbre_place':
			$c = get_post_meta( $post_id, 'insapp_nbr_participant', true ) ? get_post_meta( $post_id, 'insapp_nbr_participant', true ).' personne(s)' : 'Aucune personne'; 
      echo $c; 
			break;
	}
}
add_action( 'manage_evenement_posts_custom_column' , 'event_columns', 10, 2 );

?>