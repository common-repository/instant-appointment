<?php

function insapp_upload_image_as_attachment($image_url,$file_name,$product_id) {

  $upload_dir = wp_upload_dir();
    $image_data = file_get_contents( $image_url );

    if ( wp_mkdir_p( $upload_dir['path'] ) ) {
      $file = $upload_dir['path'] . '/' . $file_name;
    }
    else {
      $file = $upload_dir['basedir'] . '/' . $file_name;
    }

    file_put_contents( $file, $image_data );
    $wp_filetype = wp_check_filetype( $file_name, null );
    $attachment = array(
      'guid' => $upload_dir['url'] . '/' . $file_name,
      'post_mime_type' => $wp_filetype['type'],
      'post_title' => sanitize_file_name( $file_name ),
      'post_content' => '',
      'post_status' => 'inherit'
    );
      

    $attach_id = wp_insert_attachment( $attachment, $file, $product_id);

    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
    wp_update_attachment_metadata( $attach_id, $attach_data );

  return $attach_id;
}

/* Create product*/
add_action( 'wp_ajax_add_service_front', 'add_service_front_fn');
add_action( 'wp_ajax_nopriv_add_service_front', 'add_service_front_fn');
function add_service_front_fn(){

  $title = sanitize_text_field( $_POST['service_name']);
  $date_start = sanitize_text_field($_POST['service_date_start']);
  $date_end = sanitize_text_field($_POST['service_date_end']);
  $price_reg = sanitize_text_field($_POST['service_price_reg']);
  $price_sale = sanitize_text_field($_POST['service_price_sale']);

  $service_meduim= isset($_POST['service_meduim']) ? array_map( 'intval', $_POST['service_meduim'] ): '';
  $service_tag= isset($_POST['service_tag']) ? array_map( 'intval', $_POST['service_tag'] ): '';
  $service_category= isset($_POST['service_category']) ? array_map( 'intval', $_POST['service_category'] ): '';
  $service_sub_category= isset($_POST['service_sub_category']) ? array_map( 'intval', $_POST['service_sub_category'] ): '';

  $service_duration = sanitize_text_field($_POST['service_duration']);
  $service_content= sanitize_textarea_field($_POST['service_content']);
  
  $service_location = sanitize_text_field($_POST['service_location']); 
  $service_latitude = sanitize_text_field($_POST['service_latitude']);
  $service_longitude = sanitize_text_field($_POST['service_longitude']);

            
  $user_id= sanitize_text_field($_POST['service_author']); 
  $gallery_name = $_POST['service_galerie'];
   $author_adresse = get_user_meta( $user_id, 'adresse' , true );
  
  // $crenaux = sanitize_text_field($_POST['crenaux']);
  $filename = $_POST['image_name'];
  $image_size = $_POST['image_size'];
  $image_type = $_POST['image_type'];
  $image_url = $_POST['image_url'];
  $extras =  sanitize_text_field($_POST['extras']);
  // $extras =  json_encode($extras);
  

  if(isset($title) || isset($price_sale )|| isset($service_category )|| isset($service_duration )|| isset($image_url )){

    $product = array(
      'post_author' => $user_id,
      'post_content' => $service_content,
      'post_status' => "publish",
      'post_title' => $title,
      'post_parent' => '',
      'post_type' => "product"
    );
    $product_id = wp_insert_post( $product );

    if ($product) {

      $announcement_args = array(
          'post_title' => $title,
          'post_type'    => 'annonce',  
          'post_status'  => 'publish',
          'post_author' => $user_id,
          'post_content' => $service_content,
      );

      // Insérez l'annonce personnalisée
      $announcement_id = wp_insert_post($announcement_args);
      update_post_meta($announcement_id, '_product_created', $product_id);
      update_post_meta($product_id, '_annonce_location', $author_adresse); 
      update_post_meta( $product_id, '_annonce_medium', $service_meduim );
      update_post_meta($product_id, '_annonce_product', $announcement_id);
      
      update_post_meta($product_id, '_annonce_location_maps', $service_location);
      update_post_meta($product_id, '_annonce_latitude', $service_latitude);
      update_post_meta($product_id, '_annonce_longitude', $service_longitude);
      
      update_post_meta($announcement_id, '_annonce_location_maps', $service_location);
      update_post_meta($announcement_id, '_annonce_latitude', $service_latitude);
      update_post_meta($announcement_id, '_annonce_longitude', $service_longitude);
  }

    wp_set_object_terms( $product_id, 'simple', 'product_type' ); 
    update_post_meta( $product_id, '_visibility', 'visible' );
    update_post_meta( $product_id, '_stock_status', 'instock'); 
    if(!empty($price_sale) && $price_sale != 0){
      update_post_meta($product_id, '_price', $price_sale );
    }else{
      update_post_meta($product_id, '_price', $price_reg );
    }
    update_post_meta($product_id, '_regular_price', $price_reg);
    update_post_meta($product_id, '_sale_price', $price_sale);
    update_post_meta($product_id, '_extras', $extras,'json');
    update_post_meta($product_id, '_duration', $service_duration);
 
    wp_set_object_terms($announcement_id, $service_meduim, 'medium'); 

    wp_set_object_terms($product_id, $service_tag, 'product_tag'); 
    wp_set_object_terms($product_id, $service_category, 'product_cat'); 
    wp_set_object_terms($product_id, $service_sub_category, 'product_cat',true); 
    update_post_meta( $product_id, 'subcategories', $service_sub_category );

    $gallery_images = array();
    foreach ($gallery_name as $key => $value) {
     
      $attach_gallery_id = insapp_upload_image_as_attachment($value[1],$value[0],$product_id) ;
      array_push( $gallery_images, $attach_gallery_id);

     }
    update_post_meta($product_id, '_product_image_gallery', implode(',', $gallery_images));
   
    $attach_id = insapp_upload_image_as_attachment($image_url,$filename,$product_id) ;

    set_post_thumbnail( $product_id, $attach_id );
    set_post_thumbnail($announcement_id, $attach_id);
    wp_publish_post( $product_id);
 
    if ( ! is_wp_error( $product_id ) ) {
            $resp = array(
                'code' => 200,
                'message' => "Annonce créé avec succès!"
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

/*Delete product*/
add_action( 'wp_ajax_delete_product','delete_product_callback');
add_action( 'wp_ajax_nopriv_delete_product','delete_product_callback');
function delete_product_callback(){
  $product_id = sanitize_text_field( $_POST['product_id'] );
  $resp = array();
  $orders = wc_get_orders(array(
    'limit' => -1,
)); 
      foreach ($orders as $order) {
          $order_items = $order->get_items();
          $item = wc_get_order($order_items );
          $status = $order_items[ 'status' ] ;

          foreach ($order_items as $item) {
              $product = $item->get_product();
              if ($product && $product->get_id() == $product_id) {
                  $order->delete(true); 
              }
          }
      }
  array_push($resp,wp_delete_post($product_id));
    wp_send_json($resp);
}

/* Update product*/
add_action( 'wp_ajax_ia_update_product','update_product_callback');
add_action( 'wp_ajax_nopriv_ia_update_product','update_product_callback');
function update_product_callback(){
 
    $product_id = sanitize_text_field($_POST['product_id']); 
    $product = get_post($product_id);
    $category = wp_get_post_terms($product_id, 'product_cat', array( 'parent' => 0, 'hide_empty' => 0 ));
    $tag = wp_get_post_terms($product_id, 'product_tag');
    $_regular_price = wp_get_post_terms($product_id, '_regular_price');
    $meta_product = get_post_meta($product_id); 
    $image = get_the_post_thumbnail($product_id); 
    $subcategory = $meta_product['subcategories'][0]; 
    // $image_url = get_the_post_thumbnail_url($product_id);

    $gallery = get_post_meta($product_id, '_product_image_gallery', true);
    $list_url = [];
    $gallery_images = explode(",", $gallery);
  
    foreach( $gallery_images as $gallery_image){ 
      array_push($list_url,wp_get_attachment_image_src($gallery_image)[0]);
    } 
    
    $args = array(
      'post_type' => 'annonce',
      'posts_per_page' => 1,
      'meta_query' => array( 
          array(
              'key' => '_product_created',
              'value' => $product_id,
              'compare' => '='
          )
      )
    );
   $annonces = new WP_Query( $args );

   $medium_array = [];
   if ( $annonces->have_posts() ) {
      while ( $annonces->have_posts() ) : $annonces->the_post(); 
          $annonce_id = $annonces->post->ID;
          $terms = wp_get_post_terms($annonce_id, 'medium') ;
          foreach($terms as $term){ 
              array_push($medium_array,$term->term_id);
          } 
      endwhile; 
    }

    $category_array = [];
    if ( $category) {          
        foreach($category as $term){ 
            array_push($category_array,$term->term_id);
        } 
    }
  
    $subcategory_array = [];
    if ( !empty($category_array)) {  
      
      foreach($category_array as $category){

          $subcategories = get_terms( array(
            'taxonomy' => 'product_cat',
            'child_of' => $category,
            'hide_empty' => false,  
          ) );

          foreach($subcategories as $term){ 
              array_push($subcategory_array,$term->term_id);
          } 
      }
  }

    $tag_array = [];
    if ( $tag) {          
        foreach($tag as $term){ 
            array_push($tag_array,$term->term_id);
        } 
    }

    $array_result = array(
      'id' => $product_id,
      'nom' => $product->post_title,
      'description' => $product->post_content,
      'categorie' => $category_array,
      'subcategorie' => $subcategory_array,
      'medium' => $medium_array,
      'tag' => $tag_array,
      'reg_price' => $meta_product['_regular_price'][0],
      'sale_price' => $meta_product['_sale_price'][0],
      'duree' => $meta_product['_duration'][0],
      'extras' => json_decode($meta_product['_extras'][0]),
      'image' => $image,
      'image_galery' => $list_url,
      'location_maps' => $meta_product['_annonce_location_maps'][0],
      'latitude' => $meta_product['_annonce_latitude'][0],
      'longitude' => $meta_product['_annonce_longitude'][0],
    );
 
// var_dump($product->get_description());
    wp_send_json($array_result);
}

function ajax_sous_category_add_callback(){
  
  $listcategories =  $_POST['category'] ; 

  ob_start();
    ?>
        <ul class=" insapp-circle-check level-0" id="ia-subcategory-list">
           <?php 	
                      
              if (!empty($listcategories) && !is_wp_error($listcategories)) {

                foreach($listcategories as $listcategory){
                    $subcategories = get_terms( array(
                        'taxonomy' => 'product_cat',
                        'child_of' => $listcategory,
                        'hide_empty' => false, // Set to true if you want to hide empty subcategories
                    ) );
                    $i = 1;
                    foreach($subcategories as $subcategory){?>                 
                        <li class="list-item level-0">
                            
                            <div class="form-check">
                                <input class="form-check-input insapp-list-sous-category" name="insapp-list-sous-category<?php _e($i); ?>"
                                    type="checkbox" value="<?php echo $subcategory->term_id;?>" id="insapp-list-sous-category<?php _e($i); ?>">
                                <label class="form-check-label" for="insapp-list-sous-category<?php _e($i); ?>">
                                    <?php echo $subcategory->name ;?>
                                </label>
                            </div>
                        </li>  
                    <?php $i++; }
                    } 
                    
              } else {?>
                <span value="">Aucune sous categorie trouvé</span>
                <?php
              } ?>
        </ul><?php
  $ajax_out = ob_get_clean();
  wp_send_json( $ajax_out);
}

add_action( 'wp_ajax_nopriv_ajax_sous_category_add', 'ajax_sous_category_add_callback' );
add_action( 'wp_ajax_ajax_sous_category_add', 'ajax_sous_category_add_callback' );


function ajax_sous_category_update_callback(){

  $listcategories =  $_POST['category'] ; 
   $sub =  $_POST['subcategories'] ; 

  ob_start();?>
  <ul class=" insapp-circle-check level-0" id="ia-subcategory-list">
    <?php 	
              
      if (!empty($listcategories) && !is_wp_error($listcategories)) {

        foreach($listcategories as $listcategory){
            $subcategories = get_terms( array(
                'taxonomy' => 'product_cat',
                'child_of' => $listcategory,
                'hide_empty' => false, // Set to true if you want to hide empty subcategories
            ) );
            $i = 1;
            foreach($subcategories as $subcategory){
              if( in_array($subcategory->term_id,$sub)){ ?>                 
                <li class="list-item level-0">
                    
                    <div class="form-check">
                        <input class="form-check-input insapp-list-update-sous-category" name="insapp-list-update-sous-category"
                            type="checkbox"checked value="<?php echo $subcategory->term_id;?>" id="insapp-list-update-sous-category">
                        <label class="form-check-label" for="insapp-list-update-sous-category">
                            <?php echo $subcategory->name ;?>
                        </label>
                    </div>
                </li> 
            <?php
               }else{?>
                  <li class="list-item level-0">                   
                    <div class="form-check">
                        <input class="form-check-input insapp-list-update-sous-category" name="insapp-list-update-sous-category"
                            type="checkbox" value="<?php echo $subcategory->term_id;?>" id="insapp-list-update-sous-category">
                        <label class="form-check-label" for="insapp-list-update-sous-category">
                            <?php echo $subcategory->name ;?>
                        </label>
                    </div>
                </li> 
              <?php } $i++; }
            } 
            
      } else {?>
        <span value="">Aucune sous categorie trouvé</span>
        <?php
      } ?>
  </ul><?php  
  $ajax_out = ob_get_clean();
  wp_send_json( $ajax_out);
}
add_action( 'wp_ajax_nopriv_ajax_sous_category_update', 'ajax_sous_category_update_callback' );
add_action( 'wp_ajax_ajax_sous_category_update', 'ajax_sous_category_update_callback' );


add_action( 'wp_ajax_update_service_front','update_service_front_callback');
add_action( 'wp_ajax_nopriv_update_service_front','update_service_front_callback');
function update_service_front_callback(){
 
  $title = sanitize_text_field( $_POST['service_name']); 
  $price_reg = sanitize_text_field($_POST['service_price_reg']);
  $price_sale = sanitize_text_field($_POST['service_price_sale']);  
  $service_duration = sanitize_text_field($_POST['service_duration']);
  $service_content= sanitize_textarea_field($_POST['service_content']);
  $product_id= sanitize_text_field($_POST['post_id']); 
  $gallery_images = $_POST['service_galerie']; 

  $service_meduim= array_map( 'intval', $_POST['service_meduim'] );
  $service_tag=  array_map( 'intval', $_POST['service_tag'] );
  $service_category= array_map( 'intval', $_POST['service_category'] );
  $service_sub_category= array_map( 'intval', $_POST['service_sub_category'] );
  $gallery_name = $_POST['service_galerie'];
  
  $service_location = sanitize_text_field($_POST['service_location']); 
  $service_latitude = sanitize_text_field($_POST['service_latitude']);
  $service_longitude = sanitize_text_field($_POST['service_longitude']);
 
  $filename = $_POST['image_name'];
  $image_size = $_POST['image_size'];
  $image_type = $_POST['image_type'];
  $image_url = $_POST['image_url'];
  $extras =  sanitize_text_field($_POST['extras']);
  // $extras =  json_encode($extras);

  $args = array(
    'post_type' => 'annonce',
    'posts_per_page' => 1,
    'meta_query' => array( 
        array(
            'key' => '_product_created',
            'value' => $product_id,
            'compare' => '='
        )
    )
  );
 $annonces = new WP_Query( $args );

 $medium_array = [];
 if ( $annonces->have_posts() ) {
    while ( $annonces->have_posts() ) : $annonces->the_post(); 
        $annonce_id = $annonces->post->ID; 
        $my_post = array(
          'ID'           => $annonce_id,
          'post_title'   => $title,
          'post_content' => $service_content,
      );
      wp_update_post( $my_post );
    endwhile; 
  }

  if(isset($title) || isset($service_category )|| isset($service_duration )|| isset($image_url )){
    
    $product = array(
      'ID' => $product_id,
      'post_content' => $service_content,
      'post_title' => $title,
    );
     wp_update_post( $product );
     $author_id = get_post_field('post_author', $product_id);
 
    update_post_meta( $product_id, '_visibility', 'visible' );
    update_post_meta( $product_id, '_stock_status', 'instock');
    if(!empty($price_sale) && $price_sale != 0){
      update_post_meta($product_id, '_price', $price_sale );
    }else{
      update_post_meta($product_id, '_price', $price_reg );
    }
    update_post_meta($product_id, '_regular_price', $price_reg);
    update_post_meta($product_id, '_sale_price', $price_sale);
    update_post_meta($product_id, '_extras', $extras,'json');
    update_post_meta($product_id, '_duration', $service_duration);
    
     update_post_meta($product_id, '_annonce_location_maps', $service_location);
     update_post_meta($product_id, '_annonce_latitude', $service_latitude);
     update_post_meta($product_id, '_annonce_longitude', $service_longitude);
     
      update_post_meta($annonce_id, '_annonce_location_maps', $service_location);
     update_post_meta($annonce_id, '_annonce_latitude', $service_latitude);
     update_post_meta($annonce_id, '_annonce_longitude', $service_longitude);

    update_post_meta($product_id, '_annonce_product', $annonce_id);
    wp_set_object_terms($annonce_id, $service_meduim, 'medium'); 
    wp_set_object_terms($product_id, $service_tag, 'product_tag'); 
    wp_set_object_terms($product_id, $service_category, 'product_cat'); 
    wp_set_object_terms($product_id, $service_sub_category, 'product_cat',true); 
    update_post_meta( $product_id, 'subcategories', $service_sub_category );
    $author_adresse = get_user_meta( $author_id, 'adresse' , true );
    update_post_meta($product_id, '_annonce_location', $author_adresse);  
    update_post_meta($product_id, '_annonce_medium', $service_meduim);

    if($filename != null){
      $attach_id = insapp_upload_image_as_attachment($image_url,$filename,$product_id) ;
    }
   
    set_post_thumbnail( $product_id, $attach_id );
    set_post_thumbnail($annonce_id, $attach_id);
    // wp_publish_post( $product_id); 
 
    if ( ! is_wp_error( $product_id ) ) {
            $resp = array(
                'code' => 200,
                'message' => "Service modifié avec succès!"
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


add_action( 'wp_ajax_add_subcrition_back','add_subcrition_back_callback');
add_action( 'wp_ajax_nopriv_add_subcrition_back','add_subcrition_back_callback');
function add_subcrition_back_callback(){

   $name = sanitize_text_field($_POST['sub_name']);
  $description= sanitize_text_field($_POST['sub_content']); 
  $price= sanitize_textarea_field($_POST['sub_price_mensuel']); 
  $price_pro= sanitize_textarea_field($_POST['sub_price_mensuel_pro']);
  $duree = intval($_POST['sub_duration']); 
  $free_trial = $_POST['sub_free_trial']; 
  $element = sanitize_textarea_field($_POST['sub_element']); 
  
  $product_data = array(
    'post_title'    => $name, 
    'post_content'  =>  $description, 
    'post_status'   => 'publish',
    'post_type'     => 'product', 
 );
  $product_id = wp_insert_post($product_data);

    if ($product_id) {

        
        wp_set_object_terms($product_id, 'subscription', 'product_type', false);

        update_post_meta($product_id, '_subscription_period_interval', $duree); 
        update_post_meta($product_id, '_subscription_period', $duree); 
        update_post_meta($product_id, '_regular_price', $price);
        update_post_meta($product_id, '_price_pro', $price_pro);
        update_post_meta($product_id, '_list_element', $element);
        update_post_meta($product_id, '_subscription_free_trial', $free_trial);
        
        
        if(!empty($price_pro) && $price_pro != 0){
          update_post_meta($product_id, '_price', $price_pro );
        }else{
          update_post_meta($product_id, '_price', $price );
        }
          
          

        if ( ! is_wp_error( $product_id ) ) {
        $resp = array(
            'code' => 200,
            'message' => "Abonnement créé avec succès!"
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

/*Delete subscription*/
add_action( 'wp_ajax_delete_subscription','delete_subscription_callback');
add_action( 'wp_ajax_nopriv_delete_subscription','delete_subscription_callback');
function delete_subscription_callback(){
  $subscription_id = sanitize_text_field( $_POST['subscription_id'] );
    $resp = array();
    array_push($resp,wp_delete_post($subscription_id));
  wp_send_json($resp);
}

/* Update product*/
add_action( 'wp_ajax_update_subscription','update_subscription_callback');
add_action( 'wp_ajax_nopriv_update_subscription','update_subscription_callback');
function update_subscription_callback(){
  
    $subscription_id = sanitize_text_field($_POST['subscription_id']);
    $subscription = get_post($subscription_id);
    $meta_subscription = get_post_meta($subscription_id);
    $name = $subscription->post_title ;
    $description=  $subscription->post_content; 
    $price= $meta_subscription['_regular_price'][0] ; 
    $price_pro= $meta_subscription['_sale_price'][0] ;
    $duree = $meta_subscription['_subscription_period_interval'][0] ; 
    $list = $meta_subscription['_list_element'][0] ;
    
    
    $array_result = array(
      'id' => $subscription_id,
      'nom' => $name,
      'description' => $description,
      'reg_price' => $price,
      'sale_price' => $price_pro,
      'duree' => $duree,
      'list' => $list
    );
    wp_send_json($array_result);
}


add_action( 'wp_ajax_save_subscription_update','save_subscription_update_callback');
add_action( 'wp_ajax_nopriv_save_subscription_update','save_subscription_update_callback');
function save_subscription_update_callback(){
  $subscription_id = sanitize_text_field($_POST['subscription_id']);
  $name = sanitize_text_field($_POST['name']);
  $description= sanitize_text_field($_POST['description']); 
  $price= sanitize_textarea_field($_POST['price_reg']); 
  $price_pro= sanitize_textarea_field($_POST['price_sale']);
  $duree = sanitize_textarea_field($_POST['duration']); 
  $element = sanitize_textarea_field($_POST['sub_element']); 
 
    $subscription = array(
      'ID' => $subscription_id,
      'post_content' => $description,
      'post_title' => $name,
    );
    $response = wp_update_post( $subscription ); 
    update_post_meta( $subscription_id, '_visibility', 'visible' );
    update_post_meta( $subscription_id, '_stock_status', 'instock'); 
    update_post_meta($subscription_id, '_list_element', $element);
    if(!empty($price_pro) && $price_pro != 0){
      update_post_meta($product_id, '_price', $price_pro );
    }else{
      update_post_meta($product_id, '_price', $price );
    }
    update_post_meta($subscription_id, '_regular_price', $price);
    update_post_meta($subscription_id, '_sale_price', $price_pro);
    update_post_meta($subscription_id, '_subscription_period_interval', $duree);
 
    if ( ! is_wp_error( $response ) ) {
            $resp = array(
                'code' => 200,
                'message' => "Abonnement modifié avec succès!"
            );
        }else{
            $resp = array(
            'code' => 400,
	        'message' => $user_id->get_error_messages(),
            );
        }
  wp_send_json($resp);
}


add_action( 'wp_ajax_payement_abonnement','payement_abonnement_callback');
add_action( 'wp_ajax_nopriv_payement_abonnement','payement_abonnement_callback');
function payement_abonnement_callback(){
  $customer = wp_get_current_user();
  $abonnement_id = sanitize_text_field($_POST['abonnement_id']);
  $duree = get_post_meta($abonnement_id)['_subscription_period_interval'][0];
  // wp_send_json($abonnement);
  

  if ( ! empty( WC()->cart->get_cart() ) ) {
      WC()->cart->empty_cart();
  }
  if ( wc_get_product( $abonnement_id ) ) {
    // Ajouter le produit au panier
    WC()->cart->add_to_cart( $abonnement_id , $duree);

    // Rediriger vers la page checkout
    $response =  wc_get_checkout_url() ;
    
  }else{
    $response = false;
  };
  
  $resp['payment_code'] = $response;
  

    wp_send_json($resp);
}

add_action( 'wp_ajax_ia_free_abonnement_order','ia_free_abonnement_order_callback');
add_action( 'wp_ajax_nopriv_ia_free_abonnement_order','ia_free_abonnement_order_callback');
function ia_free_abonnement_order_callback(){
  $customer = wp_get_current_user();
  $abonnement_id = sanitize_text_field($_POST['abonnement_id']);

  if ( ! empty( WC()->cart->get_cart() ) ) {
      WC()->cart->empty_cart();
  }
  if ( wc_get_product( $abonnement_id ) ) {
    
    WC()->cart->add_to_cart( $abonnement_id );

    $response =  wc_get_checkout_url() ;
    
    
  }else{
    $response = false;
  };
  
  $resp['payment_code'] = $response;
  

    wp_send_json($resp);
}


add_action( 'wp_ajax_ia_desabonner_abonnement_order','ia_desabonner_abonnement_order_callback');
add_action( 'wp_ajax_nopriv_ia_desabonner_abonnement_orderr','ia_desabonner_abonnement_order_callback');
function ia_desabonner_abonnement_order_callback(){
    
    $customer = wp_get_current_user();
   $abonnement_id = sanitize_text_field($_POST['abonnement_id']);
    wp_send_json($abonnement_id);
}