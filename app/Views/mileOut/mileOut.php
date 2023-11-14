<section class="content">
    <div class="card">
        <div class="card-header">
            <h6 class="display-8 d-inline-block font-weight-bold"><i class="fas fa-chalkboard"></i>
                <?PHP echo $title; ?>
            </h6>
            <div class="card-tools">
                <ol class="breadcrumb float-sm-right pt-1 pb-1 m-0">
                    <li class="breadcrumb-item"><a href="./">Home</a></li>
                    <li class="breadcrumb-item active">
                        <?PHP echo $title; ?>
                    </li>
                </ol>
            </div>
        </div>

        <div class="card-body">
            <div class="row pt-3 p-2">
                <div class="col-sm-12 p-1 m-0">
                    <table id="dataTable"
                        class="table table-bordered table-hover dataTable dtr-inline display nowrap shadow-lg"
                        style="background-color:white">
                        <thead>
                            <tr class="bg-light">
                                <th scope="col" class="sorting_disabled">ลำดับ</th>
                                <th scope="col">วันที่</th>
                                <th scope="col">ยานพาหนะ</th>
                                <th scope="col">รูปภาพ</th>
                                <th scope="col">ผู้ร่วมเดินทาง</th>
                                <th scope="col">สถานะ</th>
                                <th scope="col">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div><!-- /.row -->
        </div>
    </div>
</section>

<?php include __DIR__ . "/jscript.php"; ?>