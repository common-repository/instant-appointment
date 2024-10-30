<h3><?php _e('Mes favoris'); ?></h3>

<div class="row">
        <?php
         
            $current_user = wp_get_current_user();
            $author_id = $current_user->ID;
            $product_ids = get_user_meta( $author_id,'ia_favorite_product',true ) == "" ? [''] : get_user_meta( $author_id,'ia_favorite_product',true );
            
            $args = array(
                'post_type'      => 'product',
                'posts_per_page' => -1,
                'post__in'       => $product_ids,
            );
            $cpt = 0;
            $annonces = new WP_Query( $args );
            if ( $annonces->have_posts() ) {
                    while ( $annonces->have_posts() ) : $annonces->the_post(); 
                            $product_id = $annonces->post->ID; 
                            $cpt++;
                            
                            $_product = wc_get_product($product_id); 
                            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), array('220','220'), true );
                            $title = get_the_title(); 
                            $price_reg = $_product->get_regular_price() ? $_product->get_regular_price() : 0;
                            $price_sale = $_product->get_sale_price() ? $_product->get_sale_price() : 0;
                            $price = $_product->get_price();
                            $categories = wp_get_post_terms($product_id, 'product_cat');
                            $datas = $_product->get_data();
                            $meta_product = $datas["meta_data"];
                            $meta = get_post_meta($product_id);
                            $date_created = get_the_date();
                            $duration = isset($meta['_duration'][0]) ? $meta['_duration'][0] : 'undefine'; 
                            $url = get_the_post_thumbnail_url() == false ? TLPLUGIN_URL . 'assets/images/default-placeholder.png': get_the_post_thumbnail_url();
                
                    ?>
                            <a class="col-6" href="<?php echo esc_url( get_permalink($product_id)); ?>">
                                <div class="row insapp_listing my-2 mx-1">
                                    <div class="col-10 col-md-10">
                                        <div class="d-flex mb-3 mb-xl-0" style="width:100%">
                                            <div class="insapp_gallery" style="width:30%;background-image: url('<?php _e($url)?>')"> </div>
                                            <div class="ms-3" style="width:70%">
                                                <div class="">
                                                    <span class="ia_table_title" style="vertical-align: inherit;">
                                                        <?php  echo $title; ?>
                                                    </span>
                                                </div>
                                                <span class="mb-0 ia_table_text">
                                                    <?php  echo 'Durée: '.$duration; ?>
                                                </span></br>
                                                <span class="mb-0 ia_table_text" style=" font-weight: 600;">
                                                  Prix:
                                                    <?php   if( $price_sale == 0 || $price_sale == ''){?>
                                                            <span>
                                                                <?php echo $price_reg.' '.get_woocommerce_currency_symbol() ?>
                                                            </span>
                                                        <?php }else{  ?>
                                                            <span style="text-decoration: line-through ">
                                                                <?php echo $price_reg.' '.get_woocommerce_currency_symbol() ?>
                                                            </span> - 
                                                            <span style=" color: #000;"> 
                                                                <?php echo $price_sale.' '.get_woocommerce_currency_symbol() ?>
                                                            </span>
                                                        <?php }  ?>
                                                </span>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2 col-md-2 d-flex justify-content-end insapp_service_rating_counter" data-product-id="<?php _e($product_id) ?>"> 
                                        <svg xmlns="http://www.w3.org/2000/svg" class="add-to-favorites" height="1em" viewBox="0 0 512 512"><path d="M47.6 300.4L228.3 469.1c7.5 7 17.4 10.9 27.7 10.9s20.2-3.9 27.7-10.9L464.4 300.4c30.4-28.3 47.6-68 47.6-109.5v-5.8c0-69.9-50.5-129.5-119.4-141C347 36.5 300.6 51.4 268 84L256 96 244 84c-32.6-32.6-79-47.5-124.6-39.9C50.5 55.6 0 115.2 0 185.1v5.8c0 41.5 17.2 81.2 47.6 109.5z"/></svg>
                                    </div>
                                </div>
                            </a>
                            <?php 
                endwhile;
            }else{?>

                <div class="">
                    <div class="my-5 insapp_listing">
                        <p class="text-muted text-center fw-semibold mt-5" style="font-size: 1rem">
                        <?php _e("Vous n'avez aucunes annonce en Favoris")?>
                        </p>
                    </div>
                </div>

            <?php } 
     ?>
</div>