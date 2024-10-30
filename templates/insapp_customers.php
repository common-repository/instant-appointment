
<!-- 
/*********************************************************************
***********            Show customers                  **************
***************************************************************/ -->


<div class="insapp_body_wrapper ">
        <div class="row mt-5">

			<h2 class="text-dark mt-5">
				<?php _e('Liste des Clients') ?>
			</h2>
		</div>
 
      <div class="table-responsive pt-3 insapp_body_content ">
        <table class="table table-bordered table-hover" id="inaspp_table" 
           
        data-search="true" 
            data-pagination="true"
            data-show-columns="true"
            data-show-pagination-switch="true"
            data-show-refresh="true"
            data-buttons-align="left"
            data-show-toggle="true" 
            data-resizable="true" 
            data-buttons-class="primary"
            data-show-export="true"
            data-toggle="table"
            data-locale="fr-FR">
          <thead>
          <tr>
                <th data-field="state" data-checkbox="true"></th>
                <th data-field="id">ID</th>
                <th data-field="Date" ><?php _e('Date')  ?></th>
                <th data-field="informations" ><?php _e('Informations')  ?></th>  
                <th data-field="etat"><?php _e('Etat')  ?></th> 
            </tr>
          </thead>
          <tbody>
          <?php
         
                
                $blogusers = get_users( array( 'role__in' => array( 'insapp_customers' ) ,'orderby' => 'registered',
                'order' => 'DESC',) );
                $i=0; 
                    foreach ( $blogusers as $user ) {
                        $ID = $user->ID;    

                        if(esc_url( $user->user_url ) != null) {
                            $insapp_url = esc_url( $user->user_url ) ;
                        }else {
                            $insapp_url = TLPLUGIN_URL.'/assets/images/avatar-fallback.jpg';
                        }
                        
                        $registration_date = $user->user_registered;
                        $profile_photo_url = get_user_meta( $ID, 'wp_user_avatar', true); 

                        if ($profile_photo_url) {
                        $user_img = $profile_photo_url;
                        } else {
                        // Display a default avatar image if the user does not have a profile photo
                        $user_img =  TLPLUGIN_DEFAULT. '/avatar-fallback.jpg';
                        }

                        $user_info = get_userdata($ID); 
                        $first_name = $user_info->first_name;
                        $last_name = $user_info->last_name; 
                        $user_mail = $user_info->user_email; 

                        $user_phone = get_user_meta( $ID, 'telephone' , true ); 
                        $user_description = get_user_meta( $ID, '_description' , true );
                        $user_state = get_user_meta( $ID, '_state' , true );
                    

        ?>
        
            <tr>
               <td></td>
                <td><?php echo $ID ?></td>    
                <td>
                  <div class="ib_date_create"> 
                    <?php echo $registration_date?>
                  </div>
                </td>  
                <td>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex insapp_user_card">
                            <div class="circle_image"><img src="<?php echo $user_img;?>"></div>
                            <div class="user_details">
                                <span><?php echo $first_name ?> <?php echo $last_name ?> </span> 
                                <span> <?php echo $user_mail?> </span>
                                <span><?php echo  $user_phone;?></span>
                            </div>
                        </div>
                    </div>
                </td> 
               
              
                <td>
                    <label class="insapp_toggle">
                        <?php $active = $user_state == "active" ? "checked" : '' ?>
                        <input id="insapp_toggleswitch" <?php _e($active) ?> value="<?php _e($ID) ?>" onclick="operateEvents(this, '<?php _e($ID) ?>')" type="checkbox">
                        <span class="insapp_roundbutton"></span>
                   </label>
                </td> 
            </tr>
            
        <?php }?>
        
          </tbody>
        </table>
        
      </div>
    </div>