<?php 
   $customer = wp_get_current_user();
   $user_id =  $customer->ID;
   
  ?>
  <div class="row mb-18 insapp_pricin_gpage">

    <div class="col-md-12 col-12 mb-5">
      <h4 class="display-6 fw-bold ls-sm text-center">Trouvez le forfait qui vous convient</h4>

    </div> 
 
       <!-- <div class="buttonWrapper">-->
       <!--   <div class="d-flex flex-row px-3">-->
       <!--       <div class="plans_type">Mois</div>-->
       <!--       <label class="toggle">-->
       <!--           <input id="toggleswitch" type="checkbox">-->
       <!--           <span class="roundbutton"></span>-->
       <!--       </label>-->
       <!--       <div class="plans_type">Année</div>-->
       <!--   </div>-->
       <!--</div> -->
           <div class="insapp_subcontent"> 
              <div class="inapp_content active" id="home">          
                 <div class="row inlisting-plan">
                    <?php
                    
                   
                    
                        $args = array(
                            'post_type' => 'product',
                            'posts_per_page' => -1,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_type',
                                    'field'    => 'slug',
                                    'terms'    => 'subscription',
                                ),
                            ),
                        );
                
                      $subscription_products = new WP_Query($args); 
                      $numer_plan = $subscription_products->found_posts; 
                      
                      if( $numer_plan > 1 && $numer_plan < 4 ){
                          $col_number = '-4';
                      }elseif( $numer_plan == 4){
                          $col_number = '-3';
                      }elseif( $numer_plan == 1){
                          $col_number = '-6';
                      }else{
                          $col_number ='';
                      }
                      
                      if ($subscription_products->have_posts()) {
                          while ($subscription_products->have_posts()) {
                           
                              $subscription_products->the_post();
                              $subscription_id = get_the_ID();
                              $list_elements =json_decode( get_post_meta($subscription_id, '_list_element', true));
                              $regular_price = get_post_meta($subscription_id, '_regular_price', true);
                              $billing_period = get_post_meta($subscription_id, '_subscription_period', true);
                                        $sale_price = get_post_meta($subscription_id, '_sale_price', true);
                              $billing_interval = get_post_meta($subscription_id, '_subscription_period_interval', true);
                              $free_trial = get_post_meta($subscription_id, '_subscription_free_trial', true);
                            //   var_dump($billing_period);
                            //   var_dump($billing_interval);
                              $currency = get_woocommerce_currency_symbol();
                              $status = get_post_status(); 
                    
                              $abonnement =  apply_filters('filter_stripe_connect_gateway_order_status', $subscription_id, $user_id); 
                              $statut_abonnement = $abonnement['status'];
                              $order_abonnement = $abonnement['order'];
                              
                             
                            if($status == 'publish'){
                                $status  = 'publié';
                            }
                            ?>

                                <div class="col<?php _e( $col_number); ?> mb-4 insapp_pricin_col"  >
                                  <div class="card " style="border-radius: 8px;">
                                  <div class="card-body">
                                    <div class="text-center pt-3" style="min-height: 110px;">
                                        <h2 class="pt-2"><?php echo esc_html(get_the_title()) ?></h2>
                                        <span class="ib_pricing_description"><?php the_content()?></span>
                                        </div>
                                      <div class="ib_pricing__price">

                                        <span class="ib_pricing__price_prefix"><?php _e($currency )?>
                                          
                                        </span>
                                        <span class="ib_pricing__price_val"><?php _e($regular_price )?></span>
                                        <span class="ib_pricing__price_suffix"> <?php _e('/ mois') ?></span>

                                        <div class=""> 
                                          <?php
                                                
                                          $order_exist = insapp_has_user_ordered_product($subscription_id, $user_id);
                                        
                                          if( ($regular_price == 0 || $sale_price ==0 )&& $order_exist == 1){
                                              
                                          }else{
                                              
                                              if($statut_abonnement == null){?>
    
                                                 <button type="button" data-id="<?php echo $subscription_id?>" class="btn submit_subcription_btn insapp_payement_abonnement_free" >
                                                     <?php _e('Essaie gratuit ('.$billing_interval.' mois)' ) ?>
                                                  </button>
    
                                              <?php } else if( $statut_abonnement == "active" || $statut_abonnement == "trialing" ){ ?>
                                              
                                                 <button type="button" data-id="<?php echo $order_abonnement ?>" class="btn submit_subcription_btn insapp_payement_abonnement_off" >
                                                    <?php _e('Desabonner') ?>
                                                  </button>
    
                                              <?php }else{ ?>
    
                                                 <button type="button" data-id="<?php echo $subscription_id ?>" class="btn submit_subcription_btn insapp_payement_abonnement_free" >
                                                    <?php _e('S\'abonner') ?>
                                                  </button> 
                                                
     
                                              <?php }  
                                        
                                        } ?>
                                                  
                                          </div>
                                      </div>
                                      <ul class="list-group list-group-flush">
                                        
                                          <?php 
                                          if(!empty($list_elements) && !is_wp_error($list_elements)) {

                                          foreach ($list_elements as $list_element) {
                                              ?>
                                          
                                              <li class="list-group-item" style=" padding: 10px!important;">
                                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-check-circle me-2 text-success icon-xs"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline>
                                                  </svg>
                                                  <?php _e($list_element) ?> 
                                              </li>
                                          <?php }  } ?>
                                        </ul>
                                    </div>
                                  </div>
                                </div> 
                          <?php }
                        }?>
                  </div>
               </div>  
               <div class="inapp_content" id="home">          
                 <div class="row">
                    <?php
                        $args = array(
                            'post_type' => 'product',
                            'posts_per_page' => -1,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_type',
                                    'field'    => 'slug',
                                    'terms'    => 'subscription',
                                ),
                            ),
                        );
                
                      $subscription_products = new WP_Query($args); 
                      
                      if ($subscription_products->have_posts()) {
                          while ($subscription_products->have_posts()) {

                              $subscription_products->the_post();
                              $subscription_id = get_the_ID();
                              $list_elements =json_decode( get_post_meta($subscription_id, '_list_element', true));
                              $regular_price = get_post_meta($subscription_id, '_regular_price', true);
                              $sale_price = get_post_meta($subscription_id, '_sale_price', true);
                              $billing_period = get_post_meta($subscription_id, '_subscription_period', true);
                              $billing_interval = get_post_meta($subscription_id, '_subscription_period_interval', true);
                              $currency = get_woocommerce_currency_symbol();
                              $status = get_post_status(); 
                              $sale_price = get_post_meta($subscription_id, '_sale_price', true);
                              $statut_abonnement = 0;
                            if($status == 'publish'){
                                $status  = 'publié';
                            }
                          
                            ?>

                                <div class="col mb-4 insapp_pricin_col"  >
                                  <div class="card " style="border-radius: 8px;">
                                  <div class="card-body">
                                    <div class="text-center pt-3" style="min-height: 110px;">
                                        <h2 class="pt-2"><?php echo esc_html(get_the_title()) ?></h2>
                                        <span class="ib_pricing_description"><?php the_content()?></span>
                                        </div>
                                      <div class="ib_pricing__price">

                                        <span class="ib_pricing__price_prefix"><?php _e($currency )?>
                                          
                                        </span>
                                        <span class="ib_pricing__price_val"><?php _e($sale_price )?></span>
                                        <span class="ib_pricing__price_suffix"> <?php _e('/ an') ?></span>

                                        <div class=""> 
                                          <?php
                                    
                                          if($statut_abonnement == 0){?>

                                             <button type="button" data-id="<?php echo $subscription_id ?>" class="btn submit_subcription_btn insapp_payement_abonnement_free" >
                                                <?php _e('Essaie gratuit') ?>
                                              </button>

                                          <?php } else if( $statut_abonnement == 1){ ?>

                                             <button type="button" data-id="<?php echo $subscription_id?>" class="btn submit_subcription_btn insapp_payement_abonnement" >
                                                <?php _e('S\'abonner') ?>
                                              </button> 

                                          <?php }else{ ?>

                                             <button type="button" data-id="<?php echo $subscription_id?>" class="btn submit_subcription_btn insapp_payement_abonnement_off" >
                                                <?php _e('Desabonner') ?>
                                              </button>
 
                                          <?php } ?>
                                                  
                                          </div>
                                      </div>
                                        <ul class="list-group list-group-flush">
                                        
                                          <?php 
                                          if(!empty($list_elements) && !is_wp_error($list_elements)) {

                                          foreach ($list_elements as $list_element) {
                                              ?>
                                          
                                              <li class="list-group-item" style=" padding: 10px!important;">
                                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-check-circle me-2 text-success icon-xs"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline>
                                                  </svg>
                                                  <?php _e($list_element) ?> 
                                              </li>
                                          <?php }  } ?>
                                        </ul>
                                    </div>
                                  </div>
                                </div> 
                          <?php }
                        }?>
                  </div>
               </div> 
           </div>


</div>
