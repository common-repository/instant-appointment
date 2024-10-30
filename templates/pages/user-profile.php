<?php get_header(); ?>

<div > 
        <?php
        // Start the loop.
 

                $insapp_templates = new Insapp_Template_Loader;
                $insapp_templates->get_template_part( 'account/single_profile' );

 
        ?>
 
</div> 
 
<?php get_footer(); ?>
