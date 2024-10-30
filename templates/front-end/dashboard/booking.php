<div class="row mt-5 align-middle">
  <div class="align-middle col-8">
    <h3 class="text-dark align-middle">
      <?php _e('Reservation d\'annonces') ?>
    </h3>
  </div>
  <div class="align-middle col-4">
    <select id="insapp_etat" class="insapp_etat form-select align-middle">
      <option value="all" selected><?php _e('Toutes les reservations') ?></option>
      <option value="on-hold"> <?php _e('En attente')?></option>
      <option value="pending"><?php _e('En cours de traitement') ?></option>
      <option value="completed"><?php _e('Terminés') ?></option>
      <option value="cancelled"><?php _e('Refusées') ?></option>
    </select>
  </div

    <p class="insapp_info"></p>
 
            <div class="insapp_resa_list">

                       <?php
                          
                          $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                          $orders_per_page = 5;

                          $current_user = wp_get_current_user();
                          $author_id = $current_user->ID; 
                          
                          $args = array(
                                'post_type'      => 'shop_order',
                                'post_status'    => array( 'wc-completed', 'wc-processing', 'wc-cancelled', 'wc-pending', 'wc-on-hold' ),
                                'posts_per_page' => $orders_per_page,
                                'paged'          => $paged,
                                'meta_query'     => array(
                                    array(
                                        'key'          => '_annonce_product',
                                        'compare'      => 'EXISTS',
                                    ),
                                    array(
                                        'key'     => '_annonce_author', 
                                        'value'   => $author_id, 
                                        'compare' => '=',
                                    ),
                                ),
                            );
                          $orders = new WP_Query($args);
                        
                          $total_pages =  $orders->max_num_pages; 
                          $total_product =  $orders->found_posts; 

                          if ($orders->have_posts()) {
                            while ( $orders->have_posts() ) : $orders->the_post(); 

                                $order_id = $orders->post->ID; 
                                $item = wc_get_order($order_id );
                                $order_data = $item->data;
                                $status = $order_data[ 'status' ] ;
                                // var_dump(json_decode(get_post_meta($order_id) ["_booking_extra"][0]));
                                setlocale(LC_TIME, 'fr_FR');
                                 $order_date = $item->get_date_created();
                                 $formatted_date = strftime('%e %B %Y, %H:%M', $order_date->getTimestamp());

                                $customer_id = $item -> get_user_id (); 
                                $customer = get_user_by('id', $customer_id);
                                $customer_name = $customer->display_name;
                                $customer_email = $customer->user_email;
                                
                                
                                $date = date('j F Y',strtotime( get_post_meta( $order_id, '_booking_date', true )));
                                $time = get_post_meta( $order_id, '_booking_time', true );
                                $bd_extras = get_post_meta( $order_id, '_booking_extra', true );
                                $extras = isset($bd_extras) ? json_decode($bd_extras) : [];
                     
                                      foreach ($item->get_items() as $item_id => $item_order ) {

                                          $product = $item_order->get_product();
                                          $product_id = $product->id;

                                          $categories = wp_get_post_terms($product_id, 'product_cat',);
                                           $categories = wp_get_post_terms($product_id , 'product_cat', array( 'parent' => 0, 'hide_empty' => 0)); 

                                          $meta = get_post_meta($product_id);
                                          $dure = isset($meta['_duration'][0]) ? $meta['_duration'][0] : 'undefine';
                                          
                                          $title = $product->name;

                                          // var_dump($product->name);
                                          switch ($status) {
                                            case 'cancelled':{
                                              $btn = '<button class="dropdown-item d-flex align-items-center insapp_btn_state btn_delete" type="button" data-id="'.$order_id.'" id="btn_delete">Supprimer
                                                  </button>';
                                              $statut = 'Refusé';
                                              break;
                                            }   
                                                
                                            case 'pending':{
                                              $btn = '<span class="ia-add-google-calendar" value="'. $order_id.'"  >
                                              <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 48 48">
                                             <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"></path><path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"></path><path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"></path><path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"></path>
                                              </svg>
                                             Ajouter agenda
                                          </span> ';
                                              $statut = 'Accepté';
                                              break;

                                            } 
                                                
                                            case 'processing':{
                                              $btn = '<button class="dropdown-item d-flex align-items-center insapp_btn_state btn_fini" data-id="'.$order_id.'" type="button" id="btn_fini">Terminer
                                                      </button>';
                                              $statut = 'Payé';
                                              break;

                                            }
                                            
                                            case 'completed':{
                                              $btn = '';
                                              $statut = 'Terminé';
                                              break;

                                            }
                                                
                                            
                                            case 'on-hold':{ 
                                              $btn = '<div class="d-flex">
                                              <button class="dropdown-item d-flex align-items-center insapp_btn_state btn_accepter" data-id="'. $order_id.'" type="button" id="btn_accepter">Accepter
                                              </button>

                                              <button class="dropdown-item d-flex align-items-center insapp_btn_state text-danger btn_refuser" data-id="'. $order_id.'" type="button" id="btn_refuser">Annuler
                                              </button>
                                              </div>';
                                              $statut = 'En attente';
                                              break;
                                            }
                                            default:{
                                              break;
                                            }
                                                
                                          }
                                          if($statut == 'Refusé'){
                                            $color = 'danger';
                                          }elseif($statut == 'Accepté'){
                                            $color = 'success';
                                          }elseif($statut == 'Terminé'){
                                            $color = 'primary';
                                          }else{
                                            $color = 'warning';
                                          }                                                         

                                                $url = get_the_post_thumbnail_url($product_id) == false ? TLPLUGIN_URL . 'assets/images/default-placeholder.png': get_the_post_thumbnail_url($product_id);
                                                                  ?>
                                              <div class="row insapp_listing_timeline py-2">
                                                <span></span>
                                                <input type="hidden" name="the_order_id" id="the_order_id" value="<?php echo $order_id; ?>">
                                              </div>
                                              <div class="">
                                                <div class="row insapp_listing">
                                                  <div class="col-12 col-md-6">

                                                    <div class="d-flex align-items-center mb-3 mb-xl-0" style="width:100%">
                                                      <div class="insapp_gallery" style="width:40%;background-image: url('<?php _e($url)?>')"> </div>
                                                      <div class="ms-3" style="width:60%">
                                                        <div class="">
                                                          <span class="ia_table_title" style="vertical-align: inherit;">
                                                            <?php echo '<span>' .  $title .'</span>' ?>
                                                          </span>
                                                        </div>
                                                        <span class="mb-0 ia_table_text">
                                                          <?php echo('Rendez-vous : '.$time) ?>
                                                        </span></br>
                                                        <span class="mb-0 ia_table_text">
                                                          <?php echo 'prix: '.$order_data [ 'total' ].' '. get_woocommerce_currency_symbol(); ?>
                                                        </span>
                                                      </div>
                                                    </div>

                                                  </div>
                                                  <div class="col-12 col-md-6 d-flex flex-column flex-md-row align-items-center ">
                                                    <div class="col-12 col-md-4 d-flex  align-items-center  justify-content-start justify-content-md-center ">
                                                      <span class="mx-3 badge badge-<?php echo $color; ?>-soft text-<?php echo $color; ?>">
                                                        <span style="vertical-align: inherit;">
                                                          <span style="vertical-align: inherit;">
                                                            <?php echo $statut ; ?>
                                                          </span>
                                                        </span>
                                                      </span>
                                                    </div>

                                                    <div class="col-12 col-md-8 d-flex my-5 justify-content-start justify-content-md-end insapp_btn_state align-items-center" role="button">
                                                      <span class="ia_table_collapse">
                                                        <?php echo $btn ; ?>
                                                      </span>
                                                    </div>

                                                  </div>
                                                  
                                                  <div class="" >
                                                    <div class="detailslistingcollapse d-flex flex-column">
                                                      <div class="mb-0 row">
                                                        <span class="ia_table_subtitle col-4">
                                                          <?php _e('Catégories: ') ?>
                                                        </span>
                                                        <div class=" col-8">
                                                          <?php foreach($categories as $category){?>
                                                            <span class="ia_table_text px-1">
                                                                <?php echo $category->name; ?>
                                                            </span>
                                                              <?php }?>
                                                        </div>
                                                      
                                                      </div>
                                                      <!-- <div class="mb-0 row">
                                                                <span class="ia_table_subtitle col-4"><?php //_e('Extras') ?></span>
                                                                <span class="ia_table_text  col-8">
                                                                  <?php //foreach($extras as $extra){?>
                                                                      <li class="col-1"><?php //echo $extra->nom.' (' .$extra->cout.get_woocommerce_currency_symbol().')' ;?></li>
                                                                  <?php //}?>
                                                                </span>
                                                              </div> 
                                                            -->
                                                            <div class="mb-0 row">
                                                              <span class="ia_table_subtitle col-4">
                                                                <?php _e('Reservé pour le ') ?>
                                                              </span>
                                                              <span class="ia_table_text  col-8">
                                                                <?php echo $date.' à '.$time; ?>
                                                              </span>
                                                            </div>
                                                            <div class="mb-0 row">
                                                              <span class="ia_table_subtitle col-4">
                                                                <?php _e('Client') ?>
                                                              </span>
                                                              <span class="ia_table_text  col-8">
                                                                <?php echo $customer_name.' - '.$customer_email ?>
                                                              </span>
                                                            </div>
                                                            <div class="mb-0 row">
                                                              <span class="ia_table_subtitle col-4">
                                                                <?php _e('Reservé le') ?>
                                                              </span>
                                                              <span class="ia_table_text  col-8">
                                                               
                                                                <?php echo $formatted_date?>
                                                              </span>
                                                            </div>
                                                          </div>
                                                        </div>
                                                      </div>
                                                    </div>

                                                    <?php } endwhile; ?>

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
                          } else {  ?>

                        
                            <div class="">
                              <div class="my-5 insapp_listing">
                                <p class="text-muted text-center fw-semibold mt-5" style="font-size: 1rem">
                                  <?php _e("Vous n'avez aucune reservation client pour l'instant")?>
                                </p>
                              </div>
                            </div>
                      <?php }  ?>

</div>

</div>