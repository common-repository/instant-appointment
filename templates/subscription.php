<!-- 
/***********************************************************************
***********            Create subscription                  **************
*****************************************************************/ -->
<div class="wrap">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 mt-5">
                <!-- Page header -->
                <div class="my-5">
                    <h3 class="mt-5">
                        <?php _e('Ajouter un abonnement','instant_Appointement') ?>
                    </h3>
                </div>
            </div>
        </div>
        <form action="" class="insapp_register_subscription">
            <div class="row">
                <div class="col-md-8 col-12">
                    <!-- card -->
                    <div class="card mb-4">
                        <!-- card body -->
                        <div class="card-body">
                            <div class="mb-5 col-lg-12 col-12 ">
                                <label for="insapp_subscription_name" class="form-label">
                                    <?php _e("Nom","instant_Appointement") ?>
                                </label>
                                <input type="text" id="insapp_subscription_name" class="form-control"
                                    placeholder="<?php _e(" Entrez le nom de l'abonnement","instant_Appointement") ?>"
                                required />
                            </div>
                            <div class="mb-5 col-lg-12 col-12">
                                <label for="insapp_subscription_description" class="form-label">
                                    <?php _e("Description","instant_Appointement") ?>
                                </label>
                                <textarea class="form-control" id="insapp_subscription_description" rows="3"></textarea>

                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="card mb-4">
                                <!-- card body -->
                                <div class="card-body">
                                    <!-- input -->
                                    <div class="mb-3">
                                        <label class="form-label">
                                            <?php _e('Prix mensuel','instant_Appointement') ?>
                                        </label>
                                        <input type="number" class="form-control" id="insapp_price_mensuel"
                                            placeholder="50.00 <?php echo get_woocommerce_currency_symbol() ;?>"  step="0.01" required />
                                    </div>
                                    <!-- input -->
                                    <div class="mb-3">
                                       
                                         
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="card mb-4">
                                <!-- card body -->
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between">
                                            <label class="form-label">Periode de facturation</label>
                                        </div>
                                        <select class="form-select" id="insapp_duration"
                                            aria-label="Default select example" required>
                                            <option value="1" selected="">Pour un mois</option>
                                            <option value="3">Pour 3 mois</option>
                                            <option value="6">Pour 6 mois</option>
                                            <option value="12"> Pour un an</option>
                                        </select>
                                    </div>
                                     <div class="mb-3">
                                        <div class="d-flex justify-content-between">
                                            <label class="form-label">Periode d'essai</label>
                                        </div>
                                        <select class="form-select" id="insapp_free_trial"
                                            aria-label="Default select example" required>
                                            <option value="7" selected="">Pour 7 jours</option>
                                            <option value="14">Pour 14 jours</option>
                                            <option value="30">Pour 1 mois</option> 
                                        </select>
                                    </div>
                                    <!-- <div class="mb-3">
                                    <label class="form-label">
                                        <?php //_e('Prix Annuel Promotionnel','instant_Appointement') ?>
                                    </label>
                                    <input type="text" class="form-control" id="insapp_price_annuel_promo" placeholder="490.00 <?php echo get_woocommerce_currency_symbol() ;?>" required />
                                </div>  -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="card px-5">
                            <div class="card-body">

                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary insapp_register_subcription_btn"
                                        style="padding: 10px 40px;">
                                        <?php _e('Créer un Abonnement')?>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-12">
                    <div class="card mb-4">

                              <div class="card-body">

                            <!--<div class="mb-3">-->
                            <!--    <div class="d-flex justify-content-between">-->
                            <!--        <label class="form-label">Status</label>-->
                            <!--    </div>-->

                            <!--    <select class="form-select" id="insapp_status" aria-label="Default select example">-->
                            <!--        <option selected="">Activé</option>-->
                            <!--        <option value="1">Desactivé</option>-->
                            <!--    </select>-->
                            <!--</div>-->

                            <div class="mb-3">
                                <label class="form-label">Liste d'elements
                                </label>
                                <input name='inspp_list_sub' value='tag1, tag2' height="510px"> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<style>
    .tagify {
    /* display: block !important;
    position: static !important;
    /* transform: none !important; */
    height:  200px;
    /* margin-top: 1em;
    padding: .5em; */ */
}
</style>