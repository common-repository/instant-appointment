<div class="container row d-flex flex-wrap  justify-content-between" >
    <form action="post" class="form-control">
        <div class="col-6 py-2 px-5">
            <label for="insapp_service_price" class="form-label"><?php _e( "Prix du service" ); ?></label> 
            <input type="number" id="insapp_service_price" class="form-control" name="insapp_service_price" value="<?php _e( $service_price ) ?>" size="25" />
        </div>
        <div class="col-6 py-2 px-5">
            <label for="insapp_service_cap" class="form-label"><?php _e( "Nombre de personnes autorisees a prendre part au service" ); ?></label> 
            <input type="number" id="insapp_service_cap" class="form-control" name="insapp_service_cap" value="<?php  _e( $service_cap ) ?>" size="25" />
        </div>
        <div class="col-6 py-2 px-5">
            <label for="insapp_service_time" class="form-label"><?php _e( "Duree du service" ); ?></label>
            <input type="time" id="insapp_service_time" class="form-control" name="insapp_service_time" value="<?php  _e( $service_time ) ?>" size="25" >
        </div>
        <div class="col-6 py-2 px-5">
            <label for="insapp_service_freq" class="form-label"><?php _e( "Frequence du service" ); ?></label>
            <select name="insapp_service_freq" id="insapp_service_freq" class="form-control">
                <option value="<?php  _e( 'Journalier' ) ?>"><?php  _e( 'Journalier' ) ?></option>
                <option value="<?php  _e( 'Mensuel' ) ?>"><?php  _e( 'Mensuel' ) ?></option>
                <option value="<?php  _e( 'Annuel' ) ?>"><?php  _e( 'Annuel' ) ?></option>
            </select>
        </div>
    </form>
</div>
