/**********************************************
 *          toggleSwitch                *
 **********************************************/

if (document.querySelector('#toggleswitch')) {
    let toggleSwitch = document.querySelectorAll('#toggleswitch');


    toggleSwitch[0].addEventListener('change', () => {

        console.log(document.querySelectorAll('.insapp_subcontent')[0]);
        console.log(document.querySelectorAll('.insapp_subcontent')[0].childNodes[1]);
        console.log(document.querySelectorAll('.insapp_subcontent')[0].childNodes[3]);
        if (toggleSwitch[0].checked) {
            
            document.querySelectorAll('.insapp_subcontent')[0].childNodes[1].classList.remove("active");
            document.querySelectorAll('.insapp_subcontent')[0].childNodes[3].classList.add("active");
        
        } else {
            
            document.querySelectorAll('.insapp_subcontent')[0].childNodes[3].classList.remove("active");
            document.querySelectorAll('.insapp_subcontent')[0].childNodes[1].classList.add("active");
        }
    });

}
/**********************************************
 *          Range price code                  *
 **********************************************/
 
    let minValue = document.getElementById("ia_price_rage_min-value");
    let maxValue = document.getElementById("ia_price_rage_max-value");

    function validateRange(minPrice, maxPrice) {
      if (minPrice > maxPrice) {
    
        // Swap to Values
        let tempValue = maxPrice;
        maxPrice = minPrice;
        minPrice = tempValue;
      }
    
      minValue.innerHTML = minPrice;
      maxValue.innerHTML = maxPrice;
    }
    
    const inputElements = document.querySelectorAll(".ia_price_range_block input");
    inputElements.forEach((element) => {
      element.addEventListener("input", (e) => {
          
        let minPrice = parseInt(inputElements[0].value);
        let maxPrice = parseInt(inputElements[1].value);
         
        validateRange(minPrice, maxPrice);
      });
    });
    // if( inputElements[0] && inputElements[1]){
        
    // validateRange(inputElements[0].value, inputElements[1].value);
    // }


  // get and check the location 
    function initAutocomplete() {
        var input = document.getElementById('ia-filter-lieu'); 
        var insapp_latitude = document.getElementById('ia-filter-lieu_latitude');
        var insapp_longitude = document.getElementById('ia-filter-lieu_longitude');
        var autocomplete = new google.maps.places.Autocomplete(input);

        autocomplete.addListener('place_changed', function() {
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                console.error("Place details not found for input: ", input.value); 
                return;
            }
            var latitude = place.geometry.location.lat();
            var longitude = place.geometry.location.lng();

            insapp_latitude.setAttribute('value', latitude);
            insapp_longitude.setAttribute('value', longitude);

        });
    }
    
    if(document.getElementById('ia-filter-lieu')){
        
        google.maps.event.addDomListener(window, 'load', initAutocomplete);
    
    }

jQuery(document).ready(function ($) {
    
    
    
     $(".ia_filter").on("click", function() {
         console.log('ib_show');
         $('.ia-sidebar-container').slideToggle();
     });
     
     /**********************************************
     *               Location radius               *
     **********************************************/
        
        // $('#ia-filter-lieu').on('click', function () {
        //  });
        
        $("#ib-radius-range").on("input", function() {
            $("#ib-radius-value").text($(this).val() + " km"); 
             var radius = $("#ib-radius-range").val(); 
              $("#ib-radius").val(radius);
             
              if($('#ia-filter-lieu_latitude').val() != ''){
                  $('.ia-filter-lieu').change();
              }
        });
       

        /**********************************************
     *     Reviews interaction     *
     **********************************************/
        

        // $('.insapp_service_rating_counter i').hover(function () {

        //     if( $(this).hasClass('add-to-favorites')){
        //         $(this).removeClass('fas fa-heart add-to-favorites');  
        //         $(this).addClass('far fa-heart');  
        //     }else{
        //         $(this).removeClass('far fa-heart');  
        //         $(this).addClass('fas fa-heart add-to-favorites');  
        //     }
          
        // });
        $('.insapp_service_rating_dash svg').on('click', function () {
            let productId = $(this).parent().attr('data-product-id')
        
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
                confirmButtonText: 'ReTirer!',
                cancelButtonText: 'Annuler',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {

                    $(this).parent().parent().css('display','none')
                    removeProductFromFavorites(productId)
                }
            })

        });
        
        $('.like-icon span').on('click', function () {
            let productId = $(this).parent().attr('data-product-id')
            console.log( productId);

            if( $(this).hasClass('add-to-favorite')){
                $(this).removeClass('add-to-favorite');  
                $(this).addClass('ia-unbookmark'); 
                removeProductFromFavorites(productId)
            }else{ 
                $(this).removeClass('ia-unbookmark');  
                $(this).addClass('add-to-favorite'); 
                
                addProductToFavorites(productId)
            }
          
        });
    
    
        $('.insapp_service_rating_counter i').on('click', function () {
            let productId = $(this).parent().attr('data-product-id')

            if( $(this).hasClass('add-to-favorites')){
                $(this).removeClass('fas fa-heart add-to-favorites');  
                $(this).addClass('far fa-heart');  
                removeProductFromFavorites(productId)
            }else{
                $(this).removeClass('far fa-heart');  
                $(this).addClass('fas fa-heart add-to-favorites');  
                addProductToFavorites(productId)
            }
          
        });

        // if (isProductInFavorites(productId)) {
        //     removeProductFromFavorites(productId);
        // } else {
        //     addProductToFavorites(productId);
        

        function addProductToFavorites(productId) {
            console.log('adding...');
            var data = {
                action: 'ia_custom_add_to_favorites',
                product_id: productId
            };
 
            $.post(templates_front_ajax.ajaxurl, data, function (response) {
             
            });
         }
    
        function removeProductFromFavorites(productId) {
            console.log('remove...'); 
            var data = {
                action: 'ia_custom_remove_to_favorites',
                product_id: productId
            };
 
            $.post(templates_front_ajax.ajaxurl, data, function (response) {
             
            });
         }
    


    /**********************************************
     *     Annonce detail page: description       *
     **********************************************/

    let element = $('.insapp_description-inner')
    let content = $('.insapp_listing_description_inner')
    let lessbtn = $('.ia-show-less ')
    let morebtn = $('.ia-show-more')

    let contentHeight = $('.insapp_listing_description_inner div').height();

    if (contentHeight < 400) {
        element.removeClass('show-more');
        content.removeClass('insapp_description-inner-wrapper');
        morebtn.css("display", "none");
        lessbtn.css("display", "none");
    }

    morebtn.on('click', function (e) {
        e.preventDefault();
        element.removeClass('show-more');
        element.addClass('show-less');
        content.removeClass('insapp_description-inner-wrapper');
        morebtn.css("display", "none");
        lessbtn.css("display", "block");
    });

    lessbtn.on('click', function (e) {
        e.preventDefault();
        element.addClass('show-more');
        element.removeClass('show-less');
        content.addClass('insapp_description-inner-wrapper');
        morebtn.css("display", "block");
        lessbtn.css("display", "none");
    });



    /**********************************************
     *     Owlcarroucel library: Declaration      *
     **********************************************/

    $('.insapp_service_container .owl-carousel').owlCarousel({
        loop: true,
        margin: 10,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: true
            },
            600: {
                items: 2,
                nav: true
            },
            1000: {
                items: 3,
                nav: true,
                loop: true,
                margin: 20
            }
        }
    })


    $('.ia-profil .owl-carousel').owlCarousel({
        loop: true,
        margin: 0,
        dots:false,
        responsiveClass: true,
        responsive: {
            0: {
                items: 2,
                nav: true
            },
            600: {
                items: 3,
                nav: true,
                loop: true,
            },
            1000: {
                items: 4,
                nav: true,
                loop: true,
                margin: 0
            }
        }
    })


    $('#ia-filter-listing-form').on('submit', function (e) {
        e.preventDefault();
        $('.insapp_loader_listing_ajax_container').css('display', 'block')
        $('.insapp_listing_ajax_container').css('visibility', 'hidden')

        var tag_filter = [];
        $('.ia-filter-tag:checked').each(function () {
            tag_filter.push($(this).val());
        });

        var medium_filter = [];
        $('.ia-filter-medium:checked').each(function () {
            medium_filter.push($(this).val());
        });

        var sous_category_filter = [];
        $('.ia-filter-sous-category:checked').each(function () {
            sous_category_filter.push($(this).val());
        });

        var sub_category = sous_category_filter;
        var title = $('#ia-filter-title').val();
        var category = $('#ia-filter-category ').val();
        var date = $('#ia-filter-date_annonce ').val();
        var medium = medium_filter; 
        var price_min = $('#ia-price-filter-min').val();
        var price_max = $('#ia-price-filter-max').val();
         var location = {
            'name' : $('#ia-filter-lieu').val(),
            'latitude' : $('#ia-filter-lieu_latitude').val(),
            'longitude' : $('#ia-filter-lieu_longitude').val(),
            'radius' : $('#ib-radius').val() 
        };
        var tag = tag_filter;

        ia_filter_all(title, category, sub_category, medium, price_min, price_max, location, tag,date)
        
    });
    /**********************************************
   *     Filter page: onchange instruction       *
   **********************************************/


    // filter title
    $('#ia-filter-title').on('change', function () {

        $('.insapp_loader_listing_ajax_container').css('display', 'block')
        $('.insapp_listing_ajax_container').css('visibility', 'hidden')

        var tag_filter = [];
        $('.ia-filter-tag:checked').each(function () {
            tag_filter.push($(this).val());
        });

        var medium_filter = [];
        $('.ia-filter-medium:checked').each(function () {
            medium_filter.push($(this).val());
        });

        var sous_category_filter = [];
        $('.ia-filter-sous-category:checked').each(function () {
            sous_category_filter.push($(this).val());
        });

        var sub_category = sous_category_filter;
        var title = $(this).val();
        var category = $('#ia-filter-category ').val();
        var date = $('#ia-filter-date_annonce ').val();
        var medium = medium_filter; 
        var price_min = $('#ia-price-filter-min').val();
        var price_max = $('#ia-price-filter-max').val();
         var location = {
            'name' : $('#ia-filter-lieu').val(),
            'latitude' : $('#ia-filter-lieu_latitude').val(),
            'longitude' : $('#ia-filter-lieu_longitude').val(),
            'radius' : $('#ib-radius').val() 
        };
        var tag = tag_filter;

        ia_filter_all(title, category, sub_category, medium, price_min, price_max, location, tag,date)


    });


    // All filter execution to the ajax
    function ia_filter_all(title, category, sub_category, medium, price_min, price_max, location, tag,date){
        
        if(price_min > price_max){
            k =  price_min
            price_min = price_max;
            price_max = k;
        }else{
            price_min = price_min;
            price_max = price_max;
        }

        var data = {
            action: 'ia_custom_field_filter',
            title_filter: title,
            category_filter: category,
            sub_category_filter: sub_category,
            medium_filter: medium,
            price_min_filter: price_min,
            price_max_filter: price_max,
            location_filter: location,
            date_filter: date,
            tag_filter: tag
        };

        console.log(data);
        $.post(templates_front_ajax.ajaxurl, data, function (response) {
            console.log(response);
            $('#ia-filtered-results').html(response.content);
            $('.insapp_loader_listing_ajax_container').css('display', 'none')
            $('.insapp_listing_ajax_container').css('visibility', 'visible')

        }, 'json');

    }

   // filter category
    $('#ia-filter-category').on('change', function () {

        $('.insapp_loader_listing_ajax_container').css('display', 'block')
        $('.insapp_listing_ajax_container').css('visibility', 'hidden')

        var tag_filter = [];
        $('.ia-filter-tag:checked').each(function () {
            tag_filter.push($(this).val());
        });

        var medium_filter = [];
        $('.ia-filter-medium:checked').each(function () {
            medium_filter.push($(this).val());
        });

        var sous_category_filter = [];
        $('.ia-filter-sous-category:checked').each(function () {
            sous_category_filter.push($(this).val());
        });

        var sub_category = sous_category_filter;
        var title = $('#ia-filter-title').val();
        var category = $('#ia-filter-category ').val();
        var medium = medium_filter;
        var date = $('#ia-filter-date_annonce ').val();
        var price_min = $('#ia-price-filter-min').val();
        var price_max = $('#ia-price-filter-max').val();
         var location = {
            'name' : $('#ia-filter-lieu').val(),
            'latitude' : $('#ia-filter-lieu_latitude').val(),
            'longitude' : $('#ia-filter-lieu_longitude').val(),
            'radius' : $('#ib-radius').val() 
        };
        var tag = tag_filter;

        ia_filter_all(title, category, sub_category, medium, price_min, price_max, location, tag,date)

    });

    // call of subcategorie when ctegorie is selected
    $('#ia-filter-category').on('change', function () {

        var data = {
            action: 'ia_ajax_filter_subcategories',
            category_filter: $('#ia-filter-category ').val(),
        };

        $.post(templates_front_ajax.ajaxurl, data, function (response) {

            $('#ia-subcategory-list').html(response);
            $('.ia-filter-sous-category').change(function () {

                $('.insapp_loader_listing_ajax_container').css('display', 'block')
                $('.insapp_listing_ajax_container').css('visibility', 'hidden')


                var tag_filter = [];
                $('.ia-filter-tag:checked').each(function () {
                    tag_filter.push($(this).val());
                });

                var medium_filter = [];
                $('.ia-filter-medium:checked').each(function () {
                    medium_filter.push($(this).val());
                });

                var sous_category_filter = [];
                $('.ia-filter-sous-category:checked').each(function () {
                    sous_category_filter.push($(this).val());
                });
                var date = $('#ia-filter-date_annonce ').val();
                var sub_category = sous_category_filter;
                var title = $('#ia-filter-title').val();
                var category = $('#ia-filter-category ').val();
                var medium = medium_filter;
                
        var price_min = $('#ia-price-filter-min').val();
        var price_max = $('#ia-price-filter-max').val();
         var location = {
            'name' : $('#ia-filter-lieu').val(),
            'latitude' : $('#ia-filter-lieu_latitude').val(),
            'longitude' : $('#ia-filter-lieu_longitude').val(),
            'radius' : $('#ib-radius').val() 
        };
        var tag = tag_filter;

                ia_filter_all(title, category, sub_category, medium, price_min, price_max, location, tag,date)


            });

        }, 'json');

    });

    //filter subcategorie
    $('.ia-filter-sous-category').change(function () {

        $('.insapp_loader_listing_ajax_container').css('display', 'block')
        $('.insapp_listing_ajax_container').css('visibility', 'hidden')


        var tag_filter = [];
        $('.ia-filter-tag:checked').each(function () {
            tag_filter.push($(this).val());
        });

        var medium_filter = [];
        $('.ia-filter-medium:checked').each(function () {
            medium_filter.push($(this).val());
        });

        var sous_category_filter = [];
        $('.ia-filter-sous-category:checked').each(function () {
            sous_category_filter.push($(this).val());
        });

        var sub_category = sous_category_filter;
        var title = $('#ia-filter-title').val();
        var category = $('#ia-filter-category ').val();
        var medium = medium_filter;
        var date = $('#ia-filter-date_annonce ').val();
        
        var price_min = $('#ia-price-filter-min').val();
        var price_max = $('#ia-price-filter-max').val();
         var location = {
            'name' : $('#ia-filter-lieu').val(),
            'latitude' : $('#ia-filter-lieu_latitude').val(),
            'longitude' : $('#ia-filter-lieu_longitude').val(),
            'radius' : $('#ib-radius').val() 
        };
        var tag = tag_filter;

        ia_filter_all(title, category, sub_category, medium, price_min, price_max, location, tag,date)


    });

    //filter tag
    $('.ia-filter-tag').change(function () {

        $('.insapp_loader_listing_ajax_container').css('display', 'block')
        $('.insapp_listing_ajax_container').css('visibility', 'hidden')


        var tag_filter = [];
        $('.ia-filter-tag:checked').each(function () {
            tag_filter.push($(this).val());
        });

        var medium_filter = [];
        $('.ia-filter-medium:checked').each(function () {
            medium_filter.push($(this).val());
        });

        var sous_category_filter = [];
        $('.ia-filter-sous-category:checked').each(function () {
            sous_category_filter.push($(this).val());
        });

        var sub_category = sous_category_filter;
        var title = $('#ia-filter-title').val();
        var category = $('#ia-filter-category ').val();
        var medium = medium_filter;
        var date = $('#ia-filter-date_annonce ').val();
        var price_min = $('#ia-price-filter-min').val();
        var price_max = $('#ia-price-filter-max').val();
         var location = {
            'name' : $('#ia-filter-lieu').val(),
            'latitude' : $('#ia-filter-lieu_latitude').val(),
            'longitude' : $('#ia-filter-lieu_longitude').val(),
            'radius' : $('#ib-radius').val() 
        };
        var tag = tag_filter;

        ia_filter_all(title, category, sub_category, medium, price_min, price_max, location, tag,date)


    });

    //filter medium
    $('.ia-filter-medium').change(function () {

        $('.insapp_loader_listing_ajax_container').css('display', 'block')
        $('.insapp_listing_ajax_container').css('visibility', 'hidden')


        var tag_filter = [];
        $('.ia-filter-tag:checked').each(function () {
            tag_filter.push($(this).val());
        });

        var medium_filter = [];
        $('.ia-filter-medium:checked').each(function () {
            medium_filter.push($(this).val());
        });

        var sous_category_filter = [];
        $('.ia-filter-sous-category:checked').each(function () {
            sous_category_filter.push($(this).val());
        });
        var date = $('#ia-filter-date_annonce ').val();
        var sub_category = sous_category_filter;
        var title = $('#ia-filter-title').val();
        var category = $('#ia-filter-category ').val();
        var medium = medium_filter;
        var price_min = $('#ia-price-filter-min').val();
        var price_max = $('#ia-price-filter-max').val();
         var location = {
            'name' : $('#ia-filter-lieu').val(),
            'latitude' : $('#ia-filter-lieu_latitude').val(),
            'longitude' : $('#ia-filter-lieu_longitude').val(),
            'radius' : $('#ib-radius').val() 
        };
        var tag = tag_filter;

        ia_filter_all(title, category, sub_category, medium, price_min, price_max, location, tag,date)


    });

    //filter lieu
    // $('.ia-filter-lieu').change(function () {

    //     $('.insapp_loader_listing_ajax_container').css('display', 'block')
    //     $('.insapp_listing_ajax_container').css('visibility', 'hidden')


    //     var tag_filter = [];
    //     $('.ia-filter-tag:checked').each(function () {
    //         tag_filter.push($(this).val());
    //     });

    //     var medium_filter = [];
    //     $('.ia-filter-medium:checked').each(function () {
    //         medium_filter.push($(this).val());
    //     });

    //     var sous_category_filter = [];
    //     $('.ia-filter-sous-category:checked').each(function () {
    //         sous_category_filter.push($(this).val());
    //     });
    //     var date = $('#ia-filter-date_annonce ').val();
    //     var sub_category = sous_category_filter;
    //     var title = $('#ia-filter-title').val();
    //     var category = $('#ia-filter-category ').val();
    //     var medium = medium_filter;
        
    //     var price_min = $('#ia-price-filter-min').val();
    //     var price_max = $('#ia-price-filter-max').val();
    //     var location = $('.ia-filter-lieu').val();
    //     var tag = tag_filter;

    //     ia_filter_all(title, category, sub_category, medium, price_min, price_max, location, tag,date)


    // });
    $('.ia-filter-lieu').change(function () {

        $('.insapp_loader_listing_ajax_container').css('display', 'block')
        $('.insapp_listing_ajax_container').css('visibility', 'hidden')


        var tag_filter = [];
        $('.ia-filter-tag:checked').each(function () {
            tag_filter.push($(this).val());
        });

        var medium_filter = [];
        $('.ia-filter-medium:checked').each(function () {
            medium_filter.push($(this).val());
        });

        var sous_category_filter = [];
        $('.ia-filter-sous-category:checked').each(function () {
            sous_category_filter.push($(this).val());
        });
        var date = $('#ia-filter-date_annonce ').val();
        var sub_category = sous_category_filter;
        var title = $('#ia-filter-title').val();
        var category = $('#ia-filter-category ').val();
        var medium = medium_filter;
        
        var price_min = $('#ia-price-filter-min').val();
        var price_max = $('#ia-price-filter-max').val();
        var location = {
            'name' : $('#ia-filter-lieu').val(),
            'latitude' : $('#ia-filter-lieu_latitude').val(),
            'longitude' : $('#ia-filter-lieu_longitude').val(),
            'radius' : $('#ib-radius').val() 
        }; 
        var tag = tag_filter;
        

        ia_filter_all(title, category, sub_category, medium, price_min, price_max, location, tag,date)


    });
    
          

    //filter price
    $('.ia-price-filter').change( function () {
 
        $('.insapp_loader_listing_ajax_container').css('display', 'block')
        $('.insapp_listing_ajax_container').css('visibility', 'hidden')


        var tag_filter = [];
        $('.ia-filter-tag:checked').each(function () {
            tag_filter.push($(this).val());
        });

        var medium_filter = [];
        $('.ia-filter-medium:checked').each(function () {
            medium_filter.push($(this).val());
        });

        var sous_category_filter = [];
        $('.ia-filter-sous-category:checked').each(function () {
            sous_category_filter.push($(this).val());
        });
        var date = $('#ia-filter-date_annonce ').val();

        var sub_category = sous_category_filter;
        var title = $('#ia-filter-title').val();
        var category = $('#ia-filter-category ').val();
        var medium = medium_filter;
        var price_min = $('#ia-price-filter-min').val();
        var price_max = $('#ia-price-filter-max').val();
        var location = {
            'name' : $('#ia-filter-lieu').val(),
            'latitude' : $('#ia-filter-lieu_latitude').val(),
            'longitude' : $('#ia-filter-lieu_longitude').val(),
            'radius' : $('#ib-radius').val() 
        };
        var tag = tag_filter;
       
        ia_filter_all(title, category, sub_category, medium, price_min, price_max, location, tag,date)
        
    });
    
    // filter date
    $('#ia-filter-date_annonce').change( function () {

        $('.insapp_loader_listing_ajax_container').css('display', 'block')
        $('.insapp_listing_ajax_container').css('visibility', 'hidden')

        var tag_filter = [];
        $('.ia-filter-tag:checked').each(function () {
            tag_filter.push($(this).val());
        });

        var medium_filter = [];
        $('.ia-filter-medium:checked').each(function () {
            medium_filter.push($(this).val());
        });

        var sous_category_filter = [];
        $('.ia-filter-sous-category:checked').each(function () {
            sous_category_filter.push($(this).val());
        });

        var sub_category = sous_category_filter;
        
        var title = $('#ia-filter-title').val();
         var category = $('#ia-filter-category ').val();
        var date = $(this).val();

        var medium = medium_filter; 
        var price_min = $('#ia-price-filter-min').val();
        var price_max = $('#ia-price-filter-max').val();
        var location = {
            'name' : $('#ia-filter-lieu').val(),
            'latitude' : $('#ia-filter-lieu_latitude').val(),
            'longitude' : $('#ia-filter-lieu_longitude').val(),
            'radius' : $('#ib-radius').val() 
        };
        var tag = tag_filter;

        ia_filter_all(title, category, sub_category, medium, price_min, price_max, location, tag,date)


    });

   /**********************************************
    *               vendor filter                *
    **********************************************/
    
     $('#ia-filter-profil-form').on('submit', function (e) {
        e.preventDefault();
            $('.insapp_loader_listing_ajax_container').css('display', 'block')
            $('.insapp_listing_ajax_container').css('visibility', 'hidden')
  
            var medium_filter = [];
            $('.ia-filter-medium-vendor:checked').each(function () {
                medium_filter.push($(this).val());
            }); 
          
            var title = $('#ia-filter-title-vendor').val();
            var category = $('#ia-filter-category-vendor').val(); 
            var medium = medium_filter;  
            var location = {
                'name' : $('#ia-filter-lieu-vendor').val(),
                'latitude' : $('#ia-filter-lieu_latitude').val(),
                'longitude' : $('#ia-filter-lieu_longitude').val(),
                'radius' : $('#ib-radius').val() 
            };
    
            ia_filter_all_vendor(title, category, medium, location)
     });
 
    // filter title
        $('#ia-filter-title-vendor').on('change', function () {
    
            $('.insapp_loader_listing_ajax_container').css('display', 'block')
            $('.insapp_listing_ajax_container').css('visibility', 'hidden')
  
            var medium_filter = [];
            $('.ia-filter-medium-vendor:checked').each(function () {
                medium_filter.push($(this).val());
            }); 
          
            var title = $(this).val();
            var category = $('#ia-filter-category-vendor').val(); 
            var medium = medium_filter;  
            var location = {
                'name' : $('#ia-filter-lieu-vendor').val(),
                'latitude' : $('#ia-filter-lieu_latitude').val(),
                'longitude' : $('#ia-filter-lieu_longitude').val(),
                'radius' : $('#ib-radius').val() 
            };
    
            ia_filter_all_vendor(title, category, medium, location)
        });
    
    
        // All filter execution to the ajax
        function ia_filter_all_vendor(title, category, medium, location){
    
            var data = {
                action: 'ia_custom_field_filter_vendor',
                title_filter: title,
                category_filter: category, 
                medium_filter: medium, 
                location_filter: location, 
            };
 console.log(data);
            $.post(templates_front_ajax.ajaxurl, data, function (response) {
                 console.log('response');
                  console.log(response);
                $('#ia-filtered-results').html(response.content);
                $('.insapp_loader_listing_ajax_container').css('display', 'none')
                $('.insapp_listing_ajax_container').css('visibility', 'visible')
    
            }, 'json');
    
        }
    
       // filter category
        $('#ia-filter-category-vendor').on('change', function () {
    
            $('.insapp_loader_listing_ajax_container').css('display', 'block')
            $('.insapp_listing_ajax_container').css('visibility', 'hidden')
    
            var medium_filter = [];
            $('.ia-filter-medium-vendor:checked').each(function () {
                medium_filter.push($(this).val());
            });
     
            var title = $('#ia-filter-title-vendor').val();
            var category = $('#ia-filter-category-vendor').val();
            var medium = medium_filter; 
            var location = {
                'name' : $('#ia-filter-lieu-vendor').val(),
                'latitude' : $('#ia-filter-lieu_latitude').val(),
                'longitude' : $('#ia-filter-lieu_longitude').val(),
                'radius' : $('#ib-radius').val() 
            };
    
    
            ia_filter_all_vendor(title, category, medium, location)
    
        });
        
        
       //filter medium
        $('.ia-filter-medium-vendor').change(function () {
    
            $('.insapp_loader_listing_ajax_container').css('display', 'block')
            $('.insapp_listing_ajax_container').css('visibility', 'hidden')
    
            var medium_filter = [];
            $('.ia-filter-medium-vendor:checked').each(function () {
                medium_filter.push($(this).val());
            });
     
            var title = $('#ia-filter-title-vendor').val();
            var category = $('#ia-filter-category-vendor ').val();
            var medium = medium_filter; 
            var location = {
                'name' : $('#ia-filter-lieu-vendor').val(),
                'latitude' : $('#ia-filter-lieu_latitude').val(),
                'longitude' : $('#ia-filter-lieu_longitude').val(),
                'radius' : $('#ib-radius').val() 
            };
    
    
             ia_filter_all_vendor(title, category, medium, location)
    
    
        });
    
        //filter lieu
        $('.ia-filter-lieu-vendor').change(function () {
    
            $('.insapp_loader_listing_ajax_container').css('display', 'block')
            $('.insapp_listing_ajax_container').css('visibility', 'hidden')
    
            var medium_filter = [];
            $('.ia-filter-medium-vendor:checked').each(function () {
                medium_filter.push($(this).val());
            });
     
            var title = $('#ia-filter-title-vendor').val();
            var category = $('#ia-filter-category-vendor ').val();
            var medium = medium_filter; 
            var location = {
                'name' : $('#ia-filter-lieu-vendor').val(),
                'latitude' : $('#ia-filter-lieu_latitude').val(),
                'longitude' : $('#ia-filter-lieu_longitude').val(),
                'radius' : $('#ib-radius').val() 
            };
    
    
             ia_filter_all_vendor(title, category, medium, location)
    
    
        });


    /**********************************************
    *     Gallery library: Declaration      *
    **********************************************/

    $('.portfolio-menu ul li').click(function () {
        $('.portfolio-menu ul li').removeClass('active');
        $(this).addClass('active');

        var selector = $(this).attr('data-filter');
        $('.portfolio-item').isotope({
            filter: selector
        });
        return false;
    });
    $(document).ready(function () {
        var popup_btn = $('.popup-btn');
        popup_btn.magnificPopup({
            type: 'image',
            gallery: {
                enabled: true
            }
        });
    });


    /**********************************************
     *     Reviews interaction     *
     **********************************************/
     
     

    $('#review-stars-work li ').hover(function () {
        console.log('ffffff');
        $(this).addClass('active');
        $(this).prevAll().addClass('active');
        console.log($(this).prevAll());
        $(this).nextAll().removeClass('active');
        console.log($(this).nextAll());

    });


    $('#review-stars-work li').on('click', function () {
        let active = $('.review-stars li').filter(function () {
            return $(this).hasClass('active');
        }).length;

        $('#insapp_overall_rating').val(active);
    });


    /**********************************************
     *              Submit reviews               *
     **********************************************/

    $('#insapp_commentform').submit(function (e) {

        e.preventDefault();
        $('.insapp_reviews_sucess').removeClass("insapp_reviews_sucess_display")
        $('.insapp_reviews_sucess').removeClass("insapp_reviews_echec_display")
        $('.insapp_btn_message').attr("disabled", "disabled");

        let rate = $('#insapp_overall_rating').val()
        let comment = $('#insapp_comment').val()


        let data = {
            'action': 'insapp_save_reviews',
            'rate': rate,
            'comment': comment,
            'product_id': $('#the_id').val(),
            'author_id': $('#insapp_author_id').attr('data-id'),
        }
        console.log(data);
        jQuery.post(service_front_ajax.ajaxurl, data, function (response) {
            console.log(response);
       
            if(response.code == 200){
                  $('.insapp_reviews_sucess').addClass("insapp_reviews_sucess_display")
                  location.reload();
            }else{
                 $('.insapp_reviews_sucess').removeClass("insapp_reviews_echec_display")
                  $('.insapp_reviews_sucess').html("Une erreur c'est produite veuillez réessayer")
                 $('.insapp_btn_message').removeAttr("disabled")
                 
                
            }
       
          
        })

    });
    
    
   /**********************************************
   *     Search bar: date     *
   **********************************************/

   $(".insapp_search_date").flatpickr({
        enableTime: false,
        // mode: "range",
        minDate: "today", 
        locale: {
            firstDayOfWeek: 1,
            weekdays: {
                shorthand: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
                longhand: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
            },
            months: {
                shorthand: ['jan', 'Fev', ',Mar', 'Avr', 'Mai', 'jun', 'Jul', 'Aou', 'Sep', 'Oct', 'Nov', 'Déc'],
                longhand: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
            },
        },
    });

    $("#ia-filter-date_annonce").flatpickr({
        enableTime: false,
        // mode: "range",
        minDate: "today", 
        locale: {
            firstDayOfWeek: 1,
            weekdays: {
                shorthand: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
                longhand: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
            },
            months: {
                shorthand: ['jan', 'Fev', ',Mar', 'Avr', 'Mai', 'jun', 'Jul', 'Aou', 'Sep', 'Oct', 'Nov', 'Déc'],
                longhand: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
            },
        },
    });




}); 
