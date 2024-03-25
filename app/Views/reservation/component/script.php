<script>
    $(document).ready(function () {
    
        checkDriverSelection();

        $('#res_driver_self').change(function(){
            // ตรวจสอบว่ามี options ที่ถูกเลือกอยู่หรือไม่
            event.preventDefault();
            event.stopPropagation();

            if($(this).find('option:selected').length > 1){
                $(this).find("option:selected").prop('selected', false);;
            }

            $(this).find('option:selected').each(function(){
                // ตรวจสอบว่าค่าของ option เป็นตัวเลขอย่างเดียวหรือไม่
                if (!isNaN($(this).val()) && $(this).val() !== '') {
                    // กำหนดให้ option เป็น disabled
                    $(this).prop('selected', false);
                }
            });
        });

        $('#SelfDrive').click(function(){
            // แสดง driver_self และซ่อน driver_need
            $('.driver_self').show();
            $('.driver_need').hide();
            $('#res_driver_self').prop('required', true);
        });

        // เมื่อคลิกที่ radio button พนักงานขับรถ (NeedDrive)
        $('#NeedDrive').click(function(){
            // แสดง driver_need และซ่อน driver_self
            $('.driver_need').show();
            $('.driver_self').hide();
            $('#res_driver_self').removeAttr('required');
        });

        //input ต่างๆ////////////////////////////////////////////////////////////////
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        $(document).Toasts('create', {
            title: 'แจ้งจากฝ่ายบุคคล',
            autohide: true,
            delay: 3000,
            body: '<?php echo reservationAlertTxt()?>'
        })

        $('#time_start').datetimepicker({
            format: 'HH:mm',
            defaultDate: moment().add(5, 'hours'),
        });

        $('#time_end').datetimepicker({
            format: 'HH:mm',
            defaultDate: moment().add(8, 'hours'),
        });

        $('#date_start').datetimepicker({
            format: 'L',
            minDate: moment(), // Prevent selecting past dates
            maxDate: moment().add(1, 'months').add(15, 'days'),
            inline: true,
            opens: 'center',
        })

        $('#date_end').datetimepicker({
            format: 'L',
            minDate: moment(), // Prevent selecting past dates
            maxDate: moment().add(1, 'months').add(15, 'days'),
            inline: true,
            opens: 'center',
        })

        $('#date_start').on('change.datetimepicker', function (e) {
            // When date_start changes, update minDate of date_end
            var selectedDate = e.date;
            $('#date_end').datetimepicker('minDate', selectedDate);
        });

        $('#time_start, #time_end').on('change.datetimepicker', function (e) {
            // Get selected dates from date_start and date_end
            var dateStart = $('#date_start').datetimepicker('viewDate');
            var dateEnd = $('#date_end').datetimepicker('viewDate');

            // Compare the selected dates
            if (dateStart.isSame(dateEnd, 'day')) {
                var timeStart = moment($('#time_start').datetimepicker('viewDate')).format('HH:mm');
                var timeEnd = moment($('#time_end').datetimepicker('viewDate')).format('HH:mm');

                // Check if timeEnd is earlier than timeStart and adjust if necessary
                if (timeEnd <= timeStart) {
                    $('#time_end').datetimepicker('date', moment($('#time_start').datetimepicker('viewDate')).add(1, 'minute'));
                }
            }
        });

        $('#date_start, #date_end,#time_start, #time_end').on('change.datetimepicker', function (e) {
            // Get selected dates from date_start and date_end
            var dateStart = $('#date_start').datetimepicker('viewDate');
            var dateEnd = $('#date_end').datetimepicker('viewDate');

            // Get selected times from time_start and time_end
            var timeStart = moment($('#time_start').datetimepicker('viewDate'));
            var timeEnd = moment($('#time_end').datetimepicker('viewDate'));

            // Check if date_start and date_end are the same day
            if (dateStart.isSame(dateEnd, 'day')) {
                // Ensure time_end is not less than or equal to time_start
                if (timeEnd.isSameOrBefore(timeStart)) {
                    $('#time_end').datetimepicker('date', timeStart.clone().add(1, 'minute'));
                }
            }
            $('#reservation_table').DataTable().ajax.reload();
        });


        $('#res_companion').select2({
            theme: 'bootstrap4',
            tags: true,
            createTag: function (params) {
                var term = $.trim(params.term);

                if (term === '') {
                    return null;
                }

                return {
                    id: term,
                    text: term,
                    newTag: true // add additional parameters if needed
                };
            }
        }).on('select2:select', function (e) {

            if (e.params.data.newTag) {
                // Handle the addition of a new tag here (if needed)
                console.log('New tag selected:', e.params.data);
            }
        });

        $('#res_driver_self').select2({
            theme: 'bootstrap4',
            tags: true,
            createTag: function (params) {
                var term = $.trim(params.term);

                if (term === '') {
                    return null;
                }

                // if($('#res_driver_self').find('option:selected').length > 1){
                //     $('#res_driver_self').val(null).trigger('change');
                // }

                return {
                    id: term,
                    text: term,
                    newTag: true // add additional parameters if needed
                };
            }
        }).on('select2:select', function (e) {

            if (e.params.data.newTag) {
                // Handle the addition of a new tag here (if needed)
                console.log('New tag selected:', e.params.data);
            }
        });

        $('#res_companion').on('change', function () {
            var selectedCompanions = $(this).find('option:selected').length + 1;
            $('#count_travel').val(selectedCompanions);
            $('#res_travel').val(selectedCompanions);
        });

        $('#res_date').daterangepicker({
            timePicker: true,
            timePickerIncrement: 1,
            timePicker24Hour: true,
            minDate: moment(),
            locale: {
                format: 'MM/DD/YYYY HH:mm'
            }
        })

        $('.form-group input[type="radio"]').on('change', function () {
            $('#reservation_table').DataTable().ajax.reload();
        });

        $(window).on('blur visibilitychange', function () {
            $('#carouselPage').carousel('pause');
        });

        //จบ input ต่างๆ////////////////////////////////////////////////////////////////

        //ปุ่มต่างๆ///////////////////////////////////////////////////////////////////////

        $(document).off("click", ".btn-search").on("click", ".btn-search", function (e) {
            $('#reservation_table').DataTable().ajax.reload();
        });

        $(document).off('click', '.viewReservation').on('click', '.viewReservation', function () {
            $('#viewReservation_table').DataTable().ajax.reload();
            var id_row = $(this).data("id");

            $.ajax({
                type: 'POST',
                url: "app/Views/reservation/functions/f-ajax.php",
                data: {
                    action: "viewReservation",
                    id_row: id_row,
                },
                beforeSend: function (data) {},
                success: function (data) {
                    // console.log(data);
                    if (data) {
                        var jsonParse = JSON.parse(data);
                        // console.log(jsonParse);
                        show_vehicle_img(jsonParse[0].attachment, jsonParse[0].date_uploaded, 'img_tb')

                        $('#TitleModalView span').html(jsonParse[0].vehicle_name);
                    } else {
                        swal("ผิดพลาด!", "ไม่พบข้อมูลที่ระบุ", "error");
                    }
                },
                error: function (data) {
                    swal("ผิดพลาด!", "ไม่พบข้อมูลที่ระบุ.", "error");
                }
            });
        });
        
        $(document).off("click", ".doReservation").on("click", ".doReservation", function (e) {
            var startDate = moment($('#date_start').val() + " " + $('#time_start').val(), "MM/DD/YYYY HH:mm");
            var endDate = moment($('#date_end').val() + " " + $('#time_end').val(), "MM/DD/YYYY HH:mm");
            $('#res_date').data('daterangepicker').setStartDate(startDate);
            $('#res_date').data('daterangepicker').setEndDate(endDate);


            $('#res_user').val('<?php echo $_SESSION['car_fullname'] ?>');
            $('#res_tel').val('<?php echo $_SESSION['car_phone'] ?>');

            var id = $(this).data('id');

            $.ajax({
                type: 'POST',
                url: "app/Views/reservation/functions/f-ajax.php",
                data: {
                    action: "DoReservation",
                    id_vehicle: id
                },
                beforeSend: function (data) {},
                success: function (data) {
                    var jsonParse = JSON.parse(data);
                    // console.log(jsonParse); return;
                    if ($.isNumeric(jsonParse)) {
                        cancelAll();
                        $('form#sendForm').each(function () {
                            this.reset()
                        });
                        swal({
                            title: "ไม่สามารถทำการจองได้!?",
                            text: "คุณมีรายการส่งมอบยานพาหนะค้างอยู่ "+jsonParse+" รายการ",
                            type: "error",
                            showCancelButton: true,
                            confirmButtonColor: "#28a745",
                            confirmButtonText: "ไปยังหน้าส่งมอบ",
                            cancelButtonColor: "#DD6B55",
                            cancelButtonText: "ตกลง",
                            closeOnConfirm: false
                        }, function () {
                            window.location.href = '?<?php echo PageSetting::$prefixController?>=handover';
                        });
                        return;
                    }
                    $('.carousel').carousel('next');
                    window.scrollTo(0,0);
                    show_vehicle_img(jsonParse.attachment, jsonParse.date_uploaded, 'show_img')
                    $('#res_vehicle').val(jsonParse.vehicle);
                    $('#id_vehicle').val(jsonParse.id_vehicle);
                    $('#id_user').val(jsonParse.id_user);
                },
                error: function (data) {
                    swal("ผิดพลาด!", "ไม่พบข้อมูลที่ระบุ.", "error");
                }
            });

        });

        $(document).off("click", ".btn-confirm").on("click", ".btn-confirm", function (e) {

            var form = document.getElementById('sendForm');
            var formData = new FormData(form);

            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            } else {
                show_reservation()
            }
            form.classList.add('was-validated');
            return false;
        });

        $(document).off("click", ". Reservation-cancel").on("click", ".Reservation-cancel", function (e) {
            swal({
                title: "ยกเลิก ?",
                text: "ต้องการยกเลิกการจองหรือไม่",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "ตกลง",
                cancelButtonText: "ไม่, ยกเลิก",
                closeOnConfirm: true
            }, function () {
                $('.carousel').carousel('prev');
                cancelAll();
                $('form#sendForm').each(function () {
                    this.reset()
                });

            });

        });

        $(document).off("click", ".backPage").on("click", ".backPage", function (e) {
            $('.carousel').carousel('prev');
        });

        $(document).off("click", ".btn-submit").on("click", ".btn-submit", function () {

            swal({
                title: "ยืนยัน ?",
                text: "ยืนยันการจองยานพาหนะ.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "ตกลง",
                cancelButtonText: "ไม่, ยกเลิก",
                closeOnConfirm: false
            }, function () {
                var frmData = $('#sendForm').serialize();
                $.ajax({
                    url: "app/Views/reservation/functions/f-ajax.php",
                    type: "POST",
                    data: {
                        "frmData": frmData,
                        "action": "addReservation"
                    },
                    beforeSend: function () {
                        $('.confirm').attr('disabled', true).text("รอ...");
                    },
                    success: function (data) {
                        // var log = data.replaceAll(' ', '');
                        // console.log(data);
                        // return false;
                        if (data == 0) {
                            sweetAlert("เกิดข้อผิดพลาด!", "ไม่สามารถทำการจองได้", "error");
                            return false;
                        } else if (data.trim() === "dupTime") {
                            sweetAlert("เกิดข้อผิดพลาด!", "ช่วงเวลาดังกล่าวมีการจองไว้แล้ว", "error");
                            return false;
                        } else if (data.trim() === "notAllowed") {
                            sweetAlert("เกิดข้อผิดพลาด!", "กรุณาจองรถก่อนใช้งาน <?php echo reservationTimeDiff("", true)?> ชั่วโมง", "error");
                            return false;
                        } else {
                            // sweetAlert("สำเร็จ...", "บันทึกข้อมูลเรียบร้อยแล้ว", "success"); //The error will display

                            $('body').find('.was-validated').removeClass();
                            $('form').each(function () {
                                this.reset()
                            });

                            swal({
                                    title: "ทำการจองสำเร็จ!",
                                    text: "กรุณารอการอนุมัติ จากฝ่ายบุคคล",
                                    type: "success",
                                },
                                function () {
                                    event.preventDefault();
                                    event.stopPropagation();
                                    window.location.href = '?<?php echo PageSetting::$prefixController?>=reservationList&id='+data;
                                })
                        }

                    },
                    error: function (jXHR, textStatus, errorThrown) {
                        //console.log(data);
                        alert(errorThrown);
                        sweetAlert("ผิดพลาด!", "ไม่สามารถบันทึกข้อมูลได้", "error");
                    }
                });
                event.preventDefault();
            });

        });

    });

    //จบ ปุ่มต่างๆ///////////////////////////////////////////////////////////////////////
    //ฟังก์ชัน    ///////////////////////////////////////////////////////////////////////
    function show_reservation() {
        show_map()
        $('.show_vehicle').text($("#res_vehicle").val());
        show_date();
        show_user();
        $('.show_place').text($("#map_place").val());
        show_companion();
        $('#show_reason').text($("#res_reason").val());
        show_acc();
        show_driver();
        $('#carouselPage').carousel('next');
        window.scrollTo(0,0);
    }

    function show_map() {
        var lat = $("#map_lat").val();
        var lng = $("#map_lon").val();
        var zoom = $("#map_zoom").val();
        var mapOlvDiv = $("#map_olv");
        if (lat != '' && lng != '' && zoom != '') {
            mapOlvDiv.parent().css('height', '250px');
            mapOlvDiv.css('height', '100%');
            updateMapOlv(lat, lng, zoom);
        } else {
            mapOlvDiv.parent().css('height', '0');
            mapOlvDiv.css('height', '0');
        }
    }

    function show_user() {
        var tel = ($('#res_tel').val() !== '') ? ' (' + $('#res_tel').val() + ')' : '';
        $('#show_user').text($("#res_user").val() + tel);
    }

    function show_date() {

        var dateString = $('#res_date').val();
        var months = [
            "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
            "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
        ];

        var dateParts = dateString.split(" - ");
        var startDate = new Date(dateParts[0]);
        var endDate = new Date(dateParts[1]);

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

    function show_companion() {
        var selectedCompanions = $('#res_companion').val();
        $('#show_companion').empty();
        if (selectedCompanions && selectedCompanions.length > 0) {
            selectedCompanions.forEach(function (companion) {
                $('#show_companion').append('<li><a>' + companion + '</a></li>');
            });
        } else {
            $('#show_companion').append('<li><a>ไม่มี</a></li>');
        }
    }

    function show_acc() {
    var selectedAcc = $('#res_acc option:selected');
    if (selectedAcc && selectedAcc.length > 0) {
        var accTextArray = [];
        selectedAcc.each(function() {
            accTextArray.push($(this).text());
        });
        var accString = accTextArray.join(', ');
        $('#show_acc').text(accString);
    } else {
        $('#show_acc').text('ไม่มี'); // Placeholder text if no accessories selected
    }
}

    function show_driver() {
        if ($('#SelfDrive').is(':checked')) {
            var selectedDriverText = $('#res_driver_self option:selected').text();    
        } else if ($('#NeedDrive').is(':checked')) {
            var selectedDriverText = $('#res_driver_need option:selected').text();    
        }
        $('#show_driver').text(selectedDriverText);
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

    function checkDriverSelection() {
        if ($('#SelfDrive').is(':checked')) {
            // ถ้าเลือกขับเอง ให้แสดง driver_self และซ่อน driver_need
            $('.driver_self').show();
            $('.driver_need').hide();
        } else if ($('#NeedDrive').is(':checked')) {
            // ถ้าเลือกพนักงานขับรถ ให้แสดง driver_need และซ่อน driver_self
            $('.driver_need').show();
            $('.driver_self').hide();
        }
    }

    function cancelAll(){
        $("#map_lat").val('');
            $("#map_lon").val('');
            $("#map_zoom").val('');
            $("#map_place").val('');
            $("#res_travel").val('');
            $("#res_reason").val('');
            $('#res_vehicle').val('');
            $('#id_vehicle').val('');
            $('#id_user').val('');

            $('#res_companion').val([]).trigger('change');
            $('#res_acc').val([]).trigger('change');
            $('#res_driver').val('1').trigger('change');

            $('.driver_self').show();
            $('.driver_need').hide();

            $('body').find('.was-validated').removeClass();
    }
</script>