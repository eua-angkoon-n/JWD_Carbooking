<div class="row">
  <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12">
    <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-clock"></i>
          เลือกช่วงเวลาที่ต้องการจอง
        </h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">

        <form id="needs-validation" class="addform" name="addform" method="POST" enctype="multipart/form-data"
          autocomplete="off" novalidate="">
          <!-- <div class="row"> -->

          <div class="row">
            <div class="col-sm-12 col-md-12 col-xs-12">
              <div class="form-group">
                <label for="date_select">จากวันที่:</label>
                <!-- <div class="input-group"> -->
                <!-- <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                          </span>
                        </div>
                        <div id="ElSelect"></div> -->
                <input type="hidden" class="form-control float-right" id="date_start" name="date_start">
                <!-- </div> -->
              </div>
            </div>
          </div>

          <!-- <div class="row">
                  <div class="col-sm-12 col-md-12 col-xs-12">
                    <div class="form-group">
                      <label for="date_select">วันที่:</label>
                      <div class="input-group" id="ElSelect">
                        <p id="result-13">&nbsp;</p>
                        <input class="form-control float-right" type="text" class="form-control float-right" id="date_select" name="date_select"/>
                      </div>
                    </div>
                  </div>
                </div> -->

          <!-- <div class="row">
                  <div class="col-sm-6 col-md-6 col-xs-6">
                    <div class="form-group">
                      <label for="time_start">เวลา:</label>
                      <div class="input-group date"  data-target-input="nearest">
                        <div class="input-group-append" data-target="#time_start" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="far fa-clock"></i></div>
                        </div>
                        <input type="text" class="form-control datetimepicker-input" id="time_start" name="time_start" data-target="#time_start" />
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-md-6 col-xs-6">
                    <div class="form-group">
                      <label for="time_end">ถึง</label>
                      <div class="input-group date"  data-target-input="nearest">
                        <div class="input-group-append" data-target="#time_end" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="far fa-clock"></i></div>
                        </div>
                        <input type="text" class="form-control datetimepicker-input" id="time_end" name="time_end" data-target="#time_end" />
                      </div>
                    </div>
                  </div>
                </div> -->

          <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
              <div class="form-group">
                <label for="time_start">เวลา:</label>
                <div class="input-group date" data-target-input="nearest">
                  <div class="input-group-append" data-target="#time_start" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                  </div>
                  <input type="text" class="form-control datetimepicker-input" id="time_start" name="time_start"
                    data-target="#time_start" data-toggle="datetimepicker" />
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12 col-md-12 col-xs-12">
              <div class="form-group">
                <label for="date_selects">ถึงวันที่:</label>
                <input type="hidden" class="form-control float-right" id="date_end" name="date_end">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12 col-md-12 col-xs-12">
              <div class="form-group">
                <label for="time_end">เวลา:</label>
                <div class="input-group date" data-target-input="nearest">
                  <div class="input-group-append" data-target="#time_end" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                  </div>
                  <input type="text" class="form-control datetimepicker-input" id="time_end" name="time_end"
                    data-target="#time_end" data-toggle="datetimepicker" />
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12 col-md-12 col-xs-12 text-center">
              <button type="button" class="btn btn-primary btn-search col-sm-6 col-md-6 col-xs-6">ค้นหา</button>

            </div>
          </div>

          <!-- </div> -->
          <!--row-->
        </form>

      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->

  <div class="col-xl-9 col-lg-8 col-md-8 col-sm-12">
    <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-car"></i>
          เลือกยานพาหนะที่ต้องการจอง
        </h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group clearfix">
              <div class="icheck-success d-inline mr-1">
                <input type="radio" id="rFree" name="r1" checked>
                <label for="rFree">
                  เฉพาะที่ว่าง
                </label>
              </div>
              <div class="icheck-danger d-inline mr-1">
                <input type="radio" id="rNotFree" name="r1">
                <label for="rNotFree">
                  ไม่ว่าง
                </label>
              </div>
              <div class="icheck-primary d-inline">
                <input type="radio" id="rAll" name="r1">
                <label for="rAll">
                  แสดงทั้งหมด
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12 p-0 m-0">

            <table id="reservation_table" class="table table-bordered table-hover dataTable dtr-inline nowrap">
              <thead>
                <tr class="bg-light text-center">
                  <!-- <th class="sorting_disabled" style="width:2%">No</th> -->
                  <th scope="col" style="width:5%"></th>
                  <th scope="col" style="width:5%">ยานพาหนะ</th>
                  <th scope="col" style="width:5%">ประเภทยานพาหนะ</th>
                  <th scope="col" style="width:1%">ที่นั่ง</th>
                  <th scope="col" style="width:2%">สถานะ</th>
                  <th scope="col" style="width:5%"></th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>

          </div>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
<input type="hidden" id="viewid" name="viewid" value=''/>