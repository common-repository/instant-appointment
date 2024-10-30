<?php


add_action( 'widgets_init', 'insapp_register_account_menu' );

function insapp_register_account_menu() {
    register_widget( 'insapp_account_menu_widget' );
}
class insapp_account_menu_widget extends WP_Widget {
  function __construct() {
        parent::__construct(
            'insapp_account_menu',
            esc_html__( 'Instant Appointment Account'),
            array( 'description' => esc_html__( "Affiche un menu personnel pour l'utilisateur connecte"), )
        );
}

public function widget( $args, $instance ) {
        echo $args['before_widget'];

        if(is_user_logged_in(  )){
           ?><div class="dropdown">
                <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php _e('Mon compte')?>
                </a>
                <?php
                    $dashboard_page = get_option('insapp_settings_name')['Dashboard_page'];
                    $services_page = get_option('insapp_settings_name')['Dashboard_page']; 
                    $resa_page = get_option('insapp_settings_name')['Dashboard_page']; 
                    $profil_page = get_option('insapp_settings_name')['Dashboard_page']; 
                ?>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li><a class="dropdown-item"  href="<?php if( $dashboard_page ) {echo esc_url(get_permalink(get_option('insapp_settings_name')['Dashboard_page']));} ?>" role="button" >
                            <i class="sl sl-icon-user"></i><?php esc_html_e('Tableaude bord');?>
                        </a></li>
                    <li><a class="dropdown-item"  href="<?php if( $services_page ) {echo esc_url(get_permalink($services_page));} ?>" role="button" >
                            <i class="sl sl-icon-user"></i><?php esc_html_e('Mes services');?>
                        </a></li>
                    <li><a class="dropdown-item"  href="<?php if( $resa_page ) {echo esc_url(get_permalink($resa_page));} ?>" role="button" >
                            <i class="sl sl-icon-user"></i><?php esc_html_e('Mes reservations');?>
                        </a></li>
                    <li><a class="dropdown-item"  href="<?php if( $profil_page ) {echo esc_url(get_permalink($profil_page));} ?>" role="button" >
                            <i class="sl sl-icon-user"></i><?php esc_html_e('Profil');?>
                        </a></li>
                    <li><a class="dropdown-item"  href="<?php echo wp_logout_url( get_permalink() ); ?>" role="button" >
                            <i class="sl sl-icon-user"></i><?php esc_html_e('Deconnexion');?>
                        </a></li>
                </ul>
            </div>
            <?php
        }else{
            $auth_page = get_option('insapp_settings_name')['Login_page']; 
 
            if( $auth_page ) {
                 ?><div class="dropdown">
                                 <a class="btn btn-primary"  href="<?php echo esc_url(get_permalink($auth_page)); ?>" role="button" >
                                     <i class="sl sl-icon-user"></i><?php esc_html_e('Authentification');?>
                                 </a>
                     </div>
                     <?php
            }
        }
        
        echo $args['after_widget'];
}
// public function form($instance){

//     $current_user = wp_get_current_user();
//     $roles = $current_user->roles;
//     $role = array_shift( $roles );
// }
}



?>
