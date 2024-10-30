<?php 

    $dashboard_page = get_option('insapp_settings_name')['Dashboard_page']; 
    $recaptcha_version = get_option('insapp_settings_name')['Parametre_recaptcha_version']; 
    $site_key = isset(get_option('insapp_settings_name')['Parametre_recaptcha_sitekey']) ? get_option('insapp_settings_name')['Parametre_recaptcha_sitekey'] : ''; 
 
    $current_user = wp_get_current_user();
    
    $private_policy_page = get_option('insapp_settings_name')['private_policy_page']; 
        
 ?>


<div class="insapp_login_container">
    <div class="insapp_login_content">
        <div class="insapp_title_text">
            <div class="title insapp_login">
                <?php _e('Connexion') ?>
            </div>
            <div class="title insapp_register">
                <?php _e('Inscriptions') ?>
            </div>
        </div>

        <div class="insapp_form_container">

            <div class="insapp_slide_controls">
                <input type="radio" name="insapp_slide" id="insapp_login" checked>
                <input type="radio" name="insapp_slide" id="insapp_register">
                <label for="insapp_login" class="insapp_slide insapp_login">Connexion</label>
                <label for="insapp_register" class="insapp_slide insapp_register">Inscription</label>
                <div class="insapp_slider_tab"></div>
            </div>

            <div class="insapp_form_inner">
                <form id="insapp_login_user_form" class="insapp_login"
                    action="<?php echo esc_url(get_permalink(get_option('insapp_settings_name')['Dashboard_page'])) ?>"
                    methode="post">
                    <div id="insapp_login_user" class="insapp_notification_sucess my-2" style="text-align: center;
                         margin-top: 30px; background-color: rgb(206 255 209); color: rgb(85 171 112); 
                         font-weight: 600; justify-content: center; min-height: 50px;
                          align-items: center; display: none; font-size: 14px; border-radius: 5px;">

                    </div>

                    <div class="field">
                        <input type="email" id="insapp_logname" placeholder="<?php _e('Email') ?>" required>
                    </div>
                    <div class="field">
                        <input type="password" id="insapp_log_password" placeholder="<?php _e('Password') ?>" required>
                    </div>
                     
                    <div class="pass-link "><a href="<?php echo esc_url( wp_lostpassword_url() ); ?>">
                            <?php _e('Mot de passe oublie?') ?>
                        </a></div>
                    <div class="field">
                        <div class="btn-layer"></div>
                        <button type="submit" class="insapp_btn" id="insapp_login_user">
                            <?php _e('Se connecter') ?>
                        </button>
                    </div>
                    <div class="insapp_signup_link">
                        <?php _e('Vous n\'avez pas de compte?') ?> <a href="">
                            <?php _e("S'inscrire") ?>
                        </a>
                    </div>
                    <div id="insapp_login_user" class="insapp_notification" style="text-align: center;
                    margin-top: 30px;background-color: #ffcece;color: #f75555;font-weight: 600;
                     justify-content: center;min-height: 50px; align-items: center;display:
                      none; font-size: 14px;border-radius: 5px;">

                    </div>
                </form>

                <form id="insapp_register_user_form" class="insapp_register"
                    action="<?php echo esc_url(get_permalink(get_option('insapp_settings_name')['Login_page'])); ?>"
                    methode="post">
                    <div id="insapp_login_user" class="insapp_notification_sucess my-3" style="text-align: center;
                         margin-top: 30px; background-color: rgb(206 255 209); color: rgb(85 171 112); 
                         font-weight: 600; justify-content: center; min-height: 50px;
                          align-items: center;  display: none; font-size: 14px; border-radius: 5px;">
                    </div>
                    <div class="insapp_group">
                        <div class=" insapp_btn_group" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="insapp-role" value="insapp_customers"
                            id="insapp-custumer-radio" autocomplete="off" checked>
                        <label class="btn btn-outl-pri" for="insapp-custumer-radio">
                               <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><style>svg{fill:#ed6f73}</style><path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464H398.7c-8.9-63.3-63.3-112-129-112H178.3c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3z"/></svg>

                             <?php _e( 'Client') ?>
                        </label>

                        <input type="radio" class="btn-check" name="insapp-role" value="insapp_photographe"
                            id="insapp-owner-radio" autocomplete="off">
                        <label class="btn btn-outl-pri" for="insapp-owner-radio"> 
                               <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><style>svg{fill:#ed6f73}</style><path d="M184 48H328c4.4 0 8 3.6 8 8V96H176V56c0-4.4 3.6-8 8-8zm-56 8V96H64C28.7 96 0 124.7 0 160v96H192 320 512V160c0-35.3-28.7-64-64-64H384V56c0-30.9-25.1-56-56-56H184c-30.9 0-56 25.1-56 56zM512 288H320v32c0 17.7-14.3 32-32 32H224c-17.7 0-32-14.3-32-32V288H0V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V288z"/></svg>

                             <?php _e('Photographe')?>
                        </label>

                    </div>

                    </div>
                    

                    <div class="field">
                        <input type="text" placeholder=" <?php _e('Nom') ?>" id="insapp_firstname" required>
                    </div>
                    <div class="field">
                        <input type="text" placeholder=" <?php _e('Prenom') ?>" id="insapp_lastname" required>
                    </div>
                    <div class="field">
                        <input type="email" placeholder=" <?php _e('Email') ?>" id="insapp_useremail" required>
                    </div>

                    <div class="field">
                        <input type="password" id="insapp_userpassword" placeholder="<?php _e('Mot de passe') ?>"
                            required>
                             <i class="bi bi-eye-slash insapp_pw_hide"></i>
                    </div>
                    <div class="field">
                        <input type="password" placeholder="<?php _e('Confirmer le mot passe')?>"
                            id="insapp_conf_userpassword" required>
                             <i class="bi bi-eye-slash insapp_pw_hide"></i>
                    </div> 
                    <?php
                        if($recaptcha_version == 'v2'){  $captcha = '';
                                $captcha2= ''; ?>
                    
                            <p class="form-row captcha_wrapper">
                                <div id="insapp-recaptcha" ></div>
                            </p> 
                            <?php 
                        }else if( $recaptcha_version == 'v3'){
                            $captcha2= 'g-recaptcha';
                            $captcha = 'data-sitekey='.$site_key.' data-callback="onSubmit" data-action="submit"' ?>
                                <div class="g-recaptcha" data-sitekey="<?php _e($site_key); ?>"></div>
                            
                            <input type="hidden" id="ia_captat_token3" name="ia_captat_token3"> 
                        <?php 
                            }else{ 
                            $captcha = '';
                                $captcha2= '';
                        } ?>

                        <p class="form-row py-3 insapp_checkbox_content">
                            <input type="checkbox" id="insapp_terms_and_conditions" name="insapp_terms_and_conditions" required >
                            <label for="insapp_terms_and_conditions" >J'accepte les <a href="<?php if( $private_policy_page ) {echo esc_url(get_permalink($private_policy_page));} ?>">conditions générales d'utilisations</a> </label>
                        </p>
        
                        <div class="field">
                            <div></div>
                            <button class="insapp_btn <?php _e($captcha2) ?>" <?php _e($captcha) ?>>
                                <?php _e("S'inscrire") ?>
                            </button>
                        </div>
    
                        <div id="insapp_register_user" class="insapp_notification" style="text-align: center;
                        margin-top: 30px;background-color: #ffcece;color: #f75555;font-weight: 600;
                            justify-content: center;align-items: center;display:
                            none; min-height: 50px;font-size: 14px;border-radius: 5px;">
    
                        </div>
    
                </form>

            </div>
        </div>
    </div>
</div>
