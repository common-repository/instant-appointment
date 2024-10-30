<?php
function insapp_insert_service_rdv($id, $customer_id, $employe_id, $description, $price, $date_rdv, $heure_rdv, $status) {
	global $wpdb;
	
	$table_name = $wpdb->prefix . 'insapp_appointment';
	
	$sql =  "INSERT INTO wp_insapp_appointment(service_id,customer_id,employe_id,description,cout,date_rdv,heure_rdv,statut_rdv)
                        VALUES($id,$customer_id,$employe_id,'$description',$price,'$date_rdv','$heure_rdv','$status')";
	$result = $wpdb->get_results($sql );
	return true;
}


function insapp_insert_event_rdv($id, $customer_id, $employe_id, $description, $price, $date_rdv, $heure_rdv, $status) {
	global $wpdb;
	
	
	$table_name = $wpdb->prefix . 'insapp_appointment';
	
	$wpdb::insert( 
		$table_name, 
		array( 
			'time' => current_time( 'mysql' ), 
	        'event_id' => $id,
	        'customer_id' => $customer_id,
	        'employe_id' => $employe_id,
	        'description' =>  $description,
	        'cout' => $price,
	        'date_rdv' => $date_rdv,
	        'heure_rdv' => $heure_rdv,
	        'statut_rdv' => $status,
	        'create_date' => current_time( 'mysql' )
		) 
	);
}

function insapp_insert_notification($title,$message,$statut,$customer_id,$photograph_id,$reception) {
	global $wpdb;
	$sql =  "INSERT INTO insapp_notification(title,msg,statut,customer_id,photographe_id,reception)
                        VALUES('$title','$message','$statut',$customer_id,$photograph_id,'$reception')";
	$result = $wpdb->get_results($sql );
	return true;
}
function insapp_get_custumer_notification($customer_id) {
	global $wpdb;
	$sql =  "SELECT * FROM insapp_notification WHERE reception = 'client' and customer_id =  $customer_id";
	 $result = $wpdb->get_results($sql);
	return $result;
}

function insapp_get_photographe_notification($photograph_id) {
	global $wpdb;
	$sql =  "SELECT * FROM insapp_notification WHERE reception = 'photographe' and photographe_id =  $photograph_id LIMIT 5";
	 $result = $wpdb->get_results($sql);
	return $result;
}



function insapp_select_agenda( $user_id ) {
	global $wpdb;
	
	$sql =  "SELECT * FROM insapp_appointment_agenda WHERE user_id =  $user_id";
	$result = $wpdb->get_results($sql);
	return $result;
}

function insapp_select_agenda_by_date( $user_id ,$date) {
	global $wpdb;
	
	$sql =  "SELECT star_time FROM insapp_appointment_agenda WHERE user_id =  $user_id AND date_event = '$date'";
	$result = $wpdb->get_results($sql);
	return $result;
}

function insapp_get_calendar_by_date($date_event){
	
	global $wpdb;
	
	$sql =  "SELECT user_id FROM insapp_appointment_agenda WHERE date_event = '$date_event'";

	$result = $wpdb->get_results($sql );
	return $result;
}

function insapp_insert_event_calendar($date_event, $user_id, $star_time){
	
	global $wpdb;
	
	$sql =  "INSERT INTO insapp_appointment_agenda(date_event,user_id,star_time)
             VALUES('$date_event', $user_id, '$star_time' )";
	$result = $wpdb->get_results($sql );
	return true;
}

function insapp_insert_drop_table( ){
	global $wpdb;
	
	$sql = 'DELETE FROM insapp_appointment_agenda';
	$result = $wpdb->get_results($sql );
	return true;
}

// function insapp_get_message( $sender_id ,$receiver_id, $message) {
// 	global $wpdb;
	
// 	$sql =  "SELECT * FROM insapp_chat_messages  WHERE
// 	   (sender_id = $sender_id AND receiver_id = $receiver_id) OR (sender_id = $receiver_id AND receiver_id = $sender_id) 
// 	   ORDER BY timestamp DESC";
// 	$result = $wpdb->get_results($sql );
// 	return $result;
// }
// function insapp_get_all_message_( $conversation_id){
// 	global $wpdb;
// 	$sql =  "SELECT * FROM insapp_chat_messages WHERE conversation_id = $conversation_id ORDER BY timestamp ASC";
// 	$result = $wpdb->get_results($sql );
// 	return $result;
// }
// function insapp_get_last_message_( $conversation_id){
// 	global $wpdb;
// 	$sql =  "SELECT smsmessage FROM insapp_chat_messages WHERE conversation_id = $conversation_id ORDER BY timestamp DESC LIMIT 1";
// 	$result = $wpdb->get_results($sql );
// 	return $result;
// }

// function insapp_insert_message($sender_id,$receiver_id,$message,$conversation_id) {
// 	global $wpdb;
// 	$sql = "INSERT INTO insapp_chat_messages(sender_id,receiver_id,smsmessage,conversation_id) VALUES($sender_id,$receiver_id,'$message',$conversation_id)";
// 	$result = $wpdb->get_results($sql );
// 	return true;
// }

function insapp_add_conversation( $sender_id ,$receiver_id) {
	global $wpdb;
	
	$sql = "INSERT INTO insapp_chat_conversations(sender_id,receiver_id) VALUES($sender_id,$receiver_id)";
	$result = $wpdb->get_results($sql );
	return true;
}
function insapp_select_conversation( $sender_id ,$receiver_id) {
	global $wpdb;
	
	$sql =  "SELECT * FROM insapp_chat_conversations  WHERE
	   (sender_id = $sender_id AND receiver_id = $receiver_id) OR (sender_id = $receiver_id AND receiver_id = $sender_id)";
	$result = $wpdb->get_results($sql );
	return $result;
}
function insapp_select_all_conversation($user_id) {
	global $wpdb;
	$sql =  "SELECT * FROM insapp_chat_conversations  WHERE
	sender_id = $user_id OR receiver_id = $user_id ORDER BY timestamp DESC";
	$result = $wpdb->get_results($sql );
	return $result;
}
function insapp_select_last_conversation($user_id) {
	global $wpdb;
	$sql =  "SELECT * FROM insapp_chat_conversations  WHERE
	sender_id = $user_id OR receiver_id = $user_id ORDER BY timestamp DESC LIMIT 1";
	$result = $wpdb->get_results($sql );
	return $result;
}

function insapp_add_connect_account( $user_id,$account_id ) {
	global $wpdb;

	$sql = "INSERT INTO insapp_user_account_connected(user_id,account_id) VALUES( $user_id,'$account_id')";
	// var_dump($sql );
	$result = $wpdb->get_results($sql );
	return true;
}

function insapp_get_connect_account($user_id) {
	global $wpdb;
	$sql =  "SELECT account_id FROM insapp_user_account_connected  WHERE user_id = $user_id";
	$result = $wpdb->get_results($sql );
	return $result;
}

function insapp_get_connect_account_status($user_id) {
	global $wpdb;
	$sql =  "SELECT connect_status FROM insapp_user_account_connected  WHERE user_id = $user_id";
	$result = $wpdb->get_results($sql );
	return $result;
}
function insapp_change_connect_account_status($user_id ,$status){
	global $wpdb;
	$sql = "UPDATE insapp_user_account_connected SET connect_status ='$status' WHERE user_id = $user_id ";
	$result = $wpdb->get_results($sql);
	return true; // display data
}

?>