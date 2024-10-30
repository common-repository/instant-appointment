<!-- 
/***********************************************************************
***********            liste abonnes                 **************
*****************************************************************/ -->


<style>
    .table>:not(caption)>*>* { 
        padding: 0.75rem 1.5rem;
    }
</style>
<div class="wrap">
    <div class="container-fluid">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="row justify-content-between mb-4">
                        <div class="col-lg-8 col-md-8 col-12">
                            <!-- Page header -->
                            <div class="mb-5">
                                <h3 class="mb-0 ">Les Abonnés</h3>

                            </div>
                        </div>
                        
                    </div>

                    <table class="table mb-0 text-nowrap table-centered">
                        <thead class="table-light">
                            <tr>
                                <th>No </th>
                                <th>Abonné</th>
                                <th>Abonnement</th>
                                <th>Statut </th>
                                <th>Date de l'abonnement</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $args = array(
                                'post_type' => 'shop_order',
                                'meta_key ' => '_order_subscription',
                                'meta_value'    => 'is_subscription', 
                                'meta_compare'  => 'LIKE', 
                            );

                            $orders = wc_get_orders( $args );

                            if(isset($orders)){
                                foreach($orders as $order){
                                    $order_id = $order->id;
                                    $item = wc_get_order($order_id );    
                                    $customer_id = $order->get_user_id();
                                    
                                    $user_info = get_userdata($customer_id);  
                                    $first_name = $user_info->first_name;
                                    $last_name = $user_info->last_name; 
                                    
                                    $customer_name = $first_name.' '.$last_name;
                                    $customer_email = $user_info->user_email;
                                    $price = $order->data["total"].get_woocommerce_currency_symbol() ;
                                    $date_paiement = $order->get_date_paid()->date('d M Y  H:i:s');
                                    $abonnement =  apply_filters('filter_stripe_connect_gateway_order_status', $order_id, $customer_id); 
                                      $statut_abonnement = $abonnement['status'];
                                      $order_abonnement = $abonnement['order'];

                                    // var_dump($date_paiement);
                                    foreach ($item->get_items() as $item_id => $item_order ) {

                                        $product = $item_order->get_product();
                                        $product_id = $product->id;
                                        $meta = get_post_meta($product_id);
                                        $title = $product->name;
                                        $interval = $meta["_subscription_period_interval"][0];
                                         
                                         
                                        if($statut_abonnement == null){
                                             $statut = 'Inactif';
                                            $class = "badge badge-danger-soft text-danger";
                                            
                                         }else if( $statut_abonnement == "active" || $statut_abonnement == "trialing" ){
                                            $statut = 'En cours';
                                            $class = "badge badge-success-soft text-success";
                                         }else{ 
                                            $statut = 'Annulé';
                                            $class = "badge badge-warning-soft text-warning ";
                                            
                                          } 

                                        // var_dump( $statut );
                                    }
                            ?>
                            <tr>
                                <td>
                                    <span>
                                        <?php echo '#'.esc_html($order_id) ?>
                                    </span>
                                </td>
                                <td class="row">
                                    <h6 class="mb-0 ia_table_text col-12">
                                        <?php echo esc_html($customer_name) ?>
                                    </h6>
                                    <span class="mb-0 ia_table_text" style=" font-weight: 600;">
                                        <a href="mailto:<?php echo esc_html($customer_email) ?>"><?php echo esc_html($customer_email) ?></a>
                                    </span>
                                </td>

                                <td>
                                    <span>
                                        <?php echo esc_html( $title ) ?>
                                    </span>
                                </td>

                                <td>
                                    <span class="<?php echo esc_html( $class ) ?>">
                                        <?php echo esc_html( $statut ) ?>
                                    </span>
                                </td>

                                <td>
                                    <span>
                                        <?php echo esc_html( $date_paiement ) ?>
                                    </span>
                                </td>

                            </tr>
                            <?php }}  ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>