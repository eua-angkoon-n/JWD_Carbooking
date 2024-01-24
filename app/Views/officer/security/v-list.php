<?php
  include __DIR__ . '/v-modal.php'; //หน้า add/edit
?>

<div class="card-body p-3">
  <div class="row">
    <div class="col-sm-12 p-0 m-0">

      <!--<a id="some_button" class="btn btn-danger">refesh</a>-->

      <table id="security_table" class="table table-bordered table-hover dataTable dtr-inline table-responsive-xl">
        <thead>
          <tr class="bg-light">
            <th class="sorting_disabled" style="width:10%">No</th>
            <th>เจ้าหน้าที่รักษาความปลอดภัย</th>
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

    $('#security_table').DataTable({
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
        beforeSend: function () {},
        url: 'app/Views/officer/security/f-table.php',
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

      var table = $('#security_table').DataTable();

      $('#security_table_length').append('<div class="col-10 d-inline"><button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-security" id="addData" data-backdrop="static" data-keyboard="false"><i class="fas fa-plus-circle"></i> เพิ่มเจ้าหน้าที่</button></div>');
      $('input[type=search]').attr('placeholder', 'เจ้าหน้าที่รักษาความปลอดภัย');

      $(document).off('click', '#addData').on('click', '#addData', function () {
        $("#id_security").val('');
        $('#exampleModalLabel span').html("เพิ่มเจ้าหน้าที่รักษาความปลอดภัย");
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
                url: "app/Views/officer/security/f-ajax.php",
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


    $(document).off('click', '.edit-security').on('click', '.edit-security', function () {
      $('#exampleModalLabel span').html("แก้ไขเจ้าหน้าที่รักษาความปลอดภัย");
      var id_row = $(this).data("id");
      $.ajax({
        type: 'POST',
        url: "app/Views/officer/security/f-ajax.php",
        data: {
          action: "edit",
          id_row: id_row
        },
        success: function (data) {
          // console.log(data);
          if (data) {
            var jsonParse = JSON.parse(data);
            $('#security').val(jsonParse.security_name);
            $('#id_security').val(jsonParse.id_security);

            $('#exampleModalLabel span').html("แก้ไขข้อมูลเจ้าหน้าที่: " + jsonParse.security_name);
            if (jsonParse.security_status == 1) {
              $('#status_use-security').prop('checked', true);
              $('#status_hold-security').prop('checked', false);
            } else {
              $('#status_use-security').prop('checked', false);
              $('#status_hold-security').prop('checked', true);
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