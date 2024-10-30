// const { DEFAULT_BREAKPOINTS } = require("react-bootstrap/esm/ThemeProvider");


//  document.getElementsByClassName('fc-dayGridMonth-button')[0].click();

function addRow() {
    var table = document.getElementById("ia_timeTable");
    var row = table.insertRow();
    var cell1 = row.insertCell();
    var cell2 = row.insertCell();
    var cell3 = row.insertCell();
    cell1.innerHTML = '<input type="time" class="form-control" name="start_time[]" />';
    cell2.innerHTML = '<input type="time" class="form-control" name="end_time[]" />';
    cell3.innerHTML = '<button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon-xs"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></button>';
}

function removeRow(button) {
    var row = button.parentNode.parentNode;
    var table = row.parentNode.parentNode;
    table.deleteRow(row.rowIndex);
}

// document.getElementById('fc-myCustomButton3-button').style.visibility = 'hidden';

// console.log(document.getElementById('fc-dayGridMonth-button'));

// document.addEventListener('DOMContentLoaded', function () {

jQuery(document).ready(function ($) {

     $('.ia_save_new_agenda_calendar').attr("disabled", "disabled");
    $('.ia_save_new_agenda_calendar').click(function (e) {
        insapp_sendEventList();
    });
    
    $('.ia_calendar_step').click(function (e) {
        e.preventDefault();

        $('.insapp_notification_agenda').css('display', 'none')
        $('.insapia_calendar_stepp_btn').attr("disabled", "disabled");

        $('.insapp_loader_ajax_containeradmin').css('display', 'initial')
        $('.ia_calendar_block').css('display', 'none')
        $('.ia_calendar_content').css('min-height', '100px')

        if ($('.ia_time_start_step').val() != '' && $('.ia_time_end_step').val() != '') {

            var selected = [];
            $('#ia_checkboxes input:checked').each(function () {
                selected.push($(this).attr('name'));
            });

            let data = {
                'action': "agenda_step_default_ajax",
                'user_id': $('.insapp_user').val(),
                'agenda_default': selected,
                'starthour': $('.ia_time_start_step').val(),
                'endhour': $('.ia_time_end_step').val(),
                'starthour2': $('.ia_time_start_step2').val(),
                'endhour2': $('.ia_time_end_step2').val(),
            }

            jQuery.post(insapp_agenda_ajax.ajaxurl, data, function (response) {
 
                let starthours = response.data.starthours
                let endhours = response.data.endhours
                let starthours2 = response.data.starthours2
                let endhours2 = response.data.endhours2

                var timeStarthours = starthours.split(":")[0];
                var timeStartminutes = starthours.split(":")[1];

                var timeEndhours = endhours.split(":")[0];
                var timeEndtminutes = endhours.split(":")[1];

                var timeStarthours2 = starthours2.split(":")[0];
                var timeStartminutes2 = starthours2.split(":")[1];

                var timeEndhours2 = endhours2.split(":")[0];
                var timeEndtminutes2 = endhours2.split(":")[1];

                removeAllEventSources();


                if (response.data.success == true) {

                    var workingDays = response.data.agenda_default;
                    var events = [];
                    
                    workingDays.forEach(function (day) {

                        switch (day) {

                            case 'lundi':
                                for (var d = moment().startOf('week').add(1, 'days'); d.isBefore(moment().endOf('quarter')); d.add(1, 'week')) {
                                    events.push({
                                        title: 'crénaux',
                                        start: d.clone().hours(parseInt(timeStarthours)).format('YYYY-MM-DDTHH:mm:ss'),
                                        end: d.clone().hours(parseInt(timeEndhours)).format('YYYY-MM-DDTHH:mm:ss'),
                                        color: 'blueviolet',   // an option!
                                        textColor: 'white'
                                    });

                                    events.push({
                                        title: 'crénaux',
                                        start: d.clone().hours(parseInt(timeStarthours2)).format('YYYY-MM-DDTHH:mm:ss'),
                                        end: d.clone().hours(parseInt(timeEndhours2)).format('YYYY-MM-DDTHH:mm:ss'),
                                        color: 'blueviolet',   // an option!
                                        textColor: 'white'
                                    });
                                }
                                break;
                            case 'mardi':
                                for (var d = moment().startOf('week').add(2, 'days'); d.isBefore(moment().endOf('quarter')); d.add(1, 'week')) {
                                    events.push({
                                        title: 'crénaux',
                                        start: d.clone().hours(parseInt(timeStarthours)).format('YYYY-MM-DDTHH:mm:ss'),
                                        end: d.clone().hours(parseInt(timeEndhours)).format('YYYY-MM-DDTHH:mm:ss'),
                                        color: 'blueviolet',   // an option!
                                        textColor: 'white',
                                        eventBackgroundColor: 'blueviolet'
                                    });

                                    events.push({
                                        title: 'crénaux',
                                        start: d.clone().hours(parseInt(timeStarthours2)).format('YYYY-MM-DDTHH:mm:ss'),
                                        end: d.clone().hours(parseInt(timeEndhours2)).format('YYYY-MM-DDTHH:mm:ss'),
                                        color: 'blueviolet',   // an option!
                                        textColor: 'white'
                                    });


                                }
                                break;
                            case 'mercredi':
                                for (var d = moment().startOf('week').add(3, 'days'); d.isBefore(moment().endOf('quarter')); d.add(1, 'week')) {
                                    events.push({
                                        title: 'crénaux',
                                        start: d.clone().hours(parseInt(timeStarthours)).format('YYYY-MM-DDTHH:mm:ss'),
                                        end: d.clone().hours(parseInt(timeEndhours)).format('YYYY-MM-DDTHH:mm:ss'),
                                        color: 'blueviolet',   // an option!
                                        textColor: 'white',
                                        eventBackgroundColor: 'blue'
                                    });
                                    events.push({
                                        title: 'crénaux',
                                        start: d.clone().hours(parseInt(timeStarthours2)).format('YYYY-MM-DDTHH:mm:ss'),
                                        end: d.clone().hours(parseInt(timeEndhours2)).format('YYYY-MM-DDTHH:mm:ss'),
                                        color: 'blueviolet',   // an option!
                                        textColor: 'white'
                                    });
                                }
                                break;

                            case 'jeudi':
                                for (var d = moment().startOf('week').add(4, 'days'); d.isBefore(moment().endOf('quarter')); d.add(1, 'week')) {
                                    events.push({
                                        title: 'crénaux',
                                        start: d.clone().hours(parseInt(timeStarthours)).format('YYYY-MM-DDTHH:mm:ss'),
                                        end: d.clone().hours(parseInt(timeEndhours)).format('YYYY-MM-DDTHH:mm:ss'),
                                        color: 'blueviolet',   // an option!
                                        textColor: 'white'
                                    });
                                    events.push({
                                        title: 'crénaux',
                                        start: d.clone().hours(parseInt(timeStarthours2)).format('YYYY-MM-DDTHH:mm:ss'),
                                        end: d.clone().hours(parseInt(timeEndhours2)).format('YYYY-MM-DDTHH:mm:ss'),
                                        color: 'blueviolet',   // an option!
                                        textColor: 'white'
                                    });
                                }
                                break;
                            case 'vendredi':
                                for (var d = moment().startOf('week').add(5, 'days'); d.isBefore(moment().endOf('quarter')); d.add(1, 'week')) {
                                    events.push({
                                        title: 'crénaux',
                                        start: d.clone().hours(parseInt(timeStarthours)).format('YYYY-MM-DDTHH:mm:ss'),
                                        end: d.clone().hours(parseInt(timeEndhours)).format('YYYY-MM-DDTHH:mm:ss'),
                                        color: 'blueviolet',   // an option!
                                        textColor: 'white'
                                    });
                                    events.push({
                                        title: 'crénaux',
                                        start: d.clone().hours(parseInt(timeStarthours2)).format('YYYY-MM-DDTHH:mm:ss'),
                                        end: d.clone().hours(parseInt(timeEndhours2)).format('YYYY-MM-DDTHH:mm:ss'),
                                        color: 'blueviolet',   // an option!
                                        textColor: 'white'
                                    });
                                }
                                break;
                            case 'samedi':
                                for (var d = moment().startOf('week').add(6, 'days'); d.isBefore(moment().endOf('quarter')); d.add(1, 'week')) {
                                    events.push({
                                        title: '',
                                        start: d.clone().hours(parseInt(timeStarthours)).format('YYYY-MM-DDTHH:mm:ss'),
                                        end: d.clone().hours(parseInt(timeEndhours)).format('YYYY-MM-DDTHH:mm:ss'),
                                        color: 'blueviolet',   // an option!
                                        textColor: 'white'
                                    });
                                    events.push({
                                        title: 'crénaux',
                                        start: d.clone().hours(parseInt(timeStarthours2)).format('YYYY-MM-DDTHH:mm:ss'),
                                        end: d.clone().hours(parseInt(timeEndhours2)).format('YYYY-MM-DDTHH:mm:ss'),
                                        color: 'blueviolet',   // an option!
                                        textColor: 'white'
                                    });
                                }
                                break;
                            case 'dimanche':
                                for (var d = moment().startOf('week').add(0, 'days'); d.isBefore(moment().endOf('quarter')); d.add(1, 'week')) {
                                    events.push({
                                        title: '',
                                        start: d.clone().hours(parseInt(timeStarthours)).format('YYYY-MM-DDTHH:mm:ss'),
                                        end: d.clone().hours(parseInt(timeEndhours)).format('YYYY-MM-DDTHH:mm:ss'),
                                        color: 'blueviolet',   // an option!
                                        textColor: 'white'
                                    });
                                    events.push({
                                        title: 'crénaux',
                                        start: d.clone().hours(parseInt(timeStarthours2)).format('YYYY-MM-DDTHH:mm:ss'),
                                        end: d.clone().hours(parseInt(timeEndhours2)).format('YYYY-MM-DDTHH:mm:ss'),
                                        color: 'blueviolet',   // an option!
                                        textColor: 'white'
                                    });
                                }
                                break;

                            default:

                                break;
                        }

                    });
                    // console.log(events);
                     $('.ia_save_new_agenda_calendar').removeAttr("disabled");
                     
                    calendarinsapp.addEventSource(events);

                    refreshCalendar();
                    // $('.fc-dayGridMonth-button').click("disabled");
                    setTimeout(function() {
                       $('.fc-dayGridMonth-button').click();
                     }, 500);
                     
                    $('.insapp_btn').removeAttr("disabled");

                    jQuery.toast({
                        heading: 'success',
                        text: "Votre agenda a été modifié avec succés",
                        showHideTransition: 'plain',
                        position: 'top-right',
                        icon: 'success',
                        hideAfter: 5000,
                    });
                    $('.insapp_notification_agenda').css('display', 'flex')
                    $('.insapp_notification_agenda').html('Proposition d\'agenda veuillez enregistrer si cela vous correspond')



                } else {
                    jQuery.toast({
                        heading: 'success',
                        text: 'une erreur c\'est produite veuillez réessayer',
                        showHideTransition: 'plain',
                        position: 'top-right',
                        icon: 'success',
                        hideAfter: 5000,
                    });

                    $('.insapp_btn').removeAttr("disabled");
                    $('.insapp_notification_agenda').css('display', 'flex')
                    $('.insapp_notification_agenda').html('une erreur c\'est produite veuillez réessayer')
                }

                $('.insapp_loader_ajax_containeradmin').css('display', 'none')
                $('.ia_calendar_block').css('display', 'flex')
                $('.ia_calendar_content').css('min-height', '1000px')

            });
        } else {

            $('.insapp_btn').removeAttr("disabled");
            $('.insapp_notification_agenda').css('display', 'flex')
            $('.insapp_notification_agenda').html('Veuillez remplir tous les champs')
           
        }
  

    });
  $('.fc-icon-chevron').before('<svg data-name="Layer 1" height="32" id="Layer_1" viewBox="0 0 32 32" width="32" xmlns="http://www.w3.org/2000/svg"><path d="M22,4.5v6H10v11H4V6.5a2.0059,2.0059,0,0,1,2-2Z" fill="#4285f4"/><polygon fill="#ea4435" points="22 27.5 22 21.5 28 21.5 22 27.5"/><rect fill="#ffba00" height="12" width="6" x="22" y="9.5"/><rect fill="#00ac47" height="12" transform="translate(40.5 8.5) rotate(90)" width="6" x="13" y="18.5"/><path d="M28,6.5v4H22v-6h4A2.0059,2.0059,0,0,1,28,6.5Z" fill="#0066da"/><path d="M10,21.5v6H6a2.0059,2.0059,0,0,1-2-2v-4Z" fill="#188038"/><path d="M15.69,17.09c0,.89-.66,1.79-2.15,1.79a3.0026,3.0026,0,0,1-1.52-.39l-.08-.06.29-.82.13.08a2.3554,2.3554,0,0,0,1.17.34,1.191,1.191,0,0,0,.88-.31.8586.8586,0,0,0,.25-.65c-.01-.73-.68-.99-1.31-.99h-.54v-.81h.54c.45,0,1.12-.22,1.12-.82,0-.45-.31-.71-.85-.71a1.8865,1.8865,0,0,0-1.04.34l-.14.1-.28-.79.07-.06a2.834,2.834,0,0,1,1.53-.45c1.19,0,1.72.73,1.72,1.45a1.4369,1.4369,0,0,1-.81,1.3A1.52,1.52,0,0,1,15.69,17.09Z" fill="#4285f4"/><polygon fill="#4285f4" points="18.71 12.98 18.71 18.79 17.73 18.79 17.73 14 16.79 14.51 16.58 13.69 17.95 12.98 18.71 12.98"/></svg> Synchroniser avec google');


});
function refreshCalendar() {

    calendarinsapp.refetchEvents();
}


var calendarEl = document.getElementById('insapp-calendar-agenda');
  
if(calendarEl != null){    
    var calendarinsapp = new FullCalendar.Calendar(calendarEl, {
        customButtons: {
            myCustomButton2: { 
                text: 'Synchroniser avec google',
                icon: 'chevron', 
                click: function () {
                    insapp_synchroniseGoogle();
                },
                id: 'insapp_google_id_onload',
            },
            myCustomButton3: {
                text: 'Deconnecter',
                click: function () {
                    insapp_deconnectGoogle();
                },
                id: 'insapp_google_id_log_out',
            }
        },
        headerToolbar: {
            left: 'prev,next ,today',
            center: 'title',
            right: 'myCustomButton2 myCustomButton3 dayGridMonth,listMonth',
        },
        initialView: 'dayGridMonth',
        locale: 'fr',
        allDayText: 'Jours',
        weekends: true,
        buttonText: {
            today: 'Aujourd\'hui',
            month: 'Mois',
            list: 'liste'
        },
        initialDate: new Date(),
        navLinks: true, // can click day/week names to navigate views
        businessHours: true,
        selectable: true,
        eventContent: function (info) {
            var startTime = '';
            var endTime = '';
            if (info.event.start && info.event.end) {
                startTime = info.event.start.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                endTime = info.event.end.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            }
            var eventColor = info.event.backgroundColor;
            var textColor = info.event.textColor;
    
            return {
                html: '<div class="event-wrapper insapp_calendar_style" style="background-color: ' + eventColor + '; color: ' + textColor + ';">' +
                    '<span>' + startTime + ' - ' + endTime + '</span>' + '</div>',
                display: 'initial'
            };
    
        },
        dateClick: function (info) {
            var dateClicked = info.date;
            afficherFormulaireModal(dateClicked);
        },
        eventSources: [
    
            {
                url: insapp_agenda_ajax.ajaxurl, // L'URL de l'endpoint AJAX
                extraParams: {
                    action: 'select_default_agenda',
                    param1: document.getElementsByClassName('insapp_user')[0].value,
                },
                method: 'GET',
                success: function (response) {
                    
                    workingDays = response.data
                    var eventsouces = []
                    workingDays.forEach(function (day) {
                        date = day.date_event
                        ing = JSON.parse(JSON.stringify(day.star_time))
                        net = ing.replace(/[{\"\]} ]/g, "")
                        str = net.split(",")
    
                        var timeStart = str[0]
                        var timeEnd = str[1]
    
                        eventsouces.push({
                            title: 'crénaux',
                            start: moment(date).hours(parseInt(timeStart)).format('YYYY-MM-DDTHH:mm:ss'),
                            end: moment(date).hours(parseInt(timeEnd)).format('YYYY-MM-DDTHH:mm:ss'),
                            color: 'blueviolet',
                            textColor: 'white'
                        });
    
                    }); 
    
                    calendarinsapp.addEventSource(eventsouces);
                   
                },
                failure: function () {
                    alert('echec lors du chargement du calendrier');
                }
    
            }
        ],
        eventRender: function (info) {
            // Créer un élément HTML pour afficher l'événement
            var eventElement = document.createElement('div');
            eventElement.classList.add('event');
            eventElement.textContent = info.event.title;
    
            // Ajouter l'élément à la cellule correspondant à la date de l'événement
            info.el.appendChild(eventElement);
        },
        eventClick: function (arg) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cet événement ?')) {
                arg.event.remove()
            }
        },
    
    });
    
    calendarinsapp.render();
}

function removeAllEventSources() {
    var eventSources = calendarinsapp.getEventSources();
    eventSources.forEach(function (source) {
        source.remove();
    });
}

function afficherFormulaireModal(date) {
    var modal = new bootstrap.Modal(document.getElementById('insapp_creneauModal'));
    modal.show();

    var formcrenaux = document.getElementById('insapp_creneauForm');
    document.body.contains(formcrenaux) && formcrenaux.addEventListener("submit", function (e) {

        e.preventDefault();
        var timeStart = jQuery('.ia_time_start_new').val()
        var timeEnd = jQuery('.ia_time_end_new').val()

        console.log(timeStart);
        console.log(timeEnd);
        console.log('timeStart');
        if ((timeEnd && timeStart) && (timeEnd > timeStart)) {

            var newslot = {
                title: 'crénaux',
                start: moment(date).hours(parseInt(timeStart)).format('YYYY-MM-DDTHH:mm:ss'),
                end: moment(date).hours(parseInt(timeEnd)).format('YYYY-MM-DDTHH:mm:ss'),
                color: 'blueviolet',
                textColor: 'white'
            };

            Sendtimeslot(newslot);
            calendarinsapp.addEvent(newslot);
        }
        formcrenaux.reset()
        modal.hide();
    });
}

function insapp_getEventList() {
    var events = calendarinsapp.getEvents();

    var eventData = events.map(function (event) {
        return {
            date: moment(event.start).format('YYYY-MM-DD'),
            times: moment(event.start).format('HH:mm') + ',' + moment(event.end).format('HH:mm'),
        };
    });
    return eventData;
}

function insapp_sendEventList() {
    var eventData = insapp_getEventList();

    let data = {
        'action': "ajax_insert_agenda",
        'events': eventData,
        'user_id': jQuery('.insapp_user').val(),
    }

    jQuery.post(insapp_agenda_ajax.ajaxurl, data, function (response) {
      
        if (response.success == true) {

            jQuery.toast({
                heading: 'success',
                text: response.data.message,
                showHideTransition: 'plain',
                position: 'top-right',
                icon: 'success',
                hideAfter: 5000,
            });
            location.reload();

        } else {
            jQuery.toast({
                heading: 'Warning',
                text: response.data.message,
                showHideTransition: 'plain',
                position: 'top-right',
                icon: 'warning',
                hideAfter: 8000,
            });
        }
    });



}

function Sendtimeslot(eventData) {
    eventData = {
        date: moment(eventData.start).format('YYYY-MM-DD'),
        times: moment(eventData.start).format('HH:mm') + ', ' + moment(eventData.end).format('HH:mm'),
    };

    let data = {
        'action': "ajax_insert_unique_agenda",
        'events': eventData,
        'user_id': jQuery('.insapp_user').val(),
    }


    jQuery.post(insapp_agenda_ajax.ajaxurl, data, function (response) {

        if (response.success == true) {
            location.reload();


        } else {
            alert('error');
        }
    });
}

function insapp_synchroniseGoogle() {
    handleAuthClick()
}

function insapp_deconnectGoogle() {
    handleSignoutClick()
}

function fetchEvents(accessToken) {

    const calendarApiUrl = 'https://www.googleapis.com/calendar/v3/calendars/primary/events';

    const params = {
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${accessToken}`, // Utilisez le token d'accès dans l'en-tête d'autorisation
            'Accept': 'application/json'
        }
    };

    fetch(calendarApiUrl, params)
        .then(response => response.json())
        .then(data => { 

            if (data.error) {

                jQuery('.insapp_info').css('display', 'flex')
                jQuery('.insapp_info').html('Accès expiré : Bien vouloir cliquer sur le bouton Synchroniser sur votre agenda')
                const targetBlock = document.querySelector('.insapp_info');
                targetBlock.scrollIntoView({ behavior: 'smooth' });

                document.getElementsByClassName('fc-myCustomButton2-button')[0].style.display = 'initial';
                document.getElementsByClassName('fc-myCustomButton3-button')[0].style.display = 'none';


            } else {


                document.getElementsByClassName('fc-myCustomButton2-button')[0].style.display = 'none';
                document.getElementsByClassName('fc-myCustomButton3-button')[0].style.display = 'initial';
                const events = [];
                data.items.forEach(eventItem => {
                    const event = {
                        title: eventItem.summary,
                        start: eventItem.start.dateTime || eventItem.start.date,
                        end: eventItem.end.dateTime || eventItem.end.date,
                        color: 'red',
                        textColor: 'white'
                    };
                    events.push(event);
                });

                calendarinsapp.addEventSource(events);


            }


        })
        .catch(error => {

            jQuery.toast({
                heading: 'Warning',
                text: 'Erreur lors de la récupération des événements :', error,
                showHideTransition: 'plain',
                position: 'top-right',
                icon: 'warning',
                hideAfter: 8000,
            });
        });
}

function insertEvents(accessToken, eventData) {

    const calendarApiUrl = 'https://www.googleapis.com/calendar/v3/calendars/primary/events';



    fetch(calendarApiUrl, {
        method: 'POST',
        headers: {
            'Authorization': `Bearer ${accessToken}`,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(eventData)
    })
        .then(response => response.json())
        .then(data => {
            console.log('Événement inséré :', data.error);
            if (data.error) {
                jQuery('.insapp_info').css('display', 'flex')

                if (data.error.code == 403) {
                    console.log('403');
                    jQuery('.insapp_info').html('Accès expiré : Bien vouloir cliquer sur le bouton Synchroniser sur votre agenda')
                } else {

                    jQuery('.insapp_info').html('Une erreur est survenu : ' + data.error.message)
                }
                const targetBlock = document.querySelector('.insapp_info');
                targetBlock.scrollIntoView({ behavior: 'smooth' });
            } else {
                jQuery.toast({
                    heading: 'success',
                    text: 'La réservation a été ajouté sur votre google agenda',
                    showHideTransition: 'plain',
                    position: 'top-right',
                    icon: 'success',
                    hideAfter: 5000,
                });
            }
        })
        .catch(error => {
            console.log('Événement inséré :', error);
            jQuery('.insapp_info').css('display', 'flex')
            jQuery('.insapp_info').html('Erreur lors de l\'insertion de l\'événement :' + error)
            const targetBlock = document.querySelector('.insapp_info');
            targetBlock.scrollIntoView({ behavior: 'smooth' });
        });

}


jQuery(document).ready(function ($) {

    gapiLoaded()
    gisLoaded()

    var token = localStorage.getItem("access_token");
 
    if (token) {

        document.getElementsByClassName('fc-myCustomButton2-button')[0].style.display = 'none';
        document.getElementsByClassName('fc-myCustomButton3-button')[0].style.display = 'initial';

    } else {
        document.getElementsByClassName('fc-myCustomButton2-button')[0].style.display = 'initial';
        document.getElementsByClassName('fc-myCustomButton3-button')[0].style.display = 'none';
    }

    fetchEvents(token)

    $('.ia-add-google-calendar').click(function () {
        $('.insapp_info').css('display', 'none')
        $('.ia-add-google-calenda').attr("disabled", "disabled");
         
        let data = {
            'action': 'insapp_get_booking_information',
            'book_id': $(this).attr('value'),
        }

        jQuery.post(insapp_agenda_ajax.ajaxurl, data, function (response) {
            
            if (response.success == true) {

              let eventData = response.data 
              checkAccessTokenValidity(eventData) 
                  
            } else {
                jQuery.toast({
                    heading: 'Warning',
                    text: response.data.message,
                    showHideTransition: 'plain',
                    position: 'top-right',
                    icon: 'warning',
                    hideAfter: 8000,
                });
               $('.ia-add-google-calenda').removeAttr("disabled")
            }

        });

    });

});
 
    if(calendarEl != null){ 
        
        const CLIENT_ID = document.currentScript.getAttribute('cliendID');
        const API_KEY = document.currentScript.getAttribute('API_KEY');
        const redirectUri = document.currentScript.getAttribute('Redirect_page');
        
        const DISCOVERY_DOC = 'https://www.googleapis.com/discovery/v1/apis/calendar/v3/rest';
        const SCOPES = 'https://www.googleapis.com/auth/calendar';
        
        let tokenClient;
        let gapiInited = false;
        let gisInited = false;
        
        function gapiLoaded() {
            gapi.load('client', initializeGapiClient); 
        }
        
        function gisLoaded() {
            tokenClient = google.accounts.oauth2.initTokenClient({
                client_id: CLIENT_ID,
                scope: SCOPES,
                access_type: 'offline',
                callback: '', // defined later
            });
            gisInited = true;
            maybeEnableButtons();
        
        }
        
        
        async function initializeGapiClient() {
            await gapi.client.init({
                apiKey: API_KEY,
                discoveryDocs: [DISCOVERY_DOC],
            });
            gapiInited = true;
            maybeEnableButtons(); 
            await checkAccessTokenValidity();
        }
        
        async function maybeEnableButtons() {
            if (gapi.auth2 && gapi.client) { 
            }
        }
        
        function handleAuthClick(Data) {
        
            tokenClient.callback = async (resp) => {
                if (resp.error !== undefined) {
                    throw (resp);
                }
        
                document.getElementsByClassName('fc-myCustomButton2-button')[0].style.display = 'none';
                document.getElementsByClassName('fc-myCustomButton3-button')[0].style.display = 'initial';
                jQuery('.insapp_info').css('display', 'none')
        
                var token = gapi.client.getToken().access_token; 
                localStorage.setItem("access_token", token);
        
                fetchEvents(token)
                 if(Data){
                     insertEvents(token, Data) 
                }
            };
        
            if (gapi.client.getToken() === null) {
                tokenClient.requestAccessToken({ prompt: 'consent' });
            } else {
                tokenClient.requestAccessToken({ prompt: '' });
            }
        }
        
        async function refreshAccessToken(Data) {
             
            try {
                const refreshToken = localStorage.getItem("refresh_token");
        
                if (!refreshToken) {
                    throw new Error("Refresh token not found");
                }
        
                const response = await fetch('https://oauth2.googleapis.com/token', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `grant_type=refresh_token&refresh_token=${refreshToken}&client_id=${CLIENT_ID}&client_secret=${API_KEY}`,
                });
        
                if (!response.ok) {
                    throw new Error(`Failed to refresh access token. Status: ${response.status}`);
                }
        
                const responseData = await response.json();
                const newAccessToken = responseData.access_token;
        
                localStorage.setItem("access_token", newAccessToken); 
                fetchEvents(newAccessToken);
                 if(Data){
                     insertEvents(newAccessToken, Data) 
                }
                
            } catch (err) {
                //handleAuthClick(Data)
            }
        }
        
        async function checkAccessTokenValidity(Data) {
            const accessToken = localStorage.getItem("access_token");
            
            if (!accessToken) {
                console.log('Access token not found');
                // handleAuthClick();
            }
        
            try {
                const response = await fetch('https://www.googleapis.com/calendar/v3/calendars/primary/events', {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`,
                    },
                });
        
                if (!response.ok) {
                    throw new Error(`Failed to check access token validity. Status: ${response.status}`);
                }
                 if(Data){
                     insertEvents(accessToken, Data) 
                }
         
            } catch (error) {
                await refreshAccessToken(Data);
            }
        }
        
        function handleSignoutClick() {
        
            const token = localStorage.getItem("access_token");
            if (token !== null) {
                google.accounts.oauth2.revoke(token.access_token);
                gapi.client.setToken('');
                localStorage.setItem("access_token", '');
                console.log('deconnecte');
                document.getElementsByClassName('fc-myCustomButton2-button')[0].style.display = 'initial';
                document.getElementsByClassName('fc-myCustomButton3-button')[0].style.display = 'none';
                location.reload();
            }
        }
    
    }