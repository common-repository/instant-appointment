<?php
$current_user = wp_get_current_user(); 
$user_info = get_userdata($current_user->ID); 

$meta = get_user_meta( $current_user->ID );
$first_name = $user_info->first_name;
$last_name = $user_info->last_name; 
$user_mail = $user_info->user_email;
$pseudo = $user_info->user_nicename;
$user_img = $user_info->user_url;
$user_phone = get_user_meta( $current_user->ID, 'telephone' , true );
$user_adresse = get_user_meta( $current_user->ID, 'adresse' , true );
$user_description = get_user_meta( $current_user->ID, '_description' , true );
$user_state = get_user_meta( $current_user->ID, '_state' , true );
$user_facebook = get_user_meta( $current_user->ID, 'facebook' , true );
$user_twitter= get_user_meta( $current_user->ID, 'twitter' , true );
$user_instagram = get_user_meta( $current_user->ID, 'instagram' , true );
$user_linkedln = get_user_meta( $current_user->ID, 'linkedln' , true );
 
$roles = $current_user->roles;
$role = array_shift( $roles );  

$user_profil_category = get_user_meta( $current_user->ID, 'category' , true );
$user_profil_category  = json_decode($user_profil_category );

$user_profil_medium = get_user_meta( $current_user->ID, '_medium' , true );
$user_profil_medium  = json_decode($user_profil_medium );
 
$avatar_url = get_avatar_url( $current_user->ID );
$user_id = get_current_user_id(); 
$profile_photo_url = get_user_meta($user_id, 'wp_user_avatar', true);

$args = array('taxonomy'   => "product_cat",'parent'=> 0,'hide_empty'=> false);
$categories = get_terms( $args); 

if ($profile_photo_url) {
  $user_img = $profile_photo_url;
} else {
  // Display a default avatar image if the user does not have a profile photo
  $user_img =  TLPLUGIN_DEFAULT. '/avatar-fallback.jpg';
}

$mediums = get_terms(
	 array(
    'taxonomy'   => 'service', 
	'hide_empty' => false 
	) 
); 

?>
<div class="container-fluid">

    <div class="row">
      <h3 class="text-dark mt-5">
        <?php _e('Mon Profil') ?>
      </h3>
    </div>
    
    <?php
        if( $user_state != 'inactive'){
            if(in_array($role,array('administrator','insapp_photographe'))){
                if($user_profil_category == '' || $user_adresse == '' || $user_description == ''|| $user_phone == '' || $first_name == '' || $last_name == '' || $user_mail == '' ){ ?>
                    <p class="insapp_info_b"><?php _e('Veuillez compléter les champs de votre profil ces informations sont importantes') ?></p>
                <?php }

            }else{
                    if($user_phone == '' || $first_name == '' || $last_name == '' || $user_mail == '' ){ ?>
                        <p class="insapp_info_b"><?php _e('Veuillez compléter les champs de votre profil ces informations sont importantes') ?></p>
                <?php } 
            } 
          } ?>

    <div class="row mt-5">
      <div class="col-12">

        <div class="card">
          <div class="insapp_notification_user_profil"
            style="text-align: center; margin-top: 30px;background-color: #ffcece;color: #f75555;font-weight: 600; justify-content: center;align-items: center;display: none; min-height: 50px;font-size: 14px;border-radius: 5px;">
          </div>

          <div class="card-body">
            <div class="mb-6  d-flex justify-content-between">
              <h4 class="mb-1">
                <?php _e('Informations de base')?>
              </h4>
              
              <div>
                    <a href="<?php _e(get_author_posts_url($current_user->ID)); ?>" class="btn btn-outline-primary d-block" >
                         <?php _e( 'Voir ma page'); ?>
                    </a>
              </div>
            </div>

            <form class="insapp_profile_form" action="">


              <div class="mb-3 row">
                <label for="email" class="col-sm-4 col-form-label
                                form-label">
                  <?php _e('Photo de profil')?>
                </label>
                <div class="col-md-8 col-12">
                  <div class="d-flex align-items-center mb-4">
                    <div>
                      <img class="image  avatar avatar-lg rounded-circle" id="user_pic" src="<?php echo $user_img ?>"
                        alt="Image">
                    </div>

                    <div class="file-upload btn btn-outline-white ms-4">
                      <input type="file" class="file-input opacity-0 " data_url="<?php _e($user_img) ?>"
                        id="user_pic_input">
                      <?php _e('Choisir la photo')?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="mb-3 row">
                <label for="fullName" class="col-sm-4 col-form-label form-label">
                  <?php _e('Pseudo')?>
                </label>
                <div class="col-sm-4 mb-3 mb-lg-0">
                  <input type="text" class="form-control" placeholder="Pseudo" value="<?php _e($pseudo) ?>"
                    id="insapp_pseudo" required="">
                </div> 
              </div>
              <div class="mb-3 row">
                <label for="fullName" class="col-sm-4 col-form-label
                                form-label">
                  <?php _e('Nom et prénom')?>
                </label>
                <div class="col-sm-4 mb-3 mb-lg-0">
                  <input type="text" class="form-control" placeholder="Prénom" value="<?php _e($last_name) ?>"
                    id="insapp_firstName" required="">
                </div>
                <div class="col-sm-4">
                  <input type="text" class="form-control" placeholder="Nom" value="<?php _e($first_name) ?>"
                    id="insapp_lastName" required="">
                </div>
              </div>
              <div class="mb-3 row">
                <label for="email" class="col-sm-4 col-form-label
                                form-label">
                  <?php _e('E-mail')?>
                </label>
                <div class="col-md-8 col-12">
                  <input type="email" class="form-control" placeholder="E-mail" value="<?php _e($user_mail) ?>"
                    id="insapp_useremail" required="">
                </div>
              </div>
              <div class="mb-3 row">
                <label for="phone" class="col-sm-4 col-form-label
                                form-label">
                  <?php _e('Téléphone ')?><span class="text-muted"></span>
                </label>
                <div class="col-md-8 col-12">
                  <input type="tel" class="form-control ib_confirme" placeholder="Téléphone" id="insapp_userphone"
                    name="insapp_userphone" value="<?php _e($user_phone) ?>">
                  <div id="phone_error"></div>
                </div>
              </div>

              <div class="row align-items-center">
                <div class="offset-md-4 col-md-8 mt-4">
                  <button type="submit" class="btn btn-primary user_update_profile_btn">
                    <?php _e('Sauvegarder les modifications')?>
                  </button>
                </div>
              </div>
            </form>

          </div>
        </div>
      </div> 
    </div>
    <?php if(in_array($role,array('administrator','insapp_photographe'))){ ?>
      <div class="row mt-5">
          <div class="col-12">

            <div class="card">
              <div class="insapp_notification_user_profil"
                style="text-align: center;    margin: 30px 20px 0;background-color: #ffcece;color: #f75555;font-weight: 600; justify-content: center;align-items: center;display: none; min-height: 50px;font-size: 14px;border-radius: 5px;">
              </div>

              <div class="card-body">
                <div class="mb-6">
                  <h4 class="mb-1">
                    <?php _e('Informations Avancés')?>
                  </h4>
                 
                </div>
          
                  
                <form class="insapp_profile_advanced_form" action="">
              
                      <div class="mb-3 row">
                        <label for="addressLine" class="col-sm-4 col-form-label form-label">Localisation</label>
                        <div class="col-md-8 col-12">
 
                            <input type="text" name="ia-filter-lieu" class="ia-filter-lieu" value="<?php echo !empty($user_adresse)? $user_adresse :'' ?>"
							id="ia-filter-lieu" placeholder=""<?php _e(" Entrez votre ville ou localisation","instant_Appointement") ?>">
							
						    	<input type="hidden" id="ia-filter-lieu_latitude" value="">
						    	<input type="hidden" id="ia-filter-lieu_longitude" value="">
							  <input type="hidden" id="ib-radius" name="radius" value="">
							   
                          </div>
                      </div>
                      <div class="mb-3 row">
                     
                            <label class="col-sm-4 form-label"> <?php _e('Service','instant_Appointement') ?></label> 
                            <div class="col-md-8 col-12">
                              <select class="form-select" id="insapp_profil_medium" require data-placeholder="Choisir vos mediums " multiple>
                                  <?php 
                                  
                                    if (!empty($mediums) && !is_wp_error($mediums)) {
                                        
                                          foreach($mediums as $medium){
                                              
                                            $selected = isset($user_profil_medium) && in_array( $medium->term_id, $user_profil_medium) ? "selected" : '';
                                            ?>
                                              <option <?php _e($selected) ?> value="<?php echo $medium->term_id ;?>">
                                                  <?php echo $medium->name ;?>
                                              </option>
                                          <?php } 
                                    } ?>
                              </select> 
                          </div>
                      </div>
                      <div class="mb-3 row">
                     
                            <label class="col-sm-4 form-label"> <?php _e('Categorie','instant_Appointement') ?></label> 
                            <div class="col-md-8 col-12">
                              <select class="form-select" id="insapp_profil_category" require
                                  data-placeholder="Choisir une categorie " multiple>
                                  <?php 
                                  
                                    if (!empty($categories) && !is_wp_error($categories)) {
                                        
                                          foreach($categories as $category){
                                              
                                            $selected = isset($user_profil_category) && in_array( $category->term_id, $user_profil_category) ? "selected" : '';
                                            ?>
                                              <option <?php _e($selected) ?> value="<?php echo $category->term_id ;?>">
                                                  <?php echo $category->name ;?>
                                              </option>
                                          <?php } 
                                    } ?>
                              </select> 
                          </div>
                      </div>

                      <div class="mb-3 row">
                        <label for="description" class="col-sm-4 col-form-label form-label">
                          <?php _e('Bio')?>
                        </label>
                        <div class="col-md-8 col-12">
                          <textarea id="insapp_user_description" class="form-control" value=""  maxlength="1500" cols="30" rows="10"><?php _e($user_description) ?></textarea>
                        
                        </div>
                      </div>
                      
                      <div class="mb-3 row">
                        <label for="phone" class="col-sm-4 col-form-label
                                        form-label">
                          <?php _e('Réseaux Sociaux ')?><small class="text-muted"><?php _e('(Informations réservées à l’administrateur)') ?></small>
                        </label>
                        <div class="col-md-8 col-12">
                            <div class="col-md-12 col-12 py-2">
                            
                              <input type="url" class="form-control ib_confirme" placeholder="Facebook" id="insapp_userfacebook"
                                name="insapp_userfacebook" value="<?php _e($user_facebook) ?>">
                              <div id="phone_error"></div>
                            </div>
                            <div class="col-md-12 col-12  py-2">
                              <input type="url" class="form-control ib_confirme" placeholder="Twitter" id="insapp_usertwitter"
                                name="insapp_usertwitter" value="<?php _e($user_twitter) ?>">
                              <div id="phone_error"></div>
                            </div>
                            <div class="col-md-12 col-12  py-2">
                              <input type="url" class="form-control ib_confirme" placeholder="Instagram" id="insapp_userinstagram"
                                name="insapp_userinstagram" value="<?php _e($user_instagram) ?>">
                              <div id="phone_error"></div>
                            </div>
                            <div class="col-md-12 col-12 py-2">
                              <input type="url" class="form-control ib_confirme" placeholder="LinkedLn" id="insapp_userlinkedln"
                                name="insapp_userlinkedIn" value="<?php _e($user_linkedln) ?>">
                              <div id="phone_error"></div>
                            </div>
                        </div>
                    
                      </div>
            

                  <div class="row align-items-center">
                    <div class="offset-md-4 col-md-8 mt-4">
                      <button type="submit" class="btn btn-primary user_update_profile_avance_btn">
                        <?php _e('Sauvegarder les modifications')?>
                      </button>
                    </div>
                  </div>
                </form>
              
              </div>
            </div>

          </div>

      </div>
      <?php } ?>
    <div class="row mt-5">
      <div class="col-12">

        <div class="card" id="edit">

          <div class="card-body">

            <div class="insapp_notification_user_password"
              style="text-align: center;     margin: 30px 20px 0;background-color: #ffcece;color: #f75555;font-weight: 600; justify-content: center;align-items: center;display: none; min-height: 50px;font-size: 14px;border-radius: 5px;">
            </div>

            <div class="mb-6 mt-6">
              <h4 class="mb-1">
                <?php _e('Changez votre mot de passe')?>
              </h4>
            </div>

            <form class="insapp_password_form" action="">
              <div class="mb-3 row">
                <label for="currentPassword" class="col-sm-4
                                  col-form-label form-label">
                  <?php _e('Mot de passe actuel')?>
                </label>

                <div class="col-md-8 col-12">
                  <input type="password" class="form-control" placeholder="Entrer le mot de passe actuel"
                    id="insappcurrentPassword" required="">
                </div>
              </div>
              <div class="mb-3 row">
                <label for="currentNewPassword" class="col-sm-4
                                  col-form-label form-label">
                  <?php _e('Nouveau mot de passe')?>
                </label>

                <div class="col-md-8 col-12">
                  <input type="password" class="form-control" placeholder="Entrez un nouveau mot de passe"
                    id="insappcurrentNewPassword" required="">
                </div>
              </div>
              <div class="row align-items-center">
                <label for="confirmNewpassword" class="col-sm-4
                                  col-form-label form-label">
                  <?php _e('Confirmer le nouveau mot de passe')?>
                </label>
                <div class="col-md-8 col-12 mb-2 mb-lg-0">
                  <input type="password" class="form-control" placeholder="Confirmer le nouveau mot de passe"
                    id="insappconfirmNewpassword" required="">
                </div>
            
                <div class="offset-md-4 col-md-8 col-12 mt-4">
                  <h6 class="mb-1">
                    <?php _e('Exigences relatives au mot de passe')?>&nbsp;:
                  </h6>
                  <p>
                    <?php _e('Assurez-vous que ces exigences sont remplies')?>&nbsp;:
                  </p>
                  <ul>
                    <li>
                      <?php _e("Minimum 8 caractères de long, plus il y en a, mieux c'est")?>
                    </li>
                  </ul>
                  <button type="submit" class="btn btn-primary user_update_password_btn">
                    <?php _e('Sauvegarder les modifications')?>
                  </button>
                </div>
              </div>
            </form>

          </div>

        </div>

      </div>
    </div>
      <?php if(in_array($role,array('administrator','insapp_photographe'))){ ?>
    <div class="row mt-5">
      <div class="col-12">

        <div class="card" id="edit">

          <div class="card-body">

                <div class="insapp_notification_user_gallery"
                  style="text-align: center;    margin: 30px 20px 0;background-color: #ffcece;color: #f75555;font-weight: 600; justify-content: center;align-items: center;display: none; min-height: 50px;font-size: 14px;border-radius: 5px;">
                </div>
                <div class="mb-4">
                    <h5 class="mb-1">
                        <?php _e('Gallery')?> (Maximum 10 fichiers avec une taille maximum de 2mo)
                    </h5> 
    
                    <div id="dropzone">
                        <div class="dropzone needsclick" id="insapp-galerie-vendor-profil" action=" ">
                            <div class="dz-message needsclick">
                                Déposez vos fichiers ici ou cliquez pour les télécharger.<br>
                            </div>
                        </div>
                    </div>
    
                </div>
                 <form class="insapp_vendor_update_galerie" action="">
                    <button type="submit" class="btn btn-primary insapp_vendor_update_galerie_btn">
                        <?php _e('Sauvegarder les modifications')?>
                     </button>
                </form>
          </div>

        </div>

      </div>
    </div>
    <?php } ?>
 
</div> 