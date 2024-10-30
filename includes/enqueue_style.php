<?php

function csspersoCSS(){
    
    if(!empty($_GET['page']) && strpos($_GET['page'], 'insapp_') !== false){

        wp_enqueue_style('toast_admin-ia', TLPLUGIN_URL.'/assets/css/jquery.toast.min.css');
   
        wp_enqueue_style('mon_style', TLPLUGIN_URL.'assets/css/mon-style.css'); 
        wp_enqueue_style('insapp_back_style', TLPLUGIN_URL.'assets/css/style.css'); 
        wp_enqueue_style('Bootstrap', TLPLUGIN_URL.'/assets/css/bootstrap.min.css');
        wp_enqueue_style('tagify_front', TLPLUGIN_URL.'assets/libs/tagify.css');
        // wp_enqueue_style('tagify_css', ' https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css');
        wp_enqueue_style(
            'insapp_toast_admin_css',
            'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css', 
            [],
            time()
        );
        
        wp_enqueue_style('muliselect', "https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" );
        wp_enqueue_style('boostrap_muliselect', "https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" );
        wp_enqueue_style('main_style_config', TLPLUGIN_URL.'/assets/css/main.css'); 
        wp_enqueue_style('thickbox'); 
        
        wp_enqueue_style(
            'insapp-admin-datatable',
            TLPLUGIN_URL . 'assets/libs/bootstrap-table.min.css', 
            [],
            time()
        );
        
        wp_enqueue_style(
            'insapp_iconsoui__boostrap',
            TLPLUGIN_URL.'assets/css/bootstrap-icons.min.css', 
            [],
            time()
        ); 
    }
}
    add_action('admin_enqueue_scripts', 'csspersoCSS',10,1);

function csspersoCSS_front(){
    
    wp_enqueue_style('Bootstrap_front', TLPLUGIN_URL.'assets/css/bootstrap.min.css');
    wp_enqueue_style('style_min_front', TLPLUGIN_URL.'assets/css/css/dashboard.css');
    wp_enqueue_style('dropzone_front', "https://unpkg.com/dropzone@5/dist/min/dropzone.min.css");
    
    wp_enqueue_style('ib_datatable_front', "https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" );
    wp_enqueue_style('ib_datatable_front2', "https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" );
   
    wp_enqueue_style('calendar_css_front', TLPLUGIN_URL.'assets/libs/main.css');
    wp_enqueue_style( 'load-fa', 'https://use.fontawesome.com/releases/v5.15.4/css/all.css?ver=5.0.2' );

  
    wp_enqueue_style('ia_owl_carousel_css_front', TLPLUGIN_URL.'assets/libs/carousel/owl.carousel.min.css');
    wp_enqueue_style('ia_owl_theme_default_css_front', TLPLUGIN_URL.'assets/libs/carousel/owl.theme.default.min.css');
    // wp_enqueue_style('ia_gallery_css_front', TLPLUGIN_URL.'assets/libs/carousel/lightgallery.css');
    // wp_enqueue_style('ia_gallery_zoom_css_front', TLPLUGIN_URL.'assets/libs/carousel/lg-zoom.css');
    // wp_enqueue_style('ia_gallery_thumbnail_css_front', TLPLUGIN_URL.'assets/libs/carousel/lg-thumbnail.css');
    // wp_enqueue_style('ia_gallery_lightgallery-bundl_css_front', TLPLUGIN_URL.'assets/libs/carousel/lightgallery-bundle.css');
   
    wp_enqueue_style('muliselect_front', "https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" );
    wp_enqueue_style('boostrap_muliselect_front', "https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" );

    wp_enqueue_style('style_front', TLPLUGIN_URL.'assets/css/css/services.css');
    wp_enqueue_style('style_login_front', TLPLUGIN_URL.'assets/css/css/login.css');
    wp_enqueue_style('ins_calendar', TLPLUGIN_URL.'assets/css/css/calendar.css');
    wp_enqueue_style('toast_front', TLPLUGIN_URL.'/assets/css/jquery.toast.min.css');
    wp_enqueue_style('insapp_datatable_css', 'https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css');
    wp_enqueue_style('main_style_config_front', TLPLUGIN_URL.'assets/css/css/main_front.css'); 
    wp_enqueue_style('insapp_template_css', TLPLUGIN_URL.'assets/css/css/templates.css');

    wp_enqueue_style('insapp_gallery_css', 'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css');
    wp_enqueue_style(
        'insapp-front-datatable',
        TLPLUGIN_URL . 'assets/libs/bootstrap-table.min.css', 
        [],
        time()
    );
    
    wp_enqueue_style(
        'insapp_iconsoui__boostrap',
        TLPLUGIN_URL.'assets/css/bootstrap-icons.min.css', 
        [],
        time()
    ); 


//   $options = get_option( 'insapp_settings_name' );
//   $custom_css = '';

//   if ( isset( $options['Parametre_secondary_color'] ) ) {
//     $secondary_color = sanitize_hex_color( $options['Parametre_secondary_color'] );
//     $custom_css .= '--secondary-color: ' . $secondary_color . ';';
//   }

//   if ( isset( $options['Parametre_principale_color'] ) ) {
//     $primary_color = sanitize_hex_color( $options['Parametre_principale_color'] );
//     $custom_css .= '--primary-color: ' . $primary_color . ';';
//   }

//   wp_add_inline_style( 'insapp_style_general', $custom_css );
  
      
}
 add_action('wp_enqueue_scripts', 'csspersoCSS_front',10000);