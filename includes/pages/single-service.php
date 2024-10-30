<?php get_header() ?>

<?php 
$id = get_the_id();
$meta_Service = get_post_meta($id);
$meta_Service = array_combine(array_keys($meta_Service), array_column($meta_Service, '0'));
$service_datas = get_post($id);	

?>

<div class="carousel-inner container-fluid">
    <?php echo esc_html( get_the_post_thumbnail( $id, 'thumbnail', array( 'class' => ' w-100 h-50 d-inline-block' ) ))?>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-8">
            <h2 class="p-5">
                <?php echo esc_html( the_title()) ?>
            </h2>
        </div>
        <div class="col-4">
            <h2 class="p-5 m-5">
                <?php if($meta_Service['insapp_service_price'] != null){echo esc_html( $meta_Service['insapp_service_price']) ;}else{(_e(0)) ;} ?>FCFA
            </h2>
        </div>
    </div>
    <div class="row justify-content-between">
        <div class="col-8 d-flex">
            <h2 class="p-5">
                <?php echo 'Categories :' ?>
            </h2>
            <?php
		    $categories = get_the_terms( $post->ID, 'categories' );
            if ( ! empty( $categories ) ) {
			    foreach ( $categories as $categorie ) {
                    $categorie_id = $categorie->term_id;
            ?>
            <h4 class="p-5 m-5">
                <?php echo esc_html( $categorie->name ).' '; ?>
            </h4>
            <?php }} ?>
        </div>
        <div class="col-4 align-self-end">
            <button type="button" class="btn btn-primary align-self-end" data-bs-toggle="modal"
                href="#exampleModalToggle">Reserver</button>
        </div>
    </div>
    <div class="d-flex justify-content-between col-md-6">
        <div class="d-flex">
            <i class="fa-light fa-people-group"></i><P>Capacité : </P>
        <h4>
            <?php if($meta_Service['insapp_service_cap'] != null){echo ' '.esc_html( $meta_Service['insapp_service_cap']) ;}else{(_e(0)) ;} ?>
            personnes
        </h4>
        </div>
        <div class="d-flex">
            <i class="fa-light fa-hourglass-clock"></i><span>Durée: </span><h4><?php echo ' '.esc_html( $meta_Service['insapp_service_time']) ;?></h4>
        </div>
    </div>
    <div class="d-flex">
        <i class="fa-regular fa-calendar-week"></i><span>Fréquence: </span><h4><?php echo ' '.esc_html( $meta_Service['insapp_service_freq']) ;?></h4>
    </div>

    <div class="py-5 justify-text">
        <?php echo esc_html( the_content()); ?>
    </div>

    <button type="button" class="btn btn-primary align-self-end" data-bs-toggle="modal"
        href="#exampleModalToggle">Reserver</button>
</div>



<!-- toggle between modal -->
<div class="modal fade gd-example-modal-xl" id="exampleModalToggle" aria-hidden="true"
    aria-labelledby="exampleModalToggleLabel" tabindex="-1"
    style="font-family: 'lato' !important; font-size: medium !important; font-weight: normal;">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel">Paiement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-12 text-center">
                    <?php echo esc_html( get_the_post_thumbnail( $id, 'thumbnail', array( 'class' => 'rounded-circle' ) ))?>
                    <h2 class="p-5">
                        <?php echo esc_html( the_title()) ?>
                    </h2>
                </div>
                <form class="row g-3" id="insapp_service_resa">
                    <div class="col-md-6 p-4">
                        <label for="customer_name" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name" value=""
                            required>
                    </div>
                    <div class="col-md-6 p-4">
                        <label for="customer_surname" class="form-label">Prenom</label>
                        <input type="text" class="form-control" id="customer_surname" name="customer_surname" value=""
                            required>
                    </div>
                    <div class="col-md-6 p-4">
                        <label for="customer_email" class="form-label">Email</label>
                        <div class="input-group">
                            <input type="email" class="form-control" id="customer_email" name="customer_email"
                                aria-describedby="inputGroupPrepend2" required>
                        </div>
                    </div>
                    <div class="col-md-6 p-4">
                        <label for="customer_tel" class="form-label">Numero de Telephone</label>
                        <input type="tel" class="form-control" id="customer_tel" name="customer_tel" width="500px"
                            required>
                    </div>
                    <div class="col-md-6 p-4">
                    </div>
                    <div class="col-md-6 p-4">
                    </div>
                    <hr style="width: 80%; align-self: center;" />
                    <?php
		                    // Get the extras related to post.
		                    $extras = get_the_terms( $post->ID, 'extras' );

	                        if ( ! empty( $extras ) ) {

			                    foreach ( $extras as $term ) { 
                                    $term_id = $term->term_id;
                                    $term_meta = get_term_meta($term_id);
                                    $term_meta = array_combine(array_keys($term_meta), array_column($term_meta, '0'));

                    ?>
                    <div>
                        <input name="extra_list" id="flexCheckDefault" value="<?php echo esc_html( $term->name ) ?>"
                            class="form-check-input select_extra" type="checkbox">
                        <label class="form-check-label " for="flexCheckDefault">
                            <?php
                                echo esc_html( $term->name );
                                if(isset( $term_meta['insapp_price_extra'] )){
                                    echo ' : <span>'.esc_html( $term_meta['insapp_price_extra'] ).' XAX</span>';
                                }
                            ?>
                        </label>
                    </div>
                    <?php }
                            }
                        ?>
                    <div class="col-md-4 p-4">
                        <label for="customer_cap" class="form-label">Nombre de participant</label>
                        <input type="number" class="form-control" id="customer_cap" name="customer_cap" min="1"
                            max="<?php echo esc_html( $meta_Service['insapp_service_cap']) ; ?>" required>
                        <div class="invalid-password-feedback" id="feedback_capacity">
                            <?php _e('Le nombre de places est invalide!'); ?>
                        </div>
                    </div>
                    <div class="col-md-4 p-4">
                        <label for="customer_date" class="form-label">Date de rendez-vous</label>
                        <input type="date" class="form-control" id="customer_date" name="customer_date" required>
                    </div>
                    <div class="col-md-4 p-4">
                        <label for="customer_time" class="form-label">Horaire de rendez-vous</label>
                        <input type="time" class="form-control" id="customer_time" name="customer_time" required>
                    </div>
                    <input type="hidden" name="resa_unit" id="resa_unit"
                        value="<?php {echo esc_html( $meta_Service['insapp_service_price']) ;} ?>">
                    <input type="hidden" name="insapp_ser_cap" id="insapp_ser_cap"
                        value="<?php {echo esc_html( $meta_Service['insapp_service_cap']) ;} ?>">
                    <input type="hidden" name="insapp_ser_cap" id="insapp_ser_id"
                        value="<?php {echo esc_html( get_the_id() );} ?>">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button class="btn btn-primary" data-bs-target="#exampleModalToggle2" id="insapp_resa_send"
                    data-bs-toggle="modal" data-bs-dismiss="modal">Suivant</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade gd-example-modal-xl" id="exampleModalToggle2" aria-hidden="true"
    aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel2">Paiement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="resa_part2">
                <div class="col-12 text-center">
                    <?php echo esc_html( get_the_post_thumbnail( $id, 'thumbnail', array( 'class' => 'rounded-circle' ) ))?>
                    <h2 class="p-5">
                        <?php echo esc_html( the_title()) ?>
                    </h2>
                </div>
                <div class="row justify-content-between">
                    <div class="col-6">
                        <p><span>Nombre de personnes</span></p>
                    </div>
                    <div class="col-4 text-end" id="cap_resa">
                    </div>
                </div>
                <div class="row justify-content-between">
                    <div class="col-4">
                        <p><span>Prix unitaire</span></p>
                    </div>
                    <div class="col-4 text-end" id="unit_price">
                    </div>
                </div>
                <div class="row justify-content-between">
                    <div class="col-4">
                        <p><span>Total a payer</span></p>
                    </div>
                    <div class="col-4 text-end" id="total_price">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    data-bs-target="#exampleModalToggle">Precedent</button>
                <button class="btn btn-primary" data-bs-dismiss="modal">Terminer</button>
            </div>
        </div>
    </div>
</div>

<?php get_footer() ?>