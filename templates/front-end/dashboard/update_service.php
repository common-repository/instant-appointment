<?php
    $args = array('taxonomy'   => "product_cat",'parent'=> 0,'hide_empty'=> false);
    $categories = get_terms( $args); 

    $listcategories = [];
    foreach ( $categories as $category ) {
    array_push( $listcategories, $category->term_id);
    }
    
    $tags = get_terms(array('taxonomy' => 'product_tag','hide_empty' => false));
    
    $mediums = get_terms(
        array(
        'taxonomy'   => 'service', 
        'hide_empty' => false 
        ) 
    ); 

    $product_id = '25035';

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-12 mt-5">
 
        <div class="my-5">
            <h3 class="mt-5">
                <?php _e('Modifier un offre','instant_Appointement') ?>
            </h3>
        </div>
    </div>
</div>
<form action="" class="insapp_update_service">
    <div class="row">
        <div class="col-md-12 col-12">
      
            <div class="card mb-4">
  
                <div class="card-body">
                    <div class="mb-5 col-lg-12 col-12 ">
                        <label for="insapp_update_service_name" class="form-label">
                            <?php _e("Nom","instant_Appointement") ?>
                        </label>
                        <input type="text" id="insapp_update_service_name" class="form-control" placeholder="<?php _e("
                            Entrez le nom de l'offre","instant_Appointement") ?>"
                        required="" />
                    </div>

                    <div class="mb-5 col-lg-12 col-12">
                        <label class="form-label">
                            <?php _e("Description","instant_Appointement") ?>
                        </label>

                        <div class="pb-8 ql-container ql-snow">
                            <div class="ql-editor ql-blank" id="insapp_update_service_editor" data-gramm="false"
                                contenteditable="true">
                                <p><br></p>
                            </div>
                            <div class="ql-clipboard" contenteditable="true" tabindex="-1"></div>
                            <div class="ql-tooltip ql-hidden">
                                <a class="ql-preview" rel="noopener noreferrer" target="_blank" href="about:blank"></a>
                                <input type="text" data-formula="e=mc^2" maxlength="15" data-link="https://quilljs.com"
                                    data-video="Embed URL">
                                <a class="ql-action"></a>
                                <a class="ql-remove"></a>
                            </div>
                        </div>
                    </div>

                </div>
                
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-12">
                <div class="card mb-4">
    
                    <div class="card-body">
            
                        <div class="mb-3">
                            <label class="form-label">
                                <?php _e('Prix Regulier','instant_Appointement') ?>
                            </label>
                            <input type="text" class="form-control" id="insapp_update_price_reg"
                                placeholder="$ 49.00" />
                        </div>
            
                        <div class="mb-3">
                            <label class="form-label">
                                <?php _e('Prix promotionnel','instant_Appointement') ?>
                            </label>
                            <input type="text" class="form-control" id="insapp_update_price_sale" placeholder="$ 49.00" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                <?php _e('Durée du service','instant_Appointement') ?>
                            </label>
                            <input name='insapp_duree' id="insapp_update_duree" type="time" class="form-control"
                                placeholder='<?php _e(" Choisir la durée du service","instant_Appointement") ?>'
                                required />

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                  <div class="card mb-4">
                    
                    <div class="card-body" style="min-height: 280px;">
                    
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <label class="form-label">
                                    <?php _e('Service','instant_Appointement') ?>
                                </label>
                            </div>
                        
                                <ul class="terms-list insapp-circle-check level-0">
                                <?php 	
                                    if (!empty($mediums) && !is_wp_error($mediums)) {
                                        foreach ($mediums as $medium) {?>
                                            <li class="list-item level-0">
                                                <div class="form-check">
                                                    <input class="form-check-input insapp-list-update-medium"  name=" "
                                                        type="checkbox" value="<?php _e($medium->term_id) ?>" id="insapp-list-update-medium">
                                                    <label class="form-check-label"
                                                        for="insapp-list-update-medium">
                                                        <?php _e($medium->name) ?>
                                                    </label>
                                                </div>
                                            </li>  
                                            
                                        <?php }
                                    } else {
                                        echo 'Aucun produit trouvé.';
                                    } ?> 
                            </ul> 
                        </div>
                
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="card mb-4">
                
                    <div class="card-body" style="min-height: 280px;"> 

                           <div class="d-flex justify-content-between">
                                <label class="form-label">
                                    <?php _e('Etiquette','instant_Appointement') ?>
                                </label>
                            </div>

                            <ul class="terms-list insapp-circle-check level-0">
                                <?php 	
                                    if (!empty($tags) && !is_wp_error($tags)) {
                                        foreach ($tags as $tag) {?>
                                            <li class="list-item level-0">
                                                <div class="form-check">
                                                    <input class="form-check-input insapp-list-update-tag"  name="insapp-list-update-tag"
                                                        type="checkbox" value="<?php _e($tag->term_id) ?>" id="insapp-list-update-tag">
                                                    <label class="form-check-label"
                                                        for="insapp-list-update-tag">
                                                        <?php _e($tag->name) ?>
                                                    </label>
                                                </div>
                                            </li>  
                                        <?php }
                                    } else {
                                        echo 'Aucun produit trouvé.';
                                    } ?> 
                            </ul>
                             <div class="mb-5 col-lg-12 col-12 ">
                                    <label for="insapp_annonce_city_update_input" class="form-label">
                                        <?php _e("Localisation","instant_Appointement") ?>
                                    </label>
                                    <input type="text" id="insapp_annonce_city_update_input" required class="form-control" placeholder="<?php _e(" Entrez votre ville ou localisation","instant_Appointement") ?>"/>
                                 <div id="insapp_location_check" class="insapp_notification" style="text-align: center;margin-top: 30px;background-color: #ffcece;color: #f75555;font-weight: 600;justify-content: center;min-height: 50px; align-items: center;display:none; font-size: 14px;border-radius: 5px;"></div>
                                </div>
                                     <input type="hidden" id="insapp_location_update_latitude" value="">
                                    <input type="hidden" id="insapp_location_update_longitude" value="">
                              
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="card mb-4">
                    
                    <div class="card-body" style="min-height: 280px;">
                    
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <label class="form-label">
                                    
                                    <?php _e('Categorie','instant_Appointement') ?>
                                </label>
                            </div>
                            
                            <select class="form-select" id="insapp_update_category"
                                data-placeholder="Choisir une categorie " multiple>
                                <?php foreach($categories as $category){?>
                                <option date_id="<?php echo $category->term_id;?>" value="<?php echo $category->term_id ;?>">
                                    <?php echo $category->name ;?>
                                </option>
                                <?php } ?>
                            </select> 
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <label class="form-label">
                                    <?php _e('Sous categorie','instant_Appointement') ?>
                                </label>
                            </div>
                            <input type="hidden" value="" id="insapp_update_subcategory_list">
                            <div class="insapp_update_sous_category_html">
                            
                                    <ul class=" insapp-circle-check level-0" id="ia-subcategory-update-list">
                                    <?php 	
                                        if (!empty($listcategories) && !is_wp_error($listcategories)) {

                                            foreach($listcategories as $listcategory){
                                            
                                                $subcategories = get_terms( array(
                                                    'taxonomy' => 'product_cat',
                                                    'child_of' => $listcategory,
                                                    'hide_empty' => false, // Set to true if you want to hide empty subcategories
                                                ) );
                                                $i = 1;
                                                foreach($subcategories as $subcategory){?>
                                            

                                                    <li class="list-item level-0">
                                                        
                                                        <div class="form-check">
                                                            <input class="form-check-input insapp-list-update-sous-category" name=" insapp-list-update-sous-category"
                                                                type="checkbox" disabled value="<?php echo $subcategory->term_id;?>" id="">
                                                            <label class="form-check-label" for=" insapp-list-update-sous-category">
                                                                <?php echo $subcategory->name ;?>
                                                            </label>
                                                        </div>
                                                    </li>  
                                                <?php $i++; }
                                                } 
                                                
                                    
                                        } else {?>
                                            <option value="">Aucune sous categorie trouvé</option>
                                            <?php
                                        } ?>
                                    </ul>
                                    
                                </div>
                        </div>
                
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mt-3 table-responsive">
                            <table class="table table-bordered" style="border-color : #cbd5e1; border-raduis: 5px">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            <?php _e("Extra") ?>
                                        </th>
                                        <th class="text-center">
                                            <?php _e("Cout") ?>
                                        </th>
                                        <th class="text-center">
                                            <?php _e("Action") ?>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody id="tab_update_extra"></tbody>
                            </table>
                        </div>

                        <div class="col-5">
                            <label class="form-label">
                                <?php _e("Nom de l'extra") ?>
                            </label>
                            <input type="text" class="form-control" id="nom_extra_update" />
                        </div>

                        <div class="col-3">
                            <label class="form-label">
                                <?php _e("Cout de l'extra") ?>
                            </label>
                            <input type='number' class="form-control" id='cout_extra_update' />
                        </div>

                        <div class="col-4">
                            <br />
                            <a class="btn btn-success" id="btn_update_exta">
                                <?php _e("Ajouter") ?>
                            </a>
                        </div>

                    </div>
               </div>
            </div>
        </div>
        
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <div class="mb-4">
                <h5 class="mb-1">
                    <?php _e('Ajouter la photo principale.')?>
                </h5> 
                <div id="insapp_img_preview"></div>
                <input type="file" class="form-control" id="update_product_img" value="">
            </div>
            <input type="hidden" class="insapp_update_img_service_url" value="" />
            <div id="preview"></div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <div class="mb-4">
                <h5 class="mb-1">
                    <?php _e('Gallery')?>
                </h5> 

                <div id="dropzone">
                    <div class="dropzone needsclick" id="insapp-galerie-update-upload" action=" ">
                        <div class="dz-message needsclick">
                            Déposez vos fichiers ici ou cliquez pour les télécharger.<br>
                        </div>
                    </div>
                </div>

            </div>
            <input type="hidden" class="insapp_img_service_url" value="" />
            <div id="preview"></div>
        </div>
    </div>
                            

    <div class="row">
        <div class="card px-5">
            <div class="card-body">
                <input type="hidden" name="product_id" id="product_id">
                <div class="col-6">
                    <button type="submit" class="btn btn-primary insapp_update_service_btn" style="padding: 10px 40px;">
                         <?php _e('Modifier un offre')?>
                    </button>
                </div>

            </div>
        </div>
    </div>
</form>