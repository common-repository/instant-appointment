<div class="container row d-flex flex-wrap  justify-content-between" >
    <form action="post" class="form-control">
        <div class="col-6 py-2 px-5">
            <label for="insapp_price_event" class="form-label"><?php _e( "Cout de l'evenement" ); ?></label> 
            <input type="number" id="insapp_price_event" class="form-control" name="insapp_price_event" value="<?php _e( $e_price_event ) ?>" size="25" />
        </div>
        <div class="col-6 py-2 px-5">
            <label for="insapp_nbr_participant" class="form-label"><?php _e( "Nombre de participants a l'evenement" ); ?></label> 
            <input type="number" id="insapp_nbr_participant" class="form-control" name="insapp_nbr_participant" value="<?php  _e( $e_nbr_participant ) ?>" size="25" />
        </div>
        <div class="col-6 py-2 px-5">
            <label for="insapp_started_date" class="form-label"><?php _e( "Date de debut de l'evenement" ); ?></label>
            <input type="date" id="insapp_started_date" class="form-control" name="insapp_started_date" value="<?php  _e( $e_started_date ) ?>" size="25" >
        </div>
        <div class="col-6 py-2 px-5">
            <label for="insapp_end_date" class="form-label"><?php _e( "Date de fin de l'evenement" ); ?></label>
            <input type="date" id="insapp_end_date" class="form-control" name="insapp_end_date" value="<?php  _e( $e_end_date ) ?>" size="25" >
        </div>

        <?php 
        $status = array(
            'select1' => 'En attente',
            'select1' => 'Validé',
            'select1' => 'Rejeté',
         );
        ?>


        <div class="col-6 py-2 px-5">
            <label for="insapp_statut_event" class="form-label"><?php _e( "Statut de l'evenement" ); ?></label>
            <select id="insapp_statut_event" name="insapp_statut_event" class="form-control">
                <option value="<?php  _e('Attente') ?>" <?php selected( $e_statut_event, 'Attente' ); ?> > En attente</option>
                <option value="<?php  _e('Validé' ) ?>" <?php selected( $e_statut_event, 'Validé'); ?> >Validé</option>
                <option value="<?php  _e('Rejeté' ) ?>"  <?php selected( $e_statut_event, 'Rejeté' ); ?> >Rejeté</option>+
            </select>
        </div>
    </form>
</div>
