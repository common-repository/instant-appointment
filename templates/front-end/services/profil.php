<?php 
if(isset($data)) :
    $users_query  = (isset($data->users_query)) ? $data->users_query : 1 ;
    $paged = (isset($data->paged)) ? $data->paged : false ;
    $users_per_page = (isset($data->users_per_page)) ? $data->users_per_page : false ;
                            
    endif; 
    $blogusers = $users_query->get_results();
    $total_users = $users_query->get_total();
    $total_pages = ceil($total_users / $users_per_page);
     

     if ( !empty($blogusers) ) {
            foreach ( $blogusers as $user ) {
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
            <?php }								

         wp_reset_postdata(); ?>
 
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
             <p>Aucun profil trouvé</p>
        </div>
             
    <?php } ?>