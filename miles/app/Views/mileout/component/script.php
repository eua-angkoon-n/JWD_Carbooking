<script src='../plugins/multifile/jquery.MultiFile.js'></script>
<script>    
    $(document).ready(function () {
        const input = document.getElementById('inputFile');
        const preview = document.getElementById('imagePreview');
        var maxFiles = 3;

        input.addEventListener('change', function (e) {
            preview.innerHTML = '';
            const files = e.target.files;

            if (files.length > maxFiles) {
                fileErrorMsg.innerHTML = 'คุณสามารถเลือกไฟล์ได้สูงสุด 3 ไฟล์เท่านั้น';
                clearInput(this); // ล้างไฟล์ที่เลือกถ้าเกินจำนวนที่กำหนด
                return false;
            }

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();

                reader.onload = function (event) {
                    const img = document.createElement('img');
                    img.classList.add('col-md-3', 'img-thumbnail');
                    img.src = event.target.result;
                    img.style.maxWidth = '100%';
                    preview.appendChild(img);
                };

                reader.readAsDataURL(file);
            }
        }); 

        //input ต่างๆ////////////////////////////////////////////////////////////////
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        var currentDate = moment();
        var startDate = moment(currentDate).startOf('month');
        var endDate = moment(currentDate).endOf('month');

        $('#datetimepicker').datetimepicker({
            defaultDate:currentDate,
            format: 'DD/MM/YYYY'
        });

        $('#datetimepicker').on('change.datetimepicker', function() {
            $('#miles_table').DataTable().ajax.reload();
            // console.log($('#ListForm').serialize());
        });

        $('#date_outPicker').datetimepicker({ 
            icons: { time: 'far fa-clock' } ,
            format: 'DD/MM/YYYY HH:mm',
            defaultDate:currentDate,
        });

        $('#ListForm').on('change', function() {
            $('#miles_table').DataTable().ajax.reload();
            // console.log($('#ListForm').serialize());
        });
           
           
         $(document).off("click", ".modalMile").on("click", ".modalMile", function (e) {
            var id       = $(this).data('id');
            var dateText = $(this).data('datetext');
            var vehicle  = $(this).data('vehicle');
            var idv      = $(this).data('idv');
           
            $('#modal_vehicle').text(vehicle);
            $('#modal_date').text(dateText);
            $('#id_res').val(id);

            var currentDate = moment().format('DD/MM/YYYY HH:mm');
            $('#date_out').val(currentDate);

            get_OutData(id, idv);
        });
           
        $(document).off("click", ".btn-saveMile").on("click", ".btn-saveMile", function (e) {

            var form = document.getElementById('needs-validation');
            var formData = new FormData(form);
            
            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            } else {
                save_mile();
            }
            form.classList.add('was-validated');
            return false;
        });

        function clearInput(input) {
            input.value = ''; // ล้างไฟล์ที่ถูกเลือก
        }

        function save_mile(){
            var formData = new FormData($('form#needs-validation')[0]);
            var files = $('#inputFile')[0].files;

            for (var i = 0; i < files.length; i++) {
                formData.append('img[]', files[i]);
            }

            formData.append('action', 'save_out');

            $.ajax({
                url: "app/Views/mileout/functions/f-ajax.php",
                type: "POST",
                processData: false,
                contentType: false,
                data: formData,
                beforeSend: function () {},
                success: function (data) {
                    console.log(data);
                    // return false;
                    if (data.trim() === "Success") {
                        $('#modal-mile').modal('hide');
                        $('body').find('.was-validated').removeClass();
                        $('form#needs-validation').each(function () {
                            this.reset()
                        });
                        $('#miles_table').DataTable().ajax.reload();

                        swal({
                                title: "บันทึกสำเร็จ!",
                                text: "เมื่อใช้งานเสร็จ โปรดอย่าลืมกรอกเลขไมล์ขาเข้าบริษัทเพื่อคืนรถ",
                                type: "success",
                            },
                            function () {
                                event.preventDefault();
                                event.stopPropagation(); 
                            })
                    } else {
                        sweetAlert("เกิดข้อผิดพลาด!", "ไม่สามารถบันทึกได้", "error");
                        return false;

                    }
                }
            });
        }

        function get_OutData(id, idv) {

            $.ajax({
                url: "app/Views/mileout/functions/f-ajax.php",
                type: "POST",
                data: {
                    'id': id,
                    'idv': idv,
                    'action': 'view'
                },
                beforeSend: function () {},
                success: function (data) {
                    var js = JSON.parse(data);

                    $('#mile_out').val(js.lastMile);
                    return false;
                }
            });
        }

        // $(document).off("click", ".btn-approve").on("click", ".btn-approve", function (e) {
        //     var id = $(this).data('id');
        //     var ac = $(this).data('action');
        //     swal({
        //             title: "อนุมัติ ?",
        //             text: "ต้องการอนุมัติการจองรถหรือไม่",
        //             type: "input",
        //             showCancelButton: true,
        //             closeOnConfirm: false,
        //             confirmButtonText: "ตกลง",
        //             cancelButtonText: "ไม่, ยกเลิก",
        //             confirmButtonColor: "#DD6B55",
        //             inputPlaceholder: "หมายเหตุ(ถ้ามี)... "
        //         },
        //         function (inputValue) {
        //             $.ajax({
        //                 url: "app/Views/approve/functions/f-ajax.php",
        //                 type: "POST",
        //                 data: {
        //                     "id": id,
        //                     "remark": inputValue,
        //                     "action": 'approve'
        //                 },
        //                 beforeSend: function () {},
        //                 success: function (data) {
        //                     // console.log(data);
        //                     // return false;
        //                     if (data == 0) {
        //                         sweetAlert("เกิดข้อผิดพลาด!", "ไม่สามารถทำการอนุมัติได้", "error");
        //                         return false;
        //                     } else {
        //                         swal({
        //                                 title: "อมุมัติ !!",
        //                                 text: "ทำการอนุมัติการจองเรียบร้อย",
        //                                 type: "success",
        //                             },
        //                             function () {
        //                                 if (ac == 'atShow') {
        //                                     show_reservation(id);
        //                                     $('#reservation_table').DataTable().ajax.reload();
        //                                     event.preventDefault();
        //                                     event.stopPropagation();
        //                                 } else {
        //                                     $('#reservation_table').DataTable().ajax.reload();
        //                                     event.preventDefault();
        //                                     event.stopPropagation();
        //                                 }
        //                             })
        //                     }
        //                 }
        //             });
        //         });
        // });

        // $(document).off("click", ".btn-noApprove").on("click", ".btn-noApprove", function (e) {
        //     var id = $(this).data('id');
        //     var ac = $(this).data('action');;
        //     swal({
        //             title: "ไม่อนุมัติ ?",
        //             text: "ต้องการไม่อนุมัติการจองรถหรือไม่",
        //             type: "input",
        //             showCancelButton: true,
        //             closeOnConfirm: false,
        //             confirmButtonText: "ตกลง",
        //             cancelButtonText: "ไม่, ยกเลิก",
        //             confirmButtonColor: "#DD6B55",
        //             inputPlaceholder: "หมายเหตุ(ถ้ามี)... "
        //         },
        //         function (inputValue) {
        //             $.ajax({
        //                 url: "app/Views/approve/functions/f-ajax.php",
        //                 type: "POST",
        //                 data: {
        //                     "id": id,
        //                     "remark": inputValue,
        //                     "action": 'noApprove'
        //                 },
        //                 beforeSend: function () {},
        //                 success: function (data) {
        //                     // console.log(data);
        //                     // return false;
        //                     if (data == 0) {
        //                         sweetAlert("เกิดข้อผิดพลาด!", "ไม่สามารถทำการยกเลิกได้", "error");
        //                         return false;
        //                     } else {
        //                         swal({
        //                                 title: "ไม่อนุมัติ !!",
        //                                 text: "สำเร็จ",
        //                                 type: "success",
        //                             },
        //                             function () {
        //                                 if (ac == 'atShow') {
        //                                     show_reservation(id);
        //                                     $('#reservation_table').DataTable().ajax.reload();
        //                                     event.preventDefault();
        //                                     event.stopPropagation();
        //                                 } else {
        //                                     $('#reservation_table').DataTable().ajax.reload();
        //                                     event.preventDefault();
        //                                     event.stopPropagation();
        //                                 }
        //                             })
        //                     }
        //                 }
        //             });
        //         });
        // });

        // $(document).off("click", ".detailReservation").on("click", ".detailReservation", function (e) {
        //     var id = $(this).data('id');
        //     show_reservation(id);
        //     $('#carouselPage').carousel('next');
        //     window.scrollTo(0, 0);
        //     return false;
        // });

        // $(document).off("click", ".backPage").on("click", ".backPage", function (e) {
        //     $('.carousel').carousel('prev');
        // });

        // $(document).off("click", ".btn-save-edit").on("click", ".btn-save-edit", function (e) {
        //     var Data = $("#editForm").serialize();
        //     var Vehicle = $("#modal_vehicle").find(":selected").text();
        //     var id = $("#modal_id").val();
        //     $.ajax({
        //         url: "app/Views/reservationAll/functions/f-ajax.php",
        //         type: "POST",
        //         data: {
        //             "data": Data,
        //             "action": 'edit'
        //         },
        //         beforeSend: function () {},
        //         success: function (data) {
        //             console.log(data);
        //             // return false;
        //             if (data.trim() === "dupTime") {
        //                 sweetAlert("ไม่สามารถทำรายการได้!", Vehicle + " ได้มีการจองในช่วงเวลานี้ก่อนหน้าแล้ว", "error");
        //                 return false;
        //             } else {
        //                 swal({
        //                         title: "แก้ไขสำเร็จ !!",
        //                         text: "สำเร็จ",
        //                         type: "success",
        //                     },
        //                     function () {
        //                         show_reservation(id);
        //                         $('#reservation_table').DataTable().ajax.reload();
        //                         $('#modal-view').modal('hide');
        //                         event.preventDefault();
        //                         event.stopPropagation();
        //                     })
        //             }
        //         }
        //     });
        // });

        //ฟังก์ชัน    ///////////////////////////////////////////////////////////////////////
        // function show_reservation(id) {
        //     $.ajax({
        //         url: "app/Views/reservationAll/functions/f-ajax.php",
        //         type: "POST",
        //         data: {
        //             "id": id,
        //             "action": "detail"
        //         },
        //         beforeSend: function () {},
        //         success: function (data) {
        //             var js = JSON.parse(data);
        //             // console.log(js);
        //             // return false;
        //             $('.show_vehicle').text(js.vehicle_name);
        //             show_date(js.start, js.end);
        //             $('#show_user').text(js.userName);
        //             $('.show_place').text(js.place_Name);
        //             show_companion(js.companion);
        //             $('#show_reason').text(js.reason);
        //             $('#show_acc').text(js.acc);
        //             $('#show_driver').text(js.driver);
        //             show_vehicle_img(js.attachment, js.date_attachment, 'show_img');
        //             show_ribbon(js.status);
        //             if (js.lat != '' && js.lat != null) {
        //                 createStaticMap(js.lat, js.lng, js.zm)
        //             } else {
        //                 $('#map_olv').html("");
        //             }
                    

        //             if (js.status == '0') {
        //                 var button = '<div class="col-12 text-center mb-1"><button type="button" class="btn btn-success btn-approve text-center w-75 h-100" data-id="' + js.res_id + '" data-action="atShow" id="btn-approve" title="อนุมัติ"><span>อนุมัติ</span></button></div><div class="col-12 text-center mb-1"><button type="button" class="btn btn-danger btn-noApprove text-center w-75 h-100" data-id="' + js.res_id + '" data-action="atShow" id="btn-noApprove" title="ไม่อนุมัติ"><span>ไม่อนุมัติ</span></button></div><div class="col-12 text-center mb-1"><button type="button" class="btn btn-warning btn-edit text-center w-75 h-100" data-id="' + js.res_id + '" data-action="atShow" data-toggle="modal" data-target="#modal-view" data-backdrop="static" data-keyboard="false" id="btn-edit" title="แก้ไข"><span>แก้ไข</span></button></div><div class="col-12 text-center"><button type="button" class="btn btn-primary backPage text-center w-75 h-100" id="backPage" title="กลับ">กลับ</span></button></div>';
        //                 modal_form(js.res_id, button, js.vehicle_name, js.vehicle_select, js.start, js.end);
        //             } else if (js.status == '1') {
        //                 var button = '<div class="col-12 text-center mb-1"><button type="button" class="btn btn-warning btn-edit text-center w-75 h-100" data-id="' + js.res_id + '" data-action="atShow" data-toggle="modal" data-target="#modal-view" data-backdrop="static" data-keyboard="false" id="btn-edit" title="แก้ไข"><span>แก้ไข</span></button></div><div class="col-12 text-center"><button type="button" class="btn btn-primary backPage text-center w-75 h-100" id="backPage" title="กลับ">กลับ</span></button></div>';
        //                 modal_form(js.res_id, button, js.vehicle_name, js.vehicle_select, js.start, js.end);
        //             } else {
        //                 var button = '<div class="col-12 text-center"><button type="button" class="btn btn-primary backPage text-center w-75 h-100" id="backPage" title="กลับ">กลับ</span></button></div>';
        //                 $("#show_button").html(button);
        //             }
        //         }
        //     });
        // }

        // function modal_form(id, button, name, select, start, end) {
        //     $("#show_button").html(button);
        //     $("#modal_vehicle_name").text(name);
        //     $("#modal_vehicle").html(select);
        //     $("#modal_id").val(id);

        //     var startDate = moment(start, 'YYYY-MM-DD HH:mm:ss'); 
        //     var endDate = moment(end, 'YYYY-MM-DD HH:mm:ss');
    
        //     $('#modal_date').daterangepicker({
        //         startDate: startDate,
        //         endDate: endDate,
        //         timePicker: true,
        //         timePicker24Hour: true,
        //         // minDate: moment(),
        //         locale: {
        //             format: 'DD/MM/YYYY HH:mm'
        //         }
        //     });
        // }


        // function show_date(start, end) {

        //     var months = [
        //         "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
        //         "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
        //     ];

        //     var startDate = new Date(start);
        //     var endDate = new Date(end);

        //     var startDay = startDate.getDate();
        //     var startMonth = months[startDate.getMonth()];
        //     var startYear = startDate.getFullYear() + 543; // Convert to Buddhist Era

        //     var startHours = startDate.getHours();
        //     var startMinutes = startDate.getMinutes();

        //     var endDay = endDate.getDate();
        //     var endMonth = months[endDate.getMonth()];
        //     var endYear = endDate.getFullYear() + 543; // Convert to Buddhist Era

        //     var endHours = endDate.getHours();
        //     var endMinutes = endDate.getMinutes();

        //     var showDate =
        //         `${startDay} ${startMonth} ${startYear} ${startHours}.${startMinutes} น. ถึง ${endDay} ${endMonth} ${endYear} ${endHours}.${endMinutes} น.`;

        //     $('#show_date').text(showDate);
        // }

        // function show_companion(companion) {
        //     var companions = companion.split(', ');

        //     // Select the show_companion list
        //     var $showCompanionList = $('#show_companion');

        //     // Clear the existing list items
        //     $showCompanionList.empty();

        //     // Iterate through the companions array and add them as list items to the show_companion list
        //     companions.forEach(function (companion) {
        //         var $listItem = $('<li>').append($('<a>').text(companion));
        //         $showCompanionList.append($listItem);
        //     });
        // }

        // function show_vehicle_img(img, date, ID) {
        //     if (img) {
        //         var imageName = img;
        //         var imagePath = 'dist/temp_img/' + date.split('-').join("") + '/';
        //         var ImageShow = imagePath + imageName;
        //     } else {
        //         var ImageShow = 'dist/img/SCGJWDLogo.png';
        //     }
        //     var imagePreview = document.getElementById(ID);
        //     imagePreview.src = ImageShow;
        // }

        // function show_ribbon(status) {
        //     $('#Show_Ribbon').removeClass('bg-warning bg-success bg-secondary bg-info bg-danger');
        //     var cls;
        //     var txt;
        //     switch (status) {
        //         case '0':
        //             cls = "bg-warning";
        //             txt = "<?php echo Setting::$reservationStatus[0] ?>";
        //             break;
        //         case '1':
        //             cls = "bg-success";
        //             txt = "<?php echo Setting::$reservationStatus[1] ?>";
        //             break;
        //         case '2':
        //             cls = "bg-danger";
        //             txt = "<?php echo Setting::$reservationStatus[2] ?>";
        //             break;
        //         case '3':
        //             cls = "bg-info";
        //             txt = "<?php echo Setting::$reservationStatus[3] ?>";
        //             break;
        //         case '4':
        //             cls = "bg-success";
        //             txt = "<?php echo Setting::$reservationStatus[4] ?>";
        //             break;
        //         case '5':
        //             cls = "bg-secondary";
        //             txt = "<?php echo Setting::$reservationStatus[5] ?>";
        //             break;
        //     }
        //     $('#Show_Ribbon').text(txt);
        //     $('#Show_Ribbon').addClass(cls);
        // }

        // function createStaticMap(lat, lng, zoom) {
        //     var mapOlv = document.getElementById('map_olv');
        //     var apiKey = 'AIzaSyD_3uR-M8yPx3Tv8DAgbenP2-vJfxzxSD8';

        //     var imageUrl = `https://maps.googleapis.com/maps/api/staticmap?center=${lat},${lng}&zoom=${zoom}&size=600x300&maptype=roadmap&markers=color:red%7C${lat},${lng}&key=${apiKey}`;

        //     var img = document.createElement('img');
        //     img.src = imageUrl;
        //     img.alt = 'Static Map';
        //     img.className = 'w-100 h-100';

        //     mapOlv.innerHTML = ''; // Clear previous content
        //     mapOlv.appendChild(img); // Append the image to the map_olv div
        // }

    });
</script>