<?php
 

function insapp_send_user_to_hubspot($user_id) {
    
    $user_info = get_userdata($user_id);  
    
      if ($user_info) {
        $endpoint = 'https://api.hubapi.com/crm/v3/objects/contacts';
        $api_key = get_option('insapp_advance')['insapp_setting_secret_key'];
        $access_token = get_option('insapp_advance')['insapp_setting_token_acces'];
        
        // Préparer les données pour l'API HubSpot
        $data = [
            'properties' => [
                'email' => $user_info->user_email,
                'firstname' => $user_info->first_name,
                'lastname' => $user_info->last_name,
                // Ajoutez d'autres propriétés ici si nécessaire
            ]
        ];
        
        $json_data = json_encode($data);
        
        $response = wp_remote_post($endpoint, [
            'method'    => 'POST',
            'body'      => $json_data,
            'headers'   => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $access_token
            ]
        ]);
        
        
        if (is_wp_error($response)) {
            error_log('Erreur lors de l\'envoi des données à HubSpot: ' . $response->get_error_message());
        } else {
            $body = wp_remote_retrieve_body($response);
            $response_code = wp_remote_retrieve_response_code($response);
            
            if ($response_code == 201) {
                error_log('Utilisateur ajouté à HubSpot avec succès.');
            } else {
                error_log('Erreur de HubSpot: ' . $body);
            }
        }
    } else {
        error_log('Erreur lors de la récupération des informations de l\'utilisateur.');
    }
    
 
}


add_action( 'wp_ajax_register_user_ajax','register_user_ajax_callback');
add_action( 'wp_ajax_nopriv_register_user_ajax','register_user_ajax_callback');
function register_user_ajax_callback(){
	
    $email = sanitize_email($_POST['email']);	
	$nom = sanitize_text_field($_POST['nom']);
	$prenom = sanitize_text_field($_POST['prenom']);
	$user_name = $prenom.' '.$nom;
	$admin_mail = get_option('insapp_settings_name')['Parametre_mail']; 
	$admin_company = get_option('insapp_settings_name')['Parametre_title']; 
	$privacy_policy = sanitize_text_field($_POST['privacy_policy']);

	if ( !$email ) {
		wp_send_json(
		   array(
			   'registered'=>false, 
			   'message'=> __('Veuillez saisir l\'adresse e-mail', 'instant_Appointement')
		   )
	   );
	   die();
  }		
    if ( !is_email($email)  ) {
 		wp_send_json(
        	array(
        		'registered'=>false, 
        		'message'=> __('Cet adresse mail n\'est pas valide', 'instant_Appointement')
        	)
        );
        die();
    }

 	$user_login = sanitize_user(trim($_POST['nom'])); 
	$password = sanitize_text_field(trim($_POST['password']));
	
		if(empty($password)) {
			wp_send_json(
				array(
					'registered'=>false, 
					'message'=> esc_html__( 'Veuillez indiquer votre mot de passe', 'instant_Appointement' )
				)
			);
			die();
		}  
	if(isset($_POST['role'])){
		$role = sanitize_text_field( $_POST['role'] );	
	} else {
		$role = 'insapp_customers';
	}
	if ( email_exists( $email ) ) { 
		wp_send_json(
        	array(
        		'registered'=>false, 
        		'message'=> __('Cette email existe déja', 'instant_Appointement')
        	)
        );
        die();
	}
	if($_POST['role'] == 'insapp_customers'){
		$state ='active';
	} else {
		$state ='inactive';
	}
	
	 $meta = array( 
            'telephone' => '',
            'adresse' => '',
			'_state' => $state,
			'privacy_policy' => $privacy_policy

        );

	$user_data = array(
	    'user_login'    => $user_name.uniqid(rand(), true),
	    'user_email'    => $email, 
        'user_nicename' => $prenom.'-'.$nom,
	    'user_pass'     => $password,
	    'role'			=> $role,
		'first_name'    => $nom,
		'last_name'     => $prenom,
	    'meta_input'    => $meta,
	);

	 $user_id = wp_insert_user( $user_data );
	 insapp_send_user_to_hubspot($user_id);
	 
	 if($admin_mail && $_POST['role'] != 'insapp_customers'){

		$to = $admin_mail;
		$subject = "Nouvelle inscription sur votre plateforme ".$admin_company."";
		$headers = array('Content-Type: text/html; charset=UTF-8','From: '.$admin_company.' <'.$admin_mail.'>','Cc: ReceiverName <second email>' );
		$body = insapp_mail_template_new_user_photographe($user_id); 

		wp_mail( $to, $subject, $body, $headers);

		$to1 = $email;
		$subject1 = "Inscription réussite sur la plateforme ".$admin_company."";
		$headers1 = array('Content-Type: text/html; charset=UTF-8','From: '.$admin_company.' <'.$admin_mail.'>','Cc: ReceiverName <second email>' );
		$body1 = insapp_mail_template_user_photographe($user_id); 

		wp_mail( $to1, $subject1, $body1, $headers1);

	 }else if($admin_mail && $_POST['role'] == 'insapp_customers'){

		$to = $email;
		$subject = "Inscription réussite sur la plateforme ".$admin_company."";
		$headers = array('Content-Type: text/html; charset=UTF-8','From: '.$admin_company.' <'.$admin_mail.'>','Cc: ReceiverName <second email>' );
		$body = insapp_mail_template_user_client($user_id); 

		wp_mail( $to, $subject, $body, $headers);

		$to1 = $admin_mail;
		$subject1 = "Nouvelle inscription sur votre plateforme ".$admin_company."";
		$headers1 = array('Content-Type: text/html; charset=UTF-8','From: '.$admin_company.' <'.$admin_mail.'>','Cc: ReceiverName <second email>' );
		$body1 = insapp_mail_template_new_user_client($user_id); 

		wp_mail( $to1, $subject1, $body1, $headers1);


	 }

	
 
	if (is_wp_error($user_id)){
	 
		  wp_send_json(array('registered'=>false,'message'=> __('Une erreur c\'est produite veuillez réessayer', 'instant_Appointement')));
	} else {
		
	    wp_send_json(array('registered'=>true, 'message'=>esc_html__('Vous avez été enregistré avec succès, vous serez connecté dans un instant.','instant_Appointement')));
	}
 
}

add_action( 'wp_ajax_login_user_ajax', 'login_user_ajax_callback' );
add_action( 'wp_ajax_nopriv_login_user_ajax', 'login_user_ajax_callback' );
function login_user_ajax_callback(){

	    // Nonce is checked, get the POST data and sign user on
	    $info = array(); 
		
	    $email = sanitize_email(trim($_POST['email']));
	    $info['user_password'] = sanitize_text_field(trim($_POST['password'])); 

		if ( !$email  ) {
 		wp_send_json(
        	array(
        		'loggedin'=>false, 
        		'message'=> __('Veuillez saisir l\'adresse e-mail', 'instant_Appointement')
        	)
        );
        
		}		
		if ( !is_email($email )  ) {
			wp_send_json(
				array(
					'loggedin'=>false, 
					'message'=> __('Cette adresse mail n\'est pas valide', 'instant_Appointement')
				)
			); 
		}
	
	    if(empty($email )) {
	    	 wp_send_json(
	    	 	array(
	    	 		'loggedin'=>false, 
	    	 		'message'=> esc_html__( 'Veuillez saisir l\'adresse e-mail', 'instant_Appointement' )
	    	 	  )
				);
	     
	    } 
	    if(empty($info['user_password'])) {
	    	 wp_send_json( 
				array( 
					'loggedin'=>false,
			        'message'=> esc_html__( 'Vous devez entrer un mot de passe pour vous connecter.', 'instant_Appointement' )
				)
			);
	    	  
	    }

		$user = get_user_by( 'email' , $email) ; 
		$info['user_login'] = $user->user_login;   

		if(empty($info['user_login'])) {
	    	 wp_send_json( 
				array( 
					'loggedin'=>false,
			        'message'=> esc_html__( 'Mauvais email, vous n\'avez pas de compte', 'instant_Appointement' )
				)
			);
	    	  
	    }

	    $user_signon = wp_signon( $info, is_ssl() );
	    if ( is_wp_error($user_signon) ){
	    	
	        wp_send_json(
	        	array(
	        		'loggedin'=>false, 
	        		'message'=>esc_html__('Mauvais nom d\'utilisateur ou mot de passe.','instant_Appointement')
	        	)
	        );

	    } else {
	    	wp_clear_auth_cookie();
          //  do_action('wp_login', $user_signon->ID);
            wp_set_current_user($user_signon->ID);
            wp_set_auth_cookie($user_signon->ID, true);
	        wp_send_json(

	        	array(
	        		'loggedin'	=>	true, 
	        		'message'	=>	esc_html__('Connexion réussie, redirection...','instant_Appointement'),
	        	
	        	)

	        );

	    }
 
	}

	

add_action( 'wp_ajax_ia_get_user_account_ajax','ia_get_user_account_ajax_callback');
add_action( 'wp_ajax_nopriv_ia_get_user_account_ajax','ia_get_user_account_ajax_callback');
function ia_get_user_account_ajax_callback() {

	if(isset($_POST['user_id'])){

		
		$user_id = get_current_user_id();
		$check = insapp_get_connect_account($user_id);

		if(empty($check)){
			
			$account_id = insapp_create_account_stripe();
			$account = $account_id->id;
			$test = insapp_add_connect_account( $user_id,$account);
			$link = insapp_get_link_account_stripe( $account);
			
		}else{
		
			$account = $check[0]->account_id;
			$link = insapp_get_link_account_stripe( $account);
		}	
			
		$resp = array(
			'code' => 200,
			'message' => $link, 
		);

	}else{

	$resp = array(
		'code' => 404,
		'message' => 'une erreur c\'est produite veuillez contacter l\'administrateur',
		);

	}

	wp_send_json($resp);
	
}

add_action( 'wp_ajax_update_user_profile_ajax','update_user_profile_ajax_callback');
add_action( 'wp_ajax_nopriv_update_user_profile_ajax','update_user_profile_ajax_callback');
function update_user_profile_ajax_callback() {

		$user_id = get_current_user_id();
		$nom = sanitize_text_field( $_POST['nom']);
		$prenom = sanitize_text_field($_POST['prenom']);
		$pseudo = sanitize_text_field($_POST['pseudo']);
		$telephone = sanitize_text_field($_POST['telephone']);
		$email = sanitize_email($_POST['email']); 

		$filename = $_POST['image_name'];
		$image_url = $_POST['image_url'];  
  
		if(!empty($filename)){
		    
			require_once ABSPATH . 'wp-admin/includes/image.php';
    		require_once ABSPATH . 'wp-admin/includes/file.php';
    		require_once ABSPATH . 'wp-admin/includes/media.php';

			$upload_dir = wp_upload_dir();
			$image_data = file_get_contents( $image_url );

			if ( wp_mkdir_p( $upload_dir['path'] ) ) {
			$file = $upload_dir['path'] . '/' . $filename;
			}
			else {
			$file = $upload_dir['basedir'] . '/' . $filename;
			}
			file_put_contents( $file, $image_data );
			$wp_filetype = wp_check_filetype( $filename, null );
			$attachment = array(
				'guid' => $upload_dir['url'] . '/' . $filename,
				'post_mime_type' => $wp_filetype['type'],
				'post_title' => sanitize_file_name( $filename ),
				'post_content' => '',
				'post_status' => 'inherit'
			);

			$attach_id = wp_insert_attachment( $attachment, $file);
			$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
				wp_update_attachment_metadata( $attach_id, $attach_data ); 
				$attachment_url = wp_get_attachment_url($attach_id);
			
			update_user_meta($user_id, 'wp_user_avatar', $attachment_url);
		}else{
		 
         }

    		$meta = array( 
				'telephone' => $telephone, 
			);
     
			$user_data = array(
				'ID'            => $user_id,
				// 'user_login'    => $prenom.' '.$nom,
				'user_nicename'  => $pseudo,
				'user_email'    => $email,   
				'first_name'    => $nom,
				'last_name'     => $prenom,
				'meta_input'    => $meta,
			);
            $user = wp_update_user( $user_data ) ;
	
	if ( is_int( $user ) ) {

		$resp = array(
			'code' => 200,
			'message' => "Modification réussi",
		);

	}else{
		$resp = array(
		'code' => 400,
		'message' => 'une erreur c\'est produite veuillez contacter l\'administrateur',);
	}

    
	wp_send_json($resp);

}

add_action( 'wp_ajax_update_profile_avance_ajax','update_profile_avance_ajax_callback');
add_action( 'wp_ajax_nopriv_update_profile_avance_ajax','update_profile_avance_ajax_callback');
function update_profile_avance_ajax_callback() {

	if(isset($_POST['user_id'])){

		$user_id = get_current_user_id();
		$facebook = sanitize_text_field( $_POST['facebook']);
		$twitter = sanitize_text_field($_POST['twitter']);
		$instagram = sanitize_text_field($_POST['instagram']); 
		$linkedln = sanitize_text_field($_POST['linkedln']); 
		$adresse = sanitize_text_field($_POST['adresse']); 
		$profil_category = $_POST['profil_category']; 
	    $profil_medium = $_POST['profil_medium']; 
		$description = $_POST['description']; 
			

    		$meta = array( 
				'telephone' => $telephone,
				'adresse' => $adresse,
				'_description' => $description,
				'category' => json_encode( $profil_category ),
				'_medium' => json_encode( $profil_medium ),
				'facebook' => $facebook,
				'twitter' => $twitter,
				'instagram' => $instagram,
				'linkedln' => $linkedln,
				
				
			);
     
			$user_data = array(
				'ID'            => $user_id,
				'meta_input'    => $meta,
			);
            $user = wp_update_user( $user_data ) ;
	
			if ( is_int( $user ) ) {

				$resp = array(
					'code' => 200,
					'message' => "Modification réussi",
				);

			}else{
				$resp = array(
				'code' => 400,
				'message' => 'Une erreur c\'est produite veuillez réessayer',
				);
			}
	}else{

		$resp = array(
				'code' => 404,
				'message' => 'une erreur c\'est produite veuillez contacter l\'administrateur',
				);

	}

    
	wp_send_json($resp);

}

add_action( 'wp_ajax_update_user_password_ajax','update_user_password_ajax_callback');
add_action( 'wp_ajax_nopriv_update_user_password_ajax','update_user_password_ajax_callback');
function update_user_password_ajax_callback() {

	if(isset($_POST['user_id'])){

		$user_id = get_current_user_id();
		$password = sanitize_text_field( $_POST['password']);
        wp_set_password( $password, $user_id );

		$resp = array(
			'code' => 200,
			'message' => "Modification réussi"
		);

	}else{
		$resp = array(
				'code' => 404,
				'message' => 'une erreur c\'est produite veuillez contacter l\'administrateur',
				);
	}
    
	wp_send_json($resp);

}


add_action( 'wp_ajax_ia_verif_token_captcha','ia_verif_token_captcha_callback');
add_action( 'wp_ajax_nopriv_ia_verif_token_captcha','ia_verif_token_captcha_callback');
function ia_verif_token_captcha_callback() {

	$recaptcha_version = get_option('insapp_settings_name')['Parametre_recaptcha_version']; 
	$private_key = isset(get_option('insapp_settings_name')['Parametre_recaptcha_privatekey']) ? get_option('insapp_settings_name')['Parametre_recaptcha_privatekey'] : ''; 
	
	if($recaptcha_version=="v2") {
		if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){

			$captcha = sanitize_text_field( $_POST['g-recaptcha-response']);
		
			$response = file_get_contents(
				"https://www.google.com/recaptcha/api/siteverify?secret=" . $private_key . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']
			);
	
			$response = json_decode($response);
		
			if ($response->success == true ) {
				$resp = array('code' => true,'message' => "sucess");
			}else{
				$resp = array('code' => false,'message' => "reCAPTCHA n'est pas validate");
			}

		}else{
			$resp = array(
					'code' => false,
					'message' => 'Vous avez oublié le reCAPTCHA',
					);
		}
		
		wp_send_json($resp);
	}

	if($recaptcha_version=="v3") {
		if(isset($_POST['token_recaptcha']) && !empty($_POST['token_recaptcha'])){
	
			$captcha = sanitize_text_field( $_POST['token_recaptcha']);
		
			$response = file_get_contents(
				"https://www.google.com/recaptcha/api/siteverify?secret=" . $private_key . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']
			);
	  
			$response = json_decode($response);
		
			if ($response->success === false) {
				$resp = array('code' => false,'message' => "reCAPTCHA n'est pas validate");
			}
			if ($response->success == true && $response->score <= 0.5) {
			 
				$resp = array('code' => false,'message' => "reCAPTCHA n'est pas validate");
			}
			if ($response->success == true && $response->score >= 0.5) {
				$resp = array('code' => true,'message' => "sucess");
			}
	
		}else{
			$resp = array(
					'code' => false,
					'message' => 'Vous avez oublié le reCAPTCHA',
					);
		}
		
		wp_send_json($resp);
	}

}


/* Get vendor gallery*/
add_action( 'wp_ajax_ia_get_profil_gallery', 'ia_get_profil_gallery_fn');
add_action( 'wp_ajax_ia_get_profil_gallery', 'ia_get_profil_gallery_fn');
function ia_get_profil_gallery_fn(){

  $user_id = get_current_user_id(); 
  
   if ( ! is_wp_error( $user_id ) ) {
  
       $gallery = get_user_meta( $user_id, '_gallery' , true ); 
       $list_url = [];
       $gallery_images = json_decode($gallery);
        foreach( $gallery_images as $gallery_image){ 
          array_push($list_url,[ 'url'=> wp_get_attachment_image_src($gallery_image)[0] , 'id' =>$gallery_image]);
        } 
        wp_send_json($list_url);

   }
 
}

/* Save vendor gallery*/
add_action( 'wp_ajax_add_gallery_to_vendor', 'add_gallery_to_vendor_fn');
add_action( 'wp_ajax_nopriv_add_gallery_to_vendor', 'add_gallery_to_vendor_fn');
function add_gallery_to_vendor_fn(){

  $user_id = get_current_user_id();
  $gallery_name = $_POST['user_galerie'];

   if ( ! is_wp_error( $user_id ) ) {
       
        $gallery = get_user_meta( $user_id, '_gallery' , true ) ; 
        
        $old_gallery_images = json_decode($gallery) == "" ? [] :  json_decode($gallery);
        $new_gallery_images = array();
        
		foreach ($gallery_name as $key => $value) {
	     	$attach_gallery_id = insapp_upload_image_as_attachment($value[1],$value[0],$user_id) ;
			array_push( $new_gallery_images, $attach_gallery_id);
		}
		
		$result = array_merge($old_gallery_images, $new_gallery_images);
        
    		$meta = array(  
			'_gallery' => json_encode( $result ), 
		);
		$user_data = array(
			'ID'            => $user_id,
			'meta_input'    => $meta,
		);
		$user = wp_update_user( $user_data ) ;

		if ( is_int( $user ) ) {

			$resp = array(
				'code' => 200,
				'message' =>__('Modification effectuée!', 'instant_Appointement')
			);
		}else{
			$resp = array(
			'code' => 400,
			'message' =>  __('Une erreur c\'est produite veuillez réessayer', 'instant_Appointement')
			);
		}

   
  
   }else{
     
        $resp = array(
        'code' => 400,
        'message' =>  __('Une erreur c\'est produite veuillez contactez l\'administrateur', 'instant_Appointement')
        );
    }
     
    wp_send_json($resp);
 
}