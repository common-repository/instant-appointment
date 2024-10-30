<?php
add_action( 'wp_ajax_get_status_ajax', 'insapp_get_status_ajax' );
function insapp_get_status_ajax() {
    global $wpdb;
    $sql =  "SELECT * FROM wp_insapp_appointment";
    $result = $wpdb->get_results($sql );
    foreach($result as $rdv){ 
        $statut = $rdv->statut_rdv;
    }
    wp_send_json($statut);
}

add_action( 'wp_ajax_set_status_ajax', 'insapp_set_status_ajax' );
function insapp_set_status_ajax() {    
    $rdv = sanitize_text_field($_POST['rdv']);
}


?>