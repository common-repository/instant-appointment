<div class="wrap">

<?php settings_errors(); ?>
        <h2> <?php _e(get_admin_page_title())?></h2>
 

        <h2 class="nav-tab-wrapper">
            <a href="?page=insapp_param&tab=general" class="nav-tab">Général</a>
            <a href="?page=insapp_param&tab=advanced" class="nav-tab">Avancé</a>
       </h2>
        <form method="post" action="options.php">
            <input type="hidden" name="my_settings_submit" value="1">
            
            <?php
            $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'general';

            if ($active_tab == 'general') {
                echo '<h3>Options Générales</h3>';
                settings_fields( 'insapp_general_settings' );
                do_settings_sections( 'insapp_general' );

            } elseif ($active_tab == 'advanced') {

              settings_fields( 'insapp_advance_Settings' );
              do_settings_sections( 'insapp_advance' );

            }
             
 
                submit_button( null,'primary','submit',true,['id'=>'pw_button'] );
            ?>
        </form>

</div>