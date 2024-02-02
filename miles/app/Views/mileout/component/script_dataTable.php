<script>
    $(document).ready(function () {
        
     $('#miles_table').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [6, 'asc'], //ถ้าโหลดครั้งแรกจะให้เรียงตามคอลัมน์ไหนก็ใส่เลขคอลัมน์ 0,'desc'
            "aoColumnDefs": [{
                    "bSortable": false,
                    "aTargets": [0]
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
                url: 'app/Views/mileout/functions/f-table.php',
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
            // "responsive": true,
        });

        $('#miles_table_length').append('<div class="col-10 d-inline"><span class="badge badge-warning mr-2" style="font-size:100%">ช่วงเช้า</span><span class="badge badge-success" style="font-size:100%">ช่วงบ่าย</span></div>');

    });
</script>