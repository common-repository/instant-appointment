<?php


add_action( 'wp_ajax_nopriv_ajax_insapp_toggleswitch_order', 'ajax_insapp_toggleswitch_order_callback' );
add_action( 'wp_ajax_ajax_insapp_toggleswitch_order', 'ajax_insapp_toggleswitch_order_callback' );
function ajax_insapp_toggleswitch_order_callback() {

    $id = $_POST['book_id'];
    $etat = sanitize_text_field( $_POST['etat'] == "true")? "cancelled" : "on-hold";

    $order = wc_get_order($id);
 
    if($order){

        $order->update_status(strval($etat));
        $order->save(); 

        $resp = array(
            'code' => 200,
            'message' => "Modification réussite"
        ); 

    }else{

        $resp = array(
            'code' => 404,
	        'message' => "Une erreur est survenue veuillez contactez l'administrateur",
        );

    }

	wp_send_json($resp);

}


add_action( 'wp_ajax_nopriv_ajax_insapp_toggleswitch_user', 'ajax_insapp_toggleswitch_user_callback' );
add_action( 'wp_ajax_ajax_insapp_toggleswitch_user', 'ajax_insapp_toggleswitch_user_callback' );
function ajax_insapp_toggleswitch_user_callback() {

    $id = $_POST['book_id'];
    $etat = sanitize_text_field( $_POST['etat'] == "true")? "active" : "inactive";


    if(isset($id) && isset($etat)){

        $meta = array( 
            '_state'	=> $etat,
        );

        $userdata = array(
            'ID'                    => $id,
            'meta_input'            =>$meta,
        );

       $user_id = wp_update_user( $userdata ) ;

        if ( ! is_wp_error( $user_id ) ) {
            $resp = array(
                'code' => 200,
                'message' => "Modification réussite"
            );
        }else{
            $resp = array(
            'code' => 400,
	        'message' => $user_id->get_error_messages(),
            );
        }

    }else{

        $resp = array(
            'code' => 404,
	        'message' => "Une erreur est survenue veuillez contactez l'administrateur",
        );

    }

	wp_send_json($resp);

}