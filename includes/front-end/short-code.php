<?php
add_shortcode( 'insapp_dashboard',  'insapp_dashboard_template' );

add_shortcode( 'insapp_listing_service',  'insapp_listing_service_template' );
function insapp_listing_service_template(){
    ob_start();
    include_once(TLPLUGIN_DIR . 'templates/front-end/listing.php');
    return ob_get_clean();
}

add_shortcode( 'insapp_list_sidebar',  'insapp_list_sidebar_template' );
function insapp_list_sidebar_template(){
    ob_start();
    include_once(TLPLUGIN_DIR . 'templates/front-end/services/testannonce.php');
    return ob_get_clean();
}

add_shortcode( 'insapp_authentification',  'insapp_authentification_template' );
function insapp_authentification_template(){
    ob_start();
    include_once(TLPLUGIN_DIR . 'templates/front-end/account/login.php');
    return ob_get_clean();
}

add_shortcode( 'insapp_dashboard_render',  'insapp_dashboard_render' );
function insapp_dashboard_render($atts){
     ob_start();
    include_once(TLPLUGIN_DIR . 'templates/front-end/dashboard/dashboard.php');
    return ob_get_clean();
}

add_shortcode( 'insapp_chat_render',  'insapp_chat_render_callback' );
function insapp_chat_render_callback($atts){
     ob_start();
    include_once(TLPLUGIN_DIR . 'templates/front-end/dashboard/chat_v2.php');
    return ob_get_clean();
}

add_shortcode( 'insapp_agenda_render',  'insapp_agenda_render_callback' );
function insapp_agenda_render_callback($atts){
     ob_start();
    include_once(TLPLUGIN_DIR . 'templates/front-end/dashboard/agenda_v2.php');
    return ob_get_clean();
}



add_shortcode( 'insapp_my_service',  'insapp_my_service' );
function insapp_my_service($atts){
     ob_start();
    include_once(TLPLUGIN_DIR . 'templates/front-end/dashboard/my_booking.php');
    return ob_get_clean();
}


add_shortcode( 'insapp_profil',  'insapp_profil' );
function insapp_profil($atts){
     ob_start();
    include_once(TLPLUGIN_DIR . 'templates/front-end/dashboard/profil.php');
    return ob_get_clean();
}


add_shortcode( 'insapp_chat',  'insapp_chat' );
function insapp_chat($atts){
     ob_start();
    include_once(TLPLUGIN_DIR . 'templates/front-end/dashboard/chat.php');
    return ob_get_clean();
}


add_shortcode( 'insapp_paiement',  'insapp_paiement' );
function insapp_paiement($atts){
     ob_start();
    include_once(TLPLUGIN_DIR . 'templates/front-end/dashboard/payment.php');
    return ob_get_clean();
}

add_shortcode( 'insapp_list_vendor',  'insapp_list_vendor_callback' );
function insapp_list_vendor_callback(){
     ob_start();
    include_once(TLPLUGIN_DIR . 'templates/front-end/services/list-profil.php');
    return ob_get_clean();
}


add_shortcode( 'insapp_services',  'insapp_services_listing' );
function insapp_services_listing($atts){
   ob_start();
   $atts = shortcode_atts( array(
        'number' => -1,  
    ), $atts, 'insapp_services' );

    $number_elements = intval( $atts['number'] );

    include_once(TLPLUGIN_DIR . 'templates/front-end/services/listing.php');
    return ob_get_clean();
}

add_shortcode( 'insapp_services_slide',  'insapp_services_listing_slide' );
function insapp_services_listing_slide($atts){
    ob_start();
    $atts = shortcode_atts( array(
        'number' => 8,  
    ), $atts, 'insapp_services' );

    $number_elements = intval( $atts['number'] );

    include_once(TLPLUGIN_DIR . 'templates/front-end/services/listing_slide.php');
    return ob_get_clean();
}


add_shortcode( 'insapp_list_search',  'insapp_list_search' );
function insapp_list_search($atts){
    ob_start();
        include_once(TLPLUGIN_DIR . 'templates/front-end/services/list_search.php');
     return ob_get_clean();
}