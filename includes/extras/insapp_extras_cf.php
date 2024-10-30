<?php
add_action('extras_edit_form_fields','edit_extras_form_fields'); 
add_action('extras_add_form_fields','add_extras_form_fields'); 

 
function edit_extras_form_fields ($term) {
   
    $extra_price = get_term_meta($term -> term_id, 'insapp_price_extra', true );
    $extra_cap = get_term_meta($term -> term_id, 'insapp_cap_extra', true );
    $extra_time = get_term_meta($term -> term_id, 'insapp_time_extra', true );
 
?>
  <div class="form-field"> 
    <tr>
           <th> <label for="insapp_price_extra"><?php _e( "Cout de l'extra" ); ?></label> </th>
            <td><input type="number" id="insapp_price_extra" name="insapp_price_extra" value="<?php _e( $extra_price) ?>"  /></td>
</tr>
        <tr>
          <th>   <label for="insapp_cap_extra"><?php _e( "Capacite de personnes acceptees" ); ?></label> </th>
           <td>  <input type="number" id="insapp_cap_extra" name="insapp_cap_extra" value="<?php  _e( $extra_cap ) ?>"  /></td>
</tr>
     <tr>
           <th>  <label for="insapp_time_extra"><?php _e( "Duree de l'extra" ); ?></label> </th>
           <td>  <input type="number" id="insapp_time_extra" name="insapp_time_extra" value="<?php  _e( $extra_time ) ?>"  /></td>
</tr>

</div>
<?php 
    } 

function add_extras_form_fields () {
?>
  <div class="form-field" method='post'>
        <div>
            <label for="insapp_price_extra"><?php _e( "Cout de l'extra" ); ?></label> 
            <input type="number" id="insapp_price_extra" name="insapp_price_extra" value=""  />
        </div>
        <div>
            <label for="insapp_cap_extra"><?php _e( "Capacite de personnes acceptees" ); ?></label> 
            <input type="number" id="insapp_cap_extra" name="insapp_cap_extra" value=""  />
        </div>
        <div>
            <label for="insapp_time_extra"><?php _e( "Duree de l'extra" ); ?></label> 
            <input type="number" id="insapp_time_extra" name="insapp_time_extra" value=""  />
        </div>
</div>
<?php 
    }
 
// when the form gets submitted, and the new field gets updated (in your case the option will get updated with the values of your custom fields above
 
add_action ( 'edited_extras', 'save_others_extra_fileds');
add_action('created_extras','save_others_extra_fileds');
// save extra category extra fields callback function
 
function save_others_extra_fileds( $term_id ) {
    if ( isset( $_POST['insapp_price_extra'] ) ) {
        update_term_meta( $term_id, 'insapp_price_extra', sanitize_text_field( $_POST[ 'insapp_price_extra' ] ) );
    }
    if ( isset( $_POST['insapp_cap_extra'] ) ) {
        update_term_meta( $term_id, 'insapp_cap_extra', sanitize_text_field( $_POST[ 'insapp_cap_extra' ] ) );
    }
    if ( isset( $_POST['insapp_time_extra'] ) ) {
        update_term_meta( $term_id, 'insapp_time_extra', sanitize_text_field( $_POST[ 'insapp_time_extra' ] ) );
    }
} 

// when a category is removed
// add_filter('deleted_term_taxonomy', 'remove_others_tax_Extras');
// function remove_others_tax_Extras($term_id) {
//     $termid = $term_id; 
//       if($_POST['taxonomy'] == 'extras'):
//         if(get_option( "tax_$termid"))
//             delete_option( "tax_$termid");
//       endif;
// }

 
// add_filter( 'manage_edit-extras_columns', 'extra_columns_type');
// add_filter( 'manage_extras_custom_column', 'extra_columns_type_manage', 10, 3);
 
// function extra_columns_type($columns) {
//         $columns['keywords'] = __( 'Detailed Description', 'dd_tax' );
//         return $columns;
//     }
// function extra_columns_type_manage( $out ,$column_name, $term) {
//     global $wp_version;
//     $out =  get_option( "tax_$termid"); 
//     if(((float)$wp_version)<3.1)
//         return $out;
//     else
//         echo $out;        
// }
 
?>