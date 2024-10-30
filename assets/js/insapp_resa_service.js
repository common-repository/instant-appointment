jQuery(document).ready(function ($) {

   
   /**
    * The function checks if the number of guests is within the capacity limit.
    * @param nbr_invit - The number of invitations that have been sent or the number of people who have
    * RSVP'd for an event.
    * @param capacity - The maximum capacity of a venue or event.
    * @returns The function `verify_cap` returns a boolean value (`true` or `false`) depending on
    * whether the `nbr_invit` parameter is between 1 and `capacity` (inclusive) or not.
    */
    function verify_cap(nbr_invit, capacity) {
        if (nbr_invit >= 1 && nbr_invit <= capacity) return true
        else return false
    }

    /* This code is attaching a click event listener to the element with the ID `#insapp_resa_send`.
    When this element is clicked, the function inside the `on` method is executed. */
    $('#insapp_resa_send').on("click", function () {

        let resa_name = $('#customer_name').val()
        let resa_surname = $('#customer_surname').val()
        let resa_email = $('#customer_email').val()
        let resa_tel = $('#customer_tel').val()
        let service_id = $('#insapp_ser_id').val()
        let checkedValue = $('.select_extra');
        let resa_extras = [];

       /* This code is selecting all elements with the class `select_extra` and iterating over them
       using the `each()` method. For each element, it checks if it is checked using the `is()`
       method with the `:checked` selector. If the element is checked, its value is added to the
       `resa_extras` array using the `push()` method. This code is used to collect all the selected
       extras for a reservation. */
        checkedValue.each(function () {
            if ($(this).is(":checked")) {
                resa_extras.push($(this).val());
            }
        });

        let resa_cap = $('#customer_cap').val()
        let resa_date = $('#customer_date').val()
        let resa_time = $('#customer_time').val()
        let resa_unit = $('#resa_unit').val()
        let service_cap = $('#insapp_ser_cap').val()
        let status = 'en attente'

        /* This code block is checking if the number of guests entered by the user (`resa_cap`) is
        within the capacity limit of the venue or event (`service_cap`) using the `verify_cap()`
        function. If the number of guests is within the limit, it removes the `invalid-feedback`
        class from the `#feedback_capacity` element and the `invalid-input` class from the
        `#customer_cap` element. It then creates an object `data` with various reservation details
        and sends it to the server using the `jQuery.post()` method. The server responds with a
        `response` object, which is used to update the HTML content of various elements on the page.
        If the number of guests is not within the limit, it adds the `invalid-feedback` class to the
        `#feedback_capacity` element and the `invalid-input` class to the `#customer_cap` element
        and logs an error message to the console. */
        if (verify_cap(resa_cap, service_cap)) {
            $('#feedback_capacity').removeClass('invalid-feedback')
            $('#customer_cap').removeClass('invalid-input')
            let data = {
                'action': 'service_reservation',
                'nom': resa_name,
                'prenom': resa_surname,
                'service_id': service_id,
                'telephone': resa_tel,
                'email': resa_email,
                'date_rdv': resa_date,
                'nbr_present': resa_cap,
                'deb_heure': resa_time,
                'resa_unit': resa_unit,
                'service_cap': service_cap,
                'resa_extras': JSON.stringify(resa_extras),
                'status': status,
            }
            console.log(data)

            /* This code block is sending a POST request to the server using the `jQuery.post()`
            method. The `service_resa_ajax.ajaxurl` variable contains the URL of the server endpoint
            that handles the request. The `data` object contains various reservation details that
            are sent to the server. The function inside the `post()` method is a callback function
            that is executed when the server responds to the request. The `response` parameter
            contains the response object sent by the server. The function logs the `response` object
            to the console and updates the HTML content of various elements on the page with the
            reservation details received from the server. */
            jQuery.post(service_book_ajax.ajaxurl, data, function (response) {
                console.log(response) 
                $('#cap_resa').html('<b>' + response.nbr_present + '</b>')
                $('#unit_price').html('<b>' + response.resa_unit + 'XAX</b>')
                $('#total_price').html('<b>' + (response.nbr_present) * (response.resa_unit) + 'XAX</b>')
            })
        }else{

            $('#feedback_capacity').addClass('invalid-feedback')
            $('#customer_cap').addClass('invalid-input')
            console.log('Nombre de places insuffisant!')
        }

    })
})