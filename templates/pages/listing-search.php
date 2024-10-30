<?php
/**
 * Listing Search result page.
 * 
 */
get_header();
// global $wp_query; 

?> 
    <div class="container "> 

        <?php  

                    // global $post;
                    // if ( $post->post_type == 'annonce' ) {
                        $insapp_templates = new Insapp_Template_Loader;
                        $insapp_templates->get_template_part( 'services/list-sidebar' );
                    // }  
                 
         ?>

    </div> 

<?php get_footer(); ?>