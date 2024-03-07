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

        $('#save_out').change(function() {
            if ($(this).val() == '0') {
                $('#save_out_txt').show();
            } else {
                $('#save_out_txt').hide();
            }
        });

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
           
        $('#date_start').prop('disabled', false);
        
        $('input[name="r1"]').on('change', function() {
            var selectedValue = $('input[name="r1"]:checked').val();

            // ถ้าเลือก rDate
            if (selectedValue === '1') {
                $('#date_start').prop('disabled', false);
            } else {
                $('#date_start').prop('disabled', true);
            }
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

            $('.select2bs4-modal').select2({
                theme: 'bootstrap4',
                width: '100%' // กำหนดความกว้างของ Select2
            });
        });
           
        $(document).off("click", ".btn-saveMile").on("click", ".btn-saveMile", function (e) {

            var newM = $('#mile_out').val();
            var oldM = $('#lastMile').val();

            if(newM < oldM){
                sweetAlert("ไม่สามารถบันทึกได้!", "เลขไมล์ไม่สามารถน้อยกว่าเลขที่มีในระบบปัจจุบันได้", "error");
                return false;
            }

            var form     = document.getElementById('needs-validation');
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
                        $('#imagePreview').html('');
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
                    } else if(data.trim() === "Diff") {
                        sweetAlert("ไม่สามารถบันทึกได้!", "เวลาที่ออกจากบริษัทต้องไม่มากกว่าหรือน้อยกว่า 1 ชั่วโมงที่จองไว้", "error");
                        return false;

                    } else if(data.trim() === "forward") {
                        sweetAlert("ไม่สามารถบันทึกล่วงหน้าได้มากกว่า 1 วัน!", "ตรวจสอบว่ารายการที่จะบันทึกถูกรายการหรือไม่", "error");
                        return false;

                    } else if(data.trim() === "no_save") {
                        sweetAlert("ไม่สามารถบันทึกได้!", "กรุณาระบุชื่อผู้บันทึก", "error");
                        return false;

                    }else {
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
                    $('#lastMile').val(js.lastMile);
                    return false;
                }
            });
        }
    });
</script>