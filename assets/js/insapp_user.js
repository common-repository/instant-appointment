function operateFormatter(value, row, index) {
    console.log('totototo', row.id);
    return '<label class="insapp_toggle"><input id="insapp_toggleswitch" value="'+row.id+'" data-id="'+row.id+'" onclick="operateEvents(this, '+row.id+')" type="checkbox"><span class="insapp_roundbutton"></span></label>';
}

function operateEvents(elt, id) {

    etat = jQuery(elt).is(":checked")

        let data = {
            'action': 'ajax_insapp_toggleswitch_user',
            'book_id': id,
            'etat' : etat
        };
       
        jQuery.post(users_ajax.ajaxurl,data,function(response){
            console.log(response);
           
            if( response.code == 200){
               
                $.toast({
                    heading: 'success',
                    text: response.message,
                    showHideTransition: 'plain',
                    position: 'top-right',
                    icon: 'success',
                    hideAfter: 5000,

                });      
                 location.reload()     ;           
            }else{ 
                $.toast({
                    heading: 'error',
                    text: response.message,
                    showHideTransition: 'plain',
                    position: 'top-right',
                    icon: 'error',
                    hideAfter: 10000,
                });

            }
            
        }) 
}

function operateOrders(elt, id) {

    etat = jQuery(elt).is(":checked")

        let data = {
            'action': 'ajax_insapp_toggleswitch_order',
            'book_id': id,
            'etat' : etat
        };
       
        console.log(data);

        jQuery.post(users_ajax.ajaxurl,data,function(response){
            console.log(response);
           
            if( response.code == 200){
                $.toast({
                    heading: 'success',
                    text: response.message,
                    showHideTransition: 'plain',
                    position: 'top-right',
                    icon: 'success',
                    hideAfter: 5000,

                }); 
                 location.reload();           
            }else{
                $.toast({
                    heading: 'error',
                    text: response.message,
                    showHideTransition: 'plain',
                    position: 'top-right',
                    icon: 'error',
                    hideAfter: 10000,
                });

            }
            
        }) 
}

jQuery(document).ready(function ($) {

    $('#yourTable').bootstrapTable();

});
