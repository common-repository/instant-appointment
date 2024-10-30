<?php

$current_user = wp_get_current_user();
$roles = $current_user->roles;
$role = array_shift( $roles );  
$user_info = get_userdata($current_user->ID);
$user_img = $user_info->user_url;
$user_state = get_user_meta( $current_user->ID, '_state' , true );
 
$first_name = $user_info->first_name;
$last_name = $user_info->last_name; 
$user_mail = $user_info->user_email; 
$user_phone = get_user_meta( $current_user->ID, 'telephone' , true );
$user_adresse = get_user_meta( $current_user->ID, 'adresse' , true );
$user_description = get_user_meta( $current_user->ID, '_description' , true );
$user_profil_category = get_user_meta( $current_user->ID, 'category' , true );

$starthour = get_user_meta( $current_user->ID, 'starthour_default' , true );
$endhour = get_user_meta( $current_user->ID, 'endhour_default' , true );
$starthour2 = get_user_meta( $current_user->ID, 'starthour_default2' , true );
$endhour2 = get_user_meta( $current_user->ID, 'endhour_default2' , true );
$agenda = json_decode(get_user_meta( $current_user->ID, 'agenda_default' , true )) == NULL ? [] : json_decode(get_user_meta( $current_user->ID, 'agenda_default' , true ));

if(!in_array($role,array('administrator','insapp_photographe','insapp_customers'))) :
    $template_loader = new Insapp_Template_Loader; 
    $template_loader->get_template_part( 'account/login'); 
    return;
endif;


global $wpdb;
$sql =  "SELECT * FROM insapp_notification ORDER BY create_date DESC LIMIT 3";
$result = $wpdb->get_results($sql );

$agenda_page = get_option('insapp_settings_name')['Agenda_page']; 
$chat_page = get_option('insapp_settings_name')['Chat_page']; 

$subs = array();
$overs = array();
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
        $sub_id = get_the_ID(); 
        $abonnement =  apply_filters('filter_stripe_connect_gateway_order_status', $sub_id, $current_user->ID);  
        $period_over = insapp_is_trial_period_over($sub_id, $current_user->ID);
       
        array_push( $subs, $abonnement["status"]);
         array_push( $overs, $period_over);
    }
}

                    
?>


<div class="insapp_dashboard_wrap">
<input type="hidden" class="insapp_user" value="<?php esc_attr_e($current_user->ID) ?>">
                         
    <div class="insapp_dashboard_sidebar">
        <div id="insapp_navigation"></div>
        <div class="insapp-simplebar-content justify-content-center">
           
            <ul class="navbar-nav flex-column" id="sideNavbar">

                 
                <li class="nav-item ins_dashbord_menu" id="tab1" data-tab="1">
                    <a class="nav-link has-arrow ins_active" href="javascript:void(0)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-home nav-icon me-2   ia_icon-xxs">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        <span> <?php _e('Tableau de bord','instant_Appointement') ?> </span> 
                    </a>
                </li>
                  
                <?php if($user_state != 'inactive'){ ?>
                   

                        <li class="nav-item">
                            <div class="ia-navbar-heading">
                                <?php _e('Principal');?>
                            </div>
                        </li>
                         <?php
                           if (in_array('trialing', $subs) || in_array('active', $subs) || in_array( false, $overs) ) { 
                               
                             if(in_array($role,array('administrator','insapp_photographe'))){ ?>
                                <li class="nav-item ins_dashbord_menu" id="tab5" data-tab="5">
                                    <a class="nav-link has-arrow collapsed " href="#!" data-bs-toggle="collapse"
                                        data-bs-target="#navinvoice" aria-expanded="false" aria-controls="navinvoice">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-clipboard nav-icon me-2   ia_icon-xxs">
                                            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                            <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                                        </svg>
                                        <span> <?php _e('Réservations client')?> </span> 
                                    </a>
    
                                </li>
                                <li class="nav-item ins_dashbord_menu" id="tab6" data-tab="6">
                                    <a class="nav-link has-arrow collapsed " href="" data-bs-toggle="collapse"
                                        data-bs-target="#navecommerce" aria-expanded="false" aria-controls="navecommerce">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512" class="feather feather-shopping-cart nav-icon me-2 ia_icon-xxs">
                                            <path fill="#fff" d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/></svg>
                                                            
                                        <span> <?php _e('Ajouter une offre')?> </span> 
                                    </a>
    
                                </li> 
                                 <li class="nav-item ins_dashbord_menu d-none" id="tab10" data-tab="10">
                                    <a class="nav-link has-arrow collapsed " href="" data-bs-toggle="collapse"
                                        data-bs-target="#navecommerce" aria-expanded="false" aria-controls="navecommerce">                     
                                        <span> <?php _e('Update une offre')?> </span> 
                                    </a>
    
                                </li> 
                                <li class="nav-item ins_dashbord_menu" id="tab8" data-tab="8">
                                    <a class="nav-link has-arrow collapsed " href="" data-bs-toggle="collapse"
                                        data-bs-target="#navecommerce" aria-expanded="false" aria-controls="navecommerce">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-shopping-cart nav-icon me-2 ia_icon-xxs">
                                            <circle cx="9" cy="21" r="1"></circle>
                                            <circle cx="20" cy="21" r="1"></circle>
                                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                        </svg>
                                        <span> <?php _e('Mes offres')?> </span> 
                                    </a>
    
                                </li>
                        <?php } 
                            } ?>

                        <li class="nav-item ins_dashbord_menu" id="tab12" data-tab="12">
                            <a class="nav-link has-arrow collapsed " href="" data-bs-toggle="collapse"
                                data-bs-target="#navecommerce" aria-expanded="false" aria-controls="navecommerce">

                                <svg xmlns="http://www.w3.org/2000/svg" stroke="#fff" viewBox="0 0 512 512" style="fill:#fff;" class="feather feather-calendar nav-icon me-2 ia_icon-xxs">
                                    <path d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8v-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5v3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20c0 0-.1-.1-.1-.1c0 0 0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5v3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2v-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z"/>
                                    </svg>
                                <span> <?php _e('Mes Favoris')?> </span> 
                            </a>

                        </li>
                    
                        <li class="nav-item ins_dashbord_menu" id="tab2" data-tab="2">
                        <a class="nav-link has-arrow " href="javascript:void(0)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-calendar nav-icon me-2   ia_icon-xxs">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                                <!-- <?php if(in_array($role,array('administrator','insapp_photographe'))){ ?>
                                    <?php }else{?>
                                    <?php _e('Mes réservations');?>
                                <?php   } ?>
                                -->
                                <span>  <?php _e('Mes réservations');?> </span> 
                            </a>
                        </li>
                        
                        <li class="nav-item"> 
                            <a class="nav-link has-arrow " href="<?php if( $chat_page ) {echo esc_url(get_permalink(get_option('insapp_settings_name')['Chat_page']));} ?>">
                        
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-message-square nav-icon me-2   ia_icon-xxs">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                </svg>
                                <span>    <?php _e('Messages');?> </span> 
                            </a>
                        </li>
                        <li class="nav-item ins_dashbord_menu" id="tab4" data-tab="4">
                            <a class="nav-link has-arrow " href="javascript:void(0)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-pie-chart nav-icon me-2   ia_icon-xxs">
                                    <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                                    <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                                </svg>
                                <span>  <?php _e('Paiements');?> </span> 
                            </a>
                        </li>

               

                        <li class="nav-item">
                            <div class="ia-navbar-heading">
                                <?php _e('Compte')?>
                            </div>
                        </li>
                        
                        <?php if(in_array($role,array('administrator','insapp_photographe'))){ ?>
                            
                        <li class="nav-item ">
                            <a class="nav-link has-arrow " href="<?php if( $agenda_page ) {echo esc_url(get_permalink(get_option('insapp_settings_name')['Agenda_page']));} ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar nav-icon me-2   ia_icon-xxs"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                               <span> <?php _e('Agenda');?> </span>
                            </a>
                        </li> 
                        <li class="nav-item ins_dashbord_menu" id="tab11" data-tab="11">
                            <a class="nav-link has-arrow " href="javascript:void(0)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-package nav-icon me-2   ia_icon-xxs"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                            <span>   <?php
                                    _e('Abonnements');
                                ?> </span> 
                            </a>
                        </li>
                        <?php }  } ?>
                <li class="nav-item ins_dashbord_menu" id="tab7" data-tab="7">
                    <a class="nav-link has-arrow " href="javascript:void(0)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-user nav-icon me-2   ia_icon-xxs">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <span> 
                        <?php _e('Profil')?> </span> 
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link has-arrow " href="<?php echo wp_logout_url( get_permalink() ); ?>">
                      <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512" class="feather feather-shopping-cart nav-icon me-2 ia_icon-xxs">
                        <path fill="#fff" d="M497 273L329 441c-15 15-41 4.5-41-17v-96H152c-13.3 0-24-10.7-24-24v-96c0-13.3 10.7-24 24-24h136V88c0-21.4 25.9-32 41-17l168 168c9.3 9.4 9.3 24.6 0 34zM192 436v-40c0-6.6-5.4-12-12-12H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h84c6.6 0 12-5.4 12-12V76c0-6.6-5.4-12-12-12H96c-53 0-96 43-96 96v192c0 53 43 96 96 96h84c6.6 0 12-5.4 12-12z"/></svg>
                                     
                       <span>  <?php _e('Déconnexion')?></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="insapp_dashboard_content">

        <div class="insappp_content_page">

            <main class="insapp_content_main">

                <div class="insapp_content_dashbord" id="insapp_tab1">
                       <?php
                            $insapp_templates = new Insapp_Template_Loader;
                            $insapp_templates->get_template_part( 'dashboard/index' );
                        ?>
                </div>
                <div class="insapp_content_dashbord" id="insapp_tab2">
                    <?php
                            $insapp_templates = new Insapp_Template_Loader;
                            $insapp_templates->get_template_part( 'dashboard/my_booking' );
                        ?>
                </div>
                <div class="insapp_content_dashbord" id="insapp_tab3">
                    <?php
                            // $insapp_templates = new Insapp_Template_Loader;
                            // $insapp_templates->get_template_part( 'dashboard/chat_v2' );
                        ?>
                </div>
                <div class="insapp_content_dashbord" id="insapp_tab4">
                    <?php
                            $insapp_templates = new Insapp_Template_Loader;
                            $insapp_templates->get_template_part( 'dashboard/payment' );
                        ?>
                </div>
                <div class="insapp_content_dashbord" id="insapp_tab5">
                    <?php
                            $insapp_templates = new Insapp_Template_Loader;
                            $insapp_templates->get_template_part( 'dashboard/booking' );
                        ?>
                </div>
                <div class="insapp_content_dashbord" id="insapp_tab6">
                    <?php
                            $insapp_templates = new Insapp_Template_Loader;
                            $insapp_templates->get_template_part( 'dashboard/services' );
                        ?>
                </div>
                <div class="insapp_content_dashbord" id="insapp_tab7">
                    <?php
                            $insapp_templates = new Insapp_Template_Loader;
                            $insapp_templates->get_template_part( 'dashboard/profil' );
                        ?>
                </div>
                <div class="insapp_content_dashbord" id="insapp_tab8">
                    <?php
                            $insapp_templates = new Insapp_Template_Loader;
                            $insapp_templates->get_template_part( 'dashboard/liste_service' );
                        ?>
                </div>
                <div class="insapp_content_dashbord" id="insapp_tab12">
                    <?php
                            $insapp_templates = new Insapp_Template_Loader;
                            $insapp_templates->get_template_part( 'dashboard/list_favoris' );
                        ?>
                </div>
                <div class="insapp_content_dashbord" id="insapp_tab9">
                     <?php
                    //         $insapp_templates = new Insapp_Template_Loader;
                    //         $insapp_templates->get_template_part( 'dashboard/agenda_v2' );
                        ?>
                </div>
                <div class="insapp_content_dashbord" id="insapp_tab10">
                    <?php
                            $insapp_templates = new Insapp_Template_Loader;
                            $insapp_templates->get_template_part( 'dashboard/update_service' );
                        ?>
                </div> 
                <div class="insapp_content_dashbord" id="insapp_tab11">
                    <?php
                            $insapp_templates = new Insapp_Template_Loader;
                            $insapp_templates->get_template_part( 'dashboard/pricing' );
                        ?>
                </div>


            </main>               
            <!--<div class="ia_calendar_block" id="insapp-calendar-agenda" ></div>-->
        </div>
    </div>

</div>

<?php
$page_id_to_disable_comments = get_the_id(); 
disable_comments_on_specific_page($page_id_to_disable_comments);
?> 