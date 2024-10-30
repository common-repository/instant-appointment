<?php get_header() ?>

<?php 
$id = get_the_id();
$meta_event = get_post_meta($id);
$meta_event = array_combine(array_keys($meta_event), array_column($meta_event, '0'));
$event_datas = get_post($id);	

?>


<div class="row justify-content-evenly">
    <div class="col-md-4 p-5 rounded gx-5" style="background-color: #f5f5f5;">
        <h2 class="p-5 mt-5">
            <?php echo the_title() ?>
        </h2>
        <p>
            <?php echo the_content() ?>
        </p>

    </div>
    <div class="col-md-3 p-5 m-5 rounded" style="background-color: #f5f5f5;">
        <h2 class="p-5 m-5">
            <?php if($meta_Service['insapp_service_price'] != null){echo $meta_Service['insapp_service_price'] ;}else{(_e(0)) ;} ?>FCFA
        </h2>
        <?php
            $service_taxonomies = get_object_taxonomies('service', 'object');
            $out = array();

	        foreach ( $service_taxonomies as $taxonomy_slug => $taxonomy ){

		    // Get the terms related to post.
		    $terms = get_the_terms( $post->ID, $taxonomy_slug );

	
            if ( ! empty( $terms ) ) {
        ?>
        <h2>
            <?php echo $taxonomy->label ; ?>
        </h2>
        <div class=" gx-5" >
            <ul>
                <?php
			foreach ( $terms as $term ) { ?>
                <!-- esc_url( get_term_link( $term->slug, $taxonomy_slug ) ), -->
                <div class="form-check ">
                    <input class="form-check-input " type="checkbox" value="<?php echo esc_html( $term->name ); ?>" id="flexCheckDefault">
                    <label class="form-check-label " for="flexCheckDefault"><span><?php echo esc_html( $term->name ); ?></span>
                    </label>
                </div>
                    <p><?php echo esc_html( $term->description ); ?></p>

                <?php }
		}
        ?>
            </ul>
        </div>
        <?php } ?>
        <button type="button" class="btn btn-primary align-self-end">Reserver</button>
    </div>
</div>


<?php get_footer() ?>