<?php $args = array('taxonomy' => "product_cat",'parent'=> 0,'hide_empty'=> false);
$categories = get_terms( $args);
$listcategories = [];
foreach ( $categories as $category ) {
array_push( $listcategories, $category->term_id);
}
 
?>
<div class="insappp_container_search_container">
        <div class="col-md-12">
        <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>annonce">
   
            <form action="" class="">
            <div class="main-search-input">
                <div class="main-search-input-item text">
                    <div class=" ">
                        <input type="text" class="keyword_search search-field" placeholder="Que cherches-tu?"  value="<?php echo get_search_query(); ?>" name="s" >
                    </div>
                </div>
                <div class="main-search-input-item ia_element_search">
                    <div class=" ">
                        <div> 
                            <select name="category" class="form-select" value="<?php echo get_search_query(); ?>"
                                data-placeholder="Categorie" tabindex="-1" aria-hidden="true">
                                <option value="0">Categories</option>
                                <?php 
                                if (!empty($categories) && !is_wp_error($categories)) {
                                    foreach($categories as $category){?>
                                        <option value="<?php echo $category->term_id ;?>">
                                            <?php echo $category->name ;?>
                                        </option>
                                <?php } 
                                    } else {?>
                                        <option value="">Aucune categorie trouvé
                                    </option>
                                        <?php
                                    }
                                ?> 
                            </select>
                        </div>
                    </div>
                </div>
               <div class="main-search-input-item select-taxonomy">
                    <div class=" "> 
                      
                        <input type="text" name="localisation" class="ia-filter-lieu" value="<?php echo get_search_query(); ?>"
							id="ia-filter-lieu" placeholder="Lieu">
							<input type="hidden"  name="latitude" id="ia-filter-lieu_latitude" value="<?php echo get_search_query(); ?>">
							<input type="hidden"  name="longitude" id="ia-filter-lieu_longitude" value="<?php echo get_search_query(); ?>">
                    </div>
                </div>
                <div class="main-search-input-item text"> 
                    
                    <div class="input-group me-3 d-flex justify-content-center " readonly="readonly">
                        <input class=" insapp_search_date" type="text"placeholder="Date" name="date-range"  value="<?php echo get_search_query(); ?>" >
                    </div>

                </div>
              
                <button type="submit" class="button search-submit">Chercher</button>
               
            </div>
            </form>
        </div>
    </div>