<?php  

function ajax_agenda_step_default_ajax_callback(){
   
    $user_id = sanitize_text_field( $_POST['user_id'] );
    $starthour = sanitize_text_field( $_POST['starthour'] );
    $endhour = sanitize_text_field( $_POST['endhour'] );
    $starthour2 = sanitize_text_field( $_POST['starthour2'] );
    $endhour2 = sanitize_text_field( $_POST['endhour2'] );
    $agenda_default = json_encode( $_POST['agenda_default'] );
   
     update_user_meta( $user_id, 'agenda_default', $agenda_default );
     update_user_meta( $user_id, 'starthour_default', $starthour );
     update_user_meta( $user_id, 'endhour_default', $endhour );
     update_user_meta( $user_id, 'starthour_default2', $starthour2 );
     update_user_meta( $user_id, 'endhour_default2', $endhour2 );
     

    if (isset($_POST['user_id'])) {
        
        $user_id = sanitize_text_field( $_POST['user_id'] );

        $response = array(
            'success' => true,
            "agenda_default" => json_decode(get_user_meta( $user_id, 'agenda_default' , true )),
            "starthours" => get_user_meta( $user_id, 'starthour_default' , true ),
            "endhours" => get_user_meta( $user_id, 'endhour_default' , true ),
            "starthours2" => get_user_meta( $user_id, 'starthour_default2' , true ),
            "endhours2" => get_user_meta( $user_id, 'endhour_default2' , true ),
        );
        wp_send_json_success($response);

      } else {
        $response = array(
          'success' => false,
          'message' => 'Aucune disponibilité trouvée'
        );
        wp_send_json_error($response);

      }
}
add_action( 'wp_ajax_agenda_step_default_ajax','ajax_agenda_step_default_ajax_callback');
add_action( 'wp_ajax_nopriv_agenda_step_default_ajax','ajax_agenda_step_default_ajax_callback');


function ajax_insert_agenda_callback(){

    if (isset($_POST['user_id'])) {
        
        $user_id = sanitize_text_field( $_POST['user_id'] );
        $eventdata = json_decode(json_encode($_POST['events'])) ;
        insapp_insert_drop_table();
    
        foreach ($eventdata as $key => $value) {
           $date_event = $value->date;
           $timeEvent = json_encode($value->times); 

           $result = insapp_insert_event_calendar($date_event, $user_id, $timeEvent);

        } 
      
        $response = array(
            'success' => true,
            "agenda_default" => json_decode(get_user_meta( $user_id, 'agenda_default' , true )), 
            'message' => 'Le crénaux ont été ajouté avec success'
        );
        wp_send_json_success($response);

      } else {
        $response = array(
          'success' => false,
          'message' => 'Echec de l\'enregistrement'
        );
        wp_send_json_error($response);

      }
}

add_action( 'wp_ajax_ajax_insert_agenda','ajax_insert_agenda_callback');
add_action( 'wp_ajax_nopriv_ajax_insert_agenda','ajax_insert_agenda_callback');

function select_default_agenda_callback(){ 

  if (isset($_GET['param1'])) {
      
      $user_id = sanitize_text_field( $_GET['param1'] );
      $result = insapp_select_agenda( $user_id);

      wp_send_json_success($result);

    } else {
      $response = array(
        'success' => false,
        'message' => 'Aucune disponibilité trouvée'
      );
      wp_send_json_error($response);

    }
}

add_action( 'wp_ajax_select_default_agenda','select_default_agenda_callback');
add_action( 'wp_ajax_nopriv_select_default_agenda','select_default_agenda_callback');


function ajax_insert_unique_agenda_callback(){

  if (isset($_POST['user_id'])) {
      
      $user_id = sanitize_text_field( $_POST['user_id'] );
      $eventdata = json_decode(json_encode($_POST['events'])) ;
     
         $date_event = $eventdata->date;
         $timeEvent =  $eventdata->times; 

         $result = insapp_insert_event_calendar($date_event, $user_id, $timeEvent);

         $response = array(
          'success' => $result,
          'message' => 'Le crénaux a été ajouté avec success'
        );
 
      wp_send_json_success($response);

    } else {
      $response = array(
        'success' => false,
        'message' => 'Echec de l\'enregistrement'
      );
      wp_send_json_error($response);

    }
}

add_action( 'wp_ajax_ajax_insert_unique_agenda','ajax_insert_unique_agenda_callback');
add_action( 'wp_ajax_nopriv_ajax_insert_unique_agenda','ajax_insert_unique_agenda_callback');


add_action('wp_ajax_insapp_send_chat_message', 'insapp_send_chat_message_callback');
add_action('wp_ajax_nopriv_insapp_send_chat_message', 'insapp_send_chat_message_callback');
function insapp_send_chat_message_callback() {

    if (isset($_POST['sender_id'], $_POST['receiver_id'])) {
 
        $sender_id = intval($_POST['sender_id']);
        $message = strval($_POST['message']);
        $receiver_id = intval($_POST['receiver_id']);
        $conversation_id = intval($_POST['conversation_id']);
        
        $result = insapp_insert_message( $sender_id ,$receiver_id, $message,$conversation_id);
 
        wp_send_json($conversation_id);
    }else{
      wp_send_json_error('Une erreur c\'est produite');
    }
    
}
 


add_action('wp_ajax_insapp_get_chat_conversation', 'insapp_get_chat_conversation_callback');
add_action('wp_ajax_nopriv_insapp_get_chat_conversation', 'insapp_get_chat_conversation_callback');
function insapp_get_chat_conversation_callback() {

    if (isset($_POST['conversation_id'])) {

        $conversation_id = intval($_POST['conversation_id']);
        $receiver_id = intval($_POST['receiver_id']);
        $user_id = get_current_user_id();  
        function fandatestime($daten){
          $date=date_create($daten);
          return date_format($date,"d M Y , H:i");
         }
         function fandtime($daten){
          $date=date_create($daten);
          return date_format($date,"H:i");
         }
      

        ob_start();
        ?>
        <div class="card-body" id="insapp_conversation_list" data-id="<?php _e($conversation_id) ?>"style="height: 650px; overflow:auto">
              <input type="hidden" class="insapp_chat_receiver" value="<?php _e($receiver_id) ?>">
              <input type="hidden" class="insapp_chat_sender" value="<?php _e($user_id) ?>">

             <?php 
                $list_messages = insapp_get_all_message_($conversation_id);
                // var_dump($list_messages);
                foreach ($list_messages as $list_message ) {
                    
                    $sender_id = $list_message->sender_id;
                    $receiver_id = $list_message->receiver_id;
                    $message = $list_message->smsmessage;
                    $date_ = $list_message->timestamp;
                                $date_time = fandatestime($date_) ; 
                                $time = fandtime($date_); 
                            
                    
                    
                    if($user_id == $sender_id ){  

                        $user_info2 = get_userdata($sender_id); 
                        $name2 = $user_info2->display_name;   
                        $profile_photo_url = get_user_meta($sender_id, 'wp_user_avatar', true);

                        if ($profile_photo_url) {
                        $user_img2 = $profile_photo_url;
                        } else {
                            $user_img2 =  TLPLUGIN_DEFAULT. '/avatar-fallback.jpg';
                        }
                        ?>

                        <div class="d-flex justify-content-end mb-4">      
                            <div class="d-flex ">
                                
                                <div class=" me-3 text-end">
                                    <small> <?php _e($time) ?></small>
                                    <div class="d-flex">
                                        <div class="me-2 mt-2">
                                            
                                        
                                        </div>
                                        
                                        <div class="card mt-2 rounded-top-md-end-0 bg-primary text-white ">
                                            
                                            <div class="card-body text-start p-2">
                                                <p class="mb-0">
                                                <?php _e($message) ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                   
                            </div>
                        </div>

                    <?php
                        
                    }else{
                        
                        $user_info2 = get_userdata($sender_id); 
                        $name2 = $user_info2->display_name;   
                        $profile_photo_url = get_user_meta($sender_id, 'wp_user_avatar', true);

                        if ($profile_photo_url) {
                        $user_img2 = $profile_photo_url;
                        } else {
                        $user_img2 =  TLPLUGIN_DEFAULT. '/avatar-fallback.jpg';
                        }

                    ?>

                        <div class="d-flex  mb-4">
                            
                            <div class=" ms-3">
                                <small><span class="username"><?php _e($name2) ?></span> , <?php _e($time) ?></small>
                                <div class="d-flex">
                                    <div class="card mt-2 rounded-top-md-left-0 border">
                                        <div class="card-body p-2">
                                            <p class="mb-0 text-dark">
                                                <?php  _e($message) ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="ms-2 mt-2">
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    <?php }
                    
                ?>
                <?php } ?>
          </div>
 
      <?php
 
      $ajax_out = ob_get_clean();
      wp_send_json( $ajax_out); 
    }else{
      wp_send_json_error('Une erreur c\'est produite');
    }
    
}

add_action('wp_ajax_insapp_get_chat_messages', 'insapp_get_chat_messages_callback');
add_action('wp_ajax_nopriv_insapp_get_chat_messages', 'insapp_get_chat_messages_callback');
function insapp_get_chat_messages_callback() {

    if (isset($_POST['sender_id'], $_POST['receiver_id'])) {
        global $wpdb; 

        $sender_id = intval($_POST['sender_id']);
        $message = $_POST['message'];
        $receiver_id = intval($_POST['receiver_id']);
        $result = insapp_get_message( $sender_id ,$receiver_id,$message);
        
        wp_send_json($results);
    }else{
      wp_send_json_error('Une erreur c\'est produite');
    }
    
}

add_action('wp_ajax_insapp_newconverstion_ajax', 'insapp_newconverstion_ajax_callback');
add_action('wp_ajax_nopriv_insapp_newconverstion_ajax', 'insapp_newconverstion_ajax_callback');
function insapp_newconverstion_ajax_callback() {

    if (isset($_POST['sender_id'], $_POST['receiver_id'])) {

        $sender_id = intval($_POST['sender_id']);
        $message = intval($_POST['message']);
        $receiver_id = intval($_POST['receiver_id']);

        $conversation = insapp_select_conversation($sender_id ,$receiver_id);
   
        if(empty($conversation)){
           $result = insapp_add_conversation( $sender_id ,$receiver_id);
           wp_send_json($result);
        }else{
         $coversation_id = $conversation[0]->id;
         $messages = insapp_get_all_message_( $conversation_id);
          wp_send_json($messages);
        }
       
    }else{

      wp_send_json_error('Une erreur c\'est produite.');

    }
    
}


add_action('wp_ajax_insapp_get_booking_information', 'insapp_get_booking_information_callback');
add_action('wp_ajax_nopriv_insapp_get_booking_information', 'insapp_get_booking_information_callback');
 
function insapp_get_booking_information_callback() {
 
    if (isset($_POST['book_id']) ) {
  
        $book_id = $_POST['book_id'] ;
        
     
        $order = wc_get_order(  $book_id  ); 
        $date = date('Y-m-d',strtotime( get_post_meta( $book_id  , '_booking_date', true )));
        $time = get_post_meta( $book_id  , '_booking_time', true );  
        $time_parts = explode(' - ', $time);
        $start_time = date('H:i',strtotime($time_parts[0])); 
        $end_time = date('H:i',strtotime($time_parts[1]));
        $description = "reservation sur le site ". get_bloginfo('name')." ";

        foreach( $order->get_items() as $item_id => $item ) {
          $name = $item->get_name(); 
          $duration = get_post_meta($product_id,'_duration',true);                                    
        }
    
   

          $data = array(
            'summary' => $name,
            'description' => $description,
            'location'=> 'location',
            'start' => array(
               'dateTime'=> $date .'T'. $start_time.':00',
              'timeZone' =>'America/Los_Angeles',
            ),
            'end' => array(
              'dateTime'=> $date .'T'. $end_time.':00',
              'timeZone' => 'America/Los_Angeles',
           )

          );

      
          $response = array(
            'success' => true,
            'message' => 'La réservation a été ajouté sur votre google agenda',
            'data' => $data
          );
          wp_send_json($response);
         
    } else {

      $response = array(
        'success' => false,
        'message' => 'Une erreur est survenu veuillez contacter l\'adminstrateur'
      );
      wp_send_json($response);

    }

}



// Dans votre plugin PHP
add_action('wp_ajax_insapp_store_access_token', 'insapp_store_access_token_callback');
add_action('wp_ajax_nopriv_insapp_store_access_token', 'insapp_store_access_token_callback');
// && isset($_POST['refresh_token']) && isset($_POST['expires_in'])
function insapp_store_access_token_callback() {
 
    if (isset($_POST['access_token']) ) {
  
        $user_id = get_current_user_id();  
        
    	update_user_meta($user_id, 'google_access_token', $_POST['access_token']);
        // update_user_meta($user_id, 'google_refresh_token', $_POST['refresh_token']);
        // update_user_meta($user_id, 'google_access_token_expires_in', $_POST['expires_in']);

    
        if ( is_int( $user_id ) ) {

          $response = array(
            'success' => 'true',
            'message' => 'Connextion réussite'
          );

          wp_send_json($response);
        }else {

          $response = array(
            'success' => false,
            'message' => 'Une erreur est survenu veuillez contacter l\'adminstrateur'
          );
          wp_send_json($response);
        }
        

    } else {

      $response = array(
        'success' => false,
        'message' => 'Une erreur est survenu veuillez contacter l\'adminstrateur'
      );
      wp_send_json($response);

    }

}