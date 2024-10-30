<?php

// include(TLPLUGIN_DIR . 'includes/event/insapp_event_cf.php'); 
// include(TLPLUGIN_DIR . 'includes/lieux/insapp_lieux_cf.php'); 

function insapp_post_type_Evenement() {

    $labels = array(
        'name'                  => ( 'Annonces' ),
        'singular_name'         => ( 'Annonce' ),
        'menu_name'             => ( 'Annonces' ),
        'name_admin_bar'        => ( 'Annonce' ),
        'archives'              => ( 'Archives de l\'annonce' ),
        'attributes'            => ( 'Attributs de l\'annonce' ),
        'parent_item_colon'     => ( 'Annonce parent' ),
        'all_items'             => ( 'Annonces' ),
        'add_new_item'          => ( 'Ajouter un annonce' ),
        'add_new'               => ( 'Ajouter un annonce' ),
        'new_item'              => ( 'Nouvel annonce' ),
        'edit_item'             => ( 'Modifier l\'annonce' ),
        'update_item'           => ( 'Mettre à jour l\'annonce' ),
        'view_item'             => ( 'Voir l\'annonce' ),
        'view_items'            => ( 'Voir les annonces' ),
        'search_items'          => ( 'Chercher un annonce' ),
        'not_found'             => ( 'Aucun annonce trouvé' ),
        'not_found_in_trash'    => ( 'Aucun annonce trouvé dans la corbeille' ),
        'featured_image'        => ( 'Image mise en avant' ),
        'set_featured_image'    => ( "Définir l'image mise en avant" ),
        'remove_featured_image' => __( "Supprimer l'image mise en avant"),
        'use_featured_image'    => ( 'Utiliser comme image mise en avant' ),
        'insert_into_item'      => ( 'Insérer dans l\'annonce' ),
        'uploaded_to_this_item' => ( 'Téléversé sur cet annonce' ),
        'items_list'            => ( 'Liste des annonces' ),
        'items_list_navigation' => ( 'Navigation des annonces' ),
        'filter_items_list'     => ( 'Filtrer la liste des annonces' ),
    );
    $args = array(
        'label'                 => 'Annonce',
        'description'           => 'Annonces',
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail','comments' ),
        'taxonomies'            => array( 'service' ), 
        'show_in_menu'          => "insapp_main_menu", 
        'hierarchical'          => true,
        'public'                => true,
        'show_ui'               => true, 
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post' 
    );
    register_post_type( 'annonce', $args );

}
add_action( 'init', 'insapp_post_type_Evenement', 0 );

function insapp_taxonomy_service() {

    $labels = array(
        'name'                       => ( 'Services' ),
        'singular_name'              => ( 'Services'),
        'menu_name'                  => ( 'Services' ),
        'all_items'                  => ( 'Tous les services' ),
        'parent_item'                => ( 'Service parent' ),
        'parent_item_colon'          => ( 'Service parent' ),
        'new_item_name'              => ( 'Nouveau service' ),
        'add_new_item'               => ( 'Ajouter un nouveau service' ),
        'edit_item'                  => ( 'Modifier le service' ),
        'update_item'                => ( 'Mettre à jour le service' ),
        'view_item'                  => ( 'Voir le service' ),
        'separate_items_with_commas' => ( 'Séparer les services par des virgules' ),
        'add_or_remove_items'        => ( 'Ajouter ou supprimer des services' ),
        'choose_from_most_used'      => ( 'Choisir parmi les plus utilisés' ),
        'popular_items'              => ( 'Services populaires' ),
        'search_items'               => ( 'Chercher un service' ),
        'not_found'                  => ( 'Aucun service trouvé' ),
        'no_terms'                   => ( 'Aucun service' ),
        'items_list'                 => ( 'Liste des services' ),
        'items_list_navigation'      => ( 'Navigation des services' ),
    );
    $args = array(
        
        'labels'                     => $labels,
        'hierarchical'               => true, 
        'tax_name'                   => 'service',
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,  
        'show_in_menu'               => true,
        'rewrite'                    => array( 'slug' => 'service'),

    );
    register_taxonomy( 'service', array( 'annonce' ), $args );

}
add_action( 'init', 'insapp_taxonomy_service', 0 );


?>

 
  
   
    
    
     
      
       
        
         
          
          