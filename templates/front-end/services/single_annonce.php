<?php 
 
 $annonce_id = get_the_ID( );
 $product_id = get_post_meta($annonce_id, '_product_created', true);
 $_product = wc_get_product($product_id);

 $name = $_product->get_name();
 $price_reg = $_product->get_regular_price();
 $price_sale = $_product->get_sale_price();
 $price = $_product->get_price();
 $categories = wp_get_post_terms($product_id, 'product_cat');

 $current_user = wp_get_current_user(); 
 $user_id = $current_user->ID; 
 
 $author_id  = get_the_author_meta('ID');
 $author = get_the_author_meta( 'display_name');
 $user_info = get_userdata($author_id);
 $user_img = $user_info->user_url;
 $profile_photo_url = get_user_meta($author_id, 'wp_user_avatar', true);
 if ($profile_photo_url) {
     $author_img = $profile_photo_url;
 } else {
     $author_img = TLPLUGIN_DEFAULT. '/avatar-fallback.jpg';
 }  
 $user_facebook = get_user_meta( $author_id, 'facebook' , true );
 $user_twitter= get_user_meta( $author_id, 'twitter' , true );
 $user_instagram = get_user_meta( $author_id, 'instagram' , true );
 $user_linkedln = get_user_meta( $author_id, 'linkedln' , true );

 $meta = get_post_meta($product_id);

 $subcategorie = isset($meta['subcategories'][0]) ? $meta['subcategories'][0] : false;
 $medium = isset($meta['_medium'][0]) ? $meta['_medium'][0] : false; 

 $dure = isset($meta['_duration'][0]) ? $meta['_duration'][0] : 'undefine';
 $extras = isset($meta["_extras"]) ? json_decode($meta["_extras"][0]) : [];
 $duration = isset($meta['_duration'][0]) ? $meta['_duration'][0] : '1:00';
 $url = get_the_post_thumbnail_url($product_id,'full') == false ? TLPLUGIN_URL . 'assets/images/default-placeholder.png': get_the_post_thumbnail_url();
 $dashboard_page = get_option('insapp_settings_name')['Dashboard_page']; 
 $chat_page = get_option('insapp_settings_name')['Chat_page']; 

 $mediums = wp_get_post_terms($annonce_id, 'service');

?>
 <div class="insapp_single_services_wrapper">

     <div class="insapp_single_services">
         <div class="insapp_single_services_container" style="background-image: 
             url('<?php _e($url)?>')">
             <div class="insapp_single_services_content">
                 <div class="insapp_single_services_content_title">

                     <div class="insapp_service_item">
                         <div class="insapp_service_item_content">
                             <?php foreach($categories as $category){ 
                                 ?>
                             
                             <?php } ?>
                             <span class="tag">
                                 <?php esc_attr_e($category->name) ?>
                             </span>
                         </div>

                         <span class="like-icon" data-product-id="<?php _e($product_id) ?>">
                          
                             
                              <?php 
                                     $user_id = get_current_user_id(); 
                                     $author_id  = get_the_author_meta('ID');
                                     
                                     if( $user_id && $user_id != $author_id ){ ?>
                                 
                                     <div class="insapp_service_rating_counter" data-product-id="<?php _e($product_id) ?>"> 
                                     <?php  
                                             $liste = get_user_meta( $user_id,'ia_favorite_product',true ) == "" ? [] : get_user_meta( $user_id,'ia_favorite_product',true ); 
                   
                                         if(in_array($product_id,$liste)){ ?>
                                             <span class= "bookmark add-to-favorite">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8v-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5v3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20c0 0-.1-.1-.1-.1c0 0 0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5v3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2v-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z"/></svg>
                                             </span>
                                        <?php }else{ ?>
                                         <span class=" bookmark ia-unbookmark ">
                                             <svg xmlns="http://www.w3.org/2000/svg"  height="1em" viewBox="0 0 512 512"><path d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8v-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5v3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20c0 0-.1-.1-.1-.1c0 0 0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5v3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2v-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z"/></svg>
                                         </span>
                                         <?php } ?>
                                             
                                     </div>
                                     <?php }else{?>
                                  

                                    <?php }  ?>
                         </span>
                         <h1>
                             <?php esc_attr_e( $name) ?>
                         </h1>
                     </div>
                 </div>

             </div>
             <span class="insapp_single_services_image"></span>

         </div>
     </div>
     <div class="container-sm ">

         <div class="insapp_single_service_body row">
             <div class="insapp_single_service_body_price">
                 <span class="price">
                     <span class="ia-svg">
                         <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                             <path
                                 d="M0 80V229.5c0 17 6.7 33.3 18.7 45.3l176 176c25 25 65.5 25 90.5 0L418.7 317.3c25-25 25-65.5 0-90.5l-176-176c-12-12-28.3-18.7-45.3-18.7H48C21.5 32 0 53.5 0 80zm112 32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                         </svg>
                     </span> Prix
                       <?php if( $price_sale == 0  || empty($price_sale)){?>
                     <span class="ia_price_product" data_price="<?php _e($price_reg) ?>">
                         <?php esc_attr_e($price_reg) ?>
                     </span>
                     <?php }else{  ?>
                     <span class="ia_price_product" data_price="<?php _e($price_sale) ?>">
                         <small style="text-decoration: line-through;padding-right: 3px;font-weight: 400">
                             <?php echo $price_reg.' '. get_woocommerce_currency_symbol(); ?>
                         </small>
                         <span style="">
                             <?php _e($price_sale) ?>
                         </span>
                     </span>

                     <?php }  ?>
                     <span class="">
                         <?php echo get_woocommerce_currency_symbol() ; ?>
                     </span>
                 </span>
             </div>

             <div class="insapp_single_service_description col-xl-8 col-lg-7 col-md-12 col-12">

                 <div class="insapp_listing_content">
                     <h3 class="insapp_title_single">Description</h3>
                     <div class="insapp_description-inner show-more">
                         <div class="insapp_description-inner-wrapper insapp_listing_description_inner">
                             <div>
                                 <?php the_content(); ?>
                             </div>
                         </div>
                         <div class="insapp_show-more-less-wrapper">
                             <a href="javascript:void(0);" class="ia-show-more insapp-text-hover-link">Voir plus</a>
                             <a href="javascript:void(0);" class="ia-show-less insapp-text-hover-link">Voir moins</a>
                         </div>
                     </div>
                 </div>
                 <div class="insapp_listing_content">
                     <h3 class="insapp_title_single">Galerie</h3>
                     <div class="insapp_galery_inner">

                         <?php
                     
                             $gallery_images = get_post_meta($product_id, '_product_image_gallery', true);
                             $gallery_image_ids = explode(',', $gallery_images);
                         if ( $gallery_image_ids ) { ?>
                         <div class="row portfolio-item">
                             <?php $i=1; foreach ( $gallery_image_ids  as $image_id) {
                                     
                                     $additional_class = '';
                                     if ( $i > 6 ) {
                                         $additional_class = 'd-none';
                                     }

                                     $more_image_class = $more_image_html = '';
                                     if ( $i == 6 && count($gallery_image_ids) > 6 ) {
                                         $more_image_html = '<span class="view-more-gallery">+'.(count($gallery_image_ids) - 4).'</span>';
                                         $more_image_class = 'view-more-image';
                                     }
                                     $url = wp_get_attachment_url($image_id);
                                 ?>
                             <div class="item selfie col-3 <?php echo esc_attr($additional_class); ?>">
                                 <a href="<?php echo esc_url(  $url ); ?>"
                                     class="fancylight popup-btn ia-popup-image-gallery" data-fancybox-group="light">
                                     <div class="image-wrapper">
                                         <?php
                                                 if ( $i <= 6 ) {
                                                     // echo wp_get_attachment_image ( $image_id, 'thumbnail' );?>
                                         <div class="ia_image_gallery_content"
                                             style="background-image: url('<?php _e($url)?>')">
                                         </div>
                                         <?php // echo trim($more_image_html);
                                                 }
                                                 ?>
                                     </div>
                                 </a>
                             </div>
                             <?php $i++; } ?>
                         </div>
                         <?php } ?>

                     </div>
                 </div>
                 <div class="insapp_listing_content d-none d-lg-block">
                     
                     <?php
                                     $reviews = get_comments(array(
                                         'post_id' => $product_id,
                                         'status' => 'approve',
                                         'posts_per_page' => 8,
                                     ));
                         ?>
                         <?php  if (!empty($reviews)) { ?>

                             <h3 class="insapp_title_single">Avis</h3>
                             
                         <?php } ?>
                     <div class="insapp_reviews-inner">

                         <ol class="ia-comment-list">
                             <?php if (!empty($reviews)) { 
                                 foreach ($reviews as $review) {

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
                                             <img src="<?php echo $user_comment ?>"
                                                 width="70" height="70" alt=""
                                                 class="avatar avatar-70 wp-user-avatar wp-user-avatar-70 photo avatar-default">
                                         </div>
                                         <div class="comment-box">

                                             <div class="clearfix">
                                                 <div class="name-comment">
                                                     <?php _e($user_comment_name) ?> </div>
                                                 <div class="d-flex align-items-center">
                                                     <span class="date"><?php _e($date) ?></span>
                                                     <div class="ms-auto insapp_rating_wrapper ">
                                                         <div class="star-rating" title="Rated 4 out of 5">
                                                             <div class="ia-review-stars-rated-wrapper"> 
                                                                     <ul class="review-stars">
                                                                         <?php
                                                                     
                                                                             for ($i = 1; $i <= 5; $i++) {
                                                                             $star_class = $i <= $rating ? 'fas fa-star active' : 'fas fa-star';
                                                                                 ?> 
                                                                                 <li><span class="<?php _e($star_class) ?>"></span></li>
                                                                         <?php } ?>
                                                                     </ul>
                                                             </div> 
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                             <div class="comment-text mt-3">
                                                 <p><?php _e($review->comment_content) ?>.</p>

                                             </div>
                                         </div>
                                     </div>
                                 </li>  

                             <?php } } ?>
                         </ol>
                     
                         <?php if( $author_id == $user_id || $current_user->ID == 0){

                         }else{?>
                         
                             <div class="insapp_booking_content">
                                 <h3 class="insapp_title_single">Ajouter un avis</h3>
                                  <div class="insapp_reviews_sucess my-2">Votre avis a bien été enregistré et est en cours de modération. Merci !</div>

                                 <div class="rating-inner">
                                     <form action=" " method="post" id="insapp_commentform" enctype="multipart/form-data"
                                         class="insapp_commentform" novalidate="">
                                         <div class="insapp_rating_wrapper comment-form-rating">
                                             <div class="rating-inner">
                                                 <div class=" d-flex comment-form-rating">
                                                     <span class="subtitle">Votre note</span>
                                                     <ul class="review-stars" id="review-stars-work">
                                                         <li class="fas fa-star active"></li>
                                                         <li class="fas fa-star"></li>
                                                         <li class="fas fa-star 3"></li>
                                                         <li class="fas fa-star 4"></li>
                                                         <li class="fas fa-star 6"></li>
                                                     </ul>
                                                     <input type="hidden" value="3" id="insapp_overall_rating" class="rating">
                                                 </div>
                                             </div>
                                         </div>

                                         <textarea id="insapp_comment" placeholder="mon avis" class="form-control"
                                             name="comment" cols="45" rows="5" required></textarea>
                                         
                                         <div class="">
                                             <button type="submit" class="insapp_btn_message">Envoyer votre avis </button>
                                         </div>
                                     </form>

                                 </div>
                             </div>

                         <?php } ?>
                     </div>


                 </div>
             </div>

             <div class="insapp_single_service_booking col-xl-4 col-lg-5 col-md-12 col-12">

                 <div class="insapp_booking_wrap">
                     <div class="insapp_booking_content">
                         <h3 class="insapp_title_single">Photographe</h3>
                         <div class="insapp_vendor_details d-flex align-items-center">
                             <a class="author-thumbnail " href="<?php _e(get_author_posts_url($author_id)); ?>">
                                 
                                     <img src="<?php echo $author_img ?>" srcset="<?php echo $author_img ?>" width="180"
                                         height="180" alt="" class=""> 
                             </a>
                             <div class="author-content">
                                 <h3 class="name">
                                     <a href="<?php _e(get_author_posts_url($author_id)); ?>">
                                         <?php _e($author); ?>
                                     </a>
                                     <input type="hidden" id="insapp_author_id" value="<?php esc_attr_e($author_id) ?>"
                                         data-id="<?php _e( get_current_user_id()) ?>">
                                 </h3>
                               

                                 <div class="">

                                     <span class="vendor_store_details_contact">
                                         
                                             <?php   
                                                 if( $author_id == $user_id  || $current_user->ID == 0 ){

                                                 }else{ 
                                                     
                                                     $urlpage = get_permalink( get_option('insapp_settings_name')['Chat_page'] );
                                                     ?>
                                                         
                                             <form action="<?php if($chat_page ){echo $urlpage;} ?>" class="insapp_envoyerMessageBtn" >
                                                                 <input type="hidden" name="su" value="<?php echo $author_id ?>">
                                                     <button type="submit" class=" insapp_btn_message d-block" >
                                                         <?php _e( 'Envoyer un message'); ?>
                                                     </button> 

                                             </form>
                                             <?php } ?>
                                         
                                     </span>
                                 </div>
                             </div>

                         </div>
                     </div>

                     <div class="insapp_booking_content">

                         <p class="insapp_info">
                             <?php _e( ''); ?>
                         </p>

                         <form class="insapp_form_booking"
                             action="<?php echo esc_url(get_permalink(get_option('insapp_settings_name')['Dashboard_page'])) ?>"
                             method="post">

                             <div id="wc-bookings-booking-form" class="wc-bookings-booking-form" style=""> </div>

                             <div class="input-group me-3 d-flex justify-content-center " readonly="readonly">
                                 <input class=" insapp_booking_date" type="hidden">
                                 <input class=" insapp_booking_slot_choosen" type="hidden" value=" ">
                                 <input class=" insapp_booking_range" type="hidden" value="<?php _e($duration) ?>">
                             </div>

                             <input type="hidden" class="insapp_slot_value " value="">
                             <div class="insapp_loader_ajax_container " style="">
                                 <div class="insapp_loader_ajax"></div>
                             </div>

                             <div class="insapp_booking_slots" id="slot_container"></div>

                             <input style="width:100%" class=" insapp_booking_time_slot" type="time" placeholder="Proposer votre crénaux">
                                
                             <?php
                                     if(getType($extras) === 'array' && count($extras) > 0){
                                     ?>
                             <div style="width:90%">
                                 <a class="nav-link has-arrow collapsed insapp_extra"
                                     style="display: flex; justify-content: space-between;padding: 10px; background: #f8f9fa"
                                     href="#!" data-bs-toggle="collapse" data-bs-target="#navDashboard" aria-expanded="false"
                                     aria-controls="navDashboard">
                                     <span class=" px-3" style=""><span style="">
                                             <?php _e('Extras') ?>
                                         </span></span>
                                     <svg id="changeColor" fill="#DC7633" xmlns="http://www.w3.org/2000/svg"
                                         xmlns:xlink="http://www.w3.org/1999/xlink" width="21" viewBox="0 0 375 374.9999"
                                         height="21" version="1.0">
                                         <defs></defs>
                                         <g></g>
                                         <g id="inner-icon" transform="translate(85, 110)"> <svg
                                                 xmlns="http://www.w3.org/2000/svg" width="199.8" height="199.8"
                                                 fill="currentColor" class="bi bi-caret-down" viewBox="0 0 16 16"
                                                 id="IconChangeColor">
                                                 <path
                                                     d="M3.204 5h9.592L8 10.481 3.204 5zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659z"
                                                     id="mainIconPathAttribute"></path>
                                             </svg> </g>
                                     </svg>
                                 </a>

                                 <div id="navDashboard" class="collapse px-5" data-bs-parent="#sideNavbar" style="">
                                     <ul class="nav flex-column">
                                         <?php foreach($extras as $extra){ ?>
                                         <li class="nav-item">
                                             <div class="mb-3">
                                                 <div class="form-check custom-checkbox">
                                                     <input type="checkbox"
                                                         class="form-check-input prod_exta insapp_extra_list"
                                                         data_calculate="<?php _e($extra->cout) ?>"
                                                         value="<?php _e($extra->nom) ?>">
                                                     <label class="form-check-label d-flex justify-content-between">
                                                         <span class="fs-5">
                                                             <?php echo $extra->nom ;?>
                                                         </span>
                                                         <span class="fs-5">
                                                             <?php echo $extra->cout.get_woocommerce_currency_symbol() ;?>
                                                         </span>
                                                     </label>
                                                 </div>
                                             </div>

                                         </li>
                                         <?php }?>
                                     </ul>
                                 </div>
                             </div>
                             <?php }?>

                             <div class="insapp_total_content  " style="width:90%">
                                 <div>
                                     <span>Cout Total</span>
                                 </div>
                                 <div class=ia_price_product_content_total>
                                     <?php $price =  $price_sale == 0  || empty($price_sale) ? $price_reg : $price_sale ;?>
                                     <span class="ia_price_product_total"><?php esc_attr_e($price) ?></span>
                                     <span class="">
                                         <?php echo get_woocommerce_currency_symbol() ; ?>
                                     </span>
                                 </div>
                             </div>
                             <?php  
                             if( $author_id == $user_id ){

                             }else{?>
                                 <a type="submit" class="insapp_button insapp_btn_booking" <?php
                                     $current_user=wp_get_current_user(); $roles=$current_user->roles;
                                     $role = array_shift( $roles );
                                     if(!in_array($role,array('administrator','insapp_photographe','insapp_customers'))){
                                     echo ('data-bs-toggle="modal" data-bs-target="#staticBackdrop"');
                                     } ?> >
                                     <?php _e( 'Reserver'); ?>
                                     <div class="insapp_loader_ajax_btn"></div>
                                 </a>
                             <?php } ?>

                             <input type="hidden" name="the_id" id="the_id" value="<?php echo $product_id ?>">
                         </form>

                     </div>
                     <?php   if (!empty($mediums) && !is_wp_error($mediums)) {?>
                     <div class="insapp_booking_content"> 
                         <div class="insapp_details_information">
                             <h3 class="insapp_title_single">Medium</h3>
                             <div class="insapp_listing-detail-categories">
                                 <ul class="list list-detail-categories">
                                     <?php 	foreach ($mediums as $medium){ 
                                         ?>
                                     <li>
                                         <span>
                                             <span class="icon-cate font">
                                                 <svg xmlns="http://www.w3.org/2000/svg" height="1em" style="fill:#fff"
                                                     viewBox="0 0 576 512">
                                                     <path
                                                         d="M234.7 42.7L197 56.8c-3 1.1-5 4-5 7.2s2 6.1 5 7.2l37.7 14.1L248.8 123c1.1 3 4 5 7.2 5s6.1-2 7.2-5l14.1-37.7L315 71.2c3-1.1 5-4 5-7.2s-2-6.1-5-7.2L277.3 42.7 263.2 5c-1.1-3-4-5-7.2-5s-6.1 2-7.2 5L234.7 42.7zM46.1 395.4c-18.7 18.7-18.7 49.1 0 67.9l34.6 34.6c18.7 18.7 49.1 18.7 67.9 0L529.9 116.5c18.7-18.7 18.7-49.1 0-67.9L495.3 14.1c-18.7-18.7-49.1-18.7-67.9 0L46.1 395.4zM484.6 82.6l-105 105-23.3-23.3 105-105 23.3 23.3zM7.5 117.2C3 118.9 0 123.2 0 128s3 9.1 7.5 10.8L64 160l21.2 56.5c1.7 4.5 6 7.5 10.8 7.5s9.1-3 10.8-7.5L128 160l56.5-21.2c4.5-1.7 7.5-6 7.5-10.8s-3-9.1-7.5-10.8L128 96 106.8 39.5C105.1 35 100.8 32 96 32s-9.1 3-10.8 7.5L64 96 7.5 117.2zm352 256c-4.5 1.7-7.5 6-7.5 10.8s3 9.1 7.5 10.8L416 416l21.2 56.5c1.7 4.5 6 7.5 10.8 7.5s9.1-3 10.8-7.5L480 416l56.5-21.2c4.5-1.7 7.5-6 7.5-10.8s-3-9.1-7.5-10.8L480 352l-21.2-56.5c-1.7-4.5-6-7.5-10.8-7.5s-9.1 3-10.8 7.5L416 352l-56.5 21.2z" />
                                                 </svg>
                                             </span>
                                             <?php _e($medium->name) ?>
                                         </span>
                                     </li>
                                     <?php } ?>
                                 </ul>
                             </div>
                         </div> 
                     </div>
                      <?php } ?>
                     <div class="insapp_listing_content d-block d-lg-none">
                     
                     <?php
                                     $reviews = get_comments(array(
                                         'post_id' => $product_id,
                                         // 'status' => 'approve',
                                         'posts_per_page' => 8,
                                     ));
                         ?>
                         <?php  if (!empty($reviews)) { ?>

                             <h3 class="insapp_title_single">Avis</h3>
                             
                         <?php } ?>
                     <div class="insapp_reviews-inner">

                         <ol class="ia-comment-list">
                             <?php if (!empty($reviews)) { 
                                 foreach ($reviews as $review) {

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
                                             <img src="<?php echo $user_comment ?>"
                                                 width="70" height="70" alt=""
                                                 class="avatar avatar-70 wp-user-avatar wp-user-avatar-70 photo avatar-default">
                                         </div>
                                         <div class="comment-box">

                                             <div class="clearfix">
                                                 <div class="name-comment">
                                                     <?php _e($user_comment_name) ?> </div>
                                                 <div class="d-flex align-items-center">
                                                     <span class="date"><?php _e($date) ?></span>
                                                     <div class="ms-auto insapp_rating_wrapper ">
                                                         <div class="star-rating" title="Rated 4 out of 5">
                                                             <div class="ia-review-stars-rated-wrapper"> 
                                                                     <ul class="review-stars">
                                                                         <?php
                                                                     
                                                                             for ($i = 1; $i <= 5; $i++) {
                                                                             $star_class = $i <= $rating ? 'fas fa-star active' : 'fas fa-star';
                                                                                 ?> 
                                                                                 <li><span class="<?php _e($star_class) ?>"></span></li>
                                                                         <?php } ?>
                                                                     </ul>
                                                             </div> 
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                             <div class="comment-text mt-3">
                                                 <p><?php _e($review->comment_content) ?>.</p>

                                             </div>
                                         </div>
                                     </div>
                                 </li>  

                             <?php } } ?>
                         </ol>
                     
                         <?php if( $author_id == $user_id ){

                         }else{?>
                         
                             <div class="insapp_booking_content">
                                 <h3 class="insapp_title_single">Ajouter un avis</h3>
                                 <div class="insapp_reviews_sucess my-2">Votre avis a bien été enregistré et est en cours de modération. Merci !</div>

                                 <div class="rating-inner">
                                     <form action=" " method="post" id="insapp_commentform" enctype="multipart/form-data"
                                         class="insapp_commentform" novalidate="">
                                         <div class="insapp_rating_wrapper comment-form-rating">
                                             <div class="rating-inner">
                                                 <div class=" d-flex comment-form-rating">
                                                     <span class="subtitle">Votre note</span>
                                                     <ul class="review-stars" id="review-stars-work">
                                                         <li class="fas fa-star active"></li>
                                                         <li class="fas fa-star"></li>
                                                         <li class="fas fa-star 3"></li>
                                                         <li class="fas fa-star 4"></li>
                                                         <li class="fas fa-star 6"></li>
                                                     </ul>
                                                     <input type="hidden" value="3" id="insapp_overall_rating" class="rating">
                                                 </div>
                                             </div>
                                         </div>

                                         <textarea id="insapp_comment" placeholder="mon avis" class="form-control"
                                             name="comment" cols="45" rows="5" required></textarea>
                                         
                                         <div class="">
                                             <button type="submit" class="insapp_btn_message">Envoyer votre avis </button>
                                         </div>
                                     </form>

                                 </div>
                             </div>

                         <?php } ?>
                     </div>


                 </div>

                 </div>

             </div>
         </div>

     </div>

     <div class="insapp_single_service container p-4">

         <div class="row">
             <div class="insapp_loader_ajax_container" style="">
                 <div class="insapp_loader_ajax"></div>
             </div>
             <?php
                 $the_categorie = wp_get_post_terms($product_id , 'product_cat', array( 'parent' => 0, 'hide_empty' => 0,'fields' => 'ids')); 

             $arg = array(
                 'post_type' => 'product',
                 'posts_per_page' => 3,  
                 'meta_query' => array(
                     array(
                         'key' => '_annonce_product',
                         'compare' => 'EXISTS'
                     ),
                 'post__not_in' => array( $annonce_id ), 
                 ),
         
             );
         
             $annonces = new WP_Query( $arg );
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
                         
                             <div class="col-lg-4 col-md-6 py-5">
                             
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
                 wp_reset_query();
             } else {
                 __( 'Aucune annonce trouvé' );
             }
             wp_reset_postdata(); 
             ?>

         </div>

     </div>


      <div class="modal fade" id="staticBackdrop" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered modal-xl">
             <div class="modal-content">

                 <div class="modal-body"> 
                     <?php
                         $current_user = wp_get_current_user();
                         $roles = $current_user->roles;
                         $role = array_shift( $roles ); 
                         if(!in_array($role,array('administrator','insapp_photographe','insapp_customers'))){       
                             $template_loader = new Insapp_Template_Loader; 
                             $template_loader->get_template_part( 'account/login'); 
                         }else{
                             $template_loader = new Insapp_Template_Loader; 
                             $template_loader->get_template_part( 'reservation'); 
                         }
                     ?>
                 </div>

             </div>
         </div>
     </div>

 </div>