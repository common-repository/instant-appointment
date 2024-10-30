<?php 
        $current_user = wp_get_current_user();
        $author_id = $current_user->ID;
   
?>
<div class="row mt-5 align-middle">
    <div class="align-middle col-8">
        <h3>
            <?php _e('Paiements')?>
        </h3>
    </div>


    <div class="align-end col-4">
        <span>
            <p><?php echo do_shortcode( '[stripe_connect_gateway_account_add]'); ?></p>
        </span>
    </div>
</div>

<div class="row">

    <div class="col-12">

        <div class="card p-2">

            <div class="card-body">

                <div class="table-responsive pt-3 insapp_body_content ">
                    <table class="table table-bordered table-hover" id="inaspp_table" data-search="true"
                        data-pagination="true" data-show-columns="true" data-show-pagination-switch="true"
                        data-show-refresh="true" data-buttons-align="left" data-show-toggle="true" data-resizable="true"
                        data-buttons-class="primary" data-show-export="true" data-toggle="table" data-locale="fr-FR">
                        <thead>
                            <tr>
                                <!--<th data-field="state" data-checkbox="true"></th>-->
                                <th data-field="commande">
                                    <?php _e('Commande')  ?>
                                </th>
                                <th data-field="Date">
                                    <?php _e('Date')  ?>
                                </th>
                                <th data-field="montant">
                                    <?php _e('Montant')  ?>
                                </th>
                                <th data-field="annonce">
                                    <?php _e('Offre/Abonnement')  ?>
                                </th> 
                                <th data-field="Facture">
                                    <?php _e('Facture')  ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                    $args = array(
                        'post_type'      => 'shop_order',
                        'post_status'    => array( 'wc-completed', 'wc-processing' ),
                        'posts_per_page' => -1,
                        'meta_query'     => array(
                                array(
                                    'key'     => '_customer_user',
                                    'value'   => $author_id,
                                    'compare' => '='
                                )
                            ),
                        // 'meta_query' => array( 
                            // array(
                            //         'key'     => '_annonce_product',
                            //         'compare' => 'EXISTS',
                            //     ),
                            // ),
                        // 'meta_key'       => '_annonce_product',
                        // 'meta_value'     => '', 
                        // 'meta_compare'   => 'EXISTS',
                        //  'author'         => $author_id, 

                    );
                    $completed_orders_query = new WP_Query( $args );
         

                    if ( $completed_orders_query->have_posts() ) {
                        while ( $completed_orders_query->have_posts() ) {
                            $completed_orders_query->the_post(); 
                            $order_id = get_the_ID();
                            $order = wc_get_order($order_id); 
                            $customer_id = $order -> get_user_id (); 
                            $date = $order->get_date_completed();
                            $time = get_post_meta($order_id, '_booking_time', true );
                
                            $custummer_photo_url = get_user_meta( $customer_id, 'wp_user_avatar', true); 
                            if ($custummer_photo_url) {
                              $user_img = $custummer_photo_url;
                            } else { 
                              $user_img =  TLPLUGIN_DEFAULT. '/avatar-fallback.jpg';
                            }
                            $custummer_info = get_userdata($customer_id); 
                            $first_name = $custummer_info->first_name;
                            $last_name = $custummer_info->last_name; 
                             foreach( $order->get_items() as $item_id => $item ) {
                                $product_name = $item->get_name(); 
                                $item_id = $item->get_product_id();
                                $urlmg = get_the_post_thumbnail_url($item) == false ? TLPLUGIN_URL . 'assets/images/default-placeholder.png': get_the_post_thumbnail_url($product_id);
                            }
                            
                            $abonnement =  apply_filters('filter_stripe_connect_gateway_order_status', $item_id, $author_id); 
                            $statut_abonnement = $abonnement['status'];
                            // if($statut_abonnement != null && $statut_abonnement != "trialing"){
                            ?>
                            <tr> 
                                <td>
                                    <span>
                                        <?php _e($order->get_order_number() )?>
                                    </span>
                                </td>
                                <td>
                                    <div class="ib_date_create">
                                        <?php echo $order->get_date_paid()->date('j F Y , h:m' ) ?>
                                    </div>
                                </td>
                                <td class="fw-semibold">
                                    <span>
                                        <?php  _e($order->get_total()) ?>
                                    </span>
                                    <?php _e(get_woocommerce_currency_symbol()) ?>
                                </td>
                                <td> 
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex insapp_user_paiment">
                                            <div class="circle_image"><img src="<?php echo $urlmg;?>"></div>
                                            <div class="user_details">
                                                <span>
                                                    <?php echo $product_name ?>
                                                </span> 
                                            </div>
                                        </div>
                                    </div>

                                </td> 
                                <td>
                                    <span onclick="function_generate_bill(this, '<?php _e($order->get_id()) ?>')">
                                        <i class="bi bi-download"></i>
                                    </span>
                                </td>

                            </tr>

                            <?php }   }?>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>