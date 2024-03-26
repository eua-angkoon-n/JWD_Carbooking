<script>
    $(document).ready(function () {
     $('#reservation_table').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [1, 'asc'], //ถ้าโหลดครั้งแรกจะให้เรียงตามคอลัมน์ไหนก็ใส่เลขคอลัมน์ 0,'desc'
            "aoColumnDefs": [{
                    "bSortable": false,
                    "aTargets": [0, 5]
                }, //คอลัมน์ที่จะไม่ให้ฟังก์ชั่นเรียง
                {
                    "bSearchable": false,
                    "aTargets": [0]
                } //คอลัมน์ที่จะไม่ให้เสิร์ช
            ],
            ajax: {
                beforeSend: function () {
                    //จะให้ทำอะไรก่อนส่งค่าไปหรือไม่
                },
                url: 'app/Views/reservation/functions/f-table.php',
                type: 'POST',
                data: function (data) {
                    var formData = $('#needs-validation').serialize();
                    var radioValue = $('input[name="r1"]:checked').attr('id');
                    formData += '&radio_value=' + radioValue;
                    data.formData = formData;
                },
                async: false,
                cache: false,
                error: function (xhr, error, code) {
                    console.log(xhr, code);
                },
            },
            "paging": true,
            "lengthChange": false, //ออฟชั่นแสดงผลต่อหน้า
            "pagingType": "simple_numbers",
            "pageLength": 10,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "scrollX": true,
            // "responsive": true,
        });

        $('#viewReservation_table').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [1, 'asc'], //ถ้าโหลดครั้งแรกจะให้เรียงตามคอลัมน์ไหนก็ใส่เลขคอลัมน์ 0,'desc'
            "aoColumnDefs": [{
                    "bSortable": false,
                    "aTargets": [0,1]
                }, //คอลัมน์ที่จะไม่ให้ฟังก์ชั่นเรียง
                {
                    "bSearchable": false,
                    "aTargets": [0,1]
                } //คอลัมน์ที่จะไม่ให้เสิร์ช
            ],
            ajax: {
                beforeSend: function () {
                    //จะให้ทำอะไรก่อนส่งค่าไปหรือไม่
                },
                url: 'app/Views/reservation/functions/f-table.php',
                type: 'POST',
                data: function (data) {
                    var formData = $('#needs-validation').serialize();
                    var id_row = $('#viewid').val();
                    formData += '&id_row=' + id_row;
                    data.formData = formData;
                    data.action = 'viewReservation';
                },
                async: false,
                cache: false,
                error: function (xhr, error, code) {
                    console.log(xhr, code);
                },
            },
            "paging": true,
            "lengthChange": false, //ออฟชั่นแสดงผลต่อหน้า
            "pagingType": "simple_numbers",
            "pageLength": 10,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": false,
        });

    });
</script>