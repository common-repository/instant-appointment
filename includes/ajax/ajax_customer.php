<?php
add_action( 'wp_ajax_add_customers_ajax', 'insapp_add_customers' );
function insapp_add_customers() {

    $nom_client = sanitize_text_field( $_POST['nom_client']);
    $prenom_client = sanitize_text_field($_POST['prenom_client']);
    $tel_client = sanitize_text_field($_POST['telephone_client']);
    $email_client = sanitize_email($_POST['email_client']);
    $sexe_client = sanitize_text_field($_POST['sexe_client']);
    $password_client = sanitize_text_field($_POST['password_client']);
    $birthday_client = sanitize_text_field($_POST['birthday_client']);
    $langue_client = sanitize_text_field($_POST['langue_client']);
    $profil_image_client = sanitize_url($_POST['profil_image_client']);
    // wp_send_json('resp');
    if(isset($nom_client) && isset($email_client)){

        $array_result = array(
            'nom_client' => $nom_client,
            'prenom_client' => $prenom_client,
            'email_client' => $email_client,
            'password_client' => $password_client,
            'langue_client' => $langue_client,
            'sexe_client' => $sexe_client,
            'tel_client' => $tel_client,
            'birthday_client' => $birthday_client,
        );
        $meta_client = array(
            'sexe_client' => $sexe_client,
            'telephone_client' => $tel_client,
            'birthday_client' => $birthday_client,
            'first_nom_client'	=> $nom_client, 
            'last_nom_client'	=> $prenom_client,
        );
       

        $userdata = array(
            'user_pass'				=> $password_client,
            'user_login'            => $prenom_client.' '.$nom_client,
            'user_email' 			=> $email_client, 
            'user_url'              => $profil_image_client,
            'user_registered' 		=> '', 	
            'role' 					=> 'insapp_customers',
            'locale' 				=> $langue_client, 
            'meta_input'            => $meta_client,
        );
       $user_id = wp_insert_user( $userdata ) ;

        if ( ! is_wp_error( $user_id ) ) {
            $resp = array(
                'code' => 200,
                'message' => "Client créé avec succès!"
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


/************************************************************
***********            Update                  **************
************************************************************/

add_action( 'wp_ajax_update_customers_ajax', 'insapp_update_customers_ajax' );
function insapp_update_customers_ajax() {
    $id = $_POST['client_id'];
    $user = get_user_by('ID', $id);
    $telephone_client = get_user_meta($user->ID, 'telephone_client', true);
    $sexe_client = get_user_meta($user->ID, 'sexe_client', true);
    $nom_client = get_user_meta($user->ID, 'first_nom_client', true);
    $prenom_client = get_user_meta($user->ID, 'last_nom_client', true);
    $email_client = $user->user_email;
    $profil_client = $user->user_url;
    $langue_client = get_user_locale($user->ID, 'locale', true);
    $birthday_client = get_user_meta($user->ID, 'birthday_client', true);

        $array_result = array(
            'nom_client' => $nom_client,
            'prenom_client' => $prenom_client,
            'email_client' => $email_client,
            'profil_client' => $profil_client,
            'langue_client' => $langue_client,
            'sexe_client' => $sexe_client,
            'tel_client' => $telephone_client,
            'birthday_client' => $birthday_client,
            'id_client' => $id,
        );


	wp_send_json($array_result);
}

add_action( 'wp_ajax_save_update_customers_ajax', 'insapp_save_update_customers' );
function insapp_save_update_customers() {
    $id_client = sanitize_text_field( $_POST['id_client']);
    $nom_client = sanitize_text_field( $_POST['nom_client']);
    $prenom_client = sanitize_text_field($_POST['prenom_client']);
    $tel_client = sanitize_text_field($_POST['telephone_client']);
    $email_client = sanitize_email($_POST['email_client']);
    $sexe_client = sanitize_text_field($_POST['sexe_client']);
    $password_client = sanitize_text_field($_POST['password_client']);
    $birthday_client = sanitize_text_field($_POST['birthday_client']);
    $langue_client = sanitize_text_field($_POST['langue_client']);
    $profil_image_client = sanitize_url($_POST['profil_image_client']);
    // wp_send_json('resp');
    if(isset($nom_client) && isset($email_client)){

        $array_result = array(
            'id_client' => $id_client,
            'nom_client' => $nom_client,
            'prenom_client' => $prenom_client,
            'email_client' => $email_client,
            'password_client' => $password_client,
            'langue_client' => $langue_client,
            'sexe_client' => $sexe_client,
            'tel_client' => $tel_client,
            'birthday_client' => $birthday_client,
        );
        $meta_client = array(
            'sexe_client' => $sexe_client,
            'telephone_client' => $tel_client,
            'birthday_client' => $birthday_client,
            'first_nom_client'	=> $nom_client, 
            'last_nom_client'	=> $prenom_client,
        );
       

        $userdata = array(
            'ID'                    => $id_client,
            'user_pass'				=> $password_client,
            'user_login'            => $prenom_client.' '.$nom_client,
            'user_email' 			=> $email_client, 
            'user_url'              => $profil_image_client,
            'user_registered' 		=> '', 	
            'role' 					=> 'insapp_customers',
            'locale' 				=> $langue_client, 
            'meta_input'            =>$meta_client,
        );
       $user_id = wp_update_user( $userdata ) ;

        if ( ! is_wp_error( $user_id ) ) {
            $resp = array(
                'code' => 200,
                'message' => "Client a bien été enregistré!"
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


add_action( 'wp_ajax_delete_customers_ajax', 'insapp_delete_customers_ajax' );
function insapp_delete_customers_ajax() {


    $id = $_POST['client_id'];
    $status = wp_delete_user($id);
    if($status) {
            $resp = array(
                'code' => 200,
                'message' => 'Client supprime avec succes!'
            );
        }else{
            $resp = array(
            'code' => 400,
	        'message' => $user_id->get_error_messages(),
            );
        }

	wp_send_json($resp);

}