<?php 

$author_id = get_query_var('author');

// $author_id  = get_the_author_meta('ID')  ;
// var_dump($author_id  );
// $author_id  =  1  ;
$current_user=wp_get_current_user(); 
 
$user_info = get_userdata($author_id); 
$meta = get_user_meta( $author_id);
 
$meta = get_user_meta( $current_user->ID );
$first_name =get_user_meta( $author_id, 'first_name' , true );
$last_name = get_user_meta( $author_id, 'last_name' , true );
 
$user_mail = $user_info->user_email;
$user_img = $user_info->user_url;
$pseudo = $user_info->user_nicename;

$user_phone = get_user_meta( $author_id, 'telephone' , true );
$user_adresse = get_user_meta( $author_id, 'adresse' , true );
$user_description = get_user_meta( $author_id, '_description' , true );
    $chat_page = get_option('insapp_settings_name')['Chat_page']; 
 
$avatar_url = get_avatar_url( $author_id );
$user_id = get_current_user_id(); 

$profile_photo_url = get_user_meta($author_id, 'wp_user_avatar', true);

if ($profile_photo_url) {
  $author_img = $profile_photo_url;
} else {
  // Display a default avatar image if the user does not have a profile photo
  $author_img =  TLPLUGIN_DEFAULT. '/avatar-fallback.jpg';
}

$profil_category = get_user_meta( $author_id, 'category' , true );
$profil_category = json_decode($profil_category );  

 $user_profil_category = [];
 foreach($profil_category as $category){
      $cat = get_term_by('id', $category, 'product_cat');
      array_push( $user_profil_category,$cat->name);
   
 }
 
$user_profil_medium = get_user_meta( $current_user->ID, '_medium' , true );
$user_profil_medium  = json_decode($user_profil_medium );



$profil_medium_list = [];
 foreach($user_profil_medium as $medium){
      $med = get_term_by('id', $medium, 'service');
      array_push( $profil_medium_list,$med->name);
   
 }
 
 $gallery = get_user_meta( $author_id, '_gallery' , true ); 
$list_url = [];
$gallery_images = json_decode($gallery);
foreach( $gallery_images as $gallery_image){ 
  array_push($list_url,wp_get_attachment_image_src($gallery_image, array('700', '600'))[0]);
} 

?>

<div class="container-fluid insapp_user_profile">

    <div class="row align-items-center">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12  ia-profil">

            <?php if(!empty($list_url)){ ?>
            
                 <div class="owl-carousel owl-theme">
                    <?php foreach ($list_url as $url) {?>
                         <div class="insapp_img_banner" style=" background-image: url('<?php echo esc_url($url) ?>');" >
                            
                    </div><?php }  ?>
                  </div>
                  
             <?php }else{ ?>
             
               <div class="pt-20 ia_banner_image"></div>
               
            <?php } ?> 
            
            <div class="  container-sm mb-5">
                <div class="d-flex align-items-center justify-content-between pt-4 pb-6 px-4">
                    <div class="d-flex align-items-start">
                 
                        <div class="avatar-xxl me-2 position-relative d-flex justify-content-end align-items-end mt-n10 ">
                           <div style=" background-image: url('<?php _e($author_img) ?>');" class="avatar-xxl rounded-circle border border-2 insapp_avatar_back" >
                            </div>
                        </div>

                        <div class="lh-1">
                            <h2 class="mb-0">
                                <?php echo $pseudo ?>
                             
                            </h2> 
                        </div>
                    </div>
                    <div>
                         <?php   
                            if( $author_id == $user_id  || $current_user->ID == 0 ){
                             
                            }else{ 
                                
                                $urlpage = get_permalink( get_option('insapp_settings_name')['Chat_page'] );
                                ?>
                                        
                                <form action="<?php if($chat_page ){echo $urlpage;} ?>" class="insapp_envoyerMessageBtn" >
                                                    <input type="hidden" name="su" value="<?php echo $author_id ?>">
                                        <button type="submit" class=" insapp_btn_message btn btn-outline-primary d-block" >
                                            <?php _e( 'Envoyer un message'); ?>
                                        </button> 
    
                               </form>
                    <?php } ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-sm">

        <div class="row">
            <div class=" col-md-12 col-12 mb-5">
                
                <div class=" insapp_booking_content row">

                    <div class="col-xl-8 col-lg-8 col-md-12 col-12  ">
    
                            <div class="insapp_details_information">
                                <h3 class="insapp_title_single  pb-3">Informations</h3>
                                 <?php if(empty($user_description) && empty($user_adresse)) {?>
                                        <div class="ia_filiter_empty">
                                            <p>Aucune Information trouvée</p>
                                        </div>
                                 <?php } ?>
                                <div class="">
                                    <?php if(!empty($user_description)) {?>
                                        <h6 class="insapp_title_single6 mb-0">Bio</h6>
                                        </hr>
                                        <p class="mt-2 mb-2">
                                            <?php _e($user_description) ?>
                                        </p>
                                     <?php } ?>
                                     <?php if(!empty($user_adresse)) {?>
                                    <div class="row">
                                    
                                        <h6 class="insapp_title_single6  pt-2 mb-0">Localisation</h6>
                                        <p class="mb-0">
                                            <?php _e($user_adresse) ?>
                                        </p>
                                    </div>
                                    
                                    <?php } ?>
                                </div>
                            </div> 

                    </div>

                    <div class="col-xl-4 col-lg-4 col-md-12 col-12  ">

                            <div class="">
                                <h3 class="insapp_title_single pb-3">Categories</h3>
                                <?php   if (!empty($profil_category)){?>
                                    <div class="insapp_listing-detail-categories">
                                        <ul class="list list-detail-categories">
                                            <?php 	foreach ($user_profil_category as $categorie){  
                                                ?>
                                                    <li>
                                                        <a href="">
                                                            <span class="icon-cate font">
                                                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" style="fill:#fff"
                                                                    viewBox="0 0 576 512">
                                                                    <path
                                                                        d="M234.7 42.7L197 56.8c-3 1.1-5 4-5 7.2s2 6.1 5 7.2l37.7 14.1L248.8 123c1.1 3 4 5 7.2 5s6.1-2 7.2-5l14.1-37.7L315 71.2c3-1.1 5-4 5-7.2s-2-6.1-5-7.2L277.3 42.7 263.2 5c-1.1-3-4-5-7.2-5s-6.1 2-7.2 5L234.7 42.7zM46.1 395.4c-18.7 18.7-18.7 49.1 0 67.9l34.6 34.6c18.7 18.7 49.1 18.7 67.9 0L529.9 116.5c18.7-18.7 18.7-49.1 0-67.9L495.3 14.1c-18.7-18.7-49.1-18.7-67.9 0L46.1 395.4zM484.6 82.6l-105 105-23.3-23.3 105-105 23.3 23.3zM7.5 117.2C3 118.9 0 123.2 0 128s3 9.1 7.5 10.8L64 160l21.2 56.5c1.7 4.5 6 7.5 10.8 7.5s9.1-3 10.8-7.5L128 160l56.5-21.2c4.5-1.7 7.5-6 7.5-10.8s-3-9.1-7.5-10.8L128 96 106.8 39.5C105.1 35 100.8 32 96 32s-9.1 3-10.8 7.5L64 96 7.5 117.2zm352 256c-4.5 1.7-7.5 6-7.5 10.8s3 9.1 7.5 10.8L416 416l21.2 56.5c1.7 4.5 6 7.5 10.8 7.5s9.1-3 10.8-7.5L480 416l56.5-21.2c4.5-1.7 7.5-6 7.5-10.8s-3-9.1-7.5-10.8L480 352l-21.2-56.5c-1.7-4.5-6-7.5-10.8-7.5s-9.1 3-10.8 7.5L416 352l-56.5 21.2z" />
                                                                </svg>
                                                            </span>
                                                            <?php _e($categorie) ?>
                                                        </a>
                                                    </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                <?php }else{ ?>
                                     <div class="ia_filiter_empty">
                                        <p>Aucune catégorie trouvée</p>
                                    </div>
                                  <?php } ?>
                                  
                            </div>
                            
                            
                            
                            <div class="pt-3">
                                <h3 class="insapp_title_single pb-3">Medium</h3>
                                <?php   if (!empty($user_profil_medium)){?>
                                    <div class="insapp_listing-detail-categories">
                                        <ul class="list list-detail-categories">
                                            <?php 	foreach ($profil_medium_list as $medium){  
                                                ?>
                                                    <li>
                                                        <a href="">
                                                            <span class="icon-cate font">
                                                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" style="fill:#fff"
                                                                    viewBox="0 0 576 512">
                                                                    <path
                                                                        d="M234.7 42.7L197 56.8c-3 1.1-5 4-5 7.2s2 6.1 5 7.2l37.7 14.1L248.8 123c1.1 3 4 5 7.2 5s6.1-2 7.2-5l14.1-37.7L315 71.2c3-1.1 5-4 5-7.2s-2-6.1-5-7.2L277.3 42.7 263.2 5c-1.1-3-4-5-7.2-5s-6.1 2-7.2 5L234.7 42.7zM46.1 395.4c-18.7 18.7-18.7 49.1 0 67.9l34.6 34.6c18.7 18.7 49.1 18.7 67.9 0L529.9 116.5c18.7-18.7 18.7-49.1 0-67.9L495.3 14.1c-18.7-18.7-49.1-18.7-67.9 0L46.1 395.4zM484.6 82.6l-105 105-23.3-23.3 105-105 23.3 23.3zM7.5 117.2C3 118.9 0 123.2 0 128s3 9.1 7.5 10.8L64 160l21.2 56.5c1.7 4.5 6 7.5 10.8 7.5s9.1-3 10.8-7.5L128 160l56.5-21.2c4.5-1.7 7.5-6 7.5-10.8s-3-9.1-7.5-10.8L128 96 106.8 39.5C105.1 35 100.8 32 96 32s-9.1 3-10.8 7.5L64 96 7.5 117.2zm352 256c-4.5 1.7-7.5 6-7.5 10.8s3 9.1 7.5 10.8L416 416l21.2 56.5c1.7 4.5 6 7.5 10.8 7.5s9.1-3 10.8-7.5L480 416l56.5-21.2c4.5-1.7 7.5-6 7.5-10.8s-3-9.1-7.5-10.8L480 352l-21.2-56.5c-1.7-4.5-6-7.5-10.8-7.5s-9.1 3-10.8 7.5L416 352l-56.5 21.2z" />
                                                                </svg>
                                                            </span>
                                                            <?php _e($medium) ?>
                                                        </a>
                                                    </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                <?php }else{ ?>
                                     <div class="ia_filiter_empty">
                                        <p>Aucun service trouvé</p>
                                    </div>
                                  <?php } ?>
                                  
                            </div>
                    </div>

                </div> 
            
            </div>
            
            <div class="col-xl-6 col-lg-6 col-md-12 col-12 mb-5">

                <div class="insapp_booking_content">

                    <h3 class="insapp_title_single pb-3">Annonces</h3>

                    <div class="row insapp_listing_ajax_container" id="ia-filtered-results">

                        <?php
                                $services_per_page = 4;
                            
                                $argsAn = array(
                                    'post_type' => 'product',
                                    'posts_per_page' => $services_per_page, 
                                    'paged' => $paged, 
                                    'author' => $author_id,
                                    'meta_query' => array(
                                        array(
                                            'key' => '_annonce_product',
                                            'compare' => 'EXISTS'
                                        )
                                    ), 
                                );  
                                $annonces = new WP_Query( $argsAn );
                                $total_pages = $annonces->max_num_pages; 
                                $total_product =  $annonces->found_posts;
                         
                
                        
                                if ( $annonces->have_posts() ) {
                                    while ( $annonces->have_posts() ) : $annonces->the_post(); 
                                    $product_id = $annonces->post->ID; 
                                    // $product_id = get_post_meta($annonce_id, '_product_created', true); 
                                    $annonce_product = get_post_meta( $product_id, '_annonce_product', true );
                                        
                                        $_product = wc_get_product($product_id);  
                                        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), array('220','220'), true );
                                        $title = get_the_title(); 
                                        $price_reg = $_product->get_regular_price()?$_product->get_regular_price():0;
                                        $price_sale = $_product->get_sale_price()?$_product->get_sale_price():0;
                                        $price = $_product->get_price(); 
                                        $categories = wp_get_post_terms($product_id, 'product_cat', array( 'parent' => 0, 'hide_empty' => 0 ));
                                        $url = get_the_post_thumbnail_url() == false ? TLPLUGIN_URL . 'assets/images/default-placeholder.png': get_the_post_thumbnail_url();
                                         
                                        $product_reviews = get_comments(array(
                                            'post_type' => 'product',
                                            'post_id' => $product_id,
                                            'status' => 'approve', 
                                        ));
                                    
                                        $total_rating = 0;
                                        $rating = 0;
                                    
                                        foreach ($product_reviews as $review) {
                                            $rating += intval(get_comment_meta($review->comment_ID, 'rating', true));
    
                                            $total_rating ++;
                                        }
                                                if(  $total_rating == 0){
                                                    $score = 0;
                                                }else{
                                                    $score = $rating/$total_rating;
                                                }  
                                    
                                            ?>
                                            
                                                <div class="col-sm-6 col-md-6 col-12 col-lg-6">
                                                
                                                    <div class="insapp_service_item_container">
                                                        <a href="<?php echo esc_url( get_permalink($annonce_product ) ); ?>"
                                                        class="">
                                                            <div class="insapp_service_item">
                                                                <div class="insapp_service_small_badges_container"></div>
                                                                <img width="520" height="397" src="<?php _e($url)?>" alt="" decoding="async"
                                                                    loading="lazy">
    
                                                                <div class="insapp_service_item_content">
                                                                    <?php 
                                                                        foreach($categories as $category){ ?>
                                                                    <span class="tag">
                                                                        <?php echo($category->name); ?>
                                                                    </span>
                                                                    <?php }?>
                                                                </div>
                                                                <span class="like-icon listeo_core-unbookmark-it liked align-center">
                                                                    <span class="pe-2 " id="service_rating">
                                                                        <?php _e(number_format($score, 1))?>
                                                                    </span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="star" height="1em"viewBox="0 0 576 512"> <style> .star { fill: #ffffff !important } </style>
                                                                        <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z" />
                                                                    </svg>
                                                                </span>
                                                            </div>
                                                        </a>
                                                        <div class="insapp_service_item_body">
                                                            <a href="<?php echo esc_url( get_permalink($annonce_product ) ); ?>" class="">
                                                                <h3>
                                                                    <?php echo($title); ?>
                                                                </h3>
                                                            </a>
                                                            <div class="insapp_service_star_rating">
                                                                <?php 
                                                                        if( $price_sale == 0){?>
                                                                <span style="">
                                                                    <?php echo $price_reg.''.get_woocommerce_currency_symbol().' ' ?>
                                                                </span>
    
                                                                <?php }else{  ?>
                                                                <span><span style="text-decoration: line-through;padding-right: 3px">
                                                                        <?php echo $price_reg.''.get_woocommerce_currency_symbol().'' ?>
                                                                    </span><span style="color: #000;">
                                                                        <?php echo $price_sale.''.get_woocommerce_currency_symbol().' ' ?>
                                                                    </span> </span>
    
                                                                <?php }  ?>
                                                                <?php 
                                                                  $user_id = get_current_user_id(); 
                                                                  $author_id  = get_the_author_meta('ID');
                                                                   
                                                                 if( $user_id && $user_id != $author_id ){ ?>
                                                                
                                                                    <div class="insapp_service_rating_counter" data-product-id="<?php _e($product_id) ?>"> 
                                                                    <?php 
                                                                         $liste = get_user_meta( $user_id,'ia_favorite_product',true ) == "" ? [] : get_user_meta( $user_id,'ia_favorite_product',true ); 
              
                                                                            if(in_array($product_id,$liste)){
                                                                                echo '<i class="fas fa-heart add-to-favorites" ></i> 
                                                                                ';
                                                                            }else{
                                                                                echo '<i class="far fa-heart " ></i>';
                                                                            }
                                                                    ?>
                                                                            
                                                                    </div>
                                                                 <?php }  ?>
                                                            </div>
                                                        </div>
                                                        </div>
                                                </div>
                                        <?php 								
                                        
                                    endwhile; 
                                
                                wp_reset_query();?>

                        <nav class="mt-5">
                            <ul class="pagination mt-5 justify-content-center">

                                <?php if ($paged > 1) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo esc_attr(get_pagenum_link($paged - 1)); ?>"
                                        aria-label="Précédent">
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
                                    <a class="page-link" href="<?php echo esc_attr(get_pagenum_link($paged + 1)); ?>"
                                        aria-label="Suivant">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                        <?php 
                                    
                            } else {
                                ?>
                        <div class="ia_filiter_empty">
                            <p>Aucune annonce trouvé</p>
                        </div>
                        <?php
                            }
                            
                            wp_reset_postdata(); ?>
                    </div> 
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-12 col-12 mb-5">

                <div class="insapp_booking_content">
                    <h3 class="insapp_title_single pb-3">Avis</h3>

                    <div class="">

                        <?php
                        $args = array(
                            'post_type' => 'product', 
                            'post_status' => 'publish',
                            'author' => $author_id,
                        );
                        $product_reviews_query = new WP_Query($args);

                        if ($product_reviews_query->have_posts()) {
                           $cpt = 0;
                        ?>
                        <div class="insapp_reviews-inner">
                            <?php 
                                ?>

                            <ol class="ia-comment-list">

                                <?php while ($product_reviews_query->have_posts()) {

                                    $product_reviews_query->the_post();
                                    $reviews = get_comments(array(
                                        'post_id' => get_the_ID(),
                                        'status' => 'approve',
                                        'posts_per_page' => 8,
                                    )); 
                                        if (!empty($reviews)) { 
                                        foreach ($reviews as $review) {
                                            $cpt++;

                                            $rating =  !empty(get_comment_meta($review->comment_ID, 'rating', true)) ? get_comment_meta($review->comment_ID, 'rating', true): '3';
                                        
                                            $date = get_comment_date( 'M j Y' , $review->comment_ID);

                                            
                                            $comment_author_id = $review->user_id; 
                                            $user = get_user_by('ID', $comment_author_id);
                                            $user_comment_name = $user->display_name;
                                                                                    
                                            $profile_photo_url = get_user_meta($comment_author_id, 'wp_user_avatar', true);
                                            if ($profile_photo_url) {
                                                $user_comment = $profile_photo_url;
                                            } else {
                                                $user_comment = TLPLUGIN_DEFAULT. '/avatar-fallback.jpg';
                                            }  
                                        
                                        
                                        ?>

                                <li class="ia-commentbyuser">

                                    <div class="the-comment">
                                        <div class="avatar">
                                            <img src="<?php echo $user_comment ?>" width="70" height="70" alt=""
                                                class="avatar avatar-70 wp-user-avatar wp-user-avatar-70 photo avatar-default">
                                        </div>
                                        <div class="comment-box">

                                            <div class="clearfix">
                                                <div class="name-comment">
                                                    <?php _e($user_comment_name) ?>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <span class="date">
                                                        <?php _e($date) ?>
                                                    </span>
                                                    <div class="ms-auto insapp_rating_wrapper ">
                                                        <div class="star-rating" title="Rated 4 out of 5">
                                                            <div class="ia-review-stars-rated-wrapper">
                                                                <ul class="review-stars">
                                                                    <?php 
                                                                                    for ($i = 1; $i <= 5; $i++) {
                                                                                    $star_class = $i <= $rating ? 'fas fa-star active' : 'fas fa-star';
                                                                                        ?>
                                                                    <li><span class="<?php _e($star_class) ?>"></span>
                                                                    </li>
                                                                    <?php } ?>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                             <div class="comment-text mt-3">
                                                <p>
                                                    <?php _e($review->comment_content) ?>.
                                                </p>

                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <?php } } } ?>

                            </ol>
                             

                        </div>
                        <?php
                      
                        if($cpt == 0){ ?>
                                    <div class="ia_filiter_empty">
                                        <p>Aucun avis trouvé</p>
                                    </div>
                            <?php } ?>
                     <?php } else {
                                ?>
                        <div class="ia_filiter_empty">
                            <p>Aucun avis trouvé</p>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>