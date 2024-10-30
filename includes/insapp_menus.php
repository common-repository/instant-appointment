<?php

add_action( 'admin_menu', 'insapp_Add_My_Admin_Link' );
function insapp_Add_My_Admin_Link()
{
    add_menu_page(
        'Bienvenu(e) sur Instant Appointment ', // Title of the page
        'Instant Appointment ', // Text to show on the menu link
        'manage_options', // Capability requirement to see the link
        'insapp_main_menu', // The 'slug' - file to display when clicking the link
        'insapp_main_menu',
        'dashicons-store',
        6
    );
    // add_submenu_page('insapp_main_menu','Dashboard','dashboard','manage_options','insapp_dashbord','insapp_dashboard');
     add_submenu_page(
        'insapp_main_menu',
        'services',
        'Services',
        'manage_options',
        'edit-tags.php?taxonomy=service',
        ''                      
    );
    add_submenu_page('insapp_main_menu','reservation','Reservations','manage_options','insapp_reservations','insapp_reservations');
    add_submenu_page('insapp_main_menu','photographe','Photographe','manage_options','insapp_users','insapp_users');
   add_submenu_page('insapp_main_menu','clients','Clients','manage_options','insapp_customers','insapp_customers');
    add_submenu_page('insapp_main_menu','abonnement','Abonnement','manage_options','insapp_subcrption','insapp_subcrption_page_list');

    add_submenu_page('insapp_main_menu','abonnement','Ajouter un Abonnement','manage_options','insapp_subcrption_add','insapp_add_subcrption_page');
    add_submenu_page('insapp_main_menu','abonnement','Liste des abonnés','manage_options','insapp_subscrit_list','insapp_subscrit_list_page');
   
    add_submenu_page('insapp_main_menu','parametres','Paramètres','manage_options','insapp_param','insapp_param');
}

function insapp_main_menu(){
    // include TLPLUGIN_DIR .'test.php';

}

function insapp_reservations(){
    include TLPLUGIN_DIR.'templates/booking.php';

}


function insapp_users(){
    include TLPLUGIN_DIR.'templates/insapp_users.php';

}

function insapp_customers(){
    include TLPLUGIN_DIR.'templates/insapp_customers.php';

}

function insapp_param(){
    include TLPLUGIN_DIR.'includes/settings/settings.php';

}

function insapp_subcrption_page_list(){
    include TLPLUGIN_DIR.'templates/subscription_list.php';
}

function insapp_add_subcrption_page(){
    include TLPLUGIN_DIR.'templates/subscription.php';
}

function insapp_subscrit_list_page(){
    include TLPLUGIN_DIR.'templates/subscriber_list.php';
}






?> 