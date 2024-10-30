
<?php

if( isset( get_option('Tentee_settings_name')['Parametre_mail'] ) || isset( get_option('Tentee_settings_name')['Parametre_title'] ) ) {
    $ibmail = esc_html( get_option('Tentee_settings_name')['Parametre_mail']  );
    $Ibtitle = esc_html(get_option('Tentee_settings_name')['Parametre_title']);
  }

  // function is_local_environment() {
  //   return ($_SERVER['SERVER_ADDR'] === '127.0.0.1' || $_SERVER['SERVER_ADDR'] === '::1');
  // }


  add_action( 'phpmailer_init', 'insapp_config_mailer' );
  function insapp_config_mailer( $phpmailer ) {
  
        // if ( is_local_environment() ) { 

            // $phpmailer->isSMTP();
            // $phpmailer->Host = $SMTPhost;
            // $phpmailer->SMTPAuth = $PAuth;
            // $phpmailer->Port = $SMTPport;
            // $phpmailer->Username = $user;
            // $phpmailer->Password = $pass; 

        // } else {
           $SMTPhost = 'sandbox.smtp.mailtrap.io';
            $PAuth = true;
            $SMTPport = 2525;
            $user = '029c93737b2b93';
            $pass = '920812721829f4';


             $phpmailer->isSMTP();
             $phpmailer->Host = $SMTPhost;
             $phpmailer->SMTPAuth = $PAuth;
             $phpmailer->Port = $SMTPport;
             $phpmailer->Username = $user;
             $phpmailer->Password = $pass; 
            // Use the default mail function for online environment
            $phpmailer->isMail();
        // }

   }
    
    add_action( 'wp_mail_failed', 'insapp_onMailError', 10, 1 );
    function insapp_onMailError( $wp_error ) {
        echo "<pre>";
        print_r($wp_error);
        echo "</pre>";
    }     

    function insapp_html_mail_content_type() {
      return 'text/html';
    }    
    add_filter( 'wp_mail_content_type', 'insapp_html_mail_content_type' );