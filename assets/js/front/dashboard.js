function Extra(_libelle = '', cout_extra = 0) {
    this.nom = _libelle;
    this.cout = cout_extra;
}
 
let liste_extras = [];
let _addExtraButton = document.getElementById('btn_addM');
if (_addExtraButton != null) {
    _addExtraButton.addEventListener('click', function () {
        let nom_extra = document.getElementById('nom_extra').value;
        let cout_extra = document.getElementById('cout_extra').value;

        let extra = new Extra(nom_extra, cout_extra);
        liste_extras.push(extra);
        console.log(liste_extras);

        let _tr = document.createElement('tr');
        let _tdM = document.createElement('td'); _tdM.innerHTML = nom_extra;
        let _tdN = document.createElement('td'); _tdN.innerHTML = cout_extra;
        let _tdAction = document.createElement('td');
        _tdAction.classList.add("justify-content-evenly");
        _tdAction.classList.add("d-grid");
        _tdAction.classList.add("gap-2");
        _tdAction.classList.add("d-md-flex");
        let _btnDele = document.createElement('button');
        _btnDele.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke = "currentColor" stroke - width="2" stroke - linecap="round" stroke - linejoin="round" class="feather feather-trash-2 icon-xs"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg > ';
        _btnDele.classList.add("btn")
        _btnDele.classList.add("btn-outline-danger")
        let _btnMore = document.createElement('button');
        _btnMore.innerHTML = '';
        _btnMore.classList.add("btn");
        _btnMore.classList.add("btn-outline-primary");

        // _tdAction.appendChild(_btnMore);
        _tdAction.appendChild(_btnDele);
        _tr.appendChild(_tdM);
        _tr.appendChild(_tdN);
        _tr.appendChild(_tdAction);

        document.getElementById('tab_extra').appendChild(_tr);


        document.getElementById('nom_extra').value = '';
        document.getElementById('cout_extra').value = '';

        _btnDele.addEventListener('click', () => {
            _tr.remove();
        });
    });
}


    // get and check the location 
    function initAutocomplete() {
        var input = document.getElementById('insapp_annonce_city_input');
        var notification = document.getElementById('insapp_location_check');
        var insapp_latitude = document.getElementById('insapp_location_latitude');
        var insapp_longitude = document.getElementById('insapp_location_longitude');
        var autocomplete = new google.maps.places.Autocomplete(input);
        notification.style.display = 'none';
        
    
        autocomplete.addListener('place_changed', function() {
            notification.style.display = 'none';
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                console.error("Place details not found for input: ", input.value);
                notification.style.display = 'flex'; 
                notification.innerHTML = "Place details not found for input:" + input.value + "";
                return;
            }
            var latitude = place.geometry.location.lat();
            var longitude = place.geometry.location.lng();

            insapp_latitude.setAttribute('value', latitude);
            insapp_longitude.setAttribute('value', longitude);

        });
    }
     if(document.getElementById('insapp_annonce_city_input')){
         
        google.maps.event.addDomListener(window, 'load', initAutocomplete);
    
    }
        
jQuery(document).ready(function ($) {

    var opentab = JSON.parse(localStorage.getItem('jstabs-opentab')) || '1';
    const tabs = document.querySelectorAll('.ins_dashbord_menu')
    const tabContents = document.querySelectorAll('.insapp_content_dashbord')
    // Functions
    const activateTab = tabnum => {

        tabs.forEach(tab => {
            tab.classList.remove('ins_active')
        })

        tabContents.forEach(tabContent => {
            tabContent.classList.remove('insapp_div_active')
        }) 
         if(document.querySelector('#tab' + tabnum) == null ||  document.querySelector('#insapp_tab' + tabnum) == null){
             tabnum = 1; 
         } 
         
        //  if(document.getElementById('#tab' + tabnum)){
            document.querySelector('#tab' + tabnum).classList.add('ins_active')
            document.querySelector('#insapp_tab' + tabnum).classList.add('insapp_div_active')
            localStorage.setItem('jstabs-opentab', JSON.stringify(tabnum))
        //  }
 
    }

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
           if (tab) {
                activateTab(tab.dataset.tab)
            }  
        })
    })
 
    activateTab(opentab)

    const fileInput = document.getElementById('product_img');
    const preview = document.getElementById('preview');
  
    $('#insapp_category').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            closeOnSelect: false,
        });

    $("#insapp_category").on("change",function() { 

        let insapp_category = []
        $("#insapp_category :selected").map(function (i, el) {
            insapp_category.push($(el).val());
        }).get();

        let data = {
          'action': 'ajax_sous_category_add',
          'category': insapp_category,
          }; 
          jQuery.post(service_front_ajax.ajaxurl,data,function(response){ 

            $('.insapp_sous_category_html').html(response);
          });
          
    });
    $("#insapp_update_category").on("change",function() { 
        let insapp_update_category = []
        $("#insapp_update_category :selected").map(function (i, el) {
            insapp_update_category.push($(el).val());
        }).get();
         
        subcategory = $('#insapp_update_subcategory_list').val()
        subcategories = subcategory.split(",");
    
        if(subcategories){
         let data = {
          'action': 'ajax_sous_category_update',
          'category': insapp_update_category, 
          'subcategories' : subcategories
          };
 
          jQuery.post(service_front_ajax.ajaxurl,data,function(response){ 
 
            $('.insapp_update_sous_category_html').html(response);
              
          });
        } 
        
          
    });


    $('.insapp_register_service').submit(function (e) {

        e.preventDefault();
        $('.insapp_register_service_btn').attr("disabled", "disabled");
        $('.insapp_register_service_info').css('display','flex');
        
        let insapp_category = []
        $("#insapp_category :selected").map(function (i, el) { 
            insapp_category.push(parseInt($(el).val()));
        }).get();
 
        var medium_list = [];
        $('.insapp-list-medium:checked').each(function() {
            medium_list.push(parseInt($(this).val()));
        });
        var tag_list = [];
        $('.insapp-list-tag:checked').each(function() {
            tag_list.push(parseInt($(this).val()));
        });
        var sous_category_list = [];
        $('.insapp-list-sous-category:checked').each(function() {
            sous_category_list.push(parseInt($(this).val()));
        });

        let content_editor = $('.ql-editor').html();
        let date_start = $('#insapp-date-start').val();
        let date_end = $('#insapp-date-start').val();
        image = $("#product_img")[0].files[0];
       
        let galleryImages = $('#insapp-galerie-upload')[0].dropzone.getAcceptedFiles();
       console.log();
        let gallery = []
        galleryImages.forEach(function (imageFile) {
             
            let images = []
            images.push(imageFile.name);
            images.push(imageFile.dataURL);
            gallery.push(images);
        });
 
        let data = {
            'action': "add_service_front",
            'service_name': $('#insapp_service_name').val(),
            'service_date_start': moment(date_start).format('Y-MM-DD'),
            'service_date_end': moment(date_end).format('Y-MM-DD'),
            'service_price_reg': $('#insapp_price_reg').val(),
            'service_price_sale': $('#insapp_price_sale').val(),
            'service_content': content_editor,
            'service_galerie': gallery,
            'service_meduim': medium_list,
            'service_tag': tag_list,
            'service_category': insapp_category,
            'service_sub_category': sous_category_list,
            'service_duration': $('#insapp_duree').val(),
            'service_author': $('.insapp_user').val(),
            'extras': JSON.stringify(liste_extras),
            // 'crenaux': crenaux,
            'image_name': image.name,
            'image_type': image.type,
            'image_size': image.size,
            'image_url': $('.insapp_img_service_url').val(),
             'service_location': $('#insapp_annonce_city_input').val(),
             'service_latitude': $('#insapp_location_latitude').val(),
            'service_longitude': $('#insapp_location_longitude').val(),  
        }
        console.log(data);
        jQuery.post(service_front_ajax.ajaxurl, data, function (response) {
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
                localStorage.setItem('jstabs-opentab', 8)
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
    
    if(document.getElementById('insapp-galerie-vendor-profil')){
        
        fileInput.addEventListener('change', () => {
    
            const fr = new FileReader();
            fr.readAsDataURL(fileInput.files[0]);
    
            fr.addEventListener('load', () => {
    
                const url = fr.result;
                image_url = url
                $('.insapp_img_service_url').val(image_url);
                const img = new Image();
                img.src = url;
            })
    
    
        });
    }
     
     if(document.getElementById('insapp-galerie-upload')){
        var dropzone_annonce = new Dropzone('#insapp-galerie-upload', {
            previewTemplate: document.querySelector('#preview-template').innerHTML,
            parallelUploads: 2,
            maxFiles: 10,
            thumbnailHeight: 120,
            thumbnailWidth: 120,
            maxFilesize: 10, 
            filesizeBase: 1000,
            acceptedFiles: ".jpg,.png,.jpeg,.gif",
            addRemoveLinks: true, 
            dictDefaultMessage: "Drop your files here or click to upload",
            dictFallbackMessage: "Your browser does not support drag & drop feature.",
            dictInvalidFileType: "Your uploaded file type is not supported.",
            dictFileTooBig: "File is too big ({{filesize}} MB). Max filesize: {{maxFilesize}} MB.",
            dictResponseError: "Server responded with {{statusCode}} code.",
            dictCancelUpload: "Cancel Upload",
            dictRemoveFile: "x",
            thumbnail: function (file, dataUrl) {
                if (file.previewElement) {
                    file.previewElement.classList.remove("dz-file-preview");
                    var images = file.previewElement.querySelectorAll("[data-dz-thumbnail]");
                    for (var i = 0; i < images.length; i++) {
                        var thumbnailElement = images[i];
                        thumbnailElement.alt = file.name;
                        thumbnailElement.src = dataUrl;
                    }
                    setTimeout(function () { file.previewElement.classList.add("dz-image-preview"); }, 1);
                }
                console.log(file);
                console.log(dataUrl);
            }
    
        });
    }
 // Initialiser la zone de dépôt Dropzone
//  Dropzone.options.insappGalerieUpload = {
//     paramName: "file", // Nom du paramètre utilisé pour le téléchargement
//     maxFilesize: 2, // Taille maximale des fichiers (en Mo)
//     success: function(file, response) {
//         // Gérer les actions après un téléchargement réussi
//         // Vous pouvez mettre à jour la prévisualisation, enregistrer l'URL dans l'input caché, etc.
//     }
// };
})
  