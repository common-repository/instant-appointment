
jQuery(document).ready(function ($) {

    $('body').on('click', '.insapp_upload_image_button', function (e) {
        console.log('hello')
        e.preventDefault();
        insapp_uploader = wp.media({
            title: 'Custom image',
            button: {
                text: 'Use this image'
            },
            multiple: false
        }).on('select', function () {
            var attachment = insapp_uploader.state().get('selection').first().toJSON();
            $('#insapp-cat-image').attr('src', attachment.url);
        })
            .open();
    });

})




window.dataLayer = window.dataLayer || [];
function gtag() { dataLayer.push(arguments); }
gtag('js', new Date());

gtag('config', 'G-M8S4MT3EYG');





