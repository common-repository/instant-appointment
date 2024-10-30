<?php
    
$current_user = wp_get_current_user();
$roles = $current_user->roles;
$role = array_shift( $roles );  
$author_id = $current_user->ID;
$user_state = get_user_meta( $current_user->ID, '_state' , true );
$subs = array();
$args = array(
    'post_type' => 'product',
    'posts_per_page' => -1,
    'tax_query' => array(
        array(
            'taxonomy' => 'product_type',
            'field'    => 'slug',
            'terms'    => 'subscription',
        ),
    ),
);
$subscription_products = new WP_Query($args); 

if ($subscription_products->have_posts()) {
    while ($subscription_products->have_posts()) {
        $subscription_products->the_post();
        $sub_id = get_the_ID();
        $abonnement =  apply_filters('filter_stripe_connect_gateway_order_status', $sub_id, $current_user->ID);  
        array_push( $subs,$abonnement["status"] );
    }
}

 if($user_state == 'inactive'){
     $button_stripe = do_shortcode('[stripe_verify_identity_document_add]');
    if(in_array($role,array('administrator','insapp_photographe'))){ ?>
 
       <div class="my-5 insapp_listing p-3 d-flex flex-column justify-content-center align-items-center ">
           <?php if($button_stripe != ""){ ?>
          <p class="text-muted text-center fw-semibold mt-5" style="font-size: 1rem">
            <?php _e("Bienvenue sur notre plateforme.Pour activer votre compte, vous devez verifier votre identité")?>
          </p>
            <div >
            <p><?php echo $button_stripe; ?></p>
             </div>
             <?php }else{ ?>
                  <p class="text-muted text-center fw-semibold mt-5" style="font-size: 1rem">
                    <?php _e("Votre compte est en cours de validation. Merci de patienter. Nous vous notifierons dès que le processus sera terminé.")?>
                  </p>
               <?php } ?>
        </div>
    <?php  }else{ ?>
         
      <p class="insapp_info_b"><?php _e('Votre compte a été blocké veuillez contacter l\'administrateur!') ?></p>
      
    <?php } ?>
    
<?php }else{

   if (in_array('trialing', $subs) || in_array('active', $subs)  ) { 

        if(in_array($role,array('administrator','insapp_photographe'))){
          if($user_profil_category == '' || $user_adresse == '' || $user_description == ''|| $user_phone == '' || $first_name == '' || $last_name == '' || $user_mail == '' ){ ?>
              <p class="insapp_info_b"><?php _e('Veuillez compléter les champs de votre profile ces informations sont importantes') ?></p>
          <?php }
          if(empty($starthour) || empty($endhour) || empty($agenda)){ ?>
            <p class="insapp_info_b"><?php _e('Veuillez prendre quelques instants pour compléter vos disponibilités. Cela aidera vos clients à choisir des crénaux correspondant à votre disponibilté') ?></p>
          <?php  } 

        }else{
              if($user_phone == '' || $first_name == '' || $last_name == '' || $user_mail == '' ){ ?>
                  <p class="insapp_info_b"><?php _e('Veuillez compléter les champs de votre profile ces informations sont importantes') ?></p>
          <?php } 
        }

    }else{
     if(in_array($role,array('administrator','insapp_photographe'))){?>
      <p class="insapp_warning_b"><?php _e('Explorez toutes les fonctionnalités en prenant un abonnement.Optez pour une expérience complète dès maintenant!') ?></p>
    
    <?php } }



    if(in_array($role,array('administrator','insapp_photographe'))) { 
    
      $args = array(  
        //   'post_status' => 'publish',
          'posts_per_page' => -1, 
          'post_type' => 'product', 
          'meta_query' => array(
             array(
                 'key' => '_annonce_product',
                 'compare' => 'EXISTS'
              ),
          ),
         'author' => $author_id, 
      );
      $query = new WP_Query($args);
      $annonces_publish = $query->found_posts; 

      $args = array(
        'author' => $author_id, 
        'post_type' => 'product',
        'post_status' => 'publish',
        'meta_query' => array(
             array(
                 'key' => '_annonce_product',
                 'compare' => 'EXISTS'
              ),
          ),
        'posts_per_page' => -1, 
    );
    
    $query = new WP_Query($args);
    $annonces = $query->found_posts; 
    if($annonces == 0){
      $percentAnnonces = 0;
    }else{
      $percentAnnonces = ($annonces_publish*100)/( $annonces) ;
    } 
 
      $args = array(
          'post_type' => 'product',  
          'author'    => $author_id,  
          'posts_per_page' => -1,
            'meta_query' => array(
             array(
                 'key' => '_annonce_product',
                 'compare' => 'EXISTS'
              ),
          ),
         'author' => $author_id
      );
      
      $reviews_query = new WP_Query($args);
      $total_reviews = 0;
      $total_reviews_reject = 0;
    
       if ($reviews_query->have_posts()) {
        while ($reviews_query->have_posts()) {
            $reviews_query->the_post();
            
            $product_id = get_the_ID(); 
          $product_reviews_reject = get_comments(array(
              'post_type' => 'product',
              'post_id' => $product_id,
              'status' => 'hold', 
          ));
          $product_reviews = get_comments(array(
            'post_type' => 'product',
            'post_id' => $product_id,
            'status' => 'approve', 
        ));
          $total_reviews += count($product_reviews);
          $total_reviews_reject += count($product_reviews_reject);
        }
      } 
      $total = $total_reviews + $total_reviews_reject;
      if($total == 0){
        $percentReviews = 0;
      }else{
        $percentReviews = ($total_reviews*100)/( $total) ;
      } 
   

       $args = array(
        'post_type'      => 'shop_order',
        'posts_per_page' => -1,
        'post_status'    => array( 'wc-completed', 'wc-processing', 'wc-pending', 'wc-on-hold'),
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
      $query_orders = new WP_Query($args);
      $compelte_orders = $query_orders->found_posts;

      $args = array(
        'post_type'      => 'shop_order',
        'post_status'    => array( 'wc-completed', 'wc-processing', 'wc-cancelled','wc-pending','wc-on-hold' ),
        'posts_per_page' => -1, 
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
      $query_orders = new WP_Query($args);
      $number_orders = $query_orders->found_posts;
      
      if($number_orders == 0){
        $percent_orders = 0;
      }else{ 
        $percent_orders  = ($compelte_orders*100)/($number_orders) ;
      }  
?>


<div class="container-fluid">
    <div class="row mt-5">
          <div class="col-md-12 col-12">
      
              <div class="d-flex justify-content-between mb-5 align-items-center">
                  <h3 class="mb-0 ">
                      <span style="vertical-align: inherit;">
                          <span style="vertical-align: inherit;"><?php _e('Tableau de bord')?></span>
                      </span>

                  </h3>
              
              </div>
         
              <div class="row  g-5 mb-5  ">
                  <div class="col">
                     <div class="card h-100 card-lift">
                        <div class="card-body">
                          <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-semi-bold "><span style="vertical-align: inherit;"><span style="vertical-align: inherit;"><?php _e('Annonces active ') ?></span></span></span>
                            <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart text-gray-400"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path><path d="M22 12A10 10 0 0 0 12 2v10z"></path></svg></span>

                          </div>
                          <div class="mt-4 mb-2 ">
                            <h3 class="fw-bold mb-0 text-center"><span style="vertical-align: inherit;"><span style="vertical-align: inherit;"><?php _e($annonces_publish) ?></span></span></h3>

                          </div>
                            <div class="d-flex justify-content-between">
                          <div class=" text-success ">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-up me-1 icon-xs"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg>
                               <span><?php _e($percentAnnonces) ?> &nbsp;% </span>
                          </div>
                          <div> <span>sur <?php _e($annonces) ?></span> </div>
                        </div>
                          
                     </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card h-100 card-lift">
                      <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                          <span class="fw-semi-bold "><span style="vertical-align: inherit;"><span style="vertical-align: inherit;"><?php _e('Nombre de reservations') ?></span></span></span>
                          <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity text-gray-400"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg></span>

                        </div>
                        <div class="mt-4 mb-2 ">
                          <h3 class="fw-bold mb-0 text-center"><span style="vertical-align: inherit;"><span style="vertical-align: inherit;"><?php _e($compelte_orders) ?></span></span></h3>

                        </div>
                        <div class="d-flex justify-content-between">
                          <div class=" text-success ">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-up me-1 icon-xs"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg>
                               <span><?php _e($percent_orders) ?> &nbsp;% </span>
                          </div>
                          <div> <span>sur <?php _e($number_orders) ?></span> </div>
                        </div>
                        
                        </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card h-100 card-lift">
                      <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                          <span class="fw-semi-bold "><span style="vertical-align: inherit;"><span style="vertical-align: inherit;"><?php _e('Nombres d\' avis') ?></span></span></span>
                          <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send text-gray-400"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg></span>

                        </div>
                        <div class="mt-4 mb-2 ">
                          <h3 class="fw-bold mb-0 text-center"><span style="vertical-align: inherit;"><span style="vertical-align: inherit;"><?php _e($total_reviews) ?></span></span></h3>

                        </div>
                        <div class="d-flex justify-content-between">
                          <div class=" text-success ">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-up me-1 icon-xs"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg>
                               <span><?php _e($percentReviews) ?> &nbsp;% </span>
                          </div>
                          <div> <span>sur <?php _e($total) ?></span> </div>
                        </div>
                      </div>
                    </div>
                  </div>
                 
              </div>

               <div class="row">
                  <div class="col-lg-12 col-12 mb-5">

                      <div class="card h-100">
                        
                          <div class="card-header">
                            <h4 class="mb-0">Recente réservation</h4>
                          </div>
                          <?php 
                              $current_user = wp_get_current_user();
                              $author_id = $current_user->ID;

                              $args = array(  
                                'post_type'      => 'shop_order',
                                'post_status'    => array( 'wc-completed', 'wc-processing', 'wc-cancelled','wc-pending','wc-on-hold' ),
                                'posts_per_page' => 10,
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
                            ?>
                          <div class="card-body">
                            <?php  if ($orders->have_posts()) { ?>
                                <div class="table-responsive table-card">
                                    <table class="table text-nowrap mb-0 table-centered">
                                      <thead class="table-light">
                                        <tr>
                                          <th  width="10%">ID</th>
                                          <th  width="30%">Client</th>
                                          <th  width="30%">Annonce</th>
                                          <th  width="10%">Prix</th> 
                                          <th  width="20%">Status</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                            <?php   
                                                while ( $orders->have_posts() ) : $orders->the_post(); 
                                                $order_id = $orders->post->ID; 
                                                
                                                $order = wc_get_order($order_id); 
                                                $order_data = $order->data;
                                                $status = $order_data['status'];
                                         
                                                $customer_id = $order -> get_user_id ();
                                                $custummer_info = get_userdata($customer_id); 
                                                $first_name = $custummer_info->first_name;
                                                $last_name = $custummer_info->last_name; 

                                                $item = wc_get_order($order_id );
                                                switch ($status) {
                                                  case 'cancelled':{
                                                    $status = 'Refusé';
                                                    $info = 'danger';
                                                    break;
                                                  }   
                                                      
                                                  case 'pending':{
                                                    $statut = 'Accepté';
                                                    $info = 'primary';
                                                    break;

                                                  } 
                                                      
                                                  case 'processing':{ 
                                                    $statut = 'Payé';
                                                    $info = 'success';
                                                    break;

                                                  }
                                                  
                                                  case 'completed':{
                                                    $statut = 'Terminé';
                                                    $info = 'info';
                                                    break;

                                                  }
                                                      
                                                  
                                                  case 'on-hold':{  
                                                    $statut = 'En attente';
                                                    $info = 'warning';
                                                    break;
                                                  }
                                                  default:{
                                                    break;
                                                  }
                                                      
                                                } 
                                              ?>
                                            <tr>
                                              <td><a href="#!">#<?php _e($order->get_order_number() )?></a></td>
                                              <td >
                                                  <div class="">
                                                        <span class="avatar avatar-xs me-1">
                                                            <span class="avatar-initials rounded-circle fs-6 bg-primary-soft">
                                                              <?php _e( substr($first_name, 0, 1)) ?>
                                                            </span>
                                                        </span>
                                                        <span>
                                                            <?php echo $first_name .' '. $last_name ?>
                                                        </span>                                                     
                                                   </div>
                                              </td>
                                                <?php foreach( $order->get_items() as $item_id => $item ) {
                                                    $product_name = $item->get_name(); 
                                                  }?>
                                              <td><span><?php echo $product_name ?></span></td>
                                              <td class="text-success ">
                                                <span>
                                                    <?php  _e($order->get_total()) ?>
                                                </span>
                                                <?php _e(get_woocommerce_currency_symbol()) ?>
                                              </td>
                                              <td><span class="badge badge-<?php _e($info) ?>-soft text-<?php _e($info) ?>"><?php _e($statut) ?></span></td>
                                            </tr>
                                          <?php  endwhile; ?>
                                          
                                

                                      </tbody>
                                    </table>
                                  </div>  <?php }else{ ?>
                                <div class=" d-flex ">
                                  <p class="d-flex align-center justify-content-center">Aucune réservation</p>
                                </div> 
                            <?php }  ?> 
                          
                          </div>

                      </div>
                  </div>
                  
               </div>
          </div>
    </div>
</div>

<?php }else{ ?>
  <div class="my-5 insapp_listing p-3 d-flex flex-column justify-content-center align-items-center ">
      <p class="text-muted text-center fw-semibold mt-5" style="font-size: 1rem">
        <?php _e("Nous sommes ravis de vous accueillir sur Notre plateforme.Votre nouvelle destination pour tout ce qui concerne la photographie ! C'est un grand plaisir de vous avoir parmi nous.")?>
      </p> 
      <p class="text-muted text-center fw-semibold mt-5" style="font-size: 1rem">
        <?php _e("Nous sommes déterminés à vous offrir une expérience exceptionnelle pour explorer le monde de la photographie, découvrir des photographes talentueux, et bien plus encore.")?>
      </p> 
      
    </div>


 
<?php } } ?>