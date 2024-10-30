jQuery(document).ready(function ($) {
    
    $('#insapp_profil_category').select2({
        theme: "bootstrap-5",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        closeOnSelect: false,
    });
    $('#insapp_profil_medium').select2({
        theme: "bootstrap-5",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        closeOnSelect: false,
    });

    $('.insapp_profile_form').submit(function (e) {
 
        e.preventDefault(); 
        $('.user_update_profile_btn').attr("disabled", "disabled");
      
        let insapp_profil_category = []
        $("#insapp_profil_category :selected").map(function (i, el) {
            insapp_profil_category.push($(el).val());
        }).get();
  

        
        image = $("#user_pic_input")[0].files[0];
        let id = $('.insapp_user').val()
        let nom = $('#insapp_lastName').val()
        let prenom = $('#insapp_firstName').val()
        let tel = $('#insapp_userphone').val()
        let email = $('#insapp_useremail').val()  
       let pseudo = $('#insapp_pseudo').val()
  
  console.log(image);
        if(image === undefined){
            image_name = "" 
        }else{
            image_name = image.name  
        }

        let data = {
            'action': 'update_user_profile_ajax',
            'user_id': id,
            'pseudo': pseudo,
            'nom': nom,
            'prenom': prenom,
            'telephone': tel,
            'email': email, 
            'image_name': image_name,  
             'image_url': $('#user_pic').attr('src'),
        }  
        console.log(data);
        jQuery.post(profils_front_ajax.ajaxurl, data, function (response) {
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
                location.reload();

            } else if (response.code == 400) {
                $.toast({
                    heading: 'error',
                    text: response.message,
                    showHideTransition: 'plain',
                    position: 'top-right',
                    icon: 'error',
                    hideAfter: 10000,
                });
                
            } else{
                $.toast({
                    heading: 'Warning',
                    text: response.message,
                    showHideTransition: 'plain',
                    position: 'top-right',
                    icon: 'warning',
                    hideAfter: 8000,
                });
                 
            }
            $('.user_update_profile_btn').removeAttr("disabled") 

        })

    });

    $('.insapp_profile_advanced_form').submit(function (e) {
        
        e.preventDefault(); 
        $('.user_update_profile_avance_btn').attr("disabled", "disabled");
        
       $('.insapp_notification_user_profil').css('display', 'none') 
        
        let insapp_profil_category = []
        $("#insapp_profil_category :selected").map(function (i, el) {
            insapp_profil_category.push($(el).val());
        }).get();
        
        let insapp_profil_medium = []
        $("#insapp_profil_medium :selected").map(function (i, el) {
            insapp_profil_medium.push($(el).val());
        }).get();
        bio = $('#insapp_user_description').val();
        console.log(bio);
        console.log(bio.length);
        
        if(bio.length < 500 || bio.length > 1500){ 
            $('.insapp_notification_user_profil').html('Votre Bio doit contenir entre 500 et 1500 caractères!')
           $('.insapp_notification_user_profil').css('display', 'flex') 
             $('.user_update_profile_avance_btn').removeAttr("disabled") 
       
        }else{

            let data = {
                'action': 'update_profile_avance_ajax',  
                'user_id': $('.insapp_user').val(),
                'adresse': $('#ia-filter-lieu').val(),
                'profil_category': insapp_profil_category, 
                'profil_medium': insapp_profil_medium, 
                'description' : $('#insapp_user_description').val(), 
                'facebook': $('#insapp_userfacebook').val(),
                'twitter': $('#insapp_usertwitter').val(),
                'instagram': $('#insapp_userinstagram').val(),
                'linkedln': $('#insapp_userlinkedln').val(),
            }  
            console.log(data);
            jQuery.post(profils_front_ajax.ajaxurl, data, function (response) {
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
                    location.reload();
    
                } else if (response.code == 400) {
                    $.toast({
                        heading: 'error',
                        text: response.message,
                        showHideTransition: 'plain',
                        position: 'top-right',
                        icon: 'error',
                        hideAfter: 10000,
                    });
                   
                } else{
                    $.toast({
                        heading: 'Warning',
                        text: response.message,
                        showHideTransition: 'plain',
                        position: 'top-right',
                        icon: 'warning',
                        hideAfter: 8000,
                    });
                     
                }
                $('.user_update_profile_avance_btn').removeAttr("disabled") 
    
            })
        }

    });
        
    $('.insapp_stripe_account_btn').submit(function (e) {
 
        e.preventDefault(); 
        // $('.user_stripe_account_sub').attr("disabled", "disabled");
 
        let id = $('.insapp_user').val()
        
        let data = {
            'action': 'ia_get_user_account_ajax',  
            'user_id': id, 
        } 
       
        jQuery.post(service_front_ajax.ajaxurl, data, function (response) {
        
            if (response.code == 200) { 
                window.location.href = response.message; 

            }else{
                $.toast({
                    heading: 'Warning',
                    text: response.message,
                    showHideTransition: 'plain',
                    position: 'top-right',
                    icon: 'warning',
                    hideAfter: 8000,
                });
            }
            
            $('.user_stripe_account_sub').removeAttr("disabled") 

        })

    });

    function verify_pw(password, conf_password) {
        if (password !== conf_password) {
            return 0;
        } else {
            return 1;
        }
    }

    $('.insapp_password_form').submit(function (e) {
       
        e.preventDefault();
        $('.insapp_notification_user_password').css('display', 'none')
        $('.insapp_notification_user_password').css('display', 'none')
        $('.user_update_password_btn').attr("disabled", "disabled");

        let id = $('.insapp_user').val()
        let currentt_password = $('#insappcurrentPassword').val() 
        let new_password = $('#insappcurrentNewPassword').val()
        let c_new_password = $('#insappconfirmNewpassword').val() 

        if (verify_pw(new_password, c_new_password) == 1) {

            if (new_password.length < 8) {

                $('.user_update_password_btn').removeAttr("disabled")
                $('.insapp_notification_user_password').css('display', 'flex')
                $('.insapp_notification_user_password').html('le mot de passe est trop court.Il faut minimum 8 chiffres')


            } else {

                let data = {
                    'action': 'update_user_password_ajax',
                    'user_id': id,
                    'password': password, 
                } 


                jQuery.post(profils_front_ajax.ajaxurl, data, function (response) {
                
                    if (response.code == 200) {
                        $.toast({
                            heading: 'success',
                            text: response.message,
                            showHideTransition: 'plain',
                            position: 'top-right',
                            icon: 'success',
                            hideAfter: 5000,
                        });
                        location.reload();
                    } else {
                        $.toast({
                            heading: 'Warning',
                            text: response.message,
                            showHideTransition: 'plain',
                            position: 'top-right',
                            icon: 'warning',
                            hideAfter: 8000,
                        });

                    }

                })
            }
        } else {
           
            $('.user_update_password_btn').removeAttr("disabled")
            $('.insapp_notification_user_password').css('display', 'flex')
            $('.insapp_notification_user_password').html('les mots de passe ne correspondent pas')

        }
    });
 

    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Exemple d'utilisation :
    const emailToCheck = 'john.doe@example.com';

    if (isValidEmail(emailToCheck)) {
        // console.log("L'adresse e - mail est valide.");
    } else {
        // console.log("L'adresse e - mail n'est pas valide.");
    } 
   
    const fileInput = document.getElementById('user_pic_input');

    if (fileInput != null) {
        fileInput.addEventListener('change', () => {

            const fr = new FileReader();
            fr.readAsDataURL(fileInput.files[0]);

            fr.addEventListener('load', () => {

                const url = fr.result;
                image_url = url
            
                $('#user_pic').attr('src', image_url);

                const img = new Image();
                img.src = url;
            })


        });
    }
     
      
    $('.insapp_vendor_update_galerie').submit(function (e) {
        
        e.preventDefault();
        $('.insapp_vendor_update_galerie_btn').attr("disabled", "disabled");
         let galleryImages = $('#insapp-galerie-vendor-profil')[0].dropzone.getAcceptedFiles();
        console.log(galleryImages)
        let gallery = []
        galleryImages.forEach(function (imageFile) {
            let images = []
            images.push(imageFile.name);
            images.push(imageFile.dataURL);
            gallery.push(images);
        });
            
         console.log(gallery)
        //  if(gallery.length != 0){
             let data = {
                'action': "add_gallery_to_vendor",
                'user_id': $('.insapp_user').val(), 
                'user_galerie': gallery, 
            }
            jQuery.post(profils_front_ajax.ajaxurl, data, function (response) {
                console.log(response);
          $('.insapp_vendor_update_galerie_btn').removeAttr("disabled")
                if (response.code == 200) {
                    $.toast({
                        heading: 'success',
                        text: response.message,
                        showHideTransition: 'plain',
                        position: 'top-right',
                        icon: 'success',
                        hideAfter: 5000,
    
                    });
                    location.reload();
                } else {
                    $.toast({
                        heading: 'Warning',
                        text: response.message,
                        showHideTransition: 'plain',
                        position: 'top-right',
                        icon: 'warning',
                        hideAfter: 8000,
                    });
    
                    $('.insapp_vendor_update_galerie_btn').removeAttr("disabled")
                }
            });
        //  }
    });
    
        let data_gallery = {
            'action': 'ia_get_profil_gallery',
            'user_id': $('.insapp_user').val(),
        } 
        jQuery.post(profils_front_ajax.ajaxurl, data_gallery, function (response) { 
            
            if(document.getElementById('insapp-galerie-vendor-profil')){
                const existingDropzone = Dropzone.forElement('#insapp-galerie-vendor-profil');
          
                if (existingDropzone) {
                    
                    existingDropzone.options.autoProcessQueue = true ;
                    existingDropzone.options.uploadMultiple = true ;
                    existingDropzone.options.resizeQuality = 0.8 ;
                    existingDropzone.options.parallelUploads = 10 ;
                    existingDropzone.options.maxFilesize = 20000;
                    existingDropzone.options.maxFile = 5;
                    // existingDropzone.options.addRemoveLinks = true ;
                    existingDropzone.options.acceptedFiles = ".png, .jpg,.jpeg"; 
                    existingDropzone.options.dictDefaultMessage = "Déposez vos fichiers (png, jpg, jpeg) ici ou cliquez pour télécharger" ;
                    existingDropzone.options.dictFallbackMessage =  "Votre navigateur ne supporte pas la fonction glisser-déposer";
                    existingDropzone.options.dictInvalidFileType = "Le type de fichier téléchargé n'est pas pris en charge";
                    existingDropzone.options.dictFileTooBig = "Le fichier est trop volumineux ({{filesize}} MB). Taille maximale des fichiers : {{maxFilesize}} MB";
                    existingDropzone.options.dictResponseError = " Le serveur a répondu avec le code {{statusCode}}";
                    existingDropzone.options.dictCancelUpload = "Annuler";
                    existingDropzone.options.dictRemoveFile = "x";
    
                    imagesArray = response;
                    imagesArray.forEach(function(imageUrl) {
                        const mockFile = { name: imageUrl, size: 345, id: imageUrl['id'] }; // Adjust size if necessary
                        existingDropzone.emit('addedfile', mockFile);
                        existingDropzone.emit('thumbnail', mockFile, imageUrl['url']);
                        existingDropzone.emit('complete', mockFile);
                    }); 
                      
                  getAllImagesWithIds();
                    // Optional: Add event listeners
                    existingDropzone.on("maxfilesexceeded", function(file) {
                        existingDropzone.emit('error', 'Vous avez atteint le nombre maximum de fichiers. Seuls 20 fichiers sont autorisés.');
                    });
                    
                } 
            }

        });
      
            // Function to get all images with their IDs
            function getAllImagesWithIds() {
                let imagesWithIds = [];
                Dropzone.forElement('#insapp-galerie-vendor-profil').files.forEach(function(file) {
                    console.log('id');
                    console.log( file.id);
                    if (file.id) {
                        imagesWithIds.push({ id: file.id, name: file.name, url: file.url });
                    }
                });
                return imagesWithIds;
            }

});  