/******* Get the public key of stripe *********/
const sitekey = document.currentScript.getAttribute('SITEKEY');

 /******* load google recaptcha  *********/
var onloadCallback = function() { 

    // jQuery('.insapp_btn').attr("disabled", "disabled");
  if(document.getElementById('insapp-recaptcha')){
       grecaptcha.render('insapp-recaptcha', {
          'sitekey' : sitekey,
          'callback' : onYes,
        });
   }
}
    
function onYes(){
    jQuery('.insapp_btn').removeAttr("disabled")
}

/******* Toggle to display password  *********/
const pwShowHide = document.querySelectorAll(".insapp_pw_hide");

pwShowHide.forEach((icon) => {
    icon.addEventListener("click", () => {
        let getPwInput = icon.parentElement.querySelector("input");
        if (getPwInput.type === "password") {
            getPwInput.type = "text";
            console.log(icon);
            icon.classList.replace("bi-eye-slash", "bi-eye");
        } else {
            getPwInput.type = "password";
            icon.classList.replace("bi-eye", "bi-eye-slash");
            console.log(icon);
        }
    });
});


jQuery(document).ready(function ($) {

    $('#dropdownNotification').dropdown();
    /*$('.dropdown-toggle').on('click', function (e) {
        alert('hello');
    });*/

    const loginText = document.querySelector(".insapp_title_text .insapp_login");
    const signupText = document.querySelector(".insapp_title_text .insapp_register");
    const loginForm = document.querySelector("form.insapp_login");
    const signupForm = document.querySelector("form.insapp_register");
    const loginBtn = document.querySelector("label.insapp_login");
    const signupBtn = document.querySelector("label.insapp_register");
    const signupLink = document.querySelector("form .insapp_signup_link a");

    // signupText.style.display = "none";
    // signupForm.style.display = "none";
    if (signupBtn != null) {
        signupBtn.onclick = (() => {
            //   loginForm.style.marginLeft = "-50%";insapp_active_login
            //   loginText.style.marginLeft = "-50%"; 
            signupText.style.display = "block";
            signupForm.style.display = "block";
            //   signupBtn.style.display = "block";
            loginForm.style.display = "none";
            //   loginBtn.style.display = "none";
            loginText.style.display = "none";
        });
    }
    if (loginBtn != null) {
        loginBtn.onclick = (() => {
            //   loginForm.style.marginLeft = "0%";
            //   loginText.style.marginLeft = "0%";
            signupText.style.display = "none";
            signupForm.style.display = "none";
            //   signupBtn.style.display = "none";
            loginForm.style.display = "block";
            //   loginBtn.style.display = "block";
            loginText.style.display = "block";
        });
    }
    if (signupLink != null) {
        signupLink.onclick = (() => {
            signupBtn.click();
            return false;
        });
    }

    
    $('#insapp_login_user_form').on('submit', function (e) {

        e.preventDefault();
        $('.insapp_notification').css('display', 'none')
        $('.insapp_notification_sucess').css('display', 'none')
        $('.insapp_btn').attr("disabled", "disabled");
        let email = $('#insapp_logname').val()
        let password = $('#insapp_log_password').val()
        $('#insapp_login_user_form .notification').removeClass('error').addClass('notice').show().text();

        let data = {
            "action": 'login_user_ajax',
            "email": email,
            "password": password,
        };

        jQuery.post(insapp_user_login.ajaxurl, data, function (response) {
            if (response.loggedin == true) {
                $('.insapp_notification_sucess').css('display', 'flex')
                $('.insapp_notification_sucess').html(response.message)

                setTimeout(function () {
                    e.currentTarget.submit()
                }, 2000);


            } else {

                $('.insapp_btn').removeAttr("disabled");
                $('.insapp_notification').css('display', 'flex')
                $('.insapp_notification').html(response.message)
            }

        })
    });


    function verify_pw(password, conf_password) {
        if (password !== conf_password) {
            return 0;
        } else {
            return 1;
        }
    }

 
    $('#insapp_register_user_form').on('submit', function (e) {

        e.preventDefault();
        var response = grecaptcha.getResponse();
        message = 'Veuillez compléter le reCAPTCHA'
        if (response.length === 0) {
            
            $('.insapp_notification').css('display', 'flex')
            $('.insapp_notification').html(message);
        } else { 
            
            ia_inscription_ofer_verification(e);
           
        }

    });


    function ia_inscription_ofer_verification(e){

         $('.insapp_notification').css('display', 'none')
        $('.insapp_notification_sucess').css('display', 'none')
        $('.insapp_btn').attr("disabled", "disabled");
        let role = $('input[name="insapp-role"]:checked').val()
        let nom = $('#insapp_firstname').val()
        let prenom = $('#insapp_lastname').val()
        let email = $('#insapp_useremail').val()
        let password = $('#insapp_userpassword').val()
        let conf_password = $('#insapp_conf_userpassword').val()
        let privacy_policy = $('#insapp_register_user_form #insapp_terms_and_conditions:checked').val()
         
        if (verify_pw(password, conf_password) == 1) {
           
            if (password.length < 8) {

                $('.insapp_btn').removeAttr("disabled")
                $('.insapp_notification').css('display', 'flex')
                $('.insapp_notification').html('le mot de passe est trop court.Il faut minimum 8 chiffres')


            } else {
            
                $('#insapp_register_user_form .notification').removeClass('error').addClass('notice').show().text();

                let data = {
                    "action": 'register_user_ajax',
                    "privacy_policy": privacy_policy,
                    "email": email,
                    "nom": nom,
                    "prenom": prenom,
                    "password": password,
                    "role": role,
                }; 

                jQuery.post(insapp_user_login.ajaxurl, data, function (response) {
     console.log(response);
                    if (response.registered == true) {

                        $('.insapp_notification_sucess').css('display', 'flex')
                        $('.insapp_notification_sucess').html(response.message)

                        setTimeout(function () {
                            e.currentTarget.submit()
                        }, 1000);

                    } else {
                        $('.insapp_btn').removeAttr("disabled");
                        $('.insapp_notification').css('display', 'flex')
                        $('.insapp_notification').html(response.message)
                    }

                });

            }

        } else {
            $('.insapp_btn').removeAttr("disabled")
            $('.insapp_notification').css('display', 'flex')
            $('.insapp_notification').html('les mots de passe ne correspondent pas')

        }
    }


}); 
// function onSubmit(token) {
//     console.log(token);
    
//     g-recaptchahh
//     document.getElementById('g-recaptcha-response').value = token;
//     let data = {
//         "action": 'ia_verif_token_captcha',
//         "token_recaptcha": token, 
//     }; 
//     console.log(data);
//     jQuery.post(insapp_user_login.ajaxurl, data, function (response) {
//       console.log(response);
//       if (response.code == 200) {
//             // ia_inscription_ofer_verification()

//         }else if(response.code == 400){

//         }else {
         
//         }
//     });
  
//     // document.getElementById("insapp_login_user_form").submit();
// }