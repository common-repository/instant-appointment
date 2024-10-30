<?php
//To limit the height of a paragraph


$args = array('taxonomy' => "product_cat",'parent'=> 0,'hide_empty'=> false);
$categories = get_terms( $args);
$listcategories = [];
foreach ( $categories as $category ) {
array_push( $listcategories, $category->term_id);
}
 

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
            'compare' => '!=', // Ignore products without a price
            'type' => 'NUMERIC',
        ),
		array(
			'key' => '_annonce_product',
			'compare' => 'EXISTS'
		)
    ),
    'orderby' => 'meta_value_num',
    'order' => 'DESC', // Sort in descending order to get the maximum price
    'meta_key' => '_price', // The meta key where the price is stored
);

$query = new WP_Query($args);

if ($query->have_posts()) { 
    $max_price = get_post_meta($query->posts[0]->ID, '_price', true); 
	$min_price = get_post_meta($query->posts[count($query->posts) - 1]->ID, '_price', true);  

}


 
 ?>
<div class="insapp_listing_sidebar_page">
	<div class="row">
		<div class="ia-sidebar-listing col-lg-4 col-12">
	        
	        <h3 class="mt-4 d-lg-flex d-none">Qui cherches-tu?</h3>
		        
			<aside class="ia-sidebar-container ia_stricky_template">

				<div class="ia-listing-search-form">


					<form id="ia-filter-profil-form" action="" class="form-search"
						method="GET">
						<div class="row">
							<div class="col-12 col-md-12 col-lg-12   ">
								<div class="form-group form-group-title">
									<input type="text" name="ia-filter-title-vendor" class="form-control " 
										id="ia-filter-title-vendor" placeholder="Nom">
								</div>
							</div>
							<div class="col-12 col-md-12 col-lg-12">
								<div class="form-group form-group-category">
									<select id="ia-filter-category-vendor" name="ia-filter-category-vendor"  class="form-select"
										data-placeholder="All Categories" tabindex="-1" aria-hidden="true">
										<option value="0">Toutes les Categories
										</option>
										
										<?php 
 										if (!empty($categories) && !is_wp_error($categories)) {
											foreach($categories as $category){  ?>
												<option date_id="<?php echo $category->term_id;?>" value="<?php echo $category->term_id ;?>">
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
							
							<div class="col-12 col-md-12 col-lg-12 mb-4">
							    <p>Localisation</p> 
								<div class="ia-filter-location-card">
									<input type="text" name="ia-filter-lieu" class="ia-filter-lieu-vendor" value="<?php echo !empty($annoncement_lieu)? $annoncement_lieu :'' ?>"
										id="ia-filter-lieu" placeholder="Lieu">
										<input type="hidden" id="ia-filter-lieu_latitude" value="">
										<input type="hidden" id="ia-filter-lieu_longitude" value="">
										  <input type="hidden" id="ib-radius" name="radius" value="">
										<div id="ib-radius-dialog" class="ib-radius-dialog" title="Sélectionner le rayon">
                                            <p>Délimite ta recherche:</p>
                                            <input type="range" min="1" max="300" value="100" id="ib-radius-range" class="ib-radius-range">
                                            <span id="ib-radius-value" class="ib-radius-value">100 km</span>
                                        </div>
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
															<input class="form-check-input ia-filter-medium-vendor"  name="ia-filter-medium-vendor"
																type="checkbox" value="<?php _e($medium->term_id) ?>" id="ia-filter-medium-vendor">
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
							 $users_per_page = 8;
                             $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                             
                             $argsprof = array( 
                                    'role__in' => array( 'insapp_photographe' ,'administrator'),
                                    'orderby' => 'registered',  
                                    'number' => $users_per_page,
                                     'offset' => ($paged - 1) * $users_per_page,
                                    'order' => 'DESC',
                                );
                
								$medium_values = array( '316', '318', '314' ); 
                            
                              
                            
							$blogusers = new WP_User_Query( $argsprof );
                            
                            $total_users = $blogusers->get_total();
                            $total_pages = ceil($total_users / $users_per_page);

							?>

				<div class="ia-main-items-wrapper" data-display_mode="list">
					<div class="ia-listings-ordering-wrapper">
						<div class="results-count">Affichage de
							<span class="first"><?php _e($paged); ?></span> à <span class="last"><?php _e($total_pages); ?></span> résultats sur <?php _e($total_users); ?></div>
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
							
							  if ( !empty($blogusers->get_results()) ) {
                                foreach ( $blogusers->get_results() as $user ) {
                                    $ID = $user->ID;    
    
                                    if(esc_url( $user->user_url ) != null) {
                                        $insapp_url = esc_url( $user->user_url ) ;
                                    }else {
                                        $insapp_url = TLPLUGIN_URL.'/assets/images/avatar-fallback.jpg';
                                    }
                                    
                                    $registration_date = $user->user_registered;
                                    $profile_photo_url = get_user_meta( $ID, 'wp_user_avatar', true); 
            
                                    if ($profile_photo_url) {
                                      $user_img = $profile_photo_url;
                                    } else {
                                      $user_img =  TLPLUGIN_DEFAULT. '/avatar-fallback.jpg';
                                    }
            
                                    $user_info = get_userdata($ID); 
                                    $first_name = $user_info->first_name;
                                    $last_name = $user_info->last_name; 
                                    $user_mail = $user_info->user_email; 
                                    $pseudo = $user_info->user_nicename;
                                    
                                    $user_phone = get_user_meta( $ID, 'telephone' , true );
                                    $user_adresse = get_user_meta( $ID, 'adresse' , true );
                                    $user_description = get_user_meta( $ID, '_description' , true ); 
                                    $user_profil_category = get_user_meta( $ID, 'category' , true );
                                    $user_profil_category  = json_decode($user_profil_category );
                                    // $user_profil_category = array_slice($user_profil_category, 0, 4);
                                    $argsAn = array(
                                    			'post_type' => 'product',
                                    			'posts_per_page' => -1,  
                                    			'meta_query' => array(
                                    				array(
                                    					'key' => '_annonce_product',
                                    					'compare' => 'EXISTS'
                                    			     	),
                                    	     	),
                                    	     	'author' => $ID,
                                    		);
                                    $annonces = new WP_Query( $argsAn ); 
                                    $total_annonce =  $annonces->found_posts; 

								    ?>
										
											<div class="col-sm-6 col-md-6 col-12 col-lg-6">
											
												<div class="insapp_profil_item_container">
													<a href="<?php echo esc_url( get_author_posts_url($ID) ); ?>" class="">
														<div class="insapp_profil_item">
															 <div class="d-flex align-items-center">
                 
                                                                <div class="  me-2 position-relative d-flex justify-content-end align-items-end">
                                                                   <div style=" background-image: url('<?php _e($user_img)?>');" class="avatar-lg rounded-circle border border-2 insapp_avatar_back">
                                                                    </div>
                                                                </div>

                                                                <div class="lh-1">
                                                                      <h4 class="mb-0"> <?php _e($pseudo)?> </h4>
                                                                </div>
                                                            </div>  
														</div>
														<hr class="mt-3 border-gray-200">
												     	<div class="insapp_profil_item_content">
															<?php $count = 0;
															if (!empty($user_profil_category) && is_array($user_profil_category)) {
    															foreach($user_profil_category as $category){ 
    															    if ($count < 4) { ?>
            															<span class="profil-cat"> 
            																<?php 
            																$term = get_term_by('id', $category, 'product_cat');
            																 echo($term->name); ?>
            															</span>
    														    	<?php   $count++;
                                                                    } else {
                                                                         
                                                                        break;
                                                                    } }
    															} ?>  
														</div> 
														
											             <p class="pb-4 m-0"><?php _e( limitParagraphHeight($user_description, 200)  )?></p>
    													<div class="insapp_profil_footer">
    													   	<div class="insapp_profil_list_services">
        													    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M345 39.1L472.8 168.4c52.4 53 52.4 138.2 0 191.2L360.8 472.9c-9.3 9.4-24.5 9.5-33.9 .2s-9.5-24.5-.2-33.9L438.6 325.9c33.9-34.3 33.9-89.4 0-123.7L310.9 72.9c-9.3-9.4-9.2-24.6 .2-33.9s24.6-9.2 33.9 .2zM0 229.5V80C0 53.5 21.5 32 48 32H197.5c17 0 33.3 6.7 45.3 18.7l168 168c25 25 25 65.5 0 90.5L277.3 442.7c-25 25-65.5 25-90.5 0l-168-168C6.7 262.7 0 246.5 0 229.5zM144 144a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"/></svg>
        													    <span><?php _e($total_annonce); ?> <?php echo $total_annonce > 1 ? 'annonces' : 'annonce'; ?></span>
    													    </div>
    													</div>
													</a>
    											</div>
											</div>
									<?php 								
									
								}; 
							 
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
            					} else {
            						 ?>
            						 <div class="ia_filiter_empty">
            							<p>Aucun profil trouvé</p>
            						</div><?php
            					}
            				            					wp_reset_postdata(); ?>
						</div>
					</div>
				</div>
				<div class="ia-main-pagination-wrapper">
					<ul class="pagination">
						 
					</ul>
				</div>


			</main><!-- .site-main -->
		</div><!-- .content-area -->

	</div>
</div> 