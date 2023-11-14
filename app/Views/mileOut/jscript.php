<script src="plugins/jquery/jquery.min.js"></script>

<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script> $.widget.bridge('uibutton', $.ui.button) </script>

<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>

<script src="dist/js/pcs_demo.js"></script>

<script src="dist/js/script.js"></script>

<script src="plugins/sweetalert/sweetalert.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>

<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script type="text/javascript">

    $(document).ready(function () {

        $('#dataTable').DataTable({
            "scrollX": true,
            "processing": true,
            "serverSide": true,
            "order": [0, 'desc'], //ถ้าโหลดครั้งแรกจะให้เรียงตามคอลัมน์ไหนก็ใส่เลขคอลัมน์ 0,'desc'
            "aoColumnDefs": [{
                    "bSortable": false,
                    "aTargets": [0]
                }, //คอลัมน์ที่จะไม่ให้ฟังก์ชั่นเรียง
                {
                    "bSearchable": false,
                    "aTargets": [0]
                } //คอลัมน์ที่จะไม่ให้เสริท
            ],
            ajax: {
                beforeSend: function () {
                    //จะให้ทำอะไรก่อนส่งค่าไปหรือไม่
                },
                url: 'app/Controllers/DataTableController.php',
                type: 'POST',
                data: function (data) {
                    data.action = "mileOut";
                },
                error: function (xhr, error, code) {
                    console.log(xhr, code);
                },
                async: false,
                cache: false,
            },
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "ทั้งหมด"]
            ],
            "paging": true,
            "lengthChange": true, //ออฟชั่นแสดงผลต่อหน้า
            "pagingType": "simple_numbers",
            "pageLength": 25,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            //"responsive": true,
        });
    });

</script>