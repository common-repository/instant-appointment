<?php
// Ajouter les rôles personnalisés
add_role('insapp_customers', 'Client');
add_role('insapp_photographe', 'Photographe');

// Empêcher l'accès au tableau de bord pour les rôles 'Client' et 'Photographe'
function insapp_redirect_custom_roles_from_admin() {
    if (defined('DOING_AJAX') && DOING_AJAX) {
        return;
    }

    $current_user = wp_get_current_user();
    if (in_array('insapp_customers', (array) $current_user->roles) || in_array('insapp_photographe', (array) $current_user->roles)) {
        wp_redirect(home_url());
        exit;
    }
}
add_action('admin_init', 'insapp_redirect_custom_roles_from_admin');

// Masquer la barre d'administration pour les rôles 'Client' et 'Photographe'
function insapp_hide_admin_bar_for_custom_roles($show_admin_bar) {
    $current_user = wp_get_current_user();
    if (in_array('insapp_customers', (array) $current_user->roles) || in_array('insapp_photographe', (array) $current_user->roles)) {
        return false;
    }
    return $show_admin_bar;
}
add_filter('show_admin_bar', 'insapp_hide_admin_bar_for_custom_roles');
