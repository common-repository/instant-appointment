<?php
 
function jspersoJS(){
    if(!empty($_GET['page']) && strpos($_GET['page'], 'insapp_') !== false){
      wp_enqueue_script('toast_ia', TLPLUGIN_URL.'assets/js/jquery.toast.min.js', array('jquery'), null, true);
      wp_enqueue_script('mon_script', TLPLUGIN_URL.'assets/js/mon_script.js', array('jquery'), null, true);
        wp_enqueue_script('Sweetalert', 'https://cdn.jsdelivr.net/npm/sweetalert2@11', array('jquery'), null, true);

        wp_enqueue_script('Bootstrap', TLPLUGIN_URL.'assets/js/bootstrap.min.js');
        wp_enqueue_script('Bootstrap_bundle', TLPLUGIN_URL.'assets/js/bootstrap.bundle.min.js');
        wp_enqueue_script('Select', "https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js");
        if ( ! did_action( 'wp_enqueue_media' ) ) {
            wp_enqueue_media();
        }

        wp_enqueue_script(
          'insapp_admin-datable',
          TLPLUGIN_URL . 'assets/libs/tableExport.min.js',
          ['jquery'],
          time()
        );
       
        wp_enqueue_script(
          'insapp_datable',
          TLPLUGIN_URL . 'assets/libs/bootstrap-table.min.js',
           ['jquery'],
          time()
        );
        wp_enqueue_script(
          'insapp_admin-datable_script',
          TLPLUGIN_URL . 'assets/libs/bootstrap-table-locale-all.js',
          ['jquery'],
          time()
        );

        wp_enqueue_script(
          'insapp_admin-datable_export',
          TLPLUGIN_URL . 'assets/libs/bootstrap-table-export.min.js',
          ['jquery'],
          time()
        );


        wp_enqueue_script('users', TLPLUGIN_URL.'assets/js/insapp_user.js', array('jquery'), null, true);
        wp_localize_script( 'users', 'users_ajax', array('ajaxurl' => admin_url( 'admin-ajax.php' ),));
        wp_enqueue_script('customers', TLPLUGIN_URL.'assets/js/insapp_customer.js', array('jquery'), null, true);
        wp_localize_script( 'customers', 'customers_ajax', array('ajaxurl' => admin_url( 'admin-ajax.php' ),));
        wp_enqueue_script('rdv', TLPLUGIN_URL.'assets/js/insapp_rdv.js', array('jquery'), null, true);
        wp_localize_script( 'rdv', 'rdv_ajax', array('ajaxurl' => admin_url( 'admin-ajax.php' ),));
        wp_enqueue_script('tagify_js', TLPLUGIN_URL.'assets/libs/tagify.min.js', array('jquery'), null, true);
   
        // wp_enqueue_script('tagify_script', 'https://cdn.jsdelivr.net/npm/@yaireo/tagify', array('jquery'));
       
        wp_enqueue_script('subscription_script', TLPLUGIN_URL.'assets/js/js/subscription.js', array('jquery'), null, true);
        wp_localize_script( 'subscription_script', 'subscription_ajax', array('ajaxurl' => admin_url( 'admin-ajax.php' ),));


       
          
    }
}
add_action('admin_enqueue_scripts', 'jspersoJS',10, 0);

function jspersoJS2(){
     // Load upload an thickbox script
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_script('main_script_config', TLPLUGIN_URL.'assets/js/main.js', array('jquery'), null, true);
    wp_enqueue_script('subscription_script', TLPLUGIN_URL.'assets/js/js/subscription.js', array('jquery'), null, true);
    wp_localize_script( 'subscription_script', 'subscription_ajax', array('ajaxurl' => admin_url( 'admin-ajax.php' ),));
}
add_action('admin_enqueue_scripts', 'jspersoJS2',10, 100);

add_filter('script_loader_tag','insapp_add_data_attribute', 10, 2);
function insapp_add_data_attribute($tag, $handle) {

  if ( 'user_auth' !== $handle )
   return $tag;
   $site_key = isset(get_option('insapp_settings_name')['Parametre_recaptcha_sitekey']) ? get_option('insapp_settings_name')['Parametre_recaptcha_sitekey'] : ''; 
  
   if(isset( get_option('insapp_settings_name')['Parametre_recaptcha_sitekey'] )){
    $tst = $site_key; 
   }else{
    $tst = 0 ;
   }
   return str_replace( 'src', 'SITEKEY = '.$tst.' src', $tag );
}


add_filter('script_loader_tag','insapp_add_data_attribute_google_api', 10, 2);
function insapp_add_data_attribute_google_api($tag, $handle) {

  if ( 'agenda_js' !== $handle )
   return $tag;
   $cliendID = isset(get_option('insapp_settings_name')['Parametre_google_cliendID']) ? get_option('insapp_settings_name')['Parametre_google_cliendID'] : ''; 
   $API_KEY = isset(get_option('insapp_settings_name')['Parametre_google_privatekey']) ? get_option('insapp_settings_name')['Parametre_google_privatekey'] : ''; 
   $Redirect_page = isset(get_option('insapp_settings_name')['Parametre_redirect_google']) ? esc_url(get_permalink( get_option('insapp_settings_name')['Parametre_redirect_google'])) : ''; 
  
   if( isset(get_option('insapp_settings_name')['Parametre_google_cliendID']) && 
   isset(get_option('insapp_settings_name')['Parametre_google_privatekey']) &&
   isset(get_option('insapp_settings_name')['Parametre_redirect_google'])){

    $tst1 = $cliendID; 
    $tst2 = $API_KEY; 
    $tst3 = $Redirect_page;

   }else{

    $tst1 = 0; 
    $tst2 = 0; 
    $tst3 = 0; 

   }

   return str_replace( 'src', 'cliendID = "'.$tst1.'" API_KEY = "'.$tst2.'" Redirect_page = "'.$tst3.'" src', $tag );
}



add_action( 'wp_enqueue_scripts','jspersoJS_front',10, 1);
function jspersoJS_front(){
    wp_enqueue_script('Bootstrap_front', TLPLUGIN_URL.'assets/js/bootstrap.min.js', array('jquery'), null, true);
    wp_enqueue_script('Bootstrap_bundle_front', TLPLUGIN_URL.'assets/js/bootstrap.bundle.min.js', array('jquery'));
    wp_enqueue_script('popper_front','https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js', array('jquery'),);
    wp_enqueue_script('services_js', TLPLUGIN_URL.'assets/js/front/services.js', array('jquery'), null, true);
    wp_localize_script('services_js', 'reservation_service_front_ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
    wp_enqueue_script('main_script_config', TLPLUGIN_URL.'assets/js/main.js', array('jquery'), null, true);
    wp_enqueue_script('toast_front', TLPLUGIN_URL.'assets/js/jquery.toast.min.js', array('jquery'), null, true);
    wp_enqueue_script('Sweetalert_front', 'https://cdn.jsdelivr.net/npm/sweetalert2@11', array('jquery'), null, true);
    wp_enqueue_script('Select_js_front', "https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js", null, true);
       

    wp_enqueue_script('flatpickr_js', TLPLUGIN_URL.'assets/libs/flatpickr.min.js', array('jquery'), null, true);
    wp_enqueue_script('quill_js', TLPLUGIN_URL.'assets/libs/quill.min.js', array('jquery'), null, true);
    wp_enqueue_script('feather_js', TLPLUGIN_URL.'assets/libs/feather.min.js', array('jquery'), null, true);
    wp_enqueue_script('dropzone_js', "https://unpkg.com/dropzone@5/dist/min/dropzone.min.js", array('jquery'), null, true);
    wp_enqueue_script('feather_js', TLPLUGIN_URL.'assets/libs/feather.min.js', array('jquery'), null, true);
    wp_enqueue_script('moment_js', TLPLUGIN_URL.'assets/libs/moment.min.js', array('jquery'), null, true);
    wp_enqueue_script('moment_range_js', TLPLUGIN_URL.'assets/libs/moment-range.js', array('jquery'), null, true);
    wp_enqueue_script('insapp_datatable_js','https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js', array('jquery'), null, true);
    // wp_enqueue_script('insapp_chat_js', TLPLUGIN_URL.'assets/libs/chat.js', array('jquery'), null, true);
   
    wp_enqueue_script('calendar_js', TLPLUGIN_URL.'assets/libs/main.js', array('jquery'), null, true);
    wp_enqueue_script('services_js', TLPLUGIN_URL.'assets/js/front/services.js', array('jquery'), null, true);
    wp_localize_script('services_js', 'booking_ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
    wp_enqueue_script('agenda_js', TLPLUGIN_URL.'assets/js/front/agenda.js', array('jquery'), null, true);
    wp_localize_script('agenda_js', 'insapp_agenda_ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
    wp_enqueue_script('dashboard_script_js', TLPLUGIN_URL.'assets/js/front/dashboard.js', array('jquery'), null, true);
    wp_localize_script('dashboard_script_js', 'service_front_ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php')));

    wp_enqueue_script('user_auth', TLPLUGIN_URL.'assets/js/front/login.js', array('jquery'), null, true);
    wp_localize_script('user_auth', 'insapp_user_login', array('ajaxurl' => admin_url( 'admin-ajax.php' ),));

    wp_enqueue_script('profils_script_js', TLPLUGIN_URL.'assets/js/front/profils.js', array('jquery'), null, true);
    wp_localize_script('profils_script_js', 'profils_front_ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
    wp_enqueue_script('templates_script_js', TLPLUGIN_URL.'assets/js/front/templates.js', array('jquery'), null, true);
    wp_localize_script('templates_script_js', 'templates_front_ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
    wp_enqueue_script('ia_owl_carousel_js', TLPLUGIN_URL.'assets/libs/carousel/owl.carousel.min.js', array('jquery'));

    wp_enqueue_script('insapp_gallery_js','https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.js');
   
    wp_enqueue_script('insapp_gallery','https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.js');
    
    wp_enqueue_script(
      'insapp_front-datable',
      TLPLUGIN_URL . 'assets/libs/tableExport.min.js',
      ['jquery'],
      time()
    );
   
    wp_enqueue_script(
      'insapp_front_datable',
      TLPLUGIN_URL . 'assets/libs/bootstrap-table.min.js',
       ['jquery'],
      time()
    );
    wp_enqueue_script(
      'insapp_front-datable_script',
      TLPLUGIN_URL . 'assets/libs/bootstrap-table-locale-all.js',
      ['jquery'],
      time()
    );

    wp_enqueue_script(
      'insapp_front-datable_export',
      TLPLUGIN_URL . 'assets/libs/bootstrap-table-export.min.js',
      ['jquery', 'insapp_google-api','insapp_google-gsi-client'],
      time()
    );

    wp_enqueue_script('toastsd_ia', TLPLUGIN_URL.'assets/js/jquery.toast.min.js', array('jquery'), null, true);
      wp_enqueue_script('mon_ssdsscript', TLPLUGIN_URL.'assets/js/mon_script.js', array('jquery'), null, true);
        wp_enqueue_script('Sweddsetalert', 'https://cdn.jsdelivr.net/npm/sweetalert2@11', array('jquery'), null, true);

        wp_enqueue_script('Bootdddsdstrap', TLPLUGIN_URL.'assets/js/bootstrap.min.js');
        wp_enqueue_script('Bootsdsdstrap_bundle', TLPLUGIN_URL.'assets/js/bootstrap.bundle.min.js');
        wp_enqueue_script('Selddsect', "https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js");
        if ( ! did_action( 'wp_enqueue_media' ) ) {
            wp_enqueue_media();
        }
 
      
      $site_key = isset(get_option('insapp_settings_name')['Parametre_recaptcha_sitekey']) ? get_option('insapp_settings_name')['Parametre_recaptcha_sitekey'] : ''; 

   $recaptcha_version = get_option('insapp_settings_name')['Parametre_recaptcha_version']; 
  if($recaptcha_version == 'v2'){ 
    $link = '?onload=onloadCallback&render=explicit';
  }else if($recaptcha_version == 'v3'){
    $link = '?render='.$site_key.'';
  }else{
    $link = '';
  }

     
      wp_enqueue_script('insapp_recaptcha_js', 'https://www.google.com/recaptcha/api.js'.$link.'', array('jquery'), null, true);
      wp_script_add_data('insapp_recaptcha_js', 'async', true); 
      wp_script_add_data('insapp_recaptcha_js', 'defer', true); 
      $api_key = 'AIzaSyCtVedFCO8vug_BbyuvM9mk3LnznJ-6-yc';
      wp_enqueue_script('insapp_google_place-api', 'https://maps.googleapis.com/maps/api/js?key='.$api_key.'&libraries=places', array('jquery'), null, false);

      wp_enqueue_script('insapp_google-api', 'https://apis.google.com/js/api.js', array('jquery'), null, false);
      wp_script_add_data('insapp_google-api', 'async', true); // Définir le script comme asynchrone
      wp_script_add_data('insapp_google-api', 'defer', true); // Définir le script comme retardé
      
           
      wp_enqueue_script('insapp_google-gsi-client', 'https://accounts.google.com/gsi/client', array('jquery'), null, false);
      wp_script_add_data('insapp_google-gsi-client', 'async', true); // Définir le script comme asynchrone
      wp_script_add_data('insapp_google-gsi-client', 'defer', true); // Définir le script comme retardé  
 
}