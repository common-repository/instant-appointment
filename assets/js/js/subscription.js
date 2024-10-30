
 
 // The DOM element you wish to replace with Tagify
 var input = document.querySelector('input[name=inspp_list_sub]');
 var inputmod = document.querySelector('input[name=inspp_list_sub_mod]');
 
 // initialize Tagify on the above input node reference
 if(input){
     var tagify = new Tagify(input);
     var tags = tagify.value.map(tag => tag.value);
 }
 if(inputmod){
     var tagifymod = new Tagify(inputmod);
 
 }
  
  
 
 jQuery(document).ready(function ($) {
 
     
     $('.insapp_register_subscription').submit(function (e) {
 
         var tags = tagify.value.map(tag => tag.value);
 
         console.log(tags)
         e.preventDefault();
         $('.insapp_register_subcription_btn').attr("disabled", "disabled");
 
         let data = {
             'action': "add_subcrition_back",
             'sub_name': $('#insapp_subscription_name').val(),
             'sub_price_mensuel': $('#insapp_price_mensuel').val(),
             // 'sub_price_mensuel_pro': $('#insapp_price_mensuel_promo').val(),
             'sub_duration': $('#insapp_duration').val(),
             'sub_free_trial': $('#insapp_free_trial').val(),
             'sub_content': $('#insapp_subscription_description').val(),
             'sub_status': $('#insapp_status').val(),
             'sub_element': JSON.stringify(tags),
         }
         console.log(data);
 
         jQuery.post(subscription_ajax.ajaxurl, data, function (response) {
             console.log(response);
             if (response.code == 200) {
                  $.toast({
                     heading: 'success',
                     text: response.message,
                     showHideTransition: 'plain',
                     position: 'top-right',
                     icon: 'warning',
                     hideAfter: 5000,
                 });
                 location.reload()
 
             } else if (response.code == 400) {
                 $.toast({
                     heading: 'error',
                     text: response.message,
                     showHideTransition: 'plain',
                     position: 'top-right',
                     icon: 'error',
                     hideAfter: 10000,
                 });
 
                 $('.insapp_register_service_btn').removeAttr("disabled")
 
             } else {
                 $.toast({
                     heading: 'Warning',
                     text: response.message,
                     showHideTransition: 'plain',
                     position: 'top-right',
                     icon: 'warning',
                     hideAfter: 8000,
                 });
 
                 $('.insapp_register_service_btn').removeAttr("disabled")
 
             }
 
 
 
         })
     });
 
     $('.btn_sub_edit').click(function (e) {
         let subscription_id = $(this).attr("data-id")
         let data = {
             'action': 'update_subscription',
             'subscription_id': subscription_id,
         }
         tagifymod.removeAllTags(); 
 
         jQuery.post(subscription_ajax.ajaxurl, data, function (response) {
             console.log(response);
             $('#subscription_id').val(response.id)
             $('#update_subscription_name').val(response.nom)
             $('#update_subscription_description').html(response.description)
             $('#sub_update_price_mensuel').val(response.reg_price)
             $('#sub_update_price_mensuel_promo').val(response.sale_price)
             $('#sub_update_duration').val(response.duree)
            
             tagifymod.addTags(JSON.parse(response.list))
             
         })
  
     });
 
     $('.insapp_update_subcription_btn').click(function (e) {
         // e.preventDefault()
         $(this).attr("disabled", "disabled");
         var tagsm = tagifymod.value.map(tag => tag.value);
 
         let data = {
             'action': "save_subscription_update",
             'subscription_id': $('#subscription_id').val(),
             'name': $('#update_subscription_name').val(),
             'price_reg': $('#sub_update_price_mensuel').val(),
             'price_sale': $('#sub_update_price_mensuel_promo').val(),
             'description': $('#update_subscription_description').val(),
             'duration': $('#sub_update_duration').val(),
             'sub_element': JSON.stringify(tagsm),
         }
         console.log(data)
         jQuery.post(subscription_ajax.ajaxurl, data, function (response) {
             console.log(response);
             if (response.code == 200) {
                 $.toast({
                     heading: 'success',
                     text: response.message,
                     showHideTransition: 'plain',
                     position: 'top-right',
                     icon: 'success',
                     hideAfter: 5000,
 
                 });
                 location.reload()
 
             } else if (response.code == 400) {
                 $.toast({
                     heading: 'error',
                     text: response.message,
                     showHideTransition: 'plain',
                     position: 'top-right',
                     icon: 'error',
                     hideAfter: 10000,
                 });
 
                 $('.insapp_register_service_btn').removeAttr("disabled")
 
             } else {
                 $.toast({
                     heading: 'Warning',
                     text: response.message,
                     showHideTransition: 'plain',
                     position: 'top-right',
                     icon: 'warning',
                     hideAfter: 8000,
                 });
 
                 $('.insapp_register_service_btn').removeAttr("disabled")
 
             }
 
 
 
         })
 
 
     })
 
     $('.btn_sub_delete').click(function (e) {
     
 
 
         let subscription_id = $(this).attr("data-id")
         const swalWithBootstrapButtons = Swal.mixin({
             customClass: {
                 confirmButton: 'btn btn-primary',
                 cancelButton: 'btn btn-danger',
             },
             buttonsStyling: false
         })
 
         swalWithBootstrapButtons.fire({
             title: 'Etes-vous sur?',
             text: "Cette action sera irreversible!",
             icon: 'warning',
             showCancelButton: true,
             confirmButtonText: 'Supprimer!',
             cancelButtonText: 'Annuler',
             reverseButtons: true
         }).then((result) => {
             if (result.isConfirmed) {
                 let data = {
                     'action': 'delete_subscription',
                     'subscription_id': subscription_id,
                 }
 
                 console.log(data)
 
                 jQuery.post(subscription_ajax.ajaxurl, data, function (response) {
                     console.log(response);
                     location.reload()
 
                 })
             }
         })
 
         
     });
     
 
 });
  