<?php get_header(); ?>

<div > 
        <?php
        // Start the loop.
        while (have_posts()) : the_post();

                $insapp_templates = new Insapp_Template_Loader;
                $insapp_templates->get_template_part( 'services/single_annonce' );

         
        endwhile;
        ?>
 
</div> 
 
<?php get_footer(); ?>
