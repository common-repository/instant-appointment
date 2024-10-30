<!-- 
/***********************************************************************
***********            liste abonnement                  **************
*****************************************************************/ -->



<div class="wrap">
    <div class="container-fluid">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="row justify-content-between mb-4">
                        <div class="col-lg-8 col-md-8 col-12">
                            <!-- Page header -->
                            <div class="mb-5">
                                <h3 class="mb-0 ">Abonnement</h3>

                            </div>
                        </div>
                        <?php 
                    $redirect_uri = site_url("/") . "wp-admin/admin.php?page=insapp_subcrption_add";
                       
                    ?>
                        <div class="col-4 col-md-4 d-flex justify-content-end text-end mt-0">
                            <a href="<?php _e($redirect_uri) ?>" id="add" name="add" class="btn btn-primary" type="button">Ajouter un
                               <span> abonnement</span>
                            </a>
                        </div>
                    </div>
                    

                    
                    <table class="table mb-0 text-nowrap table-centered">
                        <thead class="table-light">
                            <tr>
                                <th>Nom </th>
                                <th>Prix Mensuel</th> 
                                <th>periode </th>
                                <th>status</th>
                                <th>action</th>
                            </tr>
                        </thead>
                        <tbody>

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
                
                                    $regular_price = get_post_meta(get_the_ID(), '_regular_price', true);
                                    $billing_period = get_post_meta(get_the_ID(), '_subscription_period', true);
                                    // $billing_interval = get_post_meta(get_the_ID(), '_subscription_period_interval', true);
                                    $currency = get_woocommerce_currency_symbol();
                                    $status = get_post_status(); 
                                    $sale_price = get_post_meta(get_the_ID(), '_sale_price', true);
                                    
                                    if($status == 'publish'){
                                        $status  = 'publié';
                                    }
                                
                                
                            ?>
                            <tr>
                                <td>
                                    <span>
                                        <?php echo esc_html(get_the_title()) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="mb-0 ia_table_text" style=" font-weight: 600;">
                                 
                                        </span><span  class="px-1" style="color: #000;">
                                            <?php _e($regular_price.' '.$currency) ?>
                                        </span> 
                                    </span>
                                </td> 

                                <td>
                                    <span>
                                        <?php _e($billing_period." mois") ?>
                                    </span>
                                </td>

                                <td>
                                    <span>
                                        <?php echo esc_html( $status ) ?>
                                    </span>
                                </td>
                                <td class=" ">
                                    <a href="#!" class=" btn btn_sub_edit btn-icon btn-sm rounded-circle "
                                        data-template="editOne" data-bs-toggle="modal" data-id="<?php echo get_the_ID() ?>"
                                        data-bs-target="#update_subscription">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-edit icon-xs">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>

                                    </a>
                                    <a href="#!" class="btn btn_sub_delete btn-icon btn-sm rounded-circle"
                                        data-template="trashOne" data-id="<?php _e(get_the_id()) ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-trash-2 icon-xs">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path
                                                d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                            </path>
                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                        </svg>

                                    </a>
                                </td>
                            </tr>
                            <?php } } ?>

                        </tbody>
                    </table>
                    <div class="modal fade" id="update_subscription" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-12">
                                                <!-- Page header -->
                                                <div class="my-1">
                                                    <h3 class="mt-5">
                                                        <?php _e('Modifier l\'abonement','instant_Appointement') ?>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <form action="" class="insapp_update_subscription">
                                            <div class="row">
                                                <div class=" col-12">
                                                    <!-- card -->
                                                    <div class="card mb-1">
                                                        <!-- card body -->
                                                        <div class="card-body">
                                                            <div class="mb-5 col-lg-12 col-12 ">
                                                                <label for="update_subscription_name"
                                                                    class="form-label">
                                                                    <?php _e("Nom","instant_Appointement") ?>
                                                                </label>
                                                                <input type="text" id="update_subscription_name" class="form-control" placeholder="<?php _e(" Entrez le nom de l'abonnement","instant_Appointement") ?>"
                                                                required />
                                                            </div>
                                                            <div class="mb-1 col-lg-12 col-12">
                                                                <label for="update_subscription_description"
                                                                    class="form-label">
                                                                    <?php _e("Description","instant_Appointement") ?>
                                                                </label>
                                                                <textarea class="form-control"
                                                                    id="update_subscription_description"
                                                                    rows="3"></textarea>

                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="card mb-1">
                                                                <!-- card body -->
                                                                <div class="card-body row">
                                                                    <!-- input -->
                                                                    <div class="mb-3 col-md-6">
                                                                        <label class="form-label">
                                                                            <?php _e('Prix Mensuel','instant_Appointement') ?>
                                                                        </label>
                                                                        <input type="text" class="form-control" id="sub_update_price_mensuel"
                                                                            placeholder="50.00 <?php echo get_woocommerce_currency_symbol() ;?>" required />
                                                                    </div>
                                                                    <!-- input -->
                                                                    <div class="mb-3 col-md-6">
                                                                        <label class="form-label">
                                                                            <?php _e('Prix Mensuel Promotionnel','instant_Appointement') ?>
                                                                        </label>
                                                                        <input type="text" class="form-control" id="sub_update_price_mensuel_promo"
                                                                            placeholder="45.00 <?php echo get_woocommerce_currency_symbol() ;?>" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class=" col-12">
                                                            <div class="card mb-4">
                                                                <!-- card body -->
                                                                <div class="card-body row">
                                                                    <div class="mb-3 col-md-6">
                                                                           <label class="form-label">Periode de
                                                                                facturation</label> 
                                                                        <select class="form-select" id="sub_update_duration"
                                                                            aria-label="Default select example"
                                                                            required>
                                                                            <option value="1" selected="">Pour un mois
                                                                            </option>
                                                                            <option value="3">Pour 3 mois</option>
                                                                            <option value="6">Pour 6 mois</option>
                                                                            <option value="12"> Pour un an</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3 col-md-6"> 
                                                                            <label class="form-label">Status</label> 
                                                                        <select class="form-select" id="sub_update_status"
                                                                            aria-label="Default select example">
                                                                            <option selected="">Activé</option>
                                                                            <option value="1">Desactivé</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class=" col-12">
                                                            <div class="card ">
                                                                <div class="card-body">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Liste d'element
                                                                        </label>
                                                                        <input name='inspp_list_sub_mod' value=''> 
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <input type="hidden" name="subscription_id" id="subscription_id" value="">
                                        </form>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermé</button>
                                    <button type="submit" class="btn btn-primary insapp_update_subcription_btn" style="padding: 10px 40px;">
                                        <?php _e('Enregistré')?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>