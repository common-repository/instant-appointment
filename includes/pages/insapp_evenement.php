<div class="row justify-content-evenly">
    <?php
$args = array(
 	'post_type' => 'evenement',
);

$evenements = new WP_Query( $args );

// The Loop
while ( $evenements->have_posts() ) {
$evenements->the_post();
$meta_evenement = get_post_meta(get_the_id());
$meta_evenement = array_combine(array_keys($meta_evenement), array_column($meta_evenement, '0'));
$evenement_datas = get_post(get_the_id());
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
            <p class="card-text"><?php if($meta_evenement['insapp_price_event'] != null){echo $meta_evenement['insapp_price_event'] ;}else{(_e(0)) ;} ?>FCFA - <?php if($meta_evenement['insapp_nbr_participant'] != null){echo $meta_evenement['insapp_nbr_participant'].' Personnes' ;}else{echo('Accès non autorisé') ;} ?></p>
            <a href="<?php echo esc_url( get_permalink( get_the_id() ) ); ?>" class="btn btn-primary">Go somewhere</a>
        </div>
    </div>
<?php } ?>   
</div>

<?php