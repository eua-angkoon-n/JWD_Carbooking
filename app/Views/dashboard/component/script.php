<script>
   $(document).ready(function () {
     sendAjaxSide();
   });

   function sendAjaxSide() {
     $.ajax({
       url: "app/Views/dashboard/functions/f-ajax.php",
       type: "POST",
       data: {
         "action": "side_card"
       },
       beforeSend: function () {},
       success: function (data) {
        if(data == 0){
          $('#side_card').html('');
          return;
        }
         var jsonData = JSON.parse(data);
         $('#today_res').text(jsonData.info);
        //  console.log(data)
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