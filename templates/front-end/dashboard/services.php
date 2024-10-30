<?php
;
    $current_user = wp_get_current_user();
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
?>
      
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12 mt-5">

            <div class="my-5">
                <h3 class="mt-5">
                    <?php _e('Ajouter une offre','instant_Appointement') ?>
                </h3>
            </div>
        </div>
    </div>

    <form action="" class="insapp_register_service">
        <div class="row">
            <div class="col-md-12 col-12">
            
                <div class="card mb-4">
                
                    <div class="card-body">
                        <div class="mb-5 col-lg-12 col-12 ">
                            <label for="insapp_service_name" class="form-label">
                                <?php _e("Nom","instant_Appointement") ?>
                            </label>
                            <input type="text" id="insapp_service_name" class="form-control" placeholder="<?php _e(" Entrez le nom d'une offre","instant_Appointement") ?>"
                            ="" />
                        </div>

                        <div class="mb-5 col-lg-12 col-12">
                            <label class="form-label">
                                <?php _e("Description","instant_Appointement") ?>
                            </label>

                            <div class="pb-8 ql-container ql-snow" id="insapp_service_editor">
                                <div class="ql-editor ql-blank" data-gramm="false" contenteditable="true">
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
                                <input type="text" class="form-control" id="insapp_price_reg" required placeholder="49.00 <?php echo get_woocommerce_currency_symbol() ;?>" />
                            </div>
                        
                            <div class="mb-3">
                                <label class="form-label">
                                    <?php _e('Prix promotionnel','instant_Appointement') ?>
                                </label>
                                <input type="text" class="form-control" id="insapp_price_sale" placeholder="49.00 <?php echo get_woocommerce_currency_symbol() ;?>"/>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">
                                    <?php _e('Durée du service','instant_Appointement') ?>
                                </label>
                                <input name='insapp_duree' id="insapp_duree" type="time" required class="form-control"
                                    placeholder='<?php _e(" Choisir la durée du service","instant_Appointement") ?>'
                                        />

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
                                                        <input class="form-check-input insapp-list-medium"  name=" "
                                                            type="checkbox" value="<?php _e($medium->term_id) ?>" id="list_medium">
                                                        <label class="form-check-label"
                                                            for="list_medium">
                                                            <?php _e($medium->name) ?>
                                                        </label>
                                                    </div>
                                                </li>  
                                                
                                            <?php }
                                        } else {
                                            echo 'Aucun service trouvé.';
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
                                                        <input class="form-check-input insapp-list-tag"  name="filter-feature[]"
                                                            type="checkbox" value="<?php _e($tag->term_id) ?>" id="filter-feature-bike-parking-49327">
                                                        <label class="form-check-label"
                                                            for="filter-feature-bike-parking-49327">
                                                            <?php _e($tag->name) ?>
                                                        </label>
                                                    </div>
                                                </li>  
                                            <?php }
                                        } else {
                                            echo 'Aucun etiquette trouvé.';
                                        } ?> 
                                </ul>
                                <div class="mb-5 col-lg-12 col-12 ">
                                    <label for="insapp_annonce_city_input" class="form-label">
                                        <?php _e("Localisation","instant_Appointement") ?>
                                    </label>
                                    <input type="text" id="insapp_annonce_city_input" required class="form-control" placeholder="<?php _e(" Entrez votre ville ou localisation","instant_Appointement") ?>"/>
                                 <div id="insapp_location_check" class="insapp_notification" style="text-align: center;margin-top: 30px;background-color: #ffcece;color: #f75555;font-weight: 600;justify-content: center;min-height: 50px; align-items: center;display:none; font-size: 14px;border-radius: 5px;"></div>
                                </div>
                                     <input type="hidden" id="insapp_location_latitude" value="">
                                    <input type="hidden" id="insapp_location_longitude" value="">
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
                                
                                <select class="form-select" id="insapp_category"
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
                                <div class="insapp_sous_category_html">
                                
                                        <ul class=" insapp-circle-check level-0" id="ia-subcategory-list">
                                        <?php 	
                                            if (!empty($listcategories) && !is_wp_error($listcategories)) {

                                                foreach($listcategories as $listcategory){
                                                
                                                    $subcategories = get_terms( array(
                                                        'taxonomy' => 'product_cat',
                                                        'child_of' => $listcategory,
                                                        'hide_empty' => false, // Set to true if you want to hide empty subcategories
                                                    ) );
                                                    $i = 1;
                                                      if (!empty($subcategories) && !is_wp_error($subcategories)) {
                                                          
                                                        foreach($subcategories as $subcategory){
                                                          ?>
                                                       
                                                            <li class="list-item level-0">
                                                                
                                                                <div class="form-check">
                                                                    <input class="form-check-input insapp-list-sous-category" name="insapp-list-sous-category<?php _e($i);?>"
                                                                        type="checkbox" disabled value="<?php echo $subcategory->term_id;?>" id="insapp-list-sous-category<?php _e($i); ?>">
                                                                    <label class="form-check-label" for="insapp-list-sous-category<?php _e($i); ?>">
                                                                        <?php echo $subcategory->name ;?>
                                                                    </label>
                                                                </div>
                                                            </li>  
                                                        
                                                      <?php } $i++; }
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
            <div class="row ">
                <div class="card mb-4">
                    <div class="card-body">
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

                                <tbody id="tab_extra"></tbody>
                            </table>
                        </div>
                    </div>
                
                    <div class="card-body">
                    <div class="row">
                            <div class="col-5">
                                <label class="form-label">
                                    <?php _e("Nom de l'extra") ?>
                                </label>
                                <input type="text" class="form-control" id="nom_extra" />
                            </div>

                            <div class="col-3">
                                <label class="form-label">
                                    <?php _e("Cout de l'extra") ?>
                                </label>
                                <input type='number' class="form-control" id='cout_extra' />
                            </div>

                            <div class="col-4">
                                <br />
                                <a class="btn btn-primary" id="btn_addM">
                                    <?php _e(" + Ajouter") ?>
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
                    <input type="file" class="form-control" id="product_img" required>
                </div>
                <input type="hidden" class="insapp_img_service_url" value="" />
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
                        <div class="dropzone needsclick" id="insapp-galerie-upload" action=" ">
                            <div class="dz-message needsclick">
                                Déposez vos fichiers ici ou cliquez pour les télécharger.<br>
                            </div>
                        </div>
                    </div>
                    <div id="preview-template" style="display: none;">
                        <div class="dz-preview dz-file-preview">
                            <div class="dz-image"><IMG data-dz-thumbnail=""></div>
                            <div class="dz-details">
                                <div class="dz-size"><SPAN data-dz-size=""></SPAN></div>
                                <div class="dz-filename"><SPAN data-dz-name=""></SPAN></div>
                            </div>
                            <div class="dz-progress"><SPAN class="dz-upload" data-dz-uploadprogress=""></SPAN></div>
                            <div class="dz-error-message"><SPAN data-dz-errormessage=""></SPAN></div>
                            <div class="dz-success-mark">
                                <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                    <title>Check</title>
                                    <desc>Created with Sketch.</desc>
                                    <defs></defs>
                                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                        <path
                                            d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z"
                                            id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475"
                                            fill="#FFFFFF" sketch:type="MSShapeGroup"></path>
                                    </g>
                                </svg>
                            </div>
                            <div class="dz-error-mark">
                                <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                    <title>error</title>
                                    <desc>Created with Sketch.</desc>
                                    <defs></defs>
                                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                        <g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474" stroke-opacity="0.198794158"
                                            fill="#FFFFFF" fill-opacity="0.816519475">
                                            <path
                                                d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z"
                                                id="Oval-2" sketch:type="MSShapeGroup"></path>
                                        </g>
                                    </g>
                                </svg>
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

                    <div class="col-12">
                        <p class="insapp_register_service_info">
                            <?php echo 'Veuillez patienter cela prendra un peu de temps...'; ?>
                        </p>
                        <button type="submit" class="btn btn-primary insapp_register_service_btn"
                            style="padding: 10px 40px;">
                            <?php echo 'Créer une offre'; ?>
                            <span class="insapp_loader_ajax_btn" ></span>
                       </button>
                    </div>

                </div>
            </div>
        </div>
    </form> 