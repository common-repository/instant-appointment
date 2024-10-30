<?php

add_action('lieux_edit_form_fields','edit_lieux_form_fields'); 
add_action('lieux_add_form_fields','add_lieux_form_fields'); 

 
function edit_lieux_form_fields ($term) {
   
    $location_phone = get_term_meta($term -> term_id, 'insapp_location_phone', true );
    $location_address = get_term_meta($term -> term_id, 'insapp_location_address', true );
    $location_image = get_term_meta($term -> term_id, 'insapp_location_image', true );
    // $lieux = get_terms('Lieux');

    foreach($lieux as $term) {
        $upload_image = get_term_meta($term->term_id, 'insapp_location_image', true);
?>
<img src="<?php echo $location_image ?>">
<?php
    }
?>
<div class="form-field">
    <tr>
        <th> <label for="insapp_location_phone">
                <?php _e( "Numero de telephone" ); ?>
            </label> </th>
        <td><input type="tel" id="insapp_location_phone" name="insapp_location_phone"
                value="<?php _e( $location_phone) ?>" /></td>
    </tr>
    <tr>
        <th> <label for="insapp_location_address">
                <?php _e( "Localisation exacte" ); ?>
            </label> </th>
        <td> <input type="text" id="insapp_location_address" name="insapp_location_address"
                value="<?php  _e( $location_address ) ?>" /></td>
    </tr>

    <tr class="form-field term-group">
        <th scope="row"><label for="insapp_location_image">
                <?php _e( 'Image' ); ?>
            </label></th>
        <td>

            <img class="user-preview-image" src="<?php echo esc_attr( $location_image); ?>" id="cat-image" />

            <input type="text" name="insapp_location_image" id="insapp_location_image"
                value="<?php echo esc_attr( $location_image ); ?>" class="regular-text" />
            <input type='button' class="button-primary insapp_upload_image_button" value="Upload Image"
                id="uploadimage" /><br />

            <span class="description">Please upload an image for your profile.</span>
            <div class="image-preview"><img src="" style="max-width: 250px;"></div>
        </td>
    </tr>
</div>
<?php 
    } 

function add_lieux_form_fields () {
?>
<div class="form-field" method='post'>
    <div>
        <label for="insapp_location_phone">
            <?php _e( "Numero de telephone" ); ?>
        </label>
        <input type="tel" id="insapp_location_phone" name="insapp_location_phone" value="" />
    </div>
    <div>
        <label for="insapp_location_address">
            <?php _e( "Localisation exacte" ); ?>
        </label>
        <input type="text" id="insapp_location_address" name="insapp_location_address" value="" />
    </div>
    <div class="d-flex align-items-center mb-4">
        <div>
            <img class="user-preview-image image avatar avatar-lg rounded-circle" src="" id="insapp-cat-image">
        </div>
        <div class="file-upload btn btn-outline-white ms-4">
            <input type='button' class="button-primary insapp_upload_image_button file-input opacity-0"
                value="Upload Image" id="uploadimage" /><br />

        </div>
    </div>
</div>
    <?php 
    }

// when the form gets submitted, and the new field gets updated (in your case the option will get updated with the values of your custom fields above
 
add_action ( 'edited_lieux', 'edit_location_fileds');
add_action('created_lieux','save_locaion_fileds');
// save locaion category locaion fields callback function
 
function save_locaion_fileds( $term_id, $tt_id ) {
    if ( isset( $_POST['insapp_location_phone'] ) ) {
        update_term_meta( $term_id, 'insapp_location_phone', sanitize_text_field( $_POST[ 'insapp_location_phone' ] ) );
    }
    if ( isset( $_POST['insapp_location_address'] ) ) {
        update_term_meta( $term_id, 'insapp_location_address', sanitize_text_field( $_POST[ 'insapp_location_address' ] ) );
    }
    // if (isset($_POST['insapp_location_image'])){
    //     $group = '#' . sanitize_title($_POST['insapp_location_image']);
    //     add_term_meta($term_id, 'insapp_location_image', $group, true);
    // }
       if ( isset( $_POST['insapp_location_image'] ) ) {
        update_term_meta($term_id, 'insapp_location_image', $_POST['insapp_location_image']);
    }

$term_id = 39;
$image = get_term_meta($term_id, 'category_image', true);
echo '<img src="'.$image.'" />';
}

function edit_location_fileds( $term_id) {
    if ( isset( $_POST['insapp_location_phone'] ) ) {
        update_term_meta( $term_id, 'insapp_location_phone', sanitize_text_field( $_POST[ 'insapp_location_phone' ] ) );
    }
    if ( isset( $_POST['insapp_location_address'] ) ) {
        update_term_meta( $term_id, 'insapp_location_address', sanitize_text_field( $_POST[ 'insapp_location_address' ] ) );
    }
     if (isset($_POST['insapp_location_image'])){
        $group = sanitize_title($_POST['insapp_location_image']);
        update_term_meta($term_id, 'insapp_location_image', $group);
    }
}


//  add_filter( 'manage_edit-location_columns', 'display_image_column_heading' ); 
// function display_image_column_heading( $columns ) {
//     $columns['lieux_image'] = __( 'Image' );
//     return $columns;
// }

//     $lieux = get_terms('Lieux');

//     foreach($lieux as $term) {
//         $upload_image = get_term_meta($term->term_id, 'insapp_location_image', true);

?>