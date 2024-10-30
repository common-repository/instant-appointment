<div class="insapp_service_container">

    <div class="row">  
    
        <div class="insapp_loader_ajax_container" style=""><div class="insapp_loader_ajax"></div> </div>
        <div class="owl-carousel owl-theme  "> 
    
            <?php
          
                $arg = array(
                    'post_type' => 'product',
                    'posts_per_page' => 8, 
                    'meta_query' => array(
                        array(
                            'key' => '_annonce_product',
                            'compare' => 'EXISTS'
                        ),
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
                        <?php 								
                        
                    endwhile;  
                wp_reset_query();

                } else {?>
	        	  <span><?php _e('No products found'); ?></span>
                <?php }

                wp_reset_postdata(); 

            ?>     
        </div>
    </div>
</div>