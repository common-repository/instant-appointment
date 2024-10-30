<?php get_header(); ?>

<div class="container" > 
       
   <?php
       $category_id = get_queried_object_id();
        $categories = array(get_term($category_id, 'product_cat')); 
        $listcategories = [$category_id];
        $tags = get_terms(array('taxonomy' => 'product_tag','hide_empty' => false));
         
        $mediums = get_terms(
        	 array(
            'taxonomy'   => 'service', 
        	'hide_empty' => false 
        	) 
        ); 
        
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
        }
        
        function getBoundingBox($latitude, $longitude, $distance) {
            // Rayon de la Terre en kilomètres
            $earthRadius = 6371;
        
            // Conversion de la distance en radians
            $angularDistance = $distance / $earthRadius;
        
            // Conversion de latitude et longitude en radians
            $latRad = deg2rad($latitude);
            $lonRad = deg2rad($longitude);
        
            // Calcul des variations de latitude et de longitude
            $deltaLat = $angularDistance;
            $deltaLon = $angularDistance / cos($latRad);
        
            // Conversion des variations en degrés
            $deltaLatDeg = rad2deg($deltaLat);
            $deltaLonDeg = rad2deg($deltaLon);
        
            // Calcul des bornes
            $minLat = $latitude - $deltaLatDeg;
            $maxLat = $latitude + $deltaLatDeg;
            $minLon = $longitude - $deltaLonDeg;
            $maxLon = $longitude + $deltaLonDeg;
        
            return array(
                'minLatitude' => $minLat,
                'maxLatitude' => $maxLat,
                'minLongitude' => $minLon,
                'maxLongitude' => $maxLon
            );
        }
         
        
         ?>
        <div class="insapp_listing_sidebar_page">
        	<div class="row">
        		<div class="ia-sidebar-listing col-lg-4 col-12">
        			<aside class="ia-sidebar-container widget_apus_elementor_template">
        
        				<div class="ia-listing-search-form">
        
        					<form id="ia-filter-listing-form" action="" class="form-search filter-listing-form style_df"
        						method="GET">
        						<div class="row">
        							<div class="col-12 col-md-12 col-lg-12   ">
        								<div class="form-group form-group-title">
        									<input type="text" name="ia-filter-title" class="form-control " value="<?php echo !empty($annoncement_name)? $annoncement_name :'' ?>"
        										id="ia-filter-title" placeholder="Que cherchez-vous?">
        								</div>
        							</div>
        							<div class="col-12 col-md-12 col-lg-12">
        								<div class="form-group form-group-category">
        									<select id="ia-filter-category" name="ia-filter-category"  class="form-select"
        										data-placeholder="All Categories" tabindex="-1" aria-hidden="true">
        										<option value="0">Toutes les Categories
        										</option>
        										
        										<?php 
        										 $selectcat = $category_id ;
        										if (!empty($categories) && !is_wp_error($categories)) {
        											foreach($categories as $category){
        												$selected = $category->term_id == $selectcat ? "selected" : ''; ?>?>
        												<option <?php _e($selected) ?> date_id="<?php echo $category->term_id;?>" value="<?php echo $category->term_id ;?>">
        													<?php echo $category->name ;?>
        												</option>
        										<?php } 
        											} else {?>
        												<option value="">Aucune categorie trouvé
        											</option>
        												<?php
        											}
        										?> 
        									</select>
        								</div>
        							</div>
        							
        							<div class="col-12 col-md-12 col-lg-12">
        								<div class="form-group form-group-category">
        								<label class="ia-heading-label"> Sous categories </label>
        									<div class=" ">
        										<ul class=" ia-circle-check level-0" id="ia-subcategory-list">
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
        																<input class="form-check-input ia-filter-sous-category" name="ia-filter-sous-category<?php _e($i); ?>"
        																	type="checkbox" value="<?php echo $subcategory->term_id;?>" id="ia-filter-sous-category<?php _e($i); ?>">
        																<label class="form-check-label" for="ia-filter-sous-category<?php _e($i); ?>">
        																	<?php echo $subcategory->name ;?>
        																</label>
        															</div>
        														</li>  
        													<?php $i++; }
        													  } 
        													  
        										
        											} else {?>
        												     <p > <?php _e('Aucune sous categories.' )?></p>
        												<?php
        											} ?>
        										</ul>
        									</div> 
        								</div>
        							</div> 
        							
        							<div class="col-12 col-md-12 col-lg-12   ">
        							    <p>Localisation</p> 
        								<div class="ia-filter-location-card">
        									<input type="text" name="ia-filter-lieu" class="ia-filter-lieu" value="<?php echo !empty($annoncement_lieu)? $annoncement_lieu :'' ?>"
        										id="ia-filter-lieu" placeholder="Lieu">
        										<input type="hidden" id="ia-filter-lieu_latitude" value="">
        										<input type="hidden" id="ia-filter-lieu_longitude" value="">
        										  <input type="hidden" id="ib-radius" name="radius" value="">
        										<div id="ib-radius-dialog" class="ib-radius-dialog" title="Sélectionner le rayon">
                                                    <p>Choisissez le rayon de recherche :</p>
                                                    <input type="range" min="1" max="100" value="10" id="ib-radius-range" class="ib-radius-range">
                                                    <span id="ib-radius-value" class="ib-radius-value">10 km</span>
                                                </div>
        								</div>
        							</div>
        							<div class="col-12 col-md-12 col-lg-12   ">
        	
        									<div class="ia-price-wrapper ia_price_range_block">
        										<p>Prix</p> 
        										<div class="ia-price-range-card">
                                            
                                                  <div class="price-content">
                                                    <div>
                                                      <label>Min</label>
                                                      <p><span id="ia_price_rage_min-value"><?php _e($min_price) ?></span>	<?php _e(get_woocommerce_currency_symbol()); ?></p>
                                                    </div> 
                                                    <div>
                                                      <label>Max</label> 
                                                      <p><span id="ia_price_rage_max-value"><?php _e($max_price) ?></span>	<?php _e(get_woocommerce_currency_symbol()); ?></p>
                                                    </div>
                                                  </div> 
                                                    <div class="range-slider">
                                                      <input type="range" class="min-price ia-price-filter" id="ia-price-filter-min" value="<?php _e($min_price); ?>" min="<?php _e($min_price) ?>" max="<?php _e($max_price) ?>" step="10">
                                                      <input type="range" class="max-price ia-price-filter" id="ia-price-filter-max" value="<?php _e($max_price);?>" min="<?php _e($min_price) ?>" max="<?php _e($max_price) ?>" step="10">
                                                    </div>
                                                </div>
        										
        										 							
        							    	</div>
        										 							
        							    	</div>
        
        							</div>
        							<div class="col-12 col-md-12 col-lg-12   ">
        								<div class="form-group form-group-title">
        									<input type="text" name="ia-filter-date_annonce" class="form-control " value="<?php echo !empty($annoncement_date_range )? $annoncement_date_range  :'' ?>"
        										id="ia-filter-date_annonce" placeholder="Date de publication"> 
        								</div>
        							</div>
        							<div class="col-12 col-md-12 col-lg-12">
        								<div class="form-group form-group-medium ">
        									<label class="ia-heading-label"> service </label>
        									<div class=" ">
        										<ul class="terms-list ia-circle-check level-0">
        										   <?php 	
        											if (!empty($mediums) && !is_wp_error($mediums)) {
        												foreach ($mediums as $medium) {?>
        
        													<li class="list-item level-0">
        														<div class="form-check">
        															<input class="form-check-input ia-filter-medium"  name="ia-filter-medium"
        																type="checkbox" value="<?php _e($medium->term_id) ?>" id="ia-filter-medium">
        															<label class="form-check-label"
        																for="filter-feature-bike-parking-49327">
        																<?php _e($medium->name) ?>
        															</label>
        														</div>
        													</li>  
        												<?php }
        											} else {
        												echo 'Aucun service trouvé.';
        											} ?> 
        										</ul>
        									</div>
        								</div>
        
        
        							</div>
        							<div class="col-12 col-md-12 col-lg-12">
        								<div class="form-group form-group-tag ">
        									<label class="ia-heading-label"> Tag </label>
        									<div class=" ">
        										<ul class="terms-list ia-circle-check level-0">
        										   <?php 	
        											if (!empty($tags) && !is_wp_error($tags)) {
        												foreach ($tags as $tag) {?>
        
        													<li class="list-item level-0">
        														<div class="form-check">
        															<input class="form-check-input ia-filter-tag"  name="filter-feature[]"
        																type="checkbox" value="<?php _e($tag->term_id) ?>" id="filter-feature-bike-parking-49327">
        															<label class="form-check-label"
        																for="filter-feature-bike-parking-49327">
        																<?php _e($tag->name) ?>
        															</label>
        														</div>
        													</li>  
        												<?php }
        											} else {
        												echo 'Aucun service trouvé.';
        											} ?> 
        										</ul>
        									</div>
        								</div>
        
        
        							</div>  
        
        						<div class="row">
        							<div class="col-12 col-md-12 px-4 form-group-search">
        								<button class="btn btn-primary w-100" type="submit">
        									Chercher </button>
        							</div>
        						</div>
        					</form>
        				</div>
        
        			</aside>
        		</div>
        
        		<div id="ia-main-content" class="col-sm-12 col-lg-8 col-12">
        			<main class="ia-layout-type-default">
        					<?php 		
        					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        							   $services_per_page = 8; 
        							    
        							   $argsAn = array(
            								'post_type' => 'product',
            								'posts_per_page' => $services_per_page, 
            								'paged' => $paged,  
            								'meta_query' => array(
            									array(
            										'key' => '_annonce_product',
            										'compare' => 'EXISTS'
            									),
            								), 
            							); 
        
        								if (!empty($category_id)) { 
        									$argsAn['tax_query'] = array(
        										array(
        											'taxonomy' => 'product_cat', 
        											'field'    => 'term_id', 
        											'terms'    => $category_id, 
        										),
        									);
        								} 
        								 
        								$annonces = new WP_Query( $argsAn );
        								$total_pages = $annonces->max_num_pages; 
        								$total_product =  $annonces->found_posts; 
        
        
        							 ?>
        
        				<div class="ia-main-items-wrapper" data-display_mode="list">
        					<div class="ia-listings-ordering-wrapper">
        						<div class="results-count">Affichage de
        							<span class="first"><?php _e($paged); ?></span> à <span class="last"><?php _e($total_pages); ?></span> résultats sur <?php _e($total_product); ?></div>
    							<div class="ordering-display-mode-wrapper d-flex align-items-center">
        							<div class="listings-ordering ia_filter">
        						    	 <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 3h16a1 1 0 0 1 1 1v1.586a1 1 0 0 1-.293.707l-6.414 6.414a1 1 0 0 0-.293.707v6.305a1 1 0 0 1-1.243.97l-2-.5a1 1 0 0 1-.757-.97v-5.805a1 1 0 0 0-.293-.707L3.293 6.293A1 1 0 0 1 3 5.586V4a1 1 0 0 1 1-1"/></svg>
        							</div> 
        						</div>
        					</div>
        
        					<div class="ia-listings-wrapper items-wrapper clearfix">
        						<div class="insapp_loader_listing_ajax_container" style="">
        							<div class="insapp_loader_ajax"></div>
        						</div>
        						<div class="row insapp_listing_ajax_container"  id="ia-filtered-results">
        
        							<?php
        							   
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
                                                    <a class="page-link" href="<?php echo esc_attr(get_pagenum_link($paged - 1)); ?>" aria-label="Précédent">
                                                        <span aria-hidden="true">&laquo;</span>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                    
                                            <?php
                                            $links_around_current = 2; // Number of links to show around the current page
                                            for ($i = 1; $i <= $total_pages; $i++) {
                                                if ($i === 1 || $i === $total_pages || abs($i - $paged) <= $links_around_current || $total_pages <= ($links_around_current * 2 + 1)) {
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
        							
        								} else {
        						 ?>
        						 <div class="ia_filiter_empty">
        							<p>Aucune annonce trouvé</p>
        						</div><?php
        					}
        					wp_reset_postdata(); ?>
        						</div>
        
        					</div>
        
        				</div>
				
		    	</main>
	    	</div>

        	</div>
        </div>
 </div>
  
  <?php get_footer(); ?>
   
