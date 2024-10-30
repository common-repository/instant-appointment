<?php 


function nettoyage($given){
    $nettoyer = str_replace(' ', '', $given);
    return $nettoyer;
}

function limitParagraphHeight($text, $limit) {
     if (strlen($text) > $limit) {
         $truncated_text = substr($text, 0, $limit);
         $last_space = strrpos($truncated_text, ' ');
         $truncated_text = substr($truncated_text, 0, $last_space);
         $truncated_text .= '...';
        return $truncated_text;
    } else {
         return $text;
    }
} 

function getBoundingBoxes($latitude, $longitude, $distance) {
    // Rayon de la Terre en kilomètres
    $earthRadius = 6371;

    // Conversion de la distance en radians
    $angularDistance = intval($distance) / $earthRadius;

    // Conversion de latitude et longitude en radians
    $latRad = deg2rad(intval($latitude));
    $lonRad = deg2rad(intval($longitude));

    // Calcul des variations de latitude et de longitude
    $deltaLat = $angularDistance;
    $deltaLon = $angularDistance / cos($latRad);

    // Conversion des variations en degrés
    $deltaLatDeg = rad2deg($deltaLat);
    $deltaLonDeg = rad2deg($deltaLon);

    // Calcul des bornes
    $minLat = intval($latitude) - $deltaLatDeg;
    $maxLat = intval($latitude) + $deltaLatDeg;
    $minLon = intval($longitude) - $deltaLonDeg;
    $maxLon = intval($longitude) + $deltaLonDeg;

    return array(
        'minLatitude' => $minLat,
        'maxLatitude' => $maxLat,
        'minLongitude' => $minLon,
        'maxLongitude' => $maxLon
    );
}

add_action('wp_ajax_ia_custom_field_filter', 'ia_custom_field_filter');
add_action('wp_ajax_nopriv_ia_custom_field_filter', 'ia_custom_field_filter');
function ia_custom_field_filter() {
    
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'post_status' => 'publish', 
        'meta_query' => array(
            array(
                'key' => '_price',
                'value' => '',
                'compare' => '!=', 
                'type' => 'NUMERIC',
            ),
        	array(
        		'key' => '_annonce_product',
        		'compare' => 'EXISTS'
        	)
        ),
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
        'meta_key' => '_price', 
    );
    $query = new WP_Query($args);
    
    if ($query->have_posts()) { 
        
        $max_price = get_post_meta($query->posts[0]->ID, '_price', true); 
    	$min_price = get_post_meta($query->posts[count($query->posts) - 1]->ID, '_price', true);  
    
    }else{
        
        $max_price = 0; 
    	$min_price = 0;  
    }
 
    $title_filter = isset($_POST['title_filter']) ? $_POST['title_filter'] : '';
    $category_filter = isset($_POST['category_filter']) ? $_POST['category_filter'] : '';
    $sub_category_filter = isset($_POST['sub_category_filter']) ? $_POST['sub_category_filter'] : '';
    $medium_filter = isset($_POST['medium_filter']) ? $_POST['medium_filter'] : '';
    $price_filter = isset($_POST['price_filter']) ? intval($_POST['price_filter']) : '';
    $tag_filter = isset($_POST['tag_filter']) ? $_POST['tag_filter'] : ''; 
    $location_filter = isset($_POST['location_filter']) ?  $_POST['location_filter'] : '';
    $min_price = isset($_POST['price_min_filter']) ? $_POST['price_min_filter'] : $min_price;
    $max_price = isset($_POST['price_max_filter']) ? $_POST['price_max_filter'] : $max_price;
    
    if($min_price > $max_price){
        $price_max_filter = $min_price;
         $price_min_filter = $max_price;
    }else{
        $price_max_filter = $max_price;
         $price_min_filter = $min_price; 
    }
    
    $latitude = $location_filter['latitude'];  
    $longitude = $location_filter['longitude']; 
    $radius = $location_filter['radius'];
    
    $date_filter = isset($_POST['date_filter']) ? $_POST['date_filter'] : '';
    
    $author_selected = [];
    $users = insapp_get_calendar_by_date($date_filter);
    foreach ($users as $user) {
        $user_point = $user->user_id ;
       if( !in_array($user_point ,$author_selected)){
            array_push( $author_selected, $user_point);
       } 
    } 
    
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $services_per_page = 10;

    $total_pages = $annonces->max_num_pages; 
    $tatal_product =  $annonces->found_posts;
 
    $args = array(
        'post_type' => 'product', 
        'posts_per_page' => $services_per_page, 
		'paged' => $paged,
        'meta_query' => array(
            array(
                'key' => '_annonce_product',
                'compare' => 'EXISTS'
            ),
            array(
                'key' => '_price',
                'value' => array( $price_min_filter,  $price_max_filter),
                'type' => 'NUMERIC',
                'compare' => 'BETWEEN',
            ),
        ), 
    );
    
    if ($title_filter) {
        $args['s'] = $title_filter;
    }
  
    if ($location_filter['name']){ 
        
        $bracket = getBoundingBoxes($latitude, $longitude,$radius) ; 
     
    	 $args['meta_query'][]= array(
            'relation' => 'AND',
                array(
                    'key' => '_annonce_latitude',  
                    'compare' => 'EXISTS'
                ),
                array(
                    'key' => '_annonce_longitude', 
                    'compare' => 'EXISTS'
                ), 
                array(
                    'key' => '_annonce_latitude', 
                    'value' => array($bracket['minLatitude'], $bracket['maxLatitude']),  
                    'compare' => 'BETWEEN',
                ),
                array(
                    'key' => '_annonce_longitude',  
                    'value' => array($bracket['minLongitude'], $bracket['maxLongitude']), 
                    'compare' => 'BETWEEN',
                ),  
            ); 
	}  
	
    if (!empty($medium_filter)) { 
        $tax_queries[] = array(
            'taxonomy' => 'service', 
            'field'    => 'term_id', 
            'terms'    => $medium_filter, 
        );
    }
    
    if (!empty($date_filter)) {
        $args['author__in'] = $author_selected;
    } 
    
    if (!empty($tag_filter)) { 
        $tax_queries[] = array(
            'taxonomy' => 'product_tag', 
            'field'    => 'term_id', 
            'terms'    => $tag_filter, 
        );
    }
    
    if ($sub_category_filter) { 
        $tax_queries[] = array(
            'taxonomy' => 'product_cat',  
            'field'    => 'term_id',  
            'terms'    => $sub_category_filter, 
            'include_children' => false, 
        );
    } 
    
    if ($category_filter) { 
        $tax_queries[] = array(
            'taxonomy' => 'product_cat',
            'field'    => 'term_id',
            'terms'    => $category_filter,
        );
    }
    
    $args['tax_query'] = $tax_queries; 
    // wp_send_json($args); 
 
        $services = new WP_Query($args);

    ob_start();
   
        $insapp_templates = new Insapp_Template_Loader;
        $data = array( 'services' => $services, 'paged' => $paged,  );
        $insapp_templates->set_template_data($data)->get_template_part( 'services/list-annonce');

    $content = ob_get_clean();

    echo json_encode(array('content' => $content));
    die();
}


add_action('wp_ajax_ia_custom_field_filter_vendor', 'ia_custom_field_filter_vendor');
add_action('wp_ajax_nopriv_ia_custom_field_filter_vendor', 'ia_custom_field_filter_vendor');
function ia_custom_field_filter_vendor() {
 
    $title_filter = isset($_POST['title_filter']) ? $_POST['title_filter'] : '';
    $category_filter = isset($_POST['category_filter']) ? $_POST['category_filter'] : '';
    $medium_filter = isset($_POST['medium_filter']) ? $_POST['medium_filter'] : '';
    $location_filter = isset($_POST['location_filter']) ? intval($_POST['location_filter']) : '';
    
     $latitude = intval($location_filter['latitude']);  
    $longitude = intval($location_filter['longitude']); 
    $radius = intval($location_filter['radius']); 
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $users_per_page = 8;

    $args = array(
        'role__in' => array( 'administrator','insapp_photographe'),
        'orderby' => 'registered',  
        'number' => $users_per_page,
        'offset' => ($paged - 1) * $users_per_page,
        'order' => 'DESC',
    );
    
    if ($title_filter) {
        $args['search'] = '*' . esc_attr($title_filter) . '*';
        $args['meta_query'][] = array(
            'relation' => 'OR',
            array(
                'key'     => 'first_name',
                'value'   => $title_filter,
                'compare' => 'LIKE'
            ),
            array(
                'key'     => 'last_name',
                'value'   => $title_filter,
                'compare' => 'LIKE'
            ),
            array(
                'key'     => 'description',
                'value'   => $title_filter,
                'compare' => 'LIKE'
            )
        );
    }
    
    if ($location_filter){ 
        $bracket = getBoundingBoxes($latitude, $longitude,$radius) ; 
    	 $argsAn['meta_query'][]= array(
        'relation' => 'AND',
            array(
                'key' => '_annonce_latitude',  
                'compare' => 'EXISTS'
            ),
            array(
                'key' => '_annonce_longitude', 
                'compare' => 'EXISTS'
            ), 
            array(
                'key' => '_annonce_latitude', 
                'value' => array($bracket['minLatitude'], $bracket['maxLatitude']),  
                'compare' => 'BETWEEN',
            ),
            array(
                'key' => '_annonce_longitude',  
                'value' => array($bracket['minLongitude'], $bracket['maxLongitude']), 
                'compare' => 'BETWEEN',
            ),  
        ); 
	} 
    
    if (!empty($medium_filter)&& $medium_filter != 0) { 
        foreach ($medium_filter as $value) {
            $args['meta_query'][] = array(
                'key' => '_medium',
                'value' => $value,
                'compare' => 'LIKE',
            );
        } 
    }

    if ($category_filter && $category_filter != 0) { 
        $args['meta_query'][] = array(
            'key'     => 'category',
            'value'   => $category_filter,
            'compare' => 'LIKE'
        );
    }
         
    // wp_send_json($args);
    $users_query = new WP_User_Query($args);
    // wp_send_json($users_query->get_results());
    
    ob_start();
   
    $insapp_templates = new Insapp_Template_Loader;
    $data = array('users_query' => $users_query, 'paged' => $paged, 'users_per_page' => $users_per_page);
    $insapp_templates->set_template_data($data)->get_template_part('services/profil');
    
    $content = ob_get_clean();
    wp_send_json(array('content' => $content));
    // die();
}

 
add_action( 'wp_ajax_nopriv_ia_ajax_filter_subcategories', 'ia_ajax_filter_subcategories_callback' );
add_action( 'wp_ajax_ia_ajax_filter_subcategories', 'ia_ajax_filter_subcategories_callback' );

function ia_ajax_filter_subcategories_callback(){
 
    $category = sanitize_text_field( $_POST['category_filter']); 
    $subcategories = get_terms( array(
        'taxonomy' => 'product_cat',
        'child_of' => $category,
        'hide_empty' => false, 
    ) );
  
    ob_start();
        if ( ! is_wp_error( $subcategories ) && ! empty( $subcategories ) ) {
            $i = 1;
            foreach($subcategories as $subcategory){?>
        

                <li class="list-item level-0">
                    
                  <div class="form-check">
                        <input class="form-check-input ia-filter-sous-category" name="ia-filter-sous-category<?php _e($i); ?>"
                            type="checkbox" value="<?php echo $subcategory->term_id;?>" id="ia-filter-sous-category<?php _e($i); ?>">
                        <label class="form-check-label" for="ia-filter-sous-category<?php _e($i); ?>">
                            <?php echo $subcategory->name ;?>
                        </label>
                    </div>
                </li>  
            <?php $i++; }
                                
        } else { ?>
               <p > <?php _e('Aucune sous categories.' )?></p>
          <?php 
        }
    $ajax_out = ob_get_clean();
    wp_send_json( $ajax_out);
  }

add_action( 'wp_ajax_nopriv_insapp_save_reviews', 'insapp_save_reviews_callback' );
add_action( 'wp_ajax_insapp_save_reviews', 'insapp_save_reviews_callback' );

function insapp_save_reviews_callback(){
 
    $rate = intval( $_POST['rate']); 
    $comment_content = sanitize_text_field( $_POST['comment']); 
    $product_id = intval( $_POST['product_id']); 
    $author_id = intval( $_POST['author_id']);


// Créer un tableau avec les données du commentaire
$comment_data = array(
    'comment_post_ID' => $product_id,
    'user_id' => $author_id,
    'comment_content' => $comment_content,
    'comment_date' => current_time('mysql'),
    'comment_approved' => 0,
);


// Insérer le commentaire dans la base de données
$comment_id = wp_insert_comment($comment_data);
update_comment_meta( $comment_id, 'rating', $rate );
add_comment_meta($comment_id, 'rating', $rating);

    if($comment_id){
        
      $resp = array(
        'code' => 200,
        'message' => 'Commentaire ajouté avec succes', 
      );
      wp_send_json(  $resp );

    }else{
      $resp = array(
        'code' => 400,
        'message' => 'Une erreur s\'est produite veuillez contacter l\'administrateur',
      );
      wp_send_json(  $resp );

    }
    
  }

  add_action( 'wp_ajax_nopriv_ia_custom_remove_to_favorites', 'ia_custom_remove_to_favorites_callback' );
  add_action( 'wp_ajax_ia_custom_remove_to_favorites', 'ia_custom_remove_to_favorites_callback' );
  
  function ia_custom_remove_to_favorites_callback(){
   
    
      if (isset($_POST['product_id'])) {
          $product_id = intval($_POST['product_id']);
          $user_id = get_current_user_id(); 
          
          if ($user_id > 0) { 
                   
            $list = get_user_meta( $user_id,'ia_favorite_product',true ) == "" ? [] : get_user_meta( $user_id,'ia_favorite_product',true ); 
               
                      
              if(!empty($list)){
  
                 if(in_array($product_id,$list)){
                      array_splice( $list, $product_id);
                    if (($key = array_search($product_id, $list)) !== false) {
                        array_splice($list, $key, 1);
                    }
                      
                 } 
       
                  $meta = array( 
                      'ia_favorite_product' => $list, 
                  );
                  $user_data = array(
                      'ID'            => $user_id, 
                      'meta_input'    => $meta,
                  );
                  $user = wp_update_user( $user_data );
                 
              }
   
          }  
      }
   
  }
  
  
add_action( 'wp_ajax_nopriv_ia_custom_add_to_favorites', 'ia_custom_add_to_favorites_callback' );
add_action( 'wp_ajax_ia_custom_add_to_favorites', 'ia_custom_add_to_favorites_callback' );

function ia_custom_add_to_favorites_callback(){
 
  
    if (isset($_POST['product_id'])) {
        $product_id = intval($_POST['product_id']);
        $user_id = get_current_user_id(); 
        
        if ($user_id > 0) { 
                 $list = get_user_meta( $user_id,'ia_favorite_product',true ) == "" ? [] : get_user_meta( $user_id,'ia_favorite_product',true ); 
                      
            if(empty($list)){
          
                $list = array();
                array_push( $list, $product_id); 
                $meta = array( 
                    'ia_favorite_product' => $list, 
                );
         
                $user_data = array(
                    'ID'            => $user_id, 
                    'meta_input'    => $meta,
                );
                $user = wp_update_user( $user_data ) ;
    
       
            }else{

               if(!in_array($product_id,$list)){
                    array_push( $list, $product_id);
               } 

                $meta = array( 
                    'ia_favorite_product' => $list, 
                );
                $user_data = array(
                    'ID'            => $user_id, 
                    'meta_input'    => $meta,
                );
                $user = wp_update_user( $user_data );
               
            }
  
              
            $liste = get_user_meta( $user_id,'ia_favorite_product',true ) == "" ? [] : get_user_meta( $user_id,'ia_favorite_product',true ); 
                 
                 
            wp_send_json($liste) ;
 
        }  
    }
 
}