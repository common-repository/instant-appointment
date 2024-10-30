<div class="row justify-content-evenly myservice">
    <?php
$args = array(
 	'post_type' => 'service',
);

$services = new WP_Query( $args );

// The Loop
while ( $services->have_posts() ) {
$services->the_post();
$meta_Service = get_post_meta(get_the_id());
$meta_Service = array_combine(array_keys($meta_Service), array_column($meta_Service, '0'));
$service_datas = get_post(get_the_id());
// var_dump( get_the_post_thumbnail( get_the_id(), 'thumbnail' ) );
?>
    <div class="card col-3 my-4 px-5 mx-5 flex-wrap">
        <?php if(get_the_post_thumbnail( get_the_id(), 'thumbnail', array( 'class' => 'card-img-top' ) ) != null ){
            echo get_the_post_thumbnail( get_the_id(), 'thumbnail', array( 'class' => 'card-img-top' ) );
        }else{ 
        ?>
        <img src="<?php echo esc_url( TLPLUGIN_URL . 'assets/images/default-placeholder.png') ?>" class="card-img-top" alt="">
        <?php } ?>
        <div class="card-body">
            <h3 class="card-title"><?php echo the_title() ?></h3>
            <p class="card-text" style="font-family: 'lato' !important;font-size: medium !important;"><?php if($meta_Service['insapp_service_price'] != null){echo $meta_Service['insapp_service_price'] ;}else{(_e(0)) ;} ?>FCFA - <?php if($meta_Service['insapp_service_cap'] != null){echo $meta_Service['insapp_service_cap'].' Personnes' ;}else{echo('Accès non autorisé') ;} ?></p>
            <a href="<?php echo esc_url( get_permalink( get_the_id() ) ); ?>" class="btn btn-primary">Voir</a>
        </div>
    </div>
<?php } ?>   
</div>

<?php