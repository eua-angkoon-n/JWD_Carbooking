<script>
    $(document).ready(function () {
        
     $('#reservation_table').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [8, 'desc'], //ถ้าโหลดครั้งแรกจะให้เรียงตามคอลัมน์ไหนก็ใส่เลขคอลัมน์ 0,'desc'
            "aoColumnDefs": [{
                    "bSortable": false,
                    "aTargets": [0, 1, 5, 6, 7, 9, 11]
                }, //คอลัมน์ที่จะไม่ให้ฟังก์ชั่นเรียง
                {
                    "bSearchable": false,
                    "aTargets": [0, 1, 5, 6, 7, 9, 10, 11]
                } //คอลัมน์ที่จะไม่ให้เสิร์ช
            ],
            ajax: {
                beforeSend: function () {
                    //จะให้ทำอะไรก่อนส่งค่าไปหรือไม่
                },
                url: 'app/Views/reservationSum/functions/f-table.php',
                type: 'POST',
                data: function (data) {
                    data.formData = $('#ListForm').serialize();
                    data.action = 'list';
                },
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
            "scrollX": true,
            "buttons": [
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: ':not(:eq(1))' // ไม่รวม Column แรก
                    }
                },'colvis'
        
            ]
            // "responsive": true,
        }).buttons().container().appendTo('#reservation_table_wrapper .col-md-6:eq(0)');

    });
</script>