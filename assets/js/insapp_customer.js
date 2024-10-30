jQuery(document).ready(function ($) {

    $('body').on('click', '.insapp_file_input_client', function (e) {
        e.preventDefault();
        insapp_uploader = wp.media({
            title: 'Custom image',
            button: {
                text: 'Utiliser cette image'
            },
            multiple: false
        }).on('select', function () {
            var attachment = insapp_uploader.state().get('selection').first().toJSON();
            $('#insapp_contact_image_client').attr('src', attachment.url);
            $('#insapp_update_contact_image_client').attr('src', attachment.url);
        })
            .open();
    });
    //     e.preventDefault();
    //     insapp_uploader = wp.media({
    //         title: 'Custom image',
    //         button: {
    //             text: 'Utiliser cette image'
    //         },
    //         multiple: false
    //     }).on('select', function () {
    //         var attachment = insapp_uploader.state().get('selection').first().toJSON();
    //         $('#insapp_update_contact_image_client').attr('src', attachment.url);
    //     })
    //         .open();
    // });

    $('#insapp_add_customers').submit((e) => {
        e.preventDefault();


        // $('.offcanvas-end').removeClass('show')
        // $('.offcanvas-end').removeClass('hiding')
        // $('div').remove('.offcanvas-backdrop') 

        let insapp_name_client = $('#insapp_name_client').val()
        let insapp_other_name_client = $('#insapp_other_name_client').val()
        let insapp_tel_client = $('#insapp_tel_client').val()
        let insapp_email_client = $('#insapp_email_client').val()
        let insapp_sexe_client = $('#insapp_sexe_client').val()
        let insapp_password_client = $('#insapp_password_client').val()
        let insapp_conf_password_client = $('#insapp_conf_password_client').val()
        let insapp_birthday_client = $('#insapp_birthday_client').val()
        let insapp_language_client = $('#insapp_language_client').val()
        let status = verify_pw(insapp_password_client, insapp_conf_password_client);
        let insapp_contact_image_client = $('#insapp_contact_image_client').attr('src')

        switch (status) {
            case 0:
                $('#feedback_password_client').addClass('invalid-feedback')
                $('#insapp_conf_password_client').addClass('invalid-input')
                break;
            case 1:
                $('#feedback_password_client').removeClass('invalid-feedback')
                $('#insapp_conf_password_client').removeClass('invalid-input')

                let data = {
                    'action': 'add_customers_ajax',
                    'nom_client': insapp_name_client,
                    'prenom_client': insapp_other_name_client,
                    'telephone_client': insapp_tel_client,
                    'email_client': insapp_email_client,
                    'sexe_client': insapp_sexe_client,
                    'password_client': insapp_password_client,
                    'birthday_client': insapp_birthday_client,
                    'langue_client': insapp_language_client,
                    'profil_image_client': insapp_contact_image_client,
                }
                console.log(data)


                jQuery.post(customers_ajax.ajaxurl, data, function (response) {
                    $('.offcanvas-backdrop-customer').removeClass('invalid-input')
                    console.log(response)
                    if (response.code == 200) {
                        $.toast({
                            heading: 'success',
                            text: response.message,
                            showHideTransition: 'plain',
                            position: 'top-right',
                            icon: 'success',
                            hideAfter: 5000,
                        })

                    } else if (response.code == 400) {
                        $.toast({
                            heading: 'error',
                            text: response.message,
                            showHideTransition: 'plain',
                            position: 'top-right',
                            icon: 'error',
                            hideAfter: 5000,
                        })
                    } else if (response.code == 404) {
                        $.toast({
                            heading: 'Warning',
                            text: response.message,
                            showHideTransition: 'plain',
                            position: 'top-right',
                            icon: 'warning',
                            hideAfter: 5000,
                        })
                    } else { }

                })

        }
    })


function verify_pw(password, conf_password) {
    if (password !== conf_password) {
        return 0;
    } else {
        return 1;
    }
}


/************************************************************
***********            Update                  **************
************************************************************/




    $('.insapp_btn_customers_update').on("click", function () {
        let insapp_id = $(this).attr("value")
        console.log(insapp_id)

        let data = {
            'action': 'update_customers_ajax',
            'client_id': insapp_id,
        }


        jQuery.post(customers_ajax.ajaxurl, data, (response) => {
            console.log(response)
            // $('.offcanvas-backdrop').removeClass('invalid-input')
            $('#insapp_update_name_client').val(response.nom_client)
            $('#insapp_update_other_name_client').val(response.prenom_client)
            $('#insapp_update_tel_client').val(response.tel_client)
            $('#insapp_update_email_client').val(response.email_client)
            $('#insapp_update_sexe_client').val(response.sexe_client)
            $('#insapp_update_birthday_client').val(response.birthday_client)
            $('#insapp_update_language_client').val(response.langue_client)
            $('#insapp_update_contact_image_client').attr('src', response.profil_client)
            $('#save-btn-client').val(response.id_client)
        })
    })

    $('.insapp_add_customers_update').submit((e) => {
        console.log('hello')
        e.preventDefault();
        // $('.offcanvas-end').removeClass('show')
        // $('.offcanvas-end').removeClass('hiding')
        // $('div').remove('.offcanvas-backdrop') 
        let id_client = $('#save-btn-client').val()
        let insapp_name_client = $('#insapp_update_name_client').val()
        let insapp_other_name_client = $('#insapp_update_other_name_client').val()
        let insapp_tel_client = $('#insapp_update_tel_client').val()
        let insapp_email_client = $('#insapp_update_email_client').val()
        let insapp_sexe_client = $('#insapp_update_sexe_client').val()
        let insapp_birthday_client = $('#insapp_update_birthday_client').val()
        let insapp_language_client = $('#insapp_update_language_client').val()
        let insapp_contact_image_client = $('#insapp_contact_image_client').attr('src')

        $('#feedback_password_client').removeClass('invalid-feedback')
        $('#insapp_conf_password_client').removeClass('invalid-input')

        let data = {
            'action': 'save_update_customers_ajax',
            'id_client': id_client,
            'nom_client': insapp_name_client,
            'prenom_client': insapp_other_name_client,
            'telephone_client': insapp_tel_client,
            'email_client': insapp_email_client,
            'sexe_client': insapp_sexe_client,
            'birthday_client': insapp_birthday_client,
            'langue_client': insapp_language_client,
            'profil_image_client': insapp_contact_image_client,
        }
        console.log(data)


        jQuery.post(customers_ajax.ajaxurl, data, function (response) {
            $('.offcanvas-backdrop-customer').removeClass('invalid-input')
            console.log(response)
            if (response.code == 200) {
                $.toast({
                    heading: 'success',
                    text: response.message,
                    showHideTransition: 'plain',
                    position: 'top-right',
                    icon: 'success',
                    hideAfter: 5000,
                })

            } else if (response.code == 400) {
                $.toast({
                    heading: 'error',
                    text: response.message,
                    showHideTransition: 'plain',
                    position: 'top-right',
                    icon: 'error',
                    hideAfter: 5000,
                })
            } else if (response.code == 404) {
                $.toast({
                    heading: 'Warning',
                    text: response.message,
                    showHideTransition: 'plain',
                    position: 'top-right',
                    icon: 'warning',
                    hideAfter: 5000,
                })
            } else { }

        })

    }
    )



/************************************************************
***********            Delete                  **************
************************************************************/


    $('.insapp_btn_customers_delete').on("click", function () {
        let insapp_id = $(this).attr("value")
        console.log(insapp_id)

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
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
                    'action': 'delete_customers_ajax',
                    'client_id': insapp_id,
                }
                jQuery.post(users_ajax.ajaxurl, data, (response) => {

                    console.log(response)
                    swalWithBootstrapButtons.fire(
                        'Supprimé!',
                        "Le client a été supprimé.",
                        'Bravo'
                    )

                })
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    'Annuler',
                    "L'employé n'a pas été supprimé :)",
                    'erreur'
                )
            }
        })

    })

    $('.swal2-actions').addClass('justify-content-evenly')


})

