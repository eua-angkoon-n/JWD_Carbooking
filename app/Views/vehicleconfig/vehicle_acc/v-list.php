<?php
      include __DIR__ . '/v-modal.php'; //หน้า add/edit
      include __DIR__ . '/v-modal-detail.php';
?>

<div class="card-body p-3">
  <div class="row">
    <div class="col-sm-12 p-0 m-0">

      <!--<a id="some_button" class="btn btn-danger">refesh</a>-->

      <table id="vehicle_acc_table" class="table table-bordered table-hover dataTable dtr-inline table-responsive-xl">
        <thead>
          <tr class="bg-light">
            <th class="sorting_disabled" style="width:10%">No</th>
            <th>อุปกรณ์เสริม</th>
            <th style="width:10%">สถานะ</th>
            <th style="width:10%">จัดการ</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>

    </div>
  </div><!-- /.row -->

</div><!-- /.card-body -->

<script type="text/javascript"> 

    $('#vehicle_acc_table').DataTable({
      "processing": true,
      "serverSide": true,
      "order": [0, 'asc'], //ถ้าโหลดครั้งแรกจะให้เรียงตามคอลัมน์ไหนก็ใส่เลขคอลัมน์ 0,'desc'
      "aoColumnDefs": [{
          "bSortable": false,
          "aTargets": [0, 2, 3]
        }, //คอลัมน์ที่จะไม่ให้ฟังก์ชั่นเรียง
        {
          "bSearchable": false,
          "aTargets": [0, 2, 3]
        } //คอลัมน์ที่จะไม่ให้เสิร์ช
      ],
      ajax: {
        beforeSend: function () {
          //จะให้ทำอะไรก่อนส่งค่าไปหรือไม่
        },
        url: 'app/Views/vehicleconfig/vehicle_acc/f-table.php',
        type: 'POST',
        data: {
          "formData": 0,
          "action": "get"
        }, //"slt_search":slt_search
        async: false,
        cache: false,
        error: function (xhr, error, code) {
          console.log(xhr, code);
        },
      },
      "paging": true,
      "lengthChange": true, //ออฟชั่นแสดงผลต่อหน้า
      "pagingType": "simple_numbers",
      "pageLength": 10,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });

    $(document).ready(function () {

      var table = $('#vehicle_acc_table').DataTable();

      $('#vehicle_acc_table_length').append('<div class="col-10 d-inline"><button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-vehicle_acc" id="addData" data-backdrop="static" data-keyboard="false"><i class="fas fa-plus-circle"></i> เพิ่มอุปกรณ์เสริม</button></div>');
      $('input[type=search]').attr('placeholder', 'อุปกรณ์เสริม');

      $(document).off('click', '#addData').on('click', '#addData', function () {
        $("#id_vehicle_acc").val('');
        $('#exampleModalLabel span').html("เพิ่มอุปกรณ์เสริม");
      });

      $(document).on('click', '.check-status', function () {
        var chk_box = $(this).parent().find('input[type="checkbox"]');
        var id_row = $(this).parent().find('input[type="checkbox"]').data("id");

        if (chk_box.is(":checked") == true) {
          chk_box_text = "ระงับการใช้งาน";
          chk_box_value = 0;
        } else {
          chk_box_text = "ใช้งานรายการนี้";
          chk_box_value = 1;
        }

        swal({
            title: "ยืนยันการทำงาน !",
            text: "คุณต้องการ" + chk_box_text + ". ใช่หรือไม่ ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "ใช่, ทำรายการ!",
            cancelButtonText: "ไม่, ยกเลิก!",
            closeOnConfirm: false,
            closeOnCancel: true
          },
          function (isConfirm) {
            if (isConfirm) {
              $.ajax({
                type: 'POST',
                url: "app/Views/vehicleconfig/vehicle_acc/f-ajax.php",
                data: {
                  action: "update-status",
                  chk_box_value: chk_box_value,
                  id_row: id_row
                },
                success: function (data) {
                  //console.log(data); //return false;
                  if (data == 1) {
                    swal("สำเร็จ!", "บันทึกข้อมูลเรียบร้อยแล้ว.", "success");
                    if (chk_box.is(":checked") == true) {
                      ///alert("checked");
                      chk_box.prop('checked', false);
                    } else {
                      //alert("ไม่ได้ checked");
                      chk_box.prop('checked', true);
                    }
                  } else {
                    swal("ผิดพลาด!", "ไม่สามารถบันทึกข้อมูลได้.", "error");
                  }
                },
                error: function (data) {
                  swal("ผิดพลาด!", "ไม่สามารถบันทึกข้อมูลได้.", "error");
                }
              });
            } else {
              return true;
            }
          });
        return false;
      });

    });


    $(document).off('click', '.edit-vehicle_acc').on('click', '.edit-vehicle_acc', function () {
      $('#exampleModalLabel span').html("แก้ไขอุปกรณ์เสริม");
      var id_row = $(this).data("id");
      $.ajax({
        type: 'POST',
        url: "app/Views/vehicleconfig/vehicle_acc/f-ajax.php",
        data: {
          action: "edit",
          id_row: id_row
        },
        success: function (data) {
          // console.log(data);
          if (data) {
            var jsonParse = JSON.parse(data);
            $('#vehicle_acc').val(jsonParse.acc_name);
            $('#acc_remark').val(jsonParse.acc_remark);
            $('#id_vehicle_acc').val(jsonParse.id_acc);

            $('#exampleModalLabel span').html("แก้ไขอุปกรณ์เสริม: " + jsonParse.acc_name);
            if (jsonParse.acc_status == 1) {
              $('#status_use-vehicle_acc').prop('checked', true);
              $('#status_hold-vehicle_acc').prop('checked', false);
            } else {
              $('#status_use-vehicle_acc').prop('checked', false);
              $('#status_hold-vehicle_acc').prop('checked', true);
            }
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

    $(document).off('click', '.view-acc').on('click', '.view-acc', function () {
      $('#exampleModalLabel span').html("รายละเอียด");
      var id_row = $(this).data("id");
      $.ajax({
        type: 'POST',
        url: "app/Views/vehicleconfig/vehicle_acc/f-ajax.php",
        data: {
          action: "view",
          id_row: id_row
        },
        beforeSend: function (data) {
        },
        success: function (data) {
          // console.log(data);
          if (data) {
            var jsonParse = JSON.parse(data);
            // console.log(jsonParse);

            $('#acc_name_tb').text(jsonParse[0].acc_name);
            $('#remark_tb').text(jsonParse[0].acc_remark);

            $('#reg_date_tb').text(convertDateFormatView(jsonParse[0].acc_reg_date));
            $('#date_created_tb').text(convertDateFormatView(jsonParse[0].date_created));
            $('#date_edited_tb').text(convertDateFormatView(jsonParse[0].date_edited));
            

            $('#exampleModalView span').html(jsonParse[0].acc_name);
            if (jsonParse[0].acc_status == 1) {
              $('#acc_status_tb').html('<a class="text-success">กำลังใช้งาน</a>');
            } else {
              $('#acc_status_tb').html('<a class="text-danger">ระงับการใช้งาน</a>');
            }
          } else {
            swal("ผิดพลาด!", "ไม่พบข้อมูลที่ระบุ", "error");
          }
        },
        error: function (data) {
          swal("ผิดพลาด!", "ไม่พบข้อมูลที่ระบุ.", "error");
        }
      });
    });

</script>