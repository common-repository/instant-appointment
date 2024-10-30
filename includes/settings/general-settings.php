<?php

function insapp_settings_page() {

  // If plugin settings don't exist, then create them
  if( false == get_option( 'insapp_general_settings' ) ) {
    add_option( 'insapp_general_settings' );
  }
  add_settings_section( 'Parametre_general', __( 'General' ), 'ia_settings_callback', 'insapp_general');

    add_settings_field( 'Parametre_title',__( 'Nom de l\'entreprise'), 'ia_title_callback','insapp_general','Parametre_general');
    add_settings_field('Parametre_description',__( 'Description'),'ia_description_callback','insapp_general','Parametre_general',);
    add_settings_field('Parametre_mail',__( 'Email'), 'ia_mail_callback','insapp_general','Parametre_general');
    add_settings_field( 'Parametre_adress',__( 'Adresse'), 'ia_adresscallback','insapp_general','Parametre_general');
    add_settings_field('Parametre_numero',__( 'Telephone'), 'ia_numerocallback','insapp_general','Parametre_general');
    
    add_settings_field('Parametre_principale_color',__( 'Couleur principale'), 'ia_principale_color_callback','insapp_general','Parametre_general');
    add_settings_field('Parametre_secondary_color',__( 'Couleur au survol'), 'ia_secondary_color_callback','insapp_general','Parametre_general');
    
    add_settings_field('Parametre_google_cliendID',__( 'Google Client ID'), 'ia_google_clien_id_callback','insapp_general','Parametre_general');
    add_settings_field('Parametre_google_privatekey',__( 'Google API KEY'), 'ia_google_api_keycallback','insapp_general','Parametre_general');
    add_settings_field('Parametre_redirect_google',__( 'Redirect page'), 'ia_google_redirect_callback','insapp_general','Parametre_general');
   
    add_settings_field('Dashboard_page',__( 'Page Dashboard<p class="fs-6 fw-light text-wrap">Page Principale du tableau de bord</p>', 'insapp_general'), 'insapp_page_dashboard_callback','insapp_general','Parametre_general');
    add_settings_field('Login_page',__( 'Page d\'authentification<p class="fs-6 fw-light text-wrap">Affichage de la Page d\'authentification</p>', 'insapp_general'), 'insapp_page_authentification_callback','insapp_general','Parametre_general');
    add_settings_field('Chat_page',__( 'Page de messagerie<p class="fs-6 fw-light text-wrap">Page de chat pour les utilisateurs</p>', 'insapp_general'), 'insapp_page_chat_callback','insapp_general','Parametre_general');
    add_settings_field('Agenda_page',__( 'Page de l\'agenda<p class="fs-6 fw-light text-wrap">Page pour l\'agenda des utilisateurs</p>', 'insapp_general'), 'insapp_page_agenda_callback','insapp_general','Parametre_general');
   add_settings_field('private_policy_page',__( 'Page private policy<p class="fs-6 fw-light text-wrap">Page private policy</p>', 'insapp_general'), 'insapp_page_private_policy_callback','insapp_general','Parametre_general');
   
    add_settings_field( 'Parametre_recaptcha_version',__( 'Recaptcha version <p class="fs-6 fw-light text-wrap">Il est important de choisir la version</p>'), 'ia_recaptcha_version_callback','insapp_general','Parametre_general',
    [     
    'option_1' => 'v2',
    'option_2' => 'v3',
    ]);
     add_settings_field( 'Parametre_recaptcha_privatekey',__( 'recaptcha private key<p class="fs-6 fw-light text-wrap">Recuperer la private key from https://www.google.com/recaptcha/admin#list</p>'), 'ia_recaptcha_private_keycallback','insapp_general','Parametre_general');
   
    add_settings_field( 'Parametre_recaptcha_sitekey',__( 'recaptcha site key<p class="fs-6 fw-light text-wrap">Recuperer la site key from https://www.google.com/recaptcha/admin#list</p>'), 'ia_recaptcha_site_keycallback','insapp_general','Parametre_general');
  
  register_setting(
    'insapp_general_settings',
    'insapp_settings_name'
  );
   
}
add_action( 'admin_init', 'insapp_settings_page' );

function ia_settings_callback() {

}

function ia_title_callback() {

  $options = get_option( 'insapp_settings_name' );
  $titre = '';
  if( isset( $options[ 'Parametre_title' ] ) ) {
    $titre = esc_html( $options['Parametre_title'] );
  } else{ 
    $titre =  get_site_option( 'site_name' ) ;
  }
  echo '<input type="text" id="Parametre_title" name="insapp_settings_name[Parametre_title]" value="' . $titre . '" />';
}

function ia_description_callback() {

  $options = get_option( 'insapp_settings_name' );
  $titre = '';
  if( isset( $options[ 'Parametre_description' ] ) ) {
    $titre = esc_html( $options['Parametre_description'] );
  } else{ 
    $titre =  get_site_option( '' ) ;
  }
  echo '<textarea id="Parametre_description" name="insapp_settings_name[Parametre_description]">'. $titre .'</textarea>';
}

function ia_mail_callback() {

  $options = get_option( 'insapp_settings_name' );
  $titre = '';
  if( isset( $options[ 'Parametre_mail' ] ) ) {
    $titre = esc_html( $options['Parametre_mail'] );
  } else{ 
    $titre =  get_site_option( 'admin_email' ) ;
  }
  echo '<input type="text" id="Parametre_mail" name="insapp_settings_name[Parametre_mail]" value="' . $titre . '" />';
}

function ia_adresscallback() {

  $options = get_option( 'insapp_settings_name' );
  $titre = '';
  if( isset( $options[ 'Parametre_adress' ] ) ) {
    $titre = esc_html( $options['Parametre_adress'] );
  }
  echo '<input type="text" id="Parametre_adress" name="insapp_settings_name[Parametre_adress]" value="' . $titre . '" />';
}

function ia_recaptcha_version_callback($args) {

  $options = get_option('insapp_settings_name');
  $captcha = '';
  if( isset( $options['Parametre_recaptcha_version']) ) {
    $captcha = esc_html($options['Parametre_recaptcha_version']);
  }

    $html = '<select id="Parametre_recaptcha_version" name="insapp_settings_name[Parametre_recaptcha_version]"> <option value="0" >Selectionez la version du recaptcha </option>';
    $html .= '<option value="' . $args['option_1'] . '"' . selected( $captcha, $args['option_1'], false) . '>' . $args['option_1'] . '</option>';
    $html .= '<option value="' . $args['option_2'] . '"' . selected( $captcha, $args['option_2'], false) . '>' . $args['option_2'] . '</option>';
    $html .= '</select>';

    echo $html;
  
}

function ia_recaptcha_site_keycallback() {

  $options = get_option( 'insapp_settings_name' );
  $titre = '';
  if( isset( $options[ 'Parametre_recaptcha_sitekey' ] ) ) {
    $titre = esc_html( $options['Parametre_recaptcha_sitekey'] );
  }
  echo '<input type="text" id="Parametre_recaptcha_sitekey" name="insapp_settings_name[Parametre_recaptcha_sitekey]" value="' . $titre . '" />';
}

function ia_recaptcha_private_keycallback() {

  $options = get_option( 'insapp_settings_name' );
  $titre = '';
  if( isset( $options[ 'Parametre_recaptcha_privatekey' ] ) ) {
    $titre = esc_html( $options['Parametre_recaptcha_privatekey'] );
  }
  echo '<input type="password" id="Parametre_recaptcha_privatekey" name="insapp_settings_name[Parametre_recaptcha_privatekey]" value="' . $titre . '" />';
}

function ia_google_clien_id_callback() {

  $options = get_option( 'insapp_settings_name' );
  $titre = '';
  if( isset( $options[ 'Parametre_google_cliendID' ] ) ) {
    $titre = esc_html( $options['Parametre_google_cliendID'] );
  }
  echo '<input type="text" id="Parametre_google_cliendID" name="insapp_settings_name[Parametre_google_cliendID]" value="' . $titre . '" />';
}

function ia_google_api_keycallback() {

  $options = get_option( 'insapp_settings_name' );
  $titre = '';
  if( isset( $options[ 'Parametre_google_privatekey' ] ) ) {
    $titre = esc_html( $options['Parametre_google_privatekey'] );
  }
  echo '<input type="password" id="Parametre_google_privatekey" name="insapp_settings_name[Parametre_google_privatekey]" value="' . $titre . '" />';
}

function ia_google_redirect_callback() {

  $options = get_option( 'insapp_settings_name' );
  $secteur = '';
  if( isset( $options[ 'Parametre_redirect_google' ] ) ) {
    $secteur = esc_html( $options['Parametre_redirect_google'] );
  }
  $pages = get_pages( );
  
  $html = '<select id="Parametre_redirect_google" name="insapp_settings_name[Parametre_redirect_google]"> <option selected disable>Selectioner votre secteur </option>';
  foreach($pages as $page){
  
     $html .= '<option value="'.$page->ID.'"' . selected(isset(get_post($secteur)->post_title)?  get_post($secteur)->post_title : '',isset($page)? $page->post_title : '', false) . '>' . $page->post_title . '</option>';
  }
  $html .= '</select>';
  echo $html;
}


function ia_numerocallback() {

  $options = get_option( 'insapp_settings_name' );
  $titre = '';
  if( isset( $options[ 'Parametre_numero' ] ) ) {
    $titre = esc_html( $options['Parametre_numero'] );
  }
  echo '<input type="tel" id="Parametre_numero" name="insapp_settings_name[Parametre_numero]" value="' . $titre . '" />';
  
}

function ia_secondary_color_callback() {

  $options = get_option( 'insapp_settings_name' );
  $titre = '';
  if( isset( $options[ 'Parametre_secondary_color' ] ) ) {
    $color = esc_html( $options['Parametre_secondary_color'] );
  }
  echo '<input type="color" id="Parametre_secondary_color" name="insapp_settings_name[Parametre_secondary_color]" value="' . $color . '" />';
  
}
function ia_principale_color_callback() {

  $options = get_option( 'insapp_settings_name' );
  $titre = '';
  if( isset( $options[ 'Parametre_principale_color' ] ) ) {
    $color = esc_html( $options['Parametre_principale_color'] );
  }
  echo '<input type="color" id="Parametre_principale_color" name="insapp_settings_name[Parametre_principale_color]" value="' . $color . '" />';
  
}


function insapp_page_dashboard_callback() {

    $options = get_option( 'insapp_settings_name' );
    $secteur = '';
    if( isset( $options[ 'Dashboard_page' ] ) ) {
      $secteur = esc_html( $options['Dashboard_page'] );
    }
    $pages = get_pages( );
    
    $html = '<select id="Dashboard_page" name="insapp_settings_name[Dashboard_page]"> <option selected disable>Selectioner votre secteur </option>';
    foreach($pages as $page){
    
       $html .= '<option value="'.$page->ID.'"' . selected(isset(get_post($secteur)->post_title)?  get_post($secteur)->post_title : '',isset($page)? $page->post_title : '', false) . '>' . $page->post_title . '</option>';
    }
    $html .= '</select>';
    echo $html;
}

function insapp_page_authentification_callback(){

    $options = get_option( 'insapp_settings_name' );
    $secteur = '';
    if( isset( $options[ 'Login_page' ] ) ) {
      $secteur = esc_html( $options['Login_page'] );
    }
    $pages = get_pages( );
    
    $html = '<select id="Login_page" name="insapp_settings_name[Login_page]"> <option selected disable>Selectioner votre secteur </option>';
    foreach($pages as $page){
    
        $html .= '<option value="'.$page->ID.'"' . selected(isset(get_post($secteur)->post_title)?  get_post($secteur)->post_title : '',isset($page)? $page->post_title : '', false) . '>' . $page->post_title . '</option>';
   }
    $html .= '</select>';
    echo $html;

}
function insapp_page_chat_callback(){

    $options = get_option( 'insapp_settings_name' );
    $secteur = '';
    if( isset( $options[ 'Chat_page' ] ) ) {
      $secteur = esc_html( $options['Chat_page'] );
    }
    $pages = get_pages( );
    
    $html = '<select id="Chat_page" name="insapp_settings_name[Chat_page]"> <option selected disable>Selectioner votre secteur </option>';
    foreach($pages as $page){
    
        $html .= '<option value="'.$page->ID.'"' . selected(isset(get_post($secteur)->post_title)?  get_post($secteur)->post_title : '',isset($page)? $page->post_title : '', false) . '>' . $page->post_title . '</option>';
   }
    $html .= '</select>';
    echo $html;

}

function insapp_page_agenda_callback(){
  $options = get_option( 'insapp_settings_name' );
    $secteur = '';
    if( isset( $options[ 'Agenda_page' ] ) ) {
      $secteur = esc_html( $options['Agenda_page'] );
    }
    $pages = get_pages( );
    
    $html = '<select id="Agenda_page" name="insapp_settings_name[Agenda_page]"> <option selected disable>Selectioner votre secteur </option>';
    foreach($pages as $page){
    
        $html .= '<option value="'.$page->ID.'"' . selected(isset(get_post($secteur)->post_title)?  get_post($secteur)->post_title : '',isset($page)? $page->post_title : '', false) . '>' . $page->post_title . '</option>';
   }
    $html .= '</select>';
    echo $html;

}

function insapp_page_private_policy_callback(){

  $options = get_option( 'insapp_settings_name' );
  $secteur = '';
  if( isset( $options[ 'private_policy_page' ] ) ) {
    $secteur = esc_html( $options['private_policy_page'] );
  }
  $pages = get_pages( );
  
  $html = '<select id="private_policy_page" name="insapp_settings_name[private_policy_page]"> <option selected disable>Selectioner  une page </option>';
  foreach($pages as $page){
  
      $html .= '<option value="'.$page->ID.'"' . selected(isset(get_post($secteur)->post_title)?  get_post($secteur)->post_title : '',isset($page)? $page->post_title : '', false) . '>' . $page->post_title . '</option>';
 }
  $html .= '</select>';
  echo $html;

}

/*****************************  section advance *********************/

function insapp_config_hubspot() {

  if( false == get_option( 'insapp_advance_Settings' ) ) {
    add_option( 'insapp_advance_Settings' );
  }

  add_settings_section( 'insapp_setting_api', __( 'Configuration', 'instant_booking' ), 'insapp_settings_callback', 'insapp_advance');

  add_settings_field( 'insapp_setting_token_acces',__( 'Jeton d\'accès:', 'instant_booking'), 'insapp_setting_token_acces_callback','insapp_advance','insapp_setting_api');
  add_settings_field( 'insapp_setting_secret_key',__( 'Clé secréte:', 'instant_booking'), 'insapp_setting_secret_key_callback','insapp_advance','insapp_setting_api');

  register_setting(
    'insapp_advance_Settings',
    'insapp_advance'
  );

}
add_action( 'admin_init', 'insapp_config_hubspot');

function insapp_settings_callback() {

}

function insapp_setting_token_acces_callback() {

  $options = get_option( 'insapp_advance' );
  $token = '';
  if( isset( $options[ 'insapp_setting_token_acces' ] ) ) {
    $token = esc_html( $options['insapp_setting_token_acces'] );
  }
  $html = '<input type="text" class="form-control col-lg-4 col-md-6" id="insapp_setting_token_acces" name="insapp_advance[insapp_setting_token_acces]" value="' . $token . '"/>';
  echo $html;
}

function insapp_setting_secret_key_callback() {

  $options = get_option( 'insapp_advance' );
  $secret_key = '';
  if( isset( $options[ 'insapp_setting_secret_key' ] ) ) {
    $secret_key = esc_html( $options['insapp_setting_secret_key'] );
  }
 
  $html = '<input type="password" class="form-control col-lg-4 col-md-6" id="insapp_setting_secret_key" name="insapp_advance[insapp_setting_secret_key]" value="' . $secret_key . '"/>';
  echo $html;
} 