<section class="content">
    <div class="card">
        <div class="card-header">
            <h6 class="display-8 d-inline-block font-weight-bold"><i class="fas fa-chalkboard"></i>
                <?PHP echo PageSetting::$AppPage[$prefix]['title']; ?>
            </h6>
            <!-- <div class="card-tools">
                <ol class="breadcrumb float-sm-right pt-1 pb-1 m-0">
                    <li class="breadcrumb-item"><a href="./">Home</a></li>
                    <li class="breadcrumb-item active">
                        <?PHP echo PageSetting::$AppPage[$prefix]['title']; ?>
                    </li>
                </ol>
            </div> -->
        </div>

        <div class="card-body">
           
        <table class="table table-striped table-hover">
                  <thead>
                    <tr class="table-secondary">
                      <th class="text-center"><h3><strong>รายการ</strong></h3></th>
                      <th class="text-center"><h3><strong>จำนวน</strong></h3></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                        <td class="text-center p-0"><a href="?<?php echo PageSetting::$prefixController?>=mileIn" type="button" class="btn btn-block btn-light btn-lg" style="border-radius:0;">บันทึกเลขไมล์ขาออก</a></td>
                        <td class="text-center p-0"><a href="?<?php echo PageSetting::$prefixController?>=mileIn" type="button" class="btn btn-block btn-success btn-lg" style="border-radius:0;">11</a></td>
                    </tr>
                    <tr>
                        <td class="text-center p-0"><a href="?<?php echo PageSetting::$prefixController?>=mileOut" type="button" class="btn btn-block btn-light btn-lg" style="border-radius:0;">บันทึกเลขไมล์ขาเข้า</a></td>
                        <td class="text-center p-0"><a href="?<?php echo PageSetting::$prefixController?>=mileOut" type="button" class="btn btn-block btn-success btn-lg" style="border-radius:0;">12</a></td>
                    </tr>

                  </tbody>
                  <tfoot>
                  <tr>
                      <td class="bg-success"></td>
                      <td class="text-center bg-warning"><h3><strong>รวม 11</h3></strong></td>
                    </tr>
                  </tfoot>
                </table>

        </div>
    </div>
</section>