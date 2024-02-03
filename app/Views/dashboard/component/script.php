<script>
   $(document).ready(function () {
    <?php if (!empty($_SESSION['car_id_user'])) { ?>
     sendAjaxSide();
     <?php } ?>
   });

  $(document).off('click', '.show_list_vehicle').on('click', '.show_list_vehicle', function () {
    $('#exampleModalLabel span').html("รายละเอียดยานพาหนะ");
      var id_row = $(this).data("id");
      $.ajax({
        type: 'POST',
        url: "app/Views/dashboard/functions/f-ajax.php",
        data: {
          action: "show_vehicle",
          id: id_row
        },
        beforeSend: function (data) {
        },
        success: function (data) {
          console.log(data);
          // return;
          if (data) {
            var jsonParse = JSON.parse(data);
            // console.log(jsonParse);

            $('#vehicle_name_tb').text(jsonParse[0].vehicle_name);
            $('#vehicle_type_tb').text(jsonParse[0].vehicle_type);
            $('#vehicle_brand_tb').text(jsonParse[0].vehicle_brand);
            $('#vehicle_seat_tb').text(jsonParse[0].vehicle_seat);       
            
            if(jsonParse[0].attachment) {
              var imageName = jsonParse[0].attachment;
              var imagePath = 'dist/temp_img/' + jsonParse[0].date_uploaded.split('-').join("") + '/';
              var ImageShow = imagePath + imageName;
            } else {
              var ImageShow = 'dist/img/SCGJWDLogo.png';
            }
            var imagePreview = document.getElementById('img_tb');
            imagePreview.src = ImageShow;

            $('#exampleModalView span').html(jsonParse[0].vehicle_name);
    
          } else {
            swal("ผิดพลาด!", "ไม่พบข้อมูลที่ระบุ", "error");
          }
        },
        error: function (data) {
          swal("ผิดพลาด!", "ไม่พบข้อมูลที่ระบุ.", "error");
        }
      });
  });

  function convertDateFormatView(inputDate) {
      if (!inputDate) {
        return ''; // Return empty string if inputDate is empty or null
      }
      var dateParts = inputDate.split(' ');
      var date = dateParts[0].split('-');
      var time = dateParts[1] ? dateParts[1].split(':') : [];

      var year = parseInt(date[0]);
      var month = parseInt(date[1]);
      var day = parseInt(date[2]);

      // Thai month names
      var thaiMonths = [
        'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
        'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
      ];

      // Convert to Thai Buddhist Era (BE) year
      var thaiYear = year + 543;

      // Format the date
      var formattedDate = day + ' ' + thaiMonths[month - 1] + ' ' + thaiYear;

      if (time.length === 2) {
        var hour = parseInt(time[0]);
        var minute = parseInt(time[1]);
        formattedDate += ' ' + ((hour < 10) ? '0' + hour : hour) + ':' + ((minute < 10) ? '0' + minute : minute);
      }

      return formattedDate;
    }

   function sendAjaxSide() {
     $.ajax({
       url: "app/Views/dashboard/functions/f-ajax.php",
       type: "POST",
       data: {
         "action": "side_card"
       },
       beforeSend: function () {},
       success: function (data) {
         var jsonData = JSON.parse(data);
         $('#today_res').text(jsonData.info);
         
        //  console.log(data);
         if(jsonData.card == 0){
           $('#side_card').html('');
           return;
          }
         renderCards(jsonData.card);
       }
     });
   }

   function createCard(cardData) {


     if (cardData.class == 'user') {
       var cardDiv = document.createElement('div');
       cardDiv.classList.add('card', 'card-success');
       // สร้าง HTML ภายในการ์ด
       cardDiv.innerHTML = `
    <div class="card-header">
      <h3 class="card-title">รายการอนุมัติ</h3>
      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse">
          <i class="fas fa-minus"></i>
        </button>
      </div>
    </div>
    <div class="card-body p-0">
      <a type="button" href="?${cardData.prefix}=reservationList&id=${cardData.id}" class="btn btn-default btn-block p-0" style="border-radius:0;">     
        <div class="card card-main p-0 col-md-12 col-lg-12 position-relative p-3 m-0">
          <div class="ribbon-wrapper ribbon-lg">
            <div class="ribbon bg-success text-lg">
              อนุมัติ
            </div>
          </div>
          <div class="box-profile">
            <img src='dist/temp_img/${cardData.img}' alt='Vehicle Image' class='img-thumbnail rounded mx-auto d-block'>
            <h4 class="profile-username text-center">${cardData.name}</h4>
            <ul class="list-group list-group-unbordered mb-1">
              <li class="list-group-item text-center">
                <b>${cardData.date}</b>
              </li>
              <li class="list-group-item text-center">
                <span>${cardData.reason}</span>
              </li>
            </ul>
          </div>
        </div>
      </a>
    </div>`;
     } else if (cardData.class == 'admin') {
       var cardDiv = document.createElement('div');
       cardDiv.classList.add('card-body', 'p-0');

       cardDiv.innerHTML = `
            
                <a type="button" href="?${cardData.prefix}=approve&id=${cardData.id}" class="btn btn-default btn-block p-0" style="border-radius:0;">     
                  <div class="info-box m-0">
                    <span class="info-box-icon">
                      <img src='dist/temp_img/${cardData.img}' alt='Vehicle Image'
                        class='img-thumbnail rounded mx-auto d-block'>
                    </span>

                    <div class="info-box-content">
                      <span class="info-box-number text-left">${cardData.name}</span>
                      <span class="info-box-text text-left">${cardData.date}</span>
                      <span class="info-box-text text-left">${cardData.reason}</span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  </a>
                `;
     }
     return cardDiv;
   }

   // ฟังก์ชันสำหรับแสดงการ์ดที่สร้างไว้ใน div ที่มี id="side_card"
   function renderCards(cardArray) {
     var sideCardDiv = document.getElementById('side_card');
     // เคลียร์ค่าเดิมที่อยู่ใน div เพื่อเตรียมแสดงข้อมูลใหม่
     sideCardDiv.innerHTML = '';

     if (cardArray[0].class == 'admin') {
       sideCardDiv.classList.add('card', 'card-warning');
       sideCardDiv.innerHTML = `<div class="card-header">
                                <h3 class="card-title">รออนุมัติ</h3>
                                <div class="card-tools">
                                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                  </button>
                                </div>
                              </div>
                              <div id="insidecard" class="card-body p-0"></div>`;
       var insidecard = document.getElementById('insidecard');
       cardArray.forEach(function (cardData) {
         var card = createCard(cardData);
         insidecard.appendChild(card);
       });


     } else {
       // ลูปผ่าน array แล้วสร้างและแสดงการ์ดที่ได้ใน div
       cardArray.forEach(function (cardData) {
         var card = createCard(cardData);
         sideCardDiv.appendChild(card);
       });
     }

   }
</script>