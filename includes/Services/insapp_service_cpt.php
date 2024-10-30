<?php

include(TLPLUGIN_DIR . 'includes/services/insapp_service_cf.php');// Register Custom Post Type
include(TLPLUGIN_DIR . 'includes/extras/insapp_extras_cf.php');// Register Custom Post Type

function insapp_post_type_service() {

    $labels = array(
        'name'                  => ( 'Services' ),
        'singular_name'         => ( 'Service' ),
        'menu_name'             => ( 'Services' ),
        'name_admin_bar'        => ( 'Service' ),
        'archives'              => ( `Archives du service` ),
        'attributes'            => ( `Attributs du service` ),
        'parent_item_colon'     => ( 'service parent' ),
        'all_items'             => ( 'Tous les services' ),
        'add_new_item'          => ( 'nouveau service' ),
        'add_new'               => ( 'nouveau service' ),
        'new_item'              => ( 'Nouveau service' ),
        'edit_item'             => ( `Modifier le service` ),
        'update_item'           => ( `Mettre à jour le service` ),
        'view_item'             => ( `Voir le service` ),
        'view_items'            => ( 'Voir les services' ),
        'search_items'          => ( 'Chercher un service' ),
        'not_found'             => ( 'Aucun service trouvé' ),
        'not_found_in_trash'    => ( 'Aucun service trouvé dans la corbeille' ),
        'featured_image'        => ( 'Image mise en avant' ),
        'set_featured_image'    => ( "Définir l'image mise en avant" ),
        'remove_featured_image' => __( "Supprimer l'image mise en avant"),
        'use_featured_image'    => ( 'Utiliser comme image mise en avant' ),
        'insert_into_item'      => ( `Insérer dans le service` ),
        'uploaded_to_this_item' => ( 'Téléversé sur cet service' ),
        'items_list'            => ( 'Liste des services' ),
        'items_list_navigation' => ( 'Navigation des services' ),
        'filter_items_list'     => ( 'Filtrer la liste des services' ),
    );
    $args = array(
        'label'                 => ( 'service' ),
        'description'           => ( 'Toutes les services' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail' ),
        'taxonomies'            => array( 'extras', 'categories', date($format = '', $post = null) ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        // 'menu_icon'             => 'dashicons-admin-generic',
        // 'show_in_admin_bar'     => true,
        // 'show_in_nav_menus'     => true,
        // 'can_export'            => true,
        // 'has_archive'           => true,
        // 'exclude_from_search'   => false,
        // 'publicly_queryable'    => true,
        // 'capability_type'       => 'page',
    );
    register_post_type( 'service', $args );

}
add_action( 'init', 'insapp_post_type_service', 0 );

// Register Custom Taxonomy extras
function insapp_taxonomy_extras() {

    $labels = array(
        'name'                       => _x( 'extras', 'Taxonomy General Name' ),
        'singular_name'              => _x( 'extras', 'Taxonomy Singular Name' ),
        'menu_name'                  => ( 'extras' ),
        'all_items'                  => ( 'Tous les extras' ),
        'parent_item'                => ( 'Extra parent' ),
        'parent_item_colon'          => ( 'Extra parent' ),
        'new_item_name'              => ( 'Nouveau extra' ),
        'add_new_item'               => ( 'Ajouter un nouveau extra' ),
        'edit_item'                  => ( 'Modifier le extra' ),
        'update_item'                => ( 'Mettre à jour le extra' ),
        'view_item'                  => ( 'Voir le extra' ),
        'separate_items_with_commas' => ( 'Séparer les extras par des virgules' ),
        'add_or_remove_items'        => ( 'Ajouter ou supprimer des extras' ),
        'choose_from_most_used'      => ( 'Choisir parmi les plus utilisés' ),
        'popular_items'              => ( 'extras populaires' ),
        'search_items'               => ( 'Chercher un extra' ),
        'not_found'                  => ( 'Aucun extra trouvé' ),
        'no_terms'                   => ( 'Aucun extra' ),
        'items_list'                 => ( 'Liste des extras' ),
        'items_list_navigation'      => ( 'Navigation des extras' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => false,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_menu'          => true,
    );
    register_taxonomy( 'extras', array( 'service' ), $args );

}
add_action( 'init', 'insapp_taxonomy_extras', 0 );

// Register Custom Taxonomy categories
function insapp_taxonomy_categories() {

    $labels = array(
        'name'                       => _x( 'categories', 'Taxonomy General Name' ),
        'singular_name'              => _x( 'categories', 'Taxonomy Singular Name' ),
        'menu_name'                  => ( 'categories' ),
        'all_items'                  => ( 'Toutes les categories' ),
        'parent_item'                => ( 'Categorie parent' ),
        'parent_item_colon'          => ( 'Categorie parent' ),
        'new_item_name'              => ( 'Nouveau categorie' ),
        'add_new_item'               => ( 'Ajouter une nouvelle categorie' ),
        'edit_item'                  => ( 'Modifier la categorie' ),
        'update_item'                => ( 'Mettre à jour la categorie' ),
        'view_item'                  => ( 'Voir la categorie' ),
        'separate_items_with_commas' => ( 'Séparer les categories par des virgules' ),
        'add_or_remove_items'        => ( 'Ajouter ou supprimer des categories' ),
        'choose_from_most_used'      => ( 'Choisir parmi les plus utilisés' ),
        'popular_items'              => ( 'Categories populaires' ),
        'search_items'               => ( 'Chercher une categorie' ),
        'not_found'                  => ( 'Aucune categorie trouvé' ),
        'no_terms'                   => ( 'Aucune categorie' ),
        'items_list'                 => ( 'Liste des categories' ),
        'items_list_navigation'      => ( 'Navigation des categories' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => false,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_menu'          => true,
    );
    register_taxonomy( 'categories', array( 'service' ), $args );

}
add_action( 'init', 'insapp_taxonomy_categories', 0 );

?>