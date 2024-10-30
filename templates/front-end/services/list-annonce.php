<?php 
if(isset($data)) :
    $services  = (isset($data->services)) ? $data->services : false ;
    $paged = (isset($data->paged)) ? $data->paged : false ;
    endif; 
    
    $total_pages = $services->max_num_pages; 
    $tatal_product =  $services->found_posts;

   if ( $services->have_posts() ) {
    while ( $services->have_posts() ) : $services->the_post(); 
         
        $product_id = $services->post->ID;
        $annonce_product = get_post_meta( $product_id, '_annonce_product', true );
	 
         if(!empty($annonce_product) ){ 
									
        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), array('220','220'), true );
        $title = get_the_title();
        $_product = wc_get_product( $services->post->ID );
        $price_reg = $_product->get_regular_price()?$_product->get_regular_price():0;
        $price_sale = $_product->get_sale_price()?$_product->get_sale_price():0;
        $price = $_product->get_price();
        
        $args = array('taxonomy' => "product_cat",'parent'=> 0,'hide_empty'=> false);
        $categories = get_terms( $args);

        $categories = wp_get_post_terms($product_id, 'product_cat', array('fields' => 'all', 'parent' => 0));
        $url = get_the_post_thumbnail_url() == false ? TLPLUGIN_URL . 'assets/images/default-placeholder.png': get_the_post_thumbnail_url();
        
            ?>
                <div class="col-sm-6 col-md-6 col-12 col-lg-6">
                    <a href="<?php echo esc_url( get_permalink($annonce_product)); ?>"
                        class="insapp_service_item_container">
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
                                   <?php } ?>
                                
                            </div>
                            <span class="like-icon listeo_core-unbookmark-it liked align-center">
                                <span class="pe-2 " id="service_rating">
                                    <?php _e('0.0')?>
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="star" height="1em"viewBox="0 0 576 512"> <style> .star { fill: #ffffff !important } </style>
                                    <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z" />
                                </svg>
                               </span>
                        </div>
                        <div class="insapp_service_item_body">
                            <h3>
                                <?php echo($title); ?>
                            </h3>
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
                                <div class="insapp_service_rating_counter">

                                </div>
                            </div>
                        </div>
                    </a>
                </div>
        <?php	}else{ ?>
                    <div class="ia_filiter_empty">
                        <p>Aucune annonce trouvé</p>
                    </div>
                    
                <?php }								
        
    endwhile; 
    wp_reset_query(); ?>

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
									 	for ($i = 1; $i <= $total_pages; $i++) {
											if ($i === 1 || $i === $total_pages || abs($i - $paged) <= $links_around_current || $total_pages <= 5) {
											 	if ($paged === $i) {
													echo '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
												} else {
													echo '<li class="page-item"><a class="page-link" href="' . esc_attr(get_pagenum_link($i)) . '">' . $i . '</a></li>';
												}
											} elseif (abs($i - $paged) === $links_around_current + 1) {
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

} else {?>
<div class="ia_filiter_empty">
     <p>Aucune annonce trouvé</p>
</div>
     
<?php }
wp_reset_postdata(); ?>
 