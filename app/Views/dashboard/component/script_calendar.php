<script>
   $(document).ready(function () {
      sendAjaxCalendar('all');
   });

   function sendAjaxCalendar(mode) {
     $.ajax({
       url: "app/Views/dashboard/functions/f-ajax.php",
       type: "POST",
       data: {
         "mode": mode,
         "action": "calendar"
       },
       beforeSend: function () {},
       success: function (data) {
         //  return false;
         var jsonData = JSON.parse(data);
        //  console.log(jsonData)
         createCalendar(jsonData['calendar']);
         $('#list_car').html(jsonData['list'])
         if (mode == 'all') {
           $('.fc-self-button').prop('disabled', false);
           $('.fc-all-button').prop('disabled', true);
         } else if (mode == 'self') {
           $('.fc-self-button').prop('disabled', true);
           $('.fc-all-button').prop('disabled', false);
         }
       }
     });
   }

   function createCalendar(data) {

     var events = data.map(function (event) {
      // console.log(event.id);
      if(event.end == 0){
        var isAllDay = true;
      } else {
        var isAllDay = false;
      }

       return {
         title: event.name,
         start: new Date(event.start),
         end: new Date(event.end),
        allDay: isAllDay,
         backgroundColor: event.color,
         borderColor: event.color,
         id: event.id
       };
     });
     // console.log(data);
    //  console.log(events);
     var date = new Date()
     var d = date.getDate(),
       m = date.getMonth(),
       y = date.getFullYear()

     var Calendar = FullCalendar.Calendar;
     var Draggable = FullCalendar.Draggable;

     var containerEl = document.getElementById('external-events');
     var checkbox = document.getElementById('drop-remove');
     var calendarEl = document.getElementById('calendar');

     var calendar = new Calendar(calendarEl, {
       customButtons: {
        <?php if (!empty($_SESSION['car_id_user'])) { ?>
         self: {
           text: 'การจองของฉัน',
           click: function () {
             sendAjaxCalendar('self');
           }
         },
         <?php } ?>
         all: {
           text: 'ทั้งหมด',
           click: function () {
            sendAjaxCalendar('all');
           }
         }
       },
       headerToolbar: {
         left: 'all<?php if (!empty($_SESSION['car_id_user'])) { ?>,self<?php }?>',
         center: 'title',
         right: 'today,dayGridMonth,prev,next'
       },
       themeSystem: 'bootstrap',
       locale: 'en',
       events: events,
       eventClick: function(info) {
        showModal(info.event.id);
      },
       eventTimeFormat: {
         hour: '2-digit', //2-digit, numeric
         minute: '2-digit', //2-digit, numeric
         meridiem: false, //lowercase, short, narrow, false (display of AM/PM)
         hour12: false //true, false
       },
       editable: false,
       droppable: false, // this allows things to be dropped onto the calendar !!!
       drop: function (info) {
         // is the "remove after drop" checkbox checked?

       }
     });

     calendar.render();
   }

   function showModal(id) {

    $('#modal-view').modal('show');

    $.ajax({
                url: "app/Views/dashboard/functions/f-ajax.php",
                type: "POST",
                data: {
                    "id": id,
                    "action": "modal"
                },
                beforeSend: function () {},
                success: function (data) {
                    var js = JSON.parse(data);
                    // console.log(js);
                    // return false;
   
                    $('.show_vehicle').text(js.vehicle_name);
                    show_date(js.start, js.end);
                    $('#show_user').text(js.userName);
                    $('.show_place').text(js.place_Name);
                    show_companion(js.companion);
                    $('#show_reason').text(js.reason);
                    show_vehicle_img(js.attachment, js.date_attachment, 'show_img');
                    show_ribbon(js.status);
                    if (js.lat != '' && js.lat != null) {
                        createStaticMap(js.lat, js.lng, js.zm)
                    } else {
                        $('#map_olv').html("");
                    }
                }
            });
   }

   function show_date(start, end) {

     var months = [
       "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
       "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
     ];

     var startDate = new Date(start);
     var endDate = new Date(end);

     var startDay = startDate.getDate();
     var startMonth = months[startDate.getMonth()];
     var startYear = startDate.getFullYear()

     var startHours = startDate.getHours();
     var startMinutes = startDate.getMinutes();

     var endDay = endDate.getDate();
     var endMonth = months[endDate.getMonth()];
     var endYear = endDate.getFullYear()

     var endHours = endDate.getHours();
     var endMinutes = endDate.getMinutes();

     var showDate =
       `${startDay} ${startMonth} ${startYear} ${startHours}.${startMinutes} น. ถึง ${endDay} ${endMonth} ${endYear} ${endHours}.${endMinutes} น.`;

     $('#show_date').text(showDate);
}

function show_companion(companion) {
  var companions = companion.split(', ');

  // Select the show_companion list
  var $showCompanionList = $('#show_companion');

  // Clear the existing list items
  $showCompanionList.empty();

  // Iterate through the companions array and add them as list items to the show_companion list
  companions.forEach(function (companion) {
      var $listItem = $('<li>').append($('<a>').text(companion));
      $showCompanionList.append($listItem);
  });
}

function show_vehicle_img(img, date, ID) {
  if (img) {
      var imageName = img;
      var imagePath = 'dist/temp_img/' + date.split('-').join("") + '/';
      var ImageShow = imagePath + imageName;
  } else {
      var ImageShow = 'dist/img/SCGJWDLogo.png';
  }
  var imagePreview = document.getElementById(ID);
  imagePreview.src = ImageShow;
}

function show_ribbon(status) {
  $('#Show_Ribbon').removeClass('bg-warning bg-success bg-secondary bg-info');
  var cls;
  var txt;
  switch (status) {
      case '0':
          cls = "bg-warning";
          txt = "<?php echo Setting::$reservationStatus[0] ?>";
          break;
      case '1':
          cls = "bg-success";
          txt = "<?php echo Setting::$reservationStatus[1] ?>";
          break;
      case '2':
          cls = "bg-danger";
          txt = "<?php echo Setting::$reservationStatus[2] ?>";
          break;
      case '3':
          cls = "bg-info";
          txt = "<?php echo Setting::$reservationStatus[3] ?>";
          break;
      case '4':
          cls = "bg-success";
          txt = "<?php echo Setting::$reservationStatus[4] ?>";
          break;
      case '5':
          cls = "bg-secondary";
          txt = "<?php echo Setting::$reservationStatus[5] ?>";
          break;
      case '6':
          cls = "bg-success";
          txt = "<?php echo Setting::$reservationStatus[6] ?>";
          break;
  }
  $('#Show_Ribbon').text(txt);
  $('#Show_Ribbon').addClass(cls);
}

function createStaticMap(lat, lng, zoom) {
  var mapOlv = document.getElementById('map_olv');
  var apiKey = 'AIzaSyD_3uR-M8yPx3Tv8DAgbenP2-vJfxzxSD8';

  var imageUrl = `https://maps.googleapis.com/maps/api/staticmap?center=${lat},${lng}&zoom=${zoom}&size=600x300&maptype=roadmap&markers=color:red%7C${lat},${lng}&key=${apiKey}`;

  var img = document.createElement('img');
  img.src = imageUrl;
  img.alt = 'Static Map';
  img.className = 'w-100 h-100';

  mapOlv.innerHTML = ''; // Clear previous content
  mapOlv.appendChild(img); // Append the image to the map_olv div
}
</script>