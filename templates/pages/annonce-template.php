<?php

get_header(); ?>


<div class="container">
<?php
  
                $insapp_templates = new Insapp_Template_Loader;
                $insapp_templates->get_template_part( 'services/list-sidebar' );
?>

</div>

<?php get_footer(); ?>