<?php


function insapp_get_user_order_status_by_product($product_id, $user_id) {
    // Vérifiez si les paramètres sont valides
    if (!$product_id || !$user_id) {
        return false;
    }

    // Obtenez les commandes de l'utilisateur
    $customer_orders = wc_get_orders(array(
        'customer_id' => $user_id,
        'limit' => -1, // Pour obtenir toutes les commandes de l'utilisateur
    ));

    // Parcourez les commandes pour vérifier si le produit est présent
    foreach ($customer_orders as $order) {
        $items = $order->get_items();

        foreach ($items as $item) {
            if ($item->get_product_id() == $product_id) {
                // Retourne le statut de la commande
                return $order->get_status();
            }
        }
    }

    // Retourne false si aucune commande ne contient le produit
    return false;
}

function insapp_has_user_ordered_product($product_id, $user_id) {
    // Vérifiez si les paramètres sont valides
    if (!$product_id || !$user_id) {
        return false;
    }

    // Obtenez les commandes de l'utilisateur
    $customer_orders = wc_get_orders(array(
        'customer_id' => $user_id,
        'limit' => -1, // Pour obtenir toutes les commandes de l'utilisateur
    ));

    // Parcourez les commandes pour vérifier si le produit est présent
    foreach ($customer_orders as $order) {
        $items = $order->get_items();

        foreach ($items as $item) {
            if ($item->get_product_id() == $product_id) {
                // Le produit a été trouvé dans une commande précédente
                return true;
            }
        }
    }

    // Le produit n'a pas été trouvé dans les commandes
    return false;
}
 
function insapp_is_trial_period_over($product_id, $user_id) {

    $order_status = insapp_get_user_order_status_by_product($product_id, $user_id);
    if (!$order_status) {
        return false;
    }

    $customer_orders = wc_get_orders(array(
        'customer_id' => $user_id,
        'limit' => -1,
    ));

    foreach ($customer_orders as $order) {
        $items = $order->get_items();
        foreach ($items as $item) {
            if ($item->get_product_id() == $product_id) {
                $payment_date = $order->get_date_paid();
                if ($payment_date) {
                    
                    $billing_period = get_post_meta($product_id, '_subscription_period', true);
                    $end_date = strtotime("+$billing_period months", strtotime($payment_date));
                 
                    if (strtotime('now') > $end_date) {
                          return true;
                    } else {
                          return false;
                    }
                } else{
                    return false;
                }
            } 
        }
    }
    return false;
}


add_action( 'wp_ajax_ajax_add_reservation_service','ajax_add_reservation_service_callback');
add_action( 'wp_ajax_nopriv_ajax_add_reservation_service','ajax_add_reservation_service_callback');
function ajax_add_reservation_service_callback(){
    
    $customer = wp_get_current_user();
  	$admin_mail = get_option('insapp_settings_name')['Parametre_mail']; 
	$admin_company = get_option('insapp_settings_name')['Parametre_title'];
    $extra = sanitize_text_field($_POST['extra']);
    $service_id = sanitize_text_field( $_POST['service_id'] );
    $photograph_id = get_post($service_id)->post_author;
    $booking_date = sanitize_text_field( $_POST['insapp_booking_date'] );
    $booking_time = sanitize_text_field( $_POST['insapp_booking_time'] );
    $total_price =  sanitize_text_field( $_POST['Total_price'] );
    
    $service_product = wc_get_product($service_id);
    $price = $service_product->get_sale_price();
    
    $billing_address = array(
      'first_name' => $customer->first_name,
      'last_name' => $customer->last_name,
      'address_1' => '123 Main St', // Provide the street address
      'city' => 'City', // Provide the city
      'state' => 'State', // Provide the state
      'postcode' => '12345', // Provide the postal code
      'country' => 'US', // Provide the country code (e.g., US for United States)
      'email' => $customer->user_email, 
      'phone' => '555-555-5555' // Provide the customer's phone number
  );
    $price_params = array( 'totals' => array( 'subtotal' => $price, 'total' => $total_price ) );
  
    $order = wc_create_order();
    // wp_send_json( $order );
    $order->set_status( 'wc-on-hold', 'Order is created programmatically' );

    $order->set_customer_id( $customer->ID );
    $order->set_address($billing_address, 'billing');

    $order->add_product( $service_product , 1, $price_params );
    
     $order->calculate_totals();
     // Calculate 6% commission
     $order_total = $order->get_total();
     $commission = $order_total * 0.06;

     // Add commission as a fee
     $fee = new WC_Order_Item_Fee();
     $fee->set_name('Commission');
     $fee->set_amount($commission);
     $fee->set_tax_class('');
     $fee->set_tax_status('none');
     $fee->set_total($commission);
     $order->add_item($fee);
     
    $order->calculate_totals();
    $order->save();
    $order_id = $order->get_id();
    
    $author_id = get_post_field('post_author', $service_id);
    update_post_meta($order_id, '_annonce_author', $author_id); 
    
    add_post_meta( $order_id, '_booking_date', $booking_date );
    add_post_meta( $order_id, '_booking_time', $booking_time );
    add_post_meta( $order_id, '_booking_extra', $extra );
    add_post_meta( $order_id, '_annonce_product', $service_id );

   
  foreach ($billing_address as $key => $value) {
      update_post_meta($order_id, '_billing_' . $key, $value);
  }
  

    $title = "Nouvelle reservation";
    $message = "Une reservation vient d\'etre effectuee";
    $statut = 'unread';
    $reception = "photographe";

    if(isset($order)){ 

    //$code = insapp_insert_notification($title,$message,$statut,intval($customer->ID),intv$author_idal($photograph_id),$reception); 
      $to= $customer->user_email;
      $subject = 'Confirmation de réception de votre réservation';
      $headers = array('Content-Type: text/html; charset=UTF-8','From: '.$admin_company.' <'.$admin_mail.'>');
      $body = insapp_mail_template_book($order_id); 
       wp_mail($to, $subject, $body, $headers);

      $to1=get_user_by('ID', $author_id)->user_email; 
      $subject1 = 'Confirmation de réception de votre réservation';
      $headers1 = array('Content-Type: text/html; charset=UTF-8','From: '.$admin_company.' <'.$admin_mail.'>');
      $body1 = insapp_mail_ask_book($order_id); 
      wp_mail($to1, $subject1, $body1, $headers1);
        
      $resp = array(
        'code' => 200,
        'message' => 'Reservation réussie',
        'code_resa' => $extra
      );
      wp_send_json(  $resp );


    }else{
      $resp = array(
        'status' => 400,
        'message' => 'Une erreur s\'est produite veuillez contacter l\'administrateur',
      );
      wp_send_json(  $resp );

    }


}

add_action( 'wp_ajax_cancelled_order_status','cancelled_order_status_callback');
add_action( 'wp_ajax_nopriv_cancelled_order_status','cancelled_order_status_callback');
function cancelled_order_status_callback(){
    $order_id = sanitize_text_field( $_POST['order_id'] );
    $order = wc_get_order($order_id);
    	$admin_mail = get_option('insapp_settings_name')['Parametre_mail']; 
	$admin_company = get_option('insapp_settings_name')['Parametre_title'];
    if (!empty($order)) {
      $update_status = $order->update_status('cancelled');
      $customer_id = $order -> get_user_id (); 
      $customer = get_user_by('id', $customer_id);
      $items = $order->get_items();
      foreach ( $items as $item ) { 
        $product_id = $item['product_id']; 
      } 
        $product = get_post($product_id); 
        $author_id  = $product->post_author;
        $author_email = get_user_by('ID', $product->post_author)->user_email;

        $title = "Reservation Annulée";
        $message = "Le photographe a annulé votre reservation";
        $statut = 'unread';
        $reception = "client";
        insapp_insert_notification($title,$message,$statut,intval($customer->ID),intval($author_id),$reception); 

         $to = $customer->user_email;
         $subject = "Réservation annulée par le photographe";
         $headers = array('Content-Type: text/html; charset=UTF-8','From: '.$admin_company.' <'.$admin_mail.'>');
         $body = insapp_mail_template_book_cancel($order_id); 

        wp_mail( $to, $subject, $body, $headers);

        // wp_send_json(  $update_status );
    }else{
         $update_status = 'commande vide!';
    }
    wp_send_json($update_status);
}

add_action( 'wp_ajax_cancelled_cient_order_status','cancelled_cient_order_status_callback');
add_action( 'wp_ajax_nopriv_cancelled_cient_order_status','cancelled_cient_order_status_callback');
function cancelled_cient_order_status_callback(){
    $order_id = sanitize_text_field( $_POST['order_id'] );
    $order = wc_get_order($order_id);
    $customer_id = $order -> get_user_id ();
    	$admin_mail = get_option('insapp_settings_name')['Parametre_mail']; 
	$admin_company = get_option('insapp_settings_name')['Parametre_title'];
    $customer = get_user_by('id', $customer_id);
    if (!empty($order)) {
      $update_status = $order->update_status('cancelled');
      $items = $order->get_items();
      foreach ( $items as $item ) { 
        $product_id = $item['product_id']; 
      } 
        $product = get_post($product_id); 
        $author_id  = $product->post_author;
        $author_email = get_user_by('ID', $product->post_author)->user_email;

        $title = "Reservation Annulée";
        $message = "Un client a annulé la reservation de cette annonce";
        $statut = 'unread';
        $reception = "photographe";
        insapp_insert_notification($title,$message,$statut,intval($customer->ID),intval($author_id),$reception); 

         $to = $author_email;
         $subject = "Réservation annulée par le client";
         $headers = array('Content-Type: text/html; charset=UTF-8','From: '.$admin_company.' <'.$admin_mail.'>');
         $body = insapp_mail_template_client_cancel($order_id); 

        wp_mail( $to, $subject, $body, $headers);

    }else{
         $update_status = 'commande vide!';
    }
 
    wp_send_json($update_status);
}

add_action( 'wp_ajax_deleted_order_status','deleted_order_status_callback');
add_action( 'wp_ajax_nopriv_deleted_order_status','deleted_order_status_callback');
function deleted_order_status_callback(){
    $order_id = sanitize_text_field( $_POST['order_id'] );
    $order = new WC_Order($order_id);
    if (!empty($order)) {
        $update_status = $order->update_status( 'delete' );
    }else{
         $update_status = 'commande vide!';
    };
    wp_send_json($update_status);
}

add_action( 'wp_ajax_payement_order_process','payement_order_process_callback');
add_action( 'wp_ajax_nopriv_payement_order_process','payement_order_process_callback');
function payement_order_process_callback(){

  if (isset($_POST['order_id'])) {
    $order_id = sanitize_text_field($_POST['order_id']);
    $order = wc_get_order($order_id);
      if ($order) {
          $payment_url = $order->get_checkout_payment_url();
          // Redirigez le client vers la page de paiement de cette commande

          wp_send_json($payment_url);

      }
  }else{
    wp_send_json_error( 'La commande n\'existe pas.' );
  }

}

add_action( 'wp_ajax_accepted_order_status','accepted_order_status_callback');
add_action( 'wp_ajax_nopriv_accepted_order_status','accepted_order_status_callback');
function accepted_order_status_callback(){
   $order_id = sanitize_text_field( $_POST['order_id'] );
	$admin_mail = get_option('insapp_settings_name')['Parametre_mail']; 
	$admin_company = get_option('insapp_settings_name')['Parametre_title'];
    $order = new WC_Order($order_id);
    if (!empty($order)) {
      $update_status = $order->update_status( 'pending' );
        $customer_id = $order -> get_user_id (); 
        $customer = get_user_by('id', $customer_id);

        $items = $order->get_items();
        foreach ( $items as $item ) { 
          $product_id = $item['product_id']; 
      } 
        $product = get_post($product_id); 
        $author_id  = $product->post_author;
        $author_name = get_user_by('ID', $product->post_author)->user_nicename;
        $author_email = get_user_by('ID', $product->post_author)->user_email;
        // $pieces_jointes = insapp_facturepdf($order_id);
        $title = "Reservation Approuvée";
        $message = "Le photographe a approuvé votre reservation";
        $statut = 'unread';
        $reception = "client";
        insapp_insert_notification($title,$message,$statut,intval($customer->ID),intval($author_id),$reception); 

         $to = $customer->user_email;
         $subject = "Confirmation d'approbation de votre réservation";
         $headers = array('Content-Type: text/html; charset=UTF-8','From: '.$admin_company.' <'.$admin_mail.'>');
         $body = insapp_mail_template_book_approve($order_id); 

        wp_mail( $to, $subject, $body, $headers);

        // wp_send_json(  $update_status );
    }else{
         $update_status = 'commande vide!';
    }
    wp_send_json($update_status);
}

add_action( 'wp_ajax_achived_order_status','achived_order_status_callback');
add_action( 'wp_ajax_nopriv_achived_order_status','achived_order_status_callback');
function achived_order_status_callback(){
    $order_id = sanitize_text_field( $_POST['order_id'] );

    $order = new WC_Order($order_id);
    if (!empty($order)) {
        $update_status = $order->update_status( 'completed' );
        $title = "Reservation Terminée";
        $message = "Le photographe a marqué cette reservation comme terminé";
        $statut = 'unread';
        $reception = "client";
        insapp_insert_notification($title,$message,$statut,intval($customer->ID),intval($photograph_id),$reception); 

    }else{
         $update_status = 'commande vide!';
    }
    wp_send_json($update_status);
}


add_action( 'wp_ajax_filter_state','filter_state_callback');
add_action( 'wp_ajax_nopriv_filter_state','filter_state_callback');
function filter_state_callback(){
    
    $etat = sanitize_text_field( $_POST['etat'] );
    ob_start();
    
      $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
      $orders_per_page = 5;

      $current_user = wp_get_current_user();
      $author_id = $current_user->ID; 
      
      $args = array(
            'post_type'      => 'shop_order',
            'post_status'    => array($etat ),
            'posts_per_page' => $orders_per_page,
            'paged'          => $paged,
            'meta_query'     => array(
                array(
                    'key'          => '_annonce_product',
                    'compare'      => 'EXISTS',
                ),
                array(
                    'key'     => '_annonce_author', 
                    'value'   => $author_id, 
                    'compare' => '=',
                ),
            ),
        );
      
      $orders = new WP_Query($args);
    
      $total_pages =  $orders->max_num_pages; 
      $total_product =  $orders->found_posts; 

      if ($orders->have_posts()) {
        while ( $orders->have_posts() ) : $orders->the_post(); 

            $order_id = $orders->post->ID; 
            $item = wc_get_order($order_id );
            $order_data = $item->data;
            $status = $order_data[ 'status' ] ;
            // var_dump(json_decode(get_post_meta($order_id) ["_booking_extra"][0]));
            setlocale(LC_TIME, 'fr_FR');
             $order_date = $item->get_date_created();
             $formatted_date = strftime('%e %B %Y, %H:%M', $order_date->getTimestamp());

            $customer_id = $item -> get_user_id (); 
            $customer = get_user_by('id', $customer_id);
            $customer_name = $customer->display_name;
            $customer_email = $customer->user_email;
            
            
            $date = date('j F Y',strtotime( get_post_meta( $order_id, '_booking_date', true )));
            $time = get_post_meta( $order_id, '_booking_time', true );
            $bd_extras = get_post_meta( $order_id, '_booking_extra', true );
            $extras = isset($bd_extras) ? json_decode($bd_extras) : [];
 
                  foreach ($item->get_items() as $item_id => $item_order ) {

                      $product = $item_order->get_product();
                      $product_id = $product->id;

                      $categories = wp_get_post_terms($product_id, 'product_cat',);
                       $categories = wp_get_post_terms($product_id , 'product_cat', array( 'parent' => 0, 'hide_empty' => 0)); 

                      $meta = get_post_meta($product_id);
                      $dure = isset($meta['_duration'][0]) ? $meta['_duration'][0] : 'undefine';
                      
                      $title = $product->name;

                      // var_dump($product->name);
                      switch ($status) {
                        case 'cancelled':{
                          $btn = '<button class="dropdown-item d-flex align-items-center insapp_btn_state btn_delete" type="button" data-id="'.$order_id.'" id="btn_delete">Supprimer
                              </button>';
                          $statut = 'Refusé';
                          break;
                        }   
                            
                        case 'pending':{
                          $btn = '<span class="ia-add-google-calendar" value="'. $order_id.'"  >
                          <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 48 48">
                         <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"></path><path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"></path><path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"></path><path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"></path>
                          </svg>
                         Ajouter agenda
                      </span> ';
                          $statut = 'Accepté';
                          break;

                        } 
                            
                        case 'processing':{
                          $btn = '<button class="dropdown-item d-flex align-items-center insapp_btn_state btn_fini" data-id="'.$order_id.'" type="button" id="btn_fini">Terminer
                                  </button>';
                          $statut = 'Payé';
                          break;

                        }
                        
                        case 'completed':{
                          $btn = '';
                          $statut = 'Terminé';
                          break;

                        }
                            
                        
                        case 'on-hold':{ 
                          $btn = '<div class="d-flex">
                          <button class="dropdown-item d-flex align-items-center insapp_btn_state btn_accepter" data-id="'. $order_id.'" type="button" id="btn_accepter">Accepter
                          </button>

                          <button class="dropdown-item d-flex align-items-center insapp_btn_state text-danger btn_refuser" data-id="'. $order_id.'" type="button" id="btn_refuser">Annuler
                          </button>
                          </div>';
                          $statut = 'En attente';
                          break;
                        }
                        default:{
                          break;
                        }
                            
                      }
                      if($statut == 'Refusé'){
                        $color = 'danger';
                      }elseif($statut == 'Accepté'){
                        $color = 'success';
                      }elseif($statut == 'Terminé'){
                        $color = 'primary';
                      }else{
                        $color = 'warning';
                      }                                                         

                            $url = get_the_post_thumbnail_url($product_id) == false ? TLPLUGIN_URL . 'assets/images/default-placeholder.png': get_the_post_thumbnail_url($product_id);
                                              ?>
                          <div class="row insapp_listing_timeline py-2">
                            <span></span>
                            <input type="hidden" name="the_order_id" id="the_order_id" value="<?php echo $order_id; ?>">
                          </div>
                          <div class="">
                            <div class="row insapp_listing">
                              <div class="col-12 col-md-6">

                                <div class="d-flex align-items-center mb-3 mb-xl-0" style="width:100%">
                                  <div class="insapp_gallery" style="width:40%;background-image: url('<?php _e($url)?>')"> </div>
                                  <div class="ms-3" style="width:60%">
                                    <div class="">
                                      <span class="ia_table_title" style="vertical-align: inherit;">
                                        <?php echo '<span>' .  $title .'</span>' ?>
                                      </span>
                                    </div>
                                    <span class="mb-0 ia_table_text">
                                      <?php echo('Rendez-vous : '.$time) ?>
                                    </span></br>
                                    <span class="mb-0 ia_table_text">
                                      <?php echo 'prix: '.$order_data [ 'total' ].' '. get_woocommerce_currency_symbol(); ?>
                                    </span>
                                  </div>
                                </div>

                              </div>
                              <div class="col-12 col-md-6 d-flex flex-column flex-md-row align-items-center ">
                                <div class="col-12 col-md-4 d-flex  align-items-center  justify-content-start justify-content-md-center ">
                                  <span class="mx-3 badge badge-<?php echo $color; ?>-soft text-<?php echo $color; ?>">
                                    <span style="vertical-align: inherit;">
                                      <span style="vertical-align: inherit;">
                                        <?php echo $statut ; ?>
                                      </span>
                                    </span>
                                  </span>
                                </div>

                                <div class="col-12 col-md-8 d-flex my-5 justify-content-start justify-content-md-end insapp_btn_state align-items-center" role="button">
                                  <span class="ia_table_collapse">
                                    <?php echo $btn ; ?>
                                  </span>
                                </div>

                              </div>
                              
                              <div class="" >
                                <div class="detailslistingcollapse d-flex flex-column">
                                  <div class="mb-0 row">
                                    <span class="ia_table_subtitle col-4">
                                      <?php _e('Catégories: ') ?>
                                    </span>
                                    <div class=" col-8">
                                      <?php foreach($categories as $category){?>
                                        <span class="ia_table_text px-1">
                                            <?php echo $category->name; ?>
                                        </span>
                                          <?php }?>
                                    </div>
                                  
                                  </div>
                                  <!-- <div class="mb-0 row">
                                            <span class="ia_table_subtitle col-4"><?php //_e('Extras') ?></span>
                                            <span class="ia_table_text  col-8">
                                              <?php //foreach($extras as $extra){?>
                                                  <li class="col-1"><?php //echo $extra->nom.' (' .$extra->cout.get_woocommerce_currency_symbol().')' ;?></li>
                                              <?php //}?>
                                            </span>
                                          </div> 
                                        -->
                                        <div class="mb-0 row">
                                          <span class="ia_table_subtitle col-4">
                                            <?php _e('Reservé pour le ') ?>
                                          </span>
                                          <span class="ia_table_text  col-8">
                                            <?php echo $date.' à '.$time; ?>
                                          </span>
                                        </div>
                                        <div class="mb-0 row">
                                          <span class="ia_table_subtitle col-4">
                                            <?php _e('Client') ?>
                                          </span>
                                          <span class="ia_table_text  col-8">
                                            <?php echo $customer_name.' - '.$customer_email ?>
                                          </span>
                                        </div>
                                        <div class="mb-0 row">
                                          <span class="ia_table_subtitle col-4">
                                            <?php _e('Reservé le') ?>
                                          </span>
                                          <span class="ia_table_text  col-8">
                                           
                                            <?php echo $formatted_date?>
                                          </span>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <?php } endwhile; ?>

                                     <nav class="mt-5">
                            			<ul class="pagination mt-5 justify-content-center">
                            			 
                            			<?php if ($paged > 1) : ?>
                            			<li class="page-item">
                            				<a class="page-link" href="<?php echo esc_attr(get_pagenum_link($paged - 1)); ?>" aria-label="Précédent">
                            				<span aria-hidden="true">&laquo;</span>
                            				</a>
                            			</li>
                            			<?php endif; ?>
                            
                                        <?php if ($total_pages > 1) : ?>
                            			<?php
                            				$links_around_current = 5; 
                            				// Afficher les liens numériques avec points de pagination
                            				for ($i = 1; $i <= $total_pages; $i++) {
                            					if ($i === 1 || $i === $total_pages || abs($i - $paged) <= $links_around_current || $total_pages <= 5) {
                            						// Afficher le premier, le dernier et les liens autour de la page actuelle, ou
                            						// afficher tous les liens si le nombre total de pages est inférieur ou égal à 5.
                            						if ($paged === $i) {
                            							echo '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
                            						} else {
                            							echo '<li class="page-item"><a class="page-link" href="' . esc_attr(get_pagenum_link($i)) . '">' . $i . '</a></li>';
                            						}
                            					} elseif (abs($i - $paged) === $links_around_current + 1) {
                            						// Ajouter des points de pagination s'il y a un écart de 2 pages
                            						echo '<li class="page-item disabled"><span class="page-link">&hellip;</span></li>';
                            					}
                            				}
                            				?>
                            			<?php endif; ?>
                            			<?php if ($paged < $total_pages) : ?>
                            			<li class="page-item">
                            				<a class="page-link" href="<?php echo esc_attr(get_pagenum_link($paged + 1)); ?>" aria-label="Suivant">
                            				<span aria-hidden="true">&raquo;</span>
                            				</a>
                            			</li>
                            			<?php endif; ?>
                            			</ul>
                            	 </nav>

     <?php
      } else {  ?>

        <div class="">
          <div class="my-5 insapp_listing">
            <p class="text-muted text-center fw-semibold mt-5" style="font-size: 1rem">
              <?php _e("Vous n'avez aucune reservation client pour l'instant")?>
            </p>
          </div>
        </div>
  <?php }  ?>
      <?php
  $ajax_out = ob_get_clean();
  wp_send_json( $ajax_out);
}

add_action( 'wp_ajax_filter_my_state','filter_my_state_callback');
add_action( 'wp_ajax_nopriv_filter_my_state','filter_my_state_callback');
function filter_my_state_callback(){
    
    $etat = sanitize_text_field( $_POST['etat'] );
    ob_start();
      
      $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $orders_per_page = 5;

        $current_user = wp_get_current_user();
        $user_id = $current_user->ID;

        $args = array(
          'post_type'      => 'shop_order',
          'post_status'    => array($etat ),
          'posts_per_page' => $orders_per_page, 
          'paged' => $paged, 
          'meta_query'     => array(
            'relation' => 'AND',
            array(
                'key'     => '_annonce_product',
                'compare' => 'EXISTS',
            ),
            array(
                'key'     => '_customer_user',
                'value'   => $user_id,
                'compare' => '=',
            ),
        ),
        ); 
        $orders = new WP_Query($args);

       ;
        $total_pages =  $orders->max_num_pages; 
        $total_product =  $orders->found_posts;

        if ($orders->have_posts()) {
          while ( $orders->have_posts() ) : $orders->the_post(); 
          $cpt++;
          $order_id = $orders->post->ID; 
          $item = wc_get_order($order_id );
          $order_data = $item->data;
          $customer_id = $item -> get_user_id (); 
          $customer = get_user_by('id', $customer_id);
          $date = get_post_meta( $order_id, '_booking_date', true );
          $time = get_post_meta( $order_id, '_booking_time', true );
          $bd_extras = get_post_meta( $order_id, '_booking_extra', true );
          $extras = isset($bd_extras) ? json_decode($bd_extras) : [];


            foreach ($item->get_items() as $item_id => $item_order ) {

              $product_id = $item_order["product_id"];
              $product = get_post($product_id);
              $categories = wp_get_post_terms($product_id, 'product_cat');
              $meta = get_post_meta($product_id);
              $dure = isset($meta['_duration'][0]) ? $meta['_duration'][0] : 'undefine';
  
              $title = $product->post_title;
              $author_name = get_user_by('ID', $product->post_author)->display_name;
              $author_email = get_user_by('ID', $product->post_author)->user_email;
              switch ($order_data[ 'status' ]) {
                case 'on-hold':
                  $statut = 'En attente';
                  $btn = '<button class="dropdown-item d-flex align-items-center text-warning insapp_btn_state btn_refuser_client" data-id="'. $order_id.'" type="button" id="btn_refuser">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 me-2 icon-xs">
                                  <polyline points="3 6 5 6 21 6"></polyline>
                                  <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                  <line x1="10" y1="11" x2="10" y2="17"></line>
                                  <line x1="14" y1="11" x2="14" y2="17"></line>
                              </svg>Annuler
                          </button>';
                  break;
                case 'cancelled':
                  $statut = 'Annulé';
                  $btn = '<button class="dropdown-item d-flex align-items-center text-danger insapp_btn_state btn_delete" data-id="'. $order_id.'" type="button" id="btn_delete">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 me-2 icon-xs">
                                  <polyline points="3 6 5 6 21 6"></polyline>
                                  <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                  <line x1="10" y1="11" x2="10" y2="17"></line>
                                  <line x1="14" y1="11" x2="14" y2="17"></line>
                              </svg>Supprimer
                          </button>';
                  break;
                case 'completed':{
                  $statut = 'Terminé';
                  $btn = '';
                  break;
                }
                case 'pending':{

                  $statut = 'Accepté';
                  $btn = '<button type="button" class="insapp_button_back btn_payment" data-id="'. $order_id.'" data-product-id="'.$product_id.'" type="button" id="btn_pay">Payer</button>';
                  break;
                }
                case 'processing':{
                  $payment_url = wc_get_checkout_url($order_id) ;
                  $statut = 'Payé';
                  $btn = '';
                  break;
                }
                default:
                  
                  break;
              }
              if($statut == 'Annulé'){
                $color = 'danger';
              }elseif($statut == 'Accepté'){
                $color = 'success';
              }elseif($statut == 'Terminé'){
                $color = 'primary';
              }else{
                $color = 'warning';
              }  
              $url = get_the_post_thumbnail_url($product_id) == false ? TLPLUGIN_URL . 'assets/images/default-placeholder.png': get_the_post_thumbnail_url($product_id);
               
    ?>

    <div class="row insapp_listing_timeline py-2">
      <span></span>
    </div>
    <div class="">
      <div class="row insapp_listing">
        <div class="col-12 col-md-6">
          

           <div class="d-flex align-items-center mb-3 mb-xl-0" style="width:100%"> 
           <div class="insapp_gallery" style="width:30%;background-image: url('<?php _e($url)?>')"> </div>
            <div class="ms-3"  style="width:70%">
              <div class="">
                <span class="ia_table_title" style="vertical-align: inherit;">
                  <?php echo '<span>' .  $title .'</span>' ?>
                </span>
              </div>
              <span class="mb-0 ia_table_text"> <?php echo 'Rendez-vous : '.$time; ?></span></br>
              <span class="mb-0 ia_table_text"><?php echo 'prix: '.$order_data [ 'total' ].' '. get_woocommerce_currency_symbol(); ?> </span>
            </div>
          </div>
 
        </div>
        <div class="col-12 col-md-6 d-flex flex-column flex-md-row align-items-center ">     
          <div class="col-12 col-md-4 d-flex my-1 align-items-center  justify-content-start justify-content-md-center ">
              
              <span class="<?php echo "badge badge-".$color."-soft text-".$color; ?>">
                <span style="vertical-align: inherit;">
                  <span style="vertical-align: inherit;">
                    <?php echo $statut ; ?>
                  </span>
                </span>
              </span>
            </div>

            <div class="col-12 col-md-8 d-flex my-5 justify-content-start justify-content-md-end insapp_btn_state align-items-center">
            <span class="ia_table_collapse pe-5 d-flex justify-content-between align-items-center ">
                <?php echo $btn ?> 
              
                <span class="insapp_details ps-5 " type="button" data-bs-toggle="collapse" data-bs-target="#listingcollapse<?php _e($cpt)?>" >
                  <?php _e(' Details') ?>
                </span>
              </span>
            </div>
      </div>
       

        <div class="collapse" id="listingcollapse<?php _e($cpt)?>">
          <div class="detailslistingcollapse d-flex flex-column">
            <div class="mb-0 row">
              <span class="ia_table_subtitle col-4">
                <?php _e('Catégories: ') ?>
              </span>
             
              <span class="ia_table_text  col-8">
              <?php foreach($categories as $category){?>
                 <span class="px-1"> <?php echo $category->name; ?></span>
                <?php }?>
              </span>
              
            </div>
            <div class="mb-0 row">
              <span class="ia_table_subtitle col-4">
                <?php _e('Extras') ?>
              </span>
              <span class="ia_table_text  col-8">
               <?php  if(empty($extras)){
                  foreach($extras as $extra){?>
                <li class="col">
                <?php echo $extra->nom.' (' .$extra->cout.get_woocommerce_currency_symbol().')' ;?>
                </li> 
                <?php } }?>
              </span>
            </div>
            <!-- <div class="mb-0 row">
              <span class="ia_table_subtitle col-4">
                
              </span>
              <span class="ia_table_text  col-8">
                
              </span>
            </div> -->
            <div class="mb-0 row">
              <span class="ia_table_subtitle col-4">
                <?php _e('Auteur') ?>
              </span>
              <span class="ia_table_text  col-8">
                <?php echo $author_name.' - '.$author_email ?>
              </span>
            </div>
            <div class="mb-0 row">
              <span class="ia_table_subtitle col-4">
                <?php _e('Reservé le') ?>
              </span>
              <span class="ia_table_text  col-8">
              <?php echo get_the_date( 'j F Y , h:m' )?>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php } endwhile; ?>

        <nav class="mt-5">
			<ul class="pagination mt-5 justify-content-center">
			 
			<?php if ($paged > 1) : ?>
			<li class="page-item">
				<a class="page-link" href="<?php echo esc_attr(get_pagenum_link($paged - 1)); ?>" aria-label="Précédent">
				<span aria-hidden="true">&laquo;</span>
				</a>
			</li>
			<?php endif; ?>

            <?php if ($total_pages > 1) : ?>
			<?php
				$links_around_current = 5; 
				// Afficher les liens numériques avec points de pagination
				for ($i = 1; $i <= $total_pages; $i++) {
					if ($i === 1 || $i === $total_pages || abs($i - $paged) <= $links_around_current || $total_pages <= 5) {
						// Afficher le premier, le dernier et les liens autour de la page actuelle, ou
						// afficher tous les liens si le nombre total de pages est inférieur ou égal à 5.
						if ($paged === $i) {
							echo '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
						} else {
							echo '<li class="page-item"><a class="page-link" href="' . esc_attr(get_pagenum_link($i)) . '">' . $i . '</a></li>';
						}
					} elseif (abs($i - $paged) === $links_around_current + 1) {
						// Ajouter des points de pagination s'il y a un écart de 2 pages
						echo '<li class="page-item disabled"><span class="page-link">&hellip;</span></li>';
					}
				}
				?>
			<?php endif; ?>
			<?php if ($paged < $total_pages) : ?>
			<li class="page-item">
				<a class="page-link" href="<?php echo esc_attr(get_pagenum_link($paged + 1)); ?>" aria-label="Suivant">
				<span aria-hidden="true">&raquo;</span>
				</a>
			</li>
			<?php endif; ?>
			</ul>
	 </nav>
  
  <?php }else{?>

           <div class="">
        <div class="my-5 insapp_listing">
          <p class="text-muted text-center fw-semibold mt-5" style="font-size: 1rem">
            <?php _e("Vous n'avez aucune reservation en cours pour l'instant")?>
          </p>
        </div>
      </div>
  <?php }  ?>
      <?php
  $ajax_out = ob_get_clean();
  wp_send_json( $ajax_out);
}
 
function booking_get_agenda_slot_callback(){

    if (isset($_POST['author_id'])) {
        
        $author_id = sanitize_text_field( $_POST['author_id'] );
        $date = json_decode(json_encode($_POST['date'])) ;
       
        $agenda = insapp_select_agenda_by_date( $author_id ,$date) ;
           $response = array(
            'success' => 'true',
            'message' => $agenda
          );
   
        wp_send_json_success($response);
  
      } else {
        $response = array(
          'success' => false,
          'message' => 'Une erreur est survenu veuillez contacter l\'adminstrateur'
        );
        wp_send_json_error($response);
  
      }
}  
add_action( 'wp_ajax_booking_get_agenda_slot','booking_get_agenda_slot_callback');
add_action( 'wp_ajax_nopriv_booking_get_agenda_slot','booking_get_agenda_slot_callback');

add_action( 'wp_ajax_booking_services_slot', 'booking_services_slot_fn');
add_action( 'wp_ajax_nopriv_booking_services_slot', 'booking_services_slot_fn');
function booking_services_slot_fn(){
  $slots =  $_POST['slots'];
  $tampon =  $_POST['tampon'];
  $author_id = sanitize_text_field( $_POST['author_id'] );
  $date = json_decode(json_encode($_POST['date'])) ;
  $args = array(
    'post_type' => 'product',
    'posts_per_page' => -1,
    'author' => $author_id,
  );$products_query = new WP_Query($args); 
    
  if ($products_query->have_posts()) {
    $product_ids = array();
    while ($products_query->have_posts()) {
        $products_query->the_post();
        $product_ids[] = get_the_ID();
    }
    $args = array(
      'limit' => -1,  
    );
    $orders = wc_get_orders($args); 
    
    if(isset($orders)){
      $p_ids = array(); 
      foreach($orders as $order){
        $order_id = $order->get_id();
        $item = wc_get_order($order_id ); 
        $order_date = get_post_meta( $order_id, '_booking_date', true );
        $order_time = get_post_meta( $order_id, '_booking_time', true );
    
        foreach ($item->get_items() as $item_id => $item_order ) {
          $product = $item_order->get_product();
          $product_id = $product->id;
          $meta = get_post_meta($product_id);
                
          $dure = isset($meta['_duration'][0]) ? $meta['_duration'][0] : 'undefine';
          if( $dure != 'undefine'){
            
            if(in_array($product_id, $product_ids)){
              
              if($order_date == $date){
                  $book_slot[] = $order_time;
              }
                
            }
          }                                                       
            
        }
      }

      // Vérification et suppression des créneaux
      foreach ($book_slot as $creneau1) {
        foreach ($slots as $key => $creneau2) {
          if (insapp_creneaux_final($creneau1, $creneau2)) {
            unset($slots[$key]);
          }
        }
      }
      $slots = array_values($slots);

    }  
  }
  ob_start();
  
  if( $slots == null){
  ?>
  <span class="insapp_date_slot_vide"><?php _e('Nous n\'avons plus de crénaux disponible dans cette journée')  ?></span> 
          
  <?php }else{
    foreach ($slots as $slot){
  ?>
  <div class="insapp_date_slot " value="<?php _e($slot) ?>" ><?php _e($slot)  ?></div> 
  <?php }} 
    $ajax_out = ob_get_clean();
    wp_send_json( $ajax_out);
}

function insapp_creneaux_final($creneau1, $creneau2) {
  return ($creneau1 === $creneau2  || insapp_verification_tampon_intervalle($creneau1, $creneau2) || insapp_creneaux_chevauchant($creneau1, $creneau2));
}

function insapp_verification_tampon_intervalle($creneau1, $creneau2) {
  list($debut1, $fin1) = explode(' - ', $creneau1);
  list($debut2, $fin2) = explode(' - ', $creneau2);
  // Ajouter 1 heure aux dates de début et de fin du créneau 1
  $debut1_plus_1h = date('H:i', strtotime($debut1 . '+1 hour'));
  $fin1_plus_1h = date('H:i', strtotime($fin1 . '+1 hour'));
  return ($debut1_plus_1h <= $fin2 && $fin1_plus_1h >= $debut2);
}

function insapp_creneaux_chevauchant($creneau1, $creneau2) {
  list($debut1, $fin1) = explode(' - ', $creneau1);
  list($debut2, $fin2) = explode(' - ', $creneau2);
  return ($debut1 < $fin2 && $fin1 > $debut2);
}

add_action('wp_ajax_orders_payement_bill', 'get_orders_payement_bill_callback');
add_action('wp_ajax_nopriv_orders_payement_bill', 'get_orders_payement_bill_callback');
function get_orders_payement_bill_callback() {
  

  if (isset($_POST['order_id'])) {
      $order_id = $_POST['order_id'];
      $order = wc_get_order($order_id ); 
      $output = insapp_facturepdf($order_id);

      header('Content-Type: application/json');

      // Retourner les données du PDF généré sous forme de JSON
      wp_send_json(array('pdf_data' => base64_encode($output)));
     

    }else{
      wp_send_json('echec');
    }
}


// function insapp_facturepdf($order_id){ 
//   $order = wc_get_order($order_id );
//   $order_data = $order->data;
//   $customer_id = $order->get_user_id(); 
//   $customer = get_user_by('id', $customer_id);
//   $customer_name = $customer->display_name;
//   $customer_email = $customer->user_email;
//   $date = get_post_meta( $order_id, '_booking_date', true );
//   $time = get_post_meta( $order_id, '_booking_time', true );
//   $bd_extras = get_post_meta( $order_id, '_booking_extra', true ); 
//   $selected_extras = (isset($bd_extras) && $bd_extras != null) ? json_decode($bd_extras) : [];
//   $items = $order->items;
//   ob_start();
//   require TLPLUGIN_DIR. 'templates/invoice.php';
//   $html = ob_get_contents();
//   ob_end_clean(); 
//   $options = new Options();
//   $options->set('defaultFont', 'Courier');

//   $dompdf = new Dompdf($options);
//   $dompdf->loadHtml($html );
//   $dompdf->setPaper('A4', 'portrait');
//   $dompdf->render();
//   $output = $dompdf->output();
//   $pdfOutput = 'facture'.uniqid(r