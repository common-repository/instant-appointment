<?php

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$services_per_page = 10;

$current_user = wp_get_current_user();
$author_id = $current_user->ID;

$args = array(
  'post_type'      => 'shop_order',
  'post_status'    => array( 'wc-completed', 'wc-processing', 'wc-cancelled','wc-pending','wc-on-hold' ),
  'posts_per_page' => -1, 
  'meta_key'       => '_annonce_product',
  'meta_value'     => '', 
  'meta_compare'   => 'EXISTS',
); 
$orders = new WP_Query($args);
 
$total_pages =  $orders->max_num_pages; 
$total_product =  $orders->found_posts;

?>
 

 
		<div class="insapp_body_wrapper ">
		<div class="row mt-5">
			<h2 class="text-dark mt-5">
				<?php _e('Liste des rendez-vous') ?>
			</h2>
		</div>
 
			<div class="table-responsive pt-3 insapp_body_content ">
				<table class="table table-bordered table-hover" id="inaspp_table" data-search="true"
					data-pagination="true" data-show-columns="true" data-show-pagination-switch="true"
					data-show-refresh="true" data-buttons-align="left" data-show-toggle="true" data-resizable="true"
					data-buttons-class="primary" data-show-export="true" data-toggle="table" data-locale="fr-FR">
					<thead>
						<tr>
							<th data-field="state" data-checkbox="true"></th>
							<!--<th data-field="id">No</th>-->
							<th data-field="Date">
								<?php _e('Date')  ?>
							</th>
							<th data-field="reservation"style=" width: 500px">
								<?php _e('Reservation')  ?>
							</th>
							<th data-field="prix">
								<?php _e('Prix Total')  ?>
							</th>
							<th data-field="informations">
								<?php _e('Informations du client')  ?>
							</th>

							<th data-field="informations_vendor">
								<?php _e('Informations du Photographes')  ?>
							</th>
							<th data-field="statut">
								<?php _e('Statut')  ?>
							</th>
							<th data-field="Action"> 
									<?php _e('Activer/ Désactiver')  ?>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php

          if ($orders->have_posts()) {
			while ( $orders->have_posts() ) : $orders->the_post(); 
			$order_id = $orders->post->ID; 
			$item = wc_get_order($order_id );
			$order_data = $item->data;
			$status = $order_data[ 'status' ] ;

			$customer_id = $item -> get_user_id ();  

			$custummer_photo_url = get_user_meta( $customer_id, 'wp_user_avatar', true); 
			if ($custummer_photo_url) {
			$user_img = $custummer_photo_url;
			} else { 
			$user_img =  TLPLUGIN_DEFAULT. '/avatar-fallback.jpg';
			}
			$custummer_info = get_userdata($customer_id); 
			$first_name = $custummer_info->first_name;
			$last_name = $custummer_info->last_name; 
			$user_mail = $custummer_info->user_email; 
			
			$date = date('j F Y',strtotime( get_post_meta( $order_id, '_booking_date', true )));
			$time = get_post_meta( $order_id, '_booking_time', true );
			$bd_extras = get_post_meta( $order_id, '_booking_extra', true );
			$extras = isset($bd_extras) ? json_decode($bd_extras) : [];

			foreach ($item->get_items() as $item_id => $item_order ) {

				$product = $item_order->get_product();
				$product_id = $product->id;

				$author_id = $product->get_post_data()->post_author;
				$author_photo_url = get_user_meta( $author_id, 'wp_user_avatar', true); 

				if ($author_photo_url) {
				$user_img_author = $author_photo_url;
				} else { 
				$user_img_author =  TLPLUGIN_DEFAULT. '/avatar-fallback.jpg';
				}
				$author_info = get_userdata($author_id); 
				$first_name_author= $author_info->first_name;
				$last_name_author = $author_info->last_name; 
				$user_mail_author = $author_info->user_email; 

				$meta = get_post_meta($product_id);
				$dure = isset($meta['_duration'][0]) ? $meta['_duration'][0] : 'undefine';
				
				$title = $product->name;
				$url = get_the_post_thumbnail_url($product_id) == false ? TLPLUGIN_URL . 'assets/images/default-placeholder.png': get_the_post_thumbnail_url($product_id);
					 
					switch ($status) {
					case 'cancelled':{
						$btn = '<button class="dropdown-item d-flex align-items-center insapp_btn_state btn_delete" type="button" data-id="'.$order_id.'" id="btn_delete">Supprimer
							</button>';
						$statut = 'Refusé';
						break;
					}   
						
					case 'pending':{
						$btn = '';
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


        ?>

						<tr>
							<td></td>
							<!--<td>-->
								<?php  //_e($order_id) ?>
							<!--</td>-->
							<td>
								<div class="ib_date_create">
									<?php echo get_the_date( 'j F Y, h:m' )?>
								</div>
							</td>
							<td style="min-width: 300px" >
								<div class="d-flex align-items-center justify-content-between">
									<div class="d-flex insapp_user_card">
										<div class="circle_image"><img src="<?php echo $url;?>"></div>
										<div class="user_details">
											<span>
												<?php echo $title ?>
											</span>
											<span>
												<?php echo $date; ?>
											</span>
											<span>
												<?php echo ' à '.$time; ?>
											</span>
										</div>
									</div>
								</div>
							</td>
							<td class="text-danger">
								<div class="user_details">
									<span>
										<?php _e($order_data [ 'total' ].''. get_woocommerce_currency_symbol()); ?>
									</span>
								</div>
							</td>
							<td>
								<div class="d-flex align-items-center justify-content-between">
									<div class="d-flex insapp_user_card">
										<div class="circle_image"><img src="<?php echo $user_img;?>"></div>
										<div class="user_details">
											<span>
												<?php echo $first_name ?>
												<?php echo $last_name ?>
											</span>
											<span>
												<?php echo $user_mail?>
											</span>
											<span>
												<?php echo  $user_phone;?>
											</span>
										</div>
									</div>
								</div>
							</td>

							<td>
								<div class="d-flex align-items-center justify-content-between">
									<div class="d-flex insapp_user_card">
										<div class="circle_image"><img src="<?php echo $user_img_author;?>"></div>
										<div class="user_details">
											<span>
												<?php echo $first_name_author ?>
												<?php echo $last_name_author ?>
											</span>
											<span>
												<?php echo $user_mail_author?>
											</span>
											<span>
												<?php echo  $user_phone_author;?>
											</span>
										</div>
									</div>
								</div>
							</td>

							</td>


							<td>
								<span class="badge badge-<?php echo $color; ?>-soft text-<?php echo $color; ?>">
									<?php echo $statut ; ?>
								</span>
							</td>
							<td>
								<label class="insapp_toggle">
									<?php $active = $statut == 'Refusé' ? "checked" : '' ?>
									<input id="insapp_toggleswitch" <?php _e($active) ?> value="
									<?php _e($order_id) ?>" onclick="operateOrders(this, '<?php _e($order_id) ?>')" type="checkbox">
									<span class="insapp_roundbutton"></span>
								</label>
							</td>
						</tr>

						<?php }  endwhile; }?>

					</tbody>
				</table>

			</div>    