<?php

function insapp_get_password(){
 $comb = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890@& _-^!.?';
 $pass = array(); 
 $combLen = strlen($comb) - 1; 
 for ($i = 0; $i < 8; $i++) {
     $n = rand(0, $combLen);
     $pass[] = $comb[$n];
 }
 print(implode($pass)); 
}

add_action( 'wp_ajax_service_reservation', 'insapp_insert_appointment' );
add_action( 'wp_ajax_nopriv_service_reservation', 'insapp_insert_appointment' );
function insapp_insert_appointment() {
   
    $nom = sanitize_text_field( $_POST['nom']);
    $prenom = sanitize_text_field($_POST['prenom']);
    $tel = sanitize_text_field($_POST['telephone']);
    $email = sanitize_email($_POST['email']);
    $resa_extras = sanitize_text_field($_POST['resa_extras']);
    $date_rdv = sanitize_text_field($_POST['date_rdv']);
    $deb_heure = sanitize_text_field($_POST['deb_heure']);
    $nbr_present = sanitize_text_field($_POST['nbr_present']);
    $resa_unit = sanitize_text_field($_POST['resa_unit']);
    $service_cap = sanitize_text_field($_POST['service_cap']);
    $status = sanitize_text_field($_POST['status']);
    $service_id = sanitize_text_field($_POST['service_id']);

    $resp = array(
        'nom' => $nom,
        'prenom' => $prenom,
        'tel' => $tel,
        'email' => $email,
        'resa_extras' => $resa_extras,
        'date_rdv' => $date_rdv,
        'deb_heure' => $deb_heure,
        'nbr_present' => $nbr_present,
        'resa_unit' => $resa_unit,
        'status' => $status,
        'service_cap' => $service_cap,
        'service_id' => $service_id
    );

    $user = get_user_by('email', $email);
    if($user == false){

        $meta_client = array(
            'sexe_client' => '',
            'telephone_client' => $tel,
            'birthday_client' => '',
            'first_nom_client'	=> $nom, 
            'last_nom_client'	=> $prenom,
        );
       

        $userdata = array(
            'user_pass'				=> insapp_get_password(),
            'user_login'            => $prenom.' '.$nom,
            'user_email' 			=> $email, 
            'user_url'              => '',
            'user_registered' 		=> '', 	
            'role' 					=> 'insapp_customers',
            'locale' 				=> 'Francais', 
            'meta_input'            => $meta_client,
        );
       $user_id = wp_insert_user( $userdata ) ;
    }else{
        $user_id = $user->ID ;
    }
      insapp_insert_service_rdv($service_id, $user_id, 1, '', $resa_unit, $date_rdv, $deb_heure, $status) ;
    insapp_insert_service_rdv(3, 18, 1, 'il;lkjcsax',500, '', '', '$status') ;
     

      wp_send_json($resp);
}
?>