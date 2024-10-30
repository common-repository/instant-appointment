<?php
function insapp_add_service(){
    include_once(TLPLUGIN_DIR . 'includes/pages/insapp_service.php');
}
add_shortcode('service', 'insapp_add_service'); 

function insapp_add_evenement(){
    include_once(TLPLUGIN_DIR . 'includes/pages/insapp_evenement.php');
}
add_shortcode('evenement', 'insapp_add_evenement');

?>