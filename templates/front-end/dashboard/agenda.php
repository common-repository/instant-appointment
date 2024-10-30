<?php 

$current_user = wp_get_current_user();
$id_user = $current_user->ID;
$meta = get_user_meta( $current_user->ID );

$starthour = get_user_meta( $current_user->ID, 'starthour_default' , true );
$endhour = get_user_meta( $current_user->ID, 'endhour_default' , true );
$starthour2 = get_user_meta( $current_user->ID, 'starthour_default2' , true );
$endhour2 = get_user_meta( $current_user->ID, 'endhour_default2' , true );
$agenda = json_decode(get_user_meta( $current_user->ID, 'agenda_default' , true )) == NULL ? [''] : json_decode(get_user_meta( $current_user->ID, 'agenda_default' , true ));
 
$user_state = get_user_meta( $current_user->ID, '_state' , true );

?>

       <h3><?php _e('Agenda')?></h3>
       <?php
       if( $user_state != 'inactive'){

            if(in_array($role,array('administrator','insapp_photographe'))){
                if(empty($starthour) || empty($endhour) || empty($agenda)){ ?>
                    <p class="insapp_warning_b"><?php _e('Veuillez prendre quelques instants pour compléter vos disponibilités. Cela aidera vos clients à choisir des crénaux correspondant à votre disponibilté') ?></p>
                <?php  } 

            }
                
        } ?>
        


       <p class="insapp_info"></p>

         <div class="row ia_agenda_step">
             <div class=" offset-md-2 offset-1 col-md-8 col-10 mb-5">
                <!-- card -->
                <div class="card h-100"> 
                     <div class="card-body">
                         <div  class="insapp_notification_agenda" style="text-align: center;
                                margin-top: 30px;background-color: #ffcece;color: #f75555;font-weight: 600;
                                justify-content: center;min-height: 50px; align-items: center;display:
                                none; font-size: 14px;border-radius: 5px;">

                            </div>
                        
                            <div class="d-flex justify-content-center my-4">
                                    <div class="m-4">
                                        <h4 class="mb-0"> Definissez vos disponibilités  </h4>
                                    </div>
                            </div>

                            <div class="row g-2 mb-4">
                                
                            <h6 class="mb-3"><?php _e('Crénaux de disponibilité') ?></h6>
                                <div class="d-flex justify-content-evenly align-items-center">
                                    <div class="col-6 mb-0"> 
                                        <input type="time" id="textInput" class="form-control ia_time_start_step" value="<?php echo isset( $starthour) ? $starthour : '09:00' ?>">
                                    </div>
                                    <span class="">-</span>
                                    <div class="col-6 mb-0"> 
                                        <input type="time" id="textInput" class="form-control ia_time_end_step" value="<?php echo isset( $endhour) ? $endhour : '17:00' ?>" required>
                                    </div>
                            </div>
                                <div class="d-flex justify-content-evenly align-items-center">
                                    <div class="col-6 mb-0"> 
                                        <input type="time" id="textInput" class="form-control ia_time_start_step2" value="<?php echo isset( $starthour2) ? $starthour2 : '' ?>" required>
                                    </div>
                                    <span class=" ">-</span>
                                    <div class="col-6 mb-0"> 
                                        <input type="time" id="textInput" class="form-control ia_time_end_step2" value="<?php echo isset( $endhour2) ? $endhour2 : '' ?>" required>
                                    </div>
                                </div>

                            </div>
                    
                            <div class="mt-3 mb-6" id="ia_checkboxes">
                                <h6 class="mb-3"><?php _e('Jours disponibles') ?></h6>

                                <div class="d-flex justify-content-evenly align-items-center">
                        
                                    <div class="form-check d-flex align-items-center">
                                        <input class="form-check-input" type="checkbox" name="lundi" id="lundi" <?php echo in_array("lundi", $agenda) ? 'checked' : '' ?> >
                                        <label class="form-check-label" for="lundi">
                                        Lundi
                                        </label>
                                    </div>
                                    <div class="form-check d-flex ">
                                        <input class="form-check-input" type="checkbox" name="mardi" id="ia_mardi" <?php echo in_array("mardi", $agenda) ? 'checked' : '' ?> >
                                        <label class="form-check-label" for="ia_mardi">
                                        Mardi
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="mercredi" id="ia_mercredi" <?php echo in_array("mercredi", $agenda) ? 'checked' : '' ?> >
                                        <label class="form-check-label" for="ia_mercredi">
                                        Mercredi
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="jeudi" id="ia_jeudi" <?php echo in_array("jeudi", $agenda) ? 'checked' : '' ?> >
                                        <label class="form-check-label" for="ia_jeudi">
                                        Jeudi
                                        </label>
                                    </div>
                            </div>
                            <div class="d-flex justify-content-evenly  align-items-center pt-4">
                                
                                <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="vendredi" id="ia_vendredi" <?php echo in_array("vendredi", $agenda) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="ia_vendredi">
                                        Vendredi
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="samedi" id="ia_samedi" <?php echo in_array("samedi", $agenda) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="ia_samedi">
                                        Samedi
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="dimanche" id="ia_dimanche" <?php echo in_array("dimanche", $agenda) ? 'checked' : '' ?> >
                                        <label class="form-check-label" for="ia_dimanche">
                                        Dimanche
                                        </label>
                                    </div>
                                </div>

                            </div>
                     </div>
                   <!-- card footer -->
                  <div class="card-footer d-flex justify-content-end">
                         <button class="btn btn-primary ms-3 ia_calendar_step">suivant</button>
                         <button class="btn btn-primary ms-3 ia_save_new_agenda_calendar">Enregistrer</button>
                  </div>

                </div>
              </div>
         </div>
<?php


?>

   <div class="row"> 
       <div  class="insapp_notification_agenda" style="text-align: center;
            margin-top: 30px;background-color: #ffcece;color: #f75555;font-weight: 600;
            justify-content: center;min-height: 50px; align-items: center;display:
            none; font-size: 14px;border-radius: 5px;">

        </div>
        <input type="hidden" value="<?php _e($agenda_id_user) ?>" name="insapp_id_agenda_user" id="insapp_id_agenda_user">
        <div class="ia_calendar"> 
            <div class="insapp_loader_ajax_containeradmin " style=""> 
                <div class="insapp_loader_ajax"></div>
            </div>
         </div>    
         <!--<div class="ia_calendar_content" style=" ">  -->
             <div class="ia_calendar_block" id="insapp-calendar-agenda" ></div>
         <!--</div>     -->
     
        <div class="modal fade" id="insapp_creneauModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-modal="true" role="dialog" >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                    <span class="ia_table_title">Ajouter un intervalle de travail</span>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                    <form name="insapp_creneauForm" id="insapp_creneauForm" data-gtm-form-interact-id="0">
                            <div  >
                                <div class="row mb-5" >
                                    <div class="d-flex justify-content-evenly align-items-center">
                                        <div class="col-6 mb-0"> 
                                            <input type="time" id="textInput" class="form-control ia_time_start_new" value="">
                                        </div>
                                        <span>-</span>
                                        <div class="col-6 mb-0"> 
                                            <input type="time" id="textInput" class="form-control ia_time_end_new" value="">
                                        </div>
                                    </div>
                                </div>
                                
                                                    </div>
                                <div class="row my-5 g-1"> 
                                    <div class="col-4"></div>
                                    <div class="col-5 text-end">
                                        <button type="submit" class="btn btn-primary btn-md" id="insapp-add-new-event-btn">Ajouter un crenaux</button>
                                    </div> 
                                    <div class="col-3">
                                       <button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal">Fermer</button>
                                    </div> 
                                    <input type="hidden" id="event-id" name="eventid" value="2">
                                
                                </div>

                                            </form>
                
                    </div>
                </div>
            </div>
        </div>

     </div> 