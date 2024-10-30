<?php

/**
 * Plugin Name:       Instant Appointment
 * Plugin URI:        https://outstrip.tech/
 * Description:       Plugin Multivendeur pour Services.Il permet de transformez votre site WordPress en une Marketplace Dynamique de Services
 * Version:           1.2
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            outstrip
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       instant-appointment
 * Domain Path:       /lang
 */

define( 'TLPLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'TLPLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'TLPLUGIN_DEFAULT', plugin_dir_url( __FILE__ ). 'assets/images' );



require_once TLPLUGIN_DIR . 'class-instant_appointment.php';
require_once('dompdf/autoload.inc.php');

use Dompdf\Dompdf;
use Dompdf\Options; 

/**
 * Activate the plugin.
 */
function pluginprefix_activate() { 
  include(TLPLUGIN_DIR . 'includes/insapp_tables.php');
  insapp_my_custom_page();
  insapp_file_replace();
}
register_activation_hook( __FILE__, 'pluginprefix_activate' );


function insapp_file_replace() {

  $plugin_dir = plugin_dir_path( __FILE__ ) . 'templates/front-end/insapp_chat.php';
  $theme_dir = get_stylesheet_directory() . '/page-insapp_chat.php';
  // $plugin_dir = str_replace('\\', '/', $plugin_dir);
  // $theme_dir = str_replace('\\', '/', $theme_dir);

  if (!copy($plugin_dir, $theme_dir)) {
      echo "failed to copy $plugin_dir to $theme_dir...\n";
  }
}
/**
 * Deactivation hook.
 */
function pluginprefix_deactivate() { 
 
}
register_deactivation_hook( __FILE__, 'pluginprefix_deactivate' );

//add admin menu
include(TLPLUGIN_DIR . 'includes/insapp_menus.php' );

//add style
include(TLPLUGIN_DIR . 'includes/enqueue_style.php' );

//add script
include(TLPLUGIN_DIR . 'includes/enqueue_script.php' );

include(TLPLUGIN_DIR . 'includes/insapp_insert.php');
include(TLPLUGIN_DIR . 'includes/annonce/cpt.php');
include(TLPLUGIN_DIR . 'includes/ajax/ajax_users.php' );

include(TLPLUGIN_DIR . 'includes/ajax/ajax_customer.php' );

include(TLPLUGIN_DIR . 'includes/ajax/ajax_resa_service.php' );

include(TLPLUGIN_DIR . 'includes/ajax/ajax_rdv.php' );
include(TLPLUGIN_DIR . 'includes/ajax/ajax_services.php' );
include(TLPLUGIN_DIR . 'includes/front-end/ajax/login_ajax.php' );
include(TLPLUGIN_DIR . 'includes/front-end/ajax/reservation_ajax.php' );
include(TLPLUGIN_DIR . 'includes/front-end/ajax/agenda_ajax.php' );
include(TLPLUGIN_DIR . 'includes/front-end/ajax/templates_ajax.php' );




include(TLPLUGIN_DIR . 'includes/users/users_roles.php');

include_once(TLPLUGIN_DIR . 'includes/pages/insapp_short_code.php'); 




include_once(TLPLUGIN_DIR . 'includes/widget/menu.php'); 
include_once(TLPLUGIN_DIR . 'includes/mail/ia_mail.php'); 
include_once(TLPLUGIN_DIR . 'includes/mail/email_template.php'); 

include_once(TLPLUGIN_DIR . 'includes/settings/general-settings.php');

include_once(TLPLUGIN_DIR . 'includes/front-end/short-code.php');

// include_once(TLPLUGIN_DIR . 'includes/woocommerce.php');

if ( ! class_exists( 'Gamajo_Template_Loader' ) ) {
    require_once TLPLUGIN_DIR . 'class-gamajo-template-loader.php';
}
include_once(TLPLUGIN_DIR . 'class-insapp-template-loader.php');

function insapp_page($post_title,$post_name,$post_content,$parent_id =NULL){
   $existing_page  = get_page_by_title($post_title);
  
      if ($existing_page != NULL) {
           return ;
      }
      $my_pages = wp_insert_post(
          array(
              'post_title'    => $post_title,
              'post_status'   => 'publish',
              'post_author'   => get_the_author(),
              'post_type'     => 'page',
              'post_name'      => $post_name,
              'post_content'   => $post_content,
              'comment_status' => 'closed',
              'post_parent'    =>  $parent_id,
              'meta_input' => array(
                '_plugin_association' => 'instant booking',
              ),
            )
      );
      return $my_pages;
}
function insapp_my_custom_page() {

    // Create post object
    insapp_page('account','account','[insapp_authentification]');
    insapp_page('dashboard','dashboard','[insapp_dashboard_render]');
    insapp_page('Chat','Chat','[insapp_chat_render]');
    insapp_page('Agenda','Agenda','[insapp_agenda_render]');
    insapp_page('services','services','[insapp_services]');  
    insapp_page('Linting Profil','listing-profil','[insapp_list_vendor]');  


}


// add_action('woocommerce_before_single_product', 'insappp_call_single_services');

// function insappp_call_single_services() {
//   include_once(TLPLUGIN_DIR . 'templates/front-end/services/single-product.php');
// }
function insapp_custom_logout_redirect() {
    wp_redirect( home_url() ); // Redirige vers la page d'accueil
    exit();
}
add_action( 'wp_logout', 'insapp_custom_logout_redirect' );

add_action( 'wp', 'woo_hide_product_gallery' );
function woo_hide_product_gallery() {

  // if ( is_product() ) { 

    // remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
    // remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
    // remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
    // remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
    // remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
    // remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
    // remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
    // remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
    // remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );

  // }

}	

function register_delete_order_status() {
   register_post_status( 'wc-delete', array(
       'label'                     => 'Delete',
       'public'                    => true,
       'show_in_admin_status_list' => true,
       'show_in_admin_all_list'    => true,
       'exclude_from_search'       => false,
       'label_count'               => _n_noop( 'Delete <span class="count">(%s)</span>', 'Delete <span class="count">(%s)</span>' )
   ) );
}
add_action( 'init', 'register_delete_order_status' );

// Disable the order notification emails
function insapp_disable_order_emails( $enabled, $order ) {
  return false;
}
add_filter( 'woocommerce_email_enabled_new_order', 'insapp_disable_order_emails', 10, 2 );
add_filter( 'woocommerce_email_enabled_customer_processing_order', 'insapp_disable_order_emails', 10, 2 );
add_filter( 'woocommerce_email_enabled_customer_completed_order', 'insapp_disable_order_emails', 10, 2 );
add_filter( 'woocommerce_email_enabled_customer_on_hold_order', 'insapp_disable_order_emails', 10, 2 );
add_filter( 'woocommerce_email_enabled_customer_refunded_order', 'insapp_disable_order_emails', 10, 2 );
add_filter( 'woocommerce_email_enabled_customer_partially_refunded_order', 'insapp_disable_order_emails', 10, 2 );
add_filter( 'woocommerce_email_enabled_customer_note', 'insapp_disable_order_emails', 10, 2 );

// Disable the order status change notification emails
function insapp_disable_order_status_change_emails( $enabled, $order ) {
  return false;
}
add_filter( 'woocommerce_email_enabled_customer_processing_order_status', 'insapp_disable_order_status_change_emails', 10, 2 );
add_filter( 'woocommerce_email_enabled_customer_completed_order_status', 'insapp_disable_order_status_change_emails', 10, 2 );
add_filter( 'woocommerce_email_enabled_customer_on_hold_order_status', 'insapp_disable_order_status_change_emails', 10, 2 );
add_filter( 'woocommerce_email_enabled_customer_refunded_order_status', 'insapp_disable_order_status_change_emails', 10, 2 );
add_filter( 'woocommerce_email_enabled_customer_partially_refunded_order_status', 'insapp_disable_order_status_change_emails', 10, 2 );




// Définissez la fonction qui ajoute le lien de réglages
function insapp_add_settings_link($links) {
  $settings_link = '<a href="' . admin_url('admin.php?page=insapp_param') . '">Réglages</a>';
  array_push($links, $settings_link);
  return $links;
} 

// Utilisez le filtre pour ajouter le lien aux actions de votre plugin
add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'insapp_add_settings_link');


// function insapp_move_product_tabs() {
//   remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10); 
  
//   remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
// }
// add_action('init', 'insapp_move_product_tabs');
  
add_filter( 'wc_order_statuses', 'insapp_delete_order_status');
function insapp_delete_order_status( $order_statuses ) {
    $order_statuses['wc-delete'] = _x( 'Delete', 'Order status', 'woocommerce' ); 
    return $order_statuses;
}


function create_routes( $router ) {
  $router->add_route('facebook-login', array(
      'path' => 'masssaord',
      'access_callback' => true,
      'page_callback' => 'lost_password_callback'
  )); 
  $router->add_route('error', array(
      'path' => 'error',
      'access_callback' => true,
      'page_callback' => 'error'
  ));
}
add_action( 'wp_router_generate_routes', 'create_routes' );
function lost_password_callback() {
  $insapp_templates = new Insapp_Template_Loader;
  $insapp_templates->get_template_part( 'account/lost_password' );	
  exit();
} 
 
add_action('init', 'insapp_init_widget_elementor');
function insapp_init_widget_elementor() {
 
    // Check if Elementor installed and activated
    if ( ! did_action( 'elementor/loaded' ) ) {
    //   add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
      return;
    }
    include_once(TLPLUGIN_DIR . 'includes/widget/menu_elementor.php');
}

add_action( 'init', 'insapp_register_subscription_product_type' );
 
function insapp_register_subscription_product_type() {
 
  class WC_Product_subscription extends WC_Product {
			
    public function __construct( $product ) {
        $this->product_type = 'subscription';
        parent::__construct( $product );
    }
  }
}

 
add_filter( 'product_type_selector', 'insapp_add_subscription_product_type' );
 
function insapp_add_subscription_product_type( $types ){
    $types[ 'subscription' ] = __( 'Subscription');
 
    return $types;	
}

 
function wcs_hide_attributes_data_panel( $tabs) {

    // Other default values for 'attribute' are; general, inventory, shipping, linked_product, variations, advanced
    $tabs['general']['class'][] = 'show_if_subscription';
    $tabs['attribute']['class'][] = 'hide_if_subscription';
    $tabs['shipping']['class'][] = 'hide_if_subscription';
    $tabs['inventory']['class'][] = 'show_if_subscription';

    return $tabs;

}
 
function subscription_custom_js() {
  if ( 'product' != get_post_type() ) :
      return;
  endif;
  ?><script type='text/javascript'>
  jQuery( document ).ready( function() {
  jQuery( '.options_group.pricing' ).addClass( 'show_if_subscription' ).show();
  jQuery( '.general_options' ).show();
      });
  </script><?php
}
add_action( 'admin_footer', 'subscription_custom_js' );

add_filter( 'woocommerce_product_data_tabs', 'subscription_product_tab' );
function subscription_product_tab( $tabs) {
 
$tabs['subscription'] = array(
'label' => __( 'My Subscription Tab', 'dm_product' ),
'target' => 'subscription_product_options',
'class' => 'show_if_subscription_product',
);
return $tabs;
}
 
add_action( 'woocommerce_product_data_panels', 'QL_custom_product_options_product_tab_content' );
 
function QL_custom_product_options_product_tab_content() {
// Dont forget to change the id in the div with your target of your product tab
?><div id='subscription_product_options' class='panel woocommerce_options_panel'><?php
?><div class='options_group'><?php
 
  woocommerce_wp_checkbox( 
    array(
    'id' => '_enable_custom_product',
    'label' => __( 'Enable Subscription'),
    ) );
 
  woocommerce_wp_text_input(
    array(
    'id' => 'subscription_product_info',
    'label' => __( 'Enter Subscription Details', 'dm_product' ),
    'placeholder' => '',
    'desc_tip' => 'true',
    'description' => __( 'Enter subscription details.', 'dm_product' ),
    'type' => 'text'
    )
  );
  ?></div>
</div><?php
}
add_action( 'woocommerce_process_product_meta', 'save_subscription_product_settings' );
 
function save_subscription_product_settings( $post_id ){
 
	//save checkbox infomation
	$engrave_text_option = isset( $_POST['_enable_custom_product'] ) ? 'yes' : 'no';
   update_post_meta($post_id, '_enable_custom_product', esc_attr( $engrave_text_option ));
 
	// save text field information
  $subscription_product_info = $_POST['subscription_product_info1'];
 
  if( !empty( $subscription_product_info ) ) {
    update_post_meta( $post_id, 'subscription_product_info1', esc_attr( $subscription_product_info ) );
  }
}add_action( 'woocommerce_single_product_summary', 'subscription_product_front' );
 
  function subscription_product_front () {
    global $product;
    if ( 'subscription' == $product->get_type() ) { 
      echo "<strong>Subscription Type: </strong>".( get_post_meta( $product->get_id(), 'subscription_product_info' )[0] );
    }
  
  }
  // Fonction pour envoyer la facture par e-mail lorsqu'une nouvelle commande est créée
function insapp_envoyer_facture_apres_initialisation_paiement($order_id) {
  $order = wc_get_order($order_id);
 
  $customer = wp_get_current_user();
  $to = $customer->user_email;
  $subject = 'facture de réception de votre réservation';
  $headers = array('Content-Type: text/html; charset=UTF-8','From: tentee <'.$customer->user_email.'>','Cc: ReceiverName <second email>' );
  $body = insapp_mail_template_book($order_id);  
  // $pieces_jointes = insapp_facturepdf($order_id);
  wp_mail( $to, $subject, $body, $headers);
  // unlink($pieces_jointes);
}
add_action('woocommerce_new_order', 'insapp_envoyer_facture_apres_initialisation_paiement');

add_action( "woocommerce_subscription_add_to_cart", function() {
  do_action( 'woocommerce_simple_add_to_cart' );
});

add_action( 'woocommerce_order_status_processing', 'insapp_ajouter_meta_abonnement' );
function insapp_ajouter_meta_abonnement($order_id)
{
  $order = wc_get_order($order_id);

    $items = $order->get_items();
  foreach ($items as $item) {
      $product = $item->get_product();
       
      if ($product->is_type('subscription')) {
        $meta_key = '_order_subscription';
        $meta_value = 'is_subscription';
        $order->update_meta_data($meta_key, $meta_value);
        $order->save();
        break;  
      }
  }
}
 
 add_post_type_support('annonce', 'comments');



function insapp_facturepdf($order_id){ 
  
  $order = wc_get_order($order_id ); 
  $order_data = $order->data;
  $customer = $order->get_user();
  $total = $order->get_total();
 

  $customer_name = $customer->display_name;
  $customer_email = $customer->user_email;
  $order_number = $order->get_order_number();
  $date_paid = $order->get_date_paid()->date('d/m/Y');
  $date = get_post_meta( $order_id, '_booking_date', true );
  $time = get_post_meta( $order_id, '_booking_time', true );
  $bd_extras = get_post_meta( $order_id, '_booking_extra', true ); 
  $selected_extras = (isset($bd_extras) && $bd_extras != null) ? json_decode($bd_extras) : [];
  $items = $order->items; 
  $custom_logo_id = get_theme_mod( 'custom_logo' );
                    $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
  foreach( $order->get_items() as $item_id => $item ) {
    $product_name = $item->get_name();
    $product_price =  $item->get_total();
    
}
  
ob_start();
 
require TLPLUGIN_DIR. 'templates/invoice.php';
$html = ob_get_contents();
ob_end_clean(); 


$options = new Options();
$options->set('defaultFont', 'Courier');

$dompdf = new Dompdf($options); 
$dompdf->loadHtml($html, 'UTF-8');
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$output = $dompdf->output();
// $pdfOutput = 'facture'.uniqid(rand(), true).'.pdf';
// file_put_contents( $pdfOutput, $output);

 return $output;
}

/**
 * ia_single_template
 *
 * allows to redirect the display of an post type to a page configured in 'single_template'.
 * @param  mixed $template
 * @return void
 */
 
 add_filter( 'single_template', 'ia_single_annonces_template' );
 function ia_single_annonces_template( $single_template ){
     global $post;
     if('annonce' === $post->post_type){
     $file = dirname(__FILE__) .'/templates/pages/single-annonce.php';
 
       $single_template = $file;
     }
     return $single_template;
 }


 // create a template for photographe profil
function insapp_custom_user_profile_template($template) {
 
          if (is_author()) {
            $template = plugin_dir_path( __FILE__ ) . 'templates/pages/user-profile.php';
                return $template;
          
        }
        return $template;
}
add_filter('template_include', 'insapp_custom_user_profile_template');

// create a template for archive annonces
function insapp_render_search_filter_template( $template ) {
  global $wp_query;
  $post_type = get_query_var( 'post_type' );

  if ( ! empty( $wp_query->is_search ) && $post_type == 'annonce') { 
     return  plugin_dir_path( __FILE__ ) . 'templates/pages/listing-search.php';
  }
  
  return $template;
}
add_filter( 'template_include', 'insapp_render_search_filter_template' );


 add_filter( 'archive_template', 'ia_get_archives_annonces_template' );
function ia_get_archives_annonces_template( $archive_template ) {
  $post_type = get_query_var( 'post_type' );
         
     if ( is_post_type_archive ( 'annonce' ) ) {
          $archive_template = dirname( __FILE__ ) . '/templates/pages/annonce-template.php';
     }
       
     return $archive_template;
    
}

function insapp_archive_category_template($template) {
    if (is_tax('product_cat')) {
        $new_template = dirname(__FILE__) . '/templates/pages/filter-category.php';
        if (file_exists($new_template)) {
            return $new_template;
        }
    }
    return $template;
}
add_filter('template_include', 'insapp_archive_category_template', 99);

function disable_comments_on_specific_page($page_id) {

    if (!$page_id || !is_numeric($page_id)) {
        return;
    }

    $page = get_post($page_id);

    if ($page) {
        $updated_page = array(
            'ID' => $page_id,
            'comment_status' => 'closed',
        );

        wp_update_post($updated_page);
    }
}

function insapp_mailsend_after_paiement($order_id) {
    $order = wc_get_order($order_id); 
      foreach ( $items as $item ) { 
        $product_id = $item['product_id']; 
      } 
      $product = get_post($product_id);   
        
          $to = $order->get_billing_email();
          $subject = 'Confirmation de reception de paiement';
          $headers = array('Content-Type: text/html; charset=UTF-8','From: '.$admin_company.' <'.$admin_mail.'>');
          $body = insapp_mail_template_paiement($order_id); 
          wp_mail($to, $subject, $body, $headers);
           
           $to=get_user_by('ID',$product->post_author)->user_email;
          $subject = ' Notification de versement effectué par un utilisateur';
          $headers = array('Content-Type: text/html; charset=UTF-8','From: '.$admin_company.' <'.$admin_mail.'>');
          $body = insapp_mail_template_paiement_vendor($order_id); 
            wp_mail($to, $subject, $body, $headers);
          
}
add_action('woocommerce_order_status_processing', 'insapp_mailsend_after_paiement');