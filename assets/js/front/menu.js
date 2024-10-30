jQuery(document).ready(function ($) {
    $('#insapp_index_das').click(function(){
        let tab = $('#insapp_index_das_input').val()
        let data = {
            'action': 'relocate_to_index',
            'page': tab,
        }
        console.log(data)
        jQuery.post(menu_ajax.ajaxurl, data, function (response){
            console.log(response)
            localStorage.setItem('jstabs-opentab', 10)
        })
    })
})

