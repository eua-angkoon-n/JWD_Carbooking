<script>
    $(document).ready(function () {

        //input ต่างๆ////////////////////////////////////////////////////////////////
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        var currentDate = moment();
        var startDate = moment(currentDate).startOf('month');
        var endDate = moment(currentDate).endOf('month');

        $('#res_date').daterangepicker({
            startDate: startDate,
            endDate: endDate,
            locale: {
                format: 'DD/MM/YYYY'
            }
        })

        $('#ListForm').change(function () {
            // Reload the DataTable using AJAX
            $('#reservation_table').DataTable().ajax.reload();
        });

        $('#modal_date').daterangepicker({
            startDate: startDate,
            endDate: endDate,
            locale: {
                format: 'DD/MM/YYYY HH:mm:ss'
            }
        })

        $('#res_date').prop('disabled', true);

        $('input[name="r1"]').on('change', function() {
            var selectedValue = $('input[name="r1"]:checked').val();

            // ถ้าเลือก rDate
            if (selectedValue === '1') {
                $('#res_date').prop('disabled', false);
            } else {
                $('#res_date').prop('disabled', true);
            }
        });

        <?php if($id != ''){ ?>
            var id = <?php echo $id?>;
            show_reservation(id);
            $('#carouselPage').carousel('next');
            window.scrollTo(0, 0);
        <?php } ?>

        $(document).off("click", ".btn-approve").on("click", ".btn-approve", function (e) {
            var id = $(this).data('id');
            var ac = $(this).data('action');;
            swal({
                    title: "อนุมัติ ?",
                    text: "ต้องการอนุมัติการจองรถหรือไม่",
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    confirmButtonText: "ตกลง",
                    cancelButtonText: "ไม่, ยกเลิก",
                    confirmButtonColor: "#DD6B55",
                    inputPlaceholder: "หมายเหตุ(ถ้ามี)... "
                },
                function (inputValue) {
                    $.ajax({
                        url: "app/Views/approve/functions/f-ajax.php",
                        type: "POST",
                        data: {
                            "id": id,
                            "remark": inputValue,
                            "action": 'approve'
                        },
                        beforeSend: function () {},
                        success: function (data) {
                            // console.log(data);
                            // return false;
                            if (data == 0) {
                                sweetAlert("เกิดข้อผิดพลาด!", "ไม่สามารถทำการอนุมัติได้", "error");
                                return false;
                            } else {
                                swal({
                                        title: "อมุมัติ !!",
                                        text: "ทำการอนุมัติการจองเรียบร้อย",
                                        type: "success",
                                    },
                                    function () {
                                        if (ac == 'atShow') {
                                            show_reservation(id);
                                            $('#reservation_table').DataTable().ajax.reload();
                                            event.preventDefault();
                                            event.stopPropagation();
                                        } else {
                                            $('#reservation_table').DataTable().ajax.reload();
                                            event.preventDefault();
                                            event.stopPropagation();
                                        }
                                    })
                            }
                        }
                    });
                });
        });

        $(document).off("click", ".btn-noApprove").on("click", ".btn-noApprove", function (e) {
            var id = $(this).data('id');
            var ac = $(this).data('action');;
            swal({
                    title: "ไม่อนุมัติ ?",
                    text: "ต้องการไม่อนุมัติการจองรถหรือไม่",
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    confirmButtonText: "ตกลง",
                    cancelButtonText: "ไม่, ยกเลิก",
                    confirmButtonColor: "#DD6B55",
                    inputPlaceholder: "หมายเหตุ(ถ้ามี)... "
                },
                function (inputValue) {
                    $.ajax({
                        url: "app/Views/approve/functions/f-ajax.php",
                        type: "POST",
                        data: {
                            "id": id,
                            "remark": inputValue,
                            "action": 'noApprove'
                        },
                        beforeSend: function () {},
                        success: function (data) {
                            // console.log(data);
                            // return false;
                            if (data == 0) {
                                sweetAlert("เกิดข้อผิดพลาด!", "ไม่สามารถทำการยกเลิกได้", "error");
                                return false;
                            } else {
                                swal({
                                        title: "ไม่อนุมัติ !!",
                                        text: "สำเร็จ",
                                        type: "success",
                                    },
                                    function () {
                                        if (ac == 'atShow') {
                                            show_reservation(id);
                                            $('#reservation_table').DataTable().ajax.reload();
                                            event.preventDefault();
                                            event.stopPropagation();
                                        } else {
                                            $('#reservation_table').DataTable().ajax.reload();
                                            event.preventDefault();
                                            event.stopPropagation();
                                        }
                                    })
                            }
                        }
                    });
                });
        });

        $(document).off("click", ".detailReservation").on("click", ".detailReservation", function (e) {
            var id = $(this).data('id');
            show_reservation(id);
            $('#carouselPage').carousel('next');
            window.scrollTo(0, 0);
            return false;
        });

        $(document).off("click", ".backPage").on("click", ".backPage", function (e) {
            $('.carousel').carousel('prev');
        });

        $(document).off("click", ".modal-img").on("click", ".modal-img", function (e) {
            var img = $(this).data('id');
            $('#modalImg').attr('src', img);
        });

        $(document).off("click", ".btn-save-edit").on("click", ".btn-save-edit", function (e) {
            var Data = $("#editForm").serialize();
            var Vehicle = $("#modal_vehicle").find(":selected").text();
            var id = $("#modal_id").val();
            $.ajax({
                url: "app/Views/reservationAll/functions/f-ajax.php",
                type: "POST",
                data: {
                    "data": Data,
                    "action": 'edit'
                },
                beforeSend: function () {},
                success: function (data) {
                    console.log(data);
                    // return false;
                    if (data.trim() === "dupTime") {
                        sweetAlert("ไม่สามารถทำรายการได้!", Vehicle + " ได้มีการจองในช่วงเวลานี้ก่อนหน้าแล้ว", "error");
                        return false;
                    } else {
                        swal({
                                title: "แก้ไขสำเร็จ !!",
                                text: "สำเร็จ",
                                type: "success",
                            },
                            function () {
                                show_reservation(id);
                                $('#reservation_table').DataTable().ajax.reload();
                                $('#modal-view').modal('hide');
                                event.preventDefault();
                                event.stopPropagation();
                            })
                    }
                }
            });
        });

        $(document).off("click", ".CancelReservation").on("click", ".CancelReservation", function (e) {
            e.preventDefault();
            e.stopPropagation();

            var id = $(this).data('id');
            var ac = $(this).data('action');
            swal({
                    title: "ยกเลิกการจอง ?",
                    text: "ต้องการยกเลิกการจองรถหรือไม่",
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    confirmButtonText: "ตกลง",
                    cancelButtonText: "ไม่, ยกเลิก",
                    confirmButtonColor: "#DD6B55",
                    inputPlaceholder: "เหตุผล..."
                },
                function (inputValue) {
                    if (inputValue===false) {
                        return;
                    } else {
                        $.ajax({
                        url: "app/Views/reservationList/functions/f-ajax.php",
                        type: "POST",
                        data: {
                            "id": id,
                            "remark": inputValue,
                            "action": "cancel"
                        },
                        beforeSend: function () {},
                        success: function (data) {
                            // console.log(data);
                            // return false;
                            if (data == 0) {
                                sweetAlert("เกิดข้อผิดพลาด!", "ไม่สามารถทำการยกเลิกได้", "error");
                                return false;
                            } else {
                                swal({
                                        title: "ยกเลิกสำเร็จ !!",
                                        text: "ทำการยกเลิกการจองเรียบร้อย",
                                        type: "success",
                                    },
                                    function () {
                                        if (ac == 'atShow') {
                                            show_reservation(id);
                                            $('#reservation_table').DataTable().ajax.reload();
                                            event.preventDefault();
                                            event.stopPropagation();
                                        } else {
                                            $('#reservation_table').DataTable().ajax.reload();
                                            event.preventDefault();
                                            event.stopPropagation();
                                        }
                                    })
                            }
                        }
                    });
                    }
                });
        });


        //ฟังก์ชัน    ///////////////////////////////////////////////////////////////////////
        function show_reservation(id) {
            $.ajax({
                url: "app/Views/reservationList/functions/f-ajax.php",
                type: "POST",
                data: {
                    "id": id,
                    "action": "detail"
                },
                beforeSend: function () {},
                success: function (data) {
                    var js = JSON.parse(data);
                    // console.log(js);
                    if(js == true){
                        window.location.href = '?app=res';
                    }
                    <?php if($_SESSION['car_class_user'] != 1 && $_SESSION['car_class_user'] != 2){ ?>
                        if(js.id_user != <?php echo $_SESSION['car_id_user']?>){
                            window.location.href = '?app=reservationList';
                        }else {
                            window.location.href = '?app=reservationList&id='+js.id_user;
                        }
                    <?php }?>
                    $('.show_vehicle').text(js.vehicle_name);
                    show_date(js.start, js.end, js.urgent);
                    $('#show_user').text(js.userName);
                    $('.show_place').text(js.place_Name);
                    show_companion(js.companion);
                    $('#show_reason').text(js.reason);
                    $('#show_acc').text(js.acc);
                    $('#show_driver').text(js.driver);
                    show_vehicle_img(js.attachment, js.date_attachment, 'show_img');
                    show_ribbon(js.status);
                    if (js.lat != '' && js.lat != null) {
                        createStaticMap(js.lat, js.lng, js.zm)
                    } else {
                        $('#map_olv').html("");
                    }
                    

                    if (js.status == '0') {
                        var button = '<div class="col-12 text-center mb-1"><button type="button" class="btn btn-success btn-approve text-center w-75 h-100" data-id="' + js.res_id + '" data-action="atShow" id="btn-approve" title="อนุมัติ"><span>อนุมัติ</span></button></div><div class="col-12 text-center mb-1"><button type="button" class="btn btn-danger btn-noApprove text-center w-75 h-100" data-id="' + js.res_id + '" data-action="atShow" id="btn-noApprove" title="ไม่อนุมัติ"><span>ไม่อนุมัติ</span></button></div><div class="col-12 text-center mb-1"><button type="button" class="btn btn-warning btn-edit text-center w-75 h-100" data-id="' + js.res_id + '" data-action="atShow" data-toggle="modal" data-target="#modal-view" data-backdrop="static" data-keyboard="false" id="btn-edit" title="แก้ไข"><span>แก้ไข</span></button></div><div class="col-12 text-center"><button type="button" class="btn btn-primary backPage text-center w-75 h-100" id="backPage" title="กลับ">กลับ</span></button></div>';
                        modal_form(js.res_id, button, js.vehicle_name, js.vehicle_select, js.start, js.end);
                    } else if (js.status == '1') {
                        var button = '<div class="col-12 text-center mb-1"><button type="button" class="btn btn-warning btn-edit text-center w-75 h-100" data-id="' + js.res_id + '" data-action="atShow" data-toggle="modal" data-target="#modal-view" data-backdrop="static" data-keyboard="false" id="btn-edit" title="แก้ไข"><span>แก้ไข</span></button></div><div class="col-12 text-center"><button type="button" class="btn btn-primary backPage text-center w-75 h-100" id="backPage" title="กลับ">กลับ</span></button></div>';
                        modal_form(js.res_id, button, js.vehicle_name, js.vehicle_select, js.start, js.end);
                    } else {
                        var button = '<div class="col-12 text-center"><button type="button" class="btn btn-primary backPage text-center w-75 h-100" id="backPage" title="กลับ">กลับ</span></button></div>';
                        $("#show_button").html(button);
                    }

                    if(js.timeline != 0){
                        $('.default-detail').addClass('col-md-6');
                        $('.miles').addClass('col-sm-12 col-md-6');
                        $('.miles').html(js.timeline);

                    } else {
                        $('.default-detail').removeClass('col-md-6');
                        $('.miles').removeClass('col-sm-12 col-md-6');
                        $('.miles').html('');
                    }

                    if(js.handover != 0){
                        $('.handover').html(js.handover);

                    } else {
                        $('.handover').html('');
                    }
                }
            });
        }

        function modal_form(id, button, name, select, start, end) {
            $("#show_button").html(button);
            $("#modal_vehicle_name").text(name);
            $("#modal_vehicle").html(select);
            $("#modal_id").val(id);

            var startDate = moment(start, 'YYYY-MM-DD HH:mm:ss'); 
            var endDate = moment(end, 'YYYY-MM-DD HH:mm:ss');
    
            $('#modal_date').daterangepicker({
                startDate: startDate,
                endDate: endDate,
                timePicker: true,
                timePicker24Hour: true,
                // minDate: moment(),
                locale: {
                    format: 'DD/MM/YYYY HH:mm'
                }
            });
        }


        function show_date(start, end, urgent) {
            var months = [
                "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
                "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
            ];

            var startDate = new Date(start);
            var endDate = new Date(end);

            var startDay = startDate.getDate();
            var startMonth = months[startDate.getMonth()];
            var startYear = startDate.getFullYear()

            var startHours = startDate.getHours().toString().padStart(2, '0');
            var startMinutes = startDate.getMinutes().toString().padStart(2, '0');

            var endDay = endDate.getDate();
            var endMonth = months[endDate.getMonth()];
            var endYear = endDate.getFullYear()

            var endHours = endDate.getHours().toString().padStart(2, '0');
            var endMinutes = endDate.getMinutes().toString().padStart(2, '0');

            var showDate =
                `${startDay} ${startMonth} ${startYear} ${startHours}.${startMinutes} น. ถึง ${endDay} ${endMonth} ${endYear} ${endHours}.${endMinutes} น.`;

            if(urgent == 1){
                $('#show_date').html(showDate + " <a class='text-red'><strong><?php echo Setting::$reservationUrgent[0]?></strong></a>"); 
            } else {
                $('#show_date').html(showDate);
            }
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
            $('#Show_Ribbon').removeClass('bg-warning bg-success bg-secondary bg-info bg-danger');
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

    });
</script>