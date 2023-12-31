<style type="text/css">
    .table-view tr td{ line-height:auto; vertical-align:middle; padding:5px 5px; margin:0px;}
</style>

<div class="modal fade" id="modal-view" tabindex="-1" role="dialog" aria-labelledby="dataformLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="TitleModalView"><i class="fas fa-angle-double-right"></i> <span>ยานพาหนะ</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body p-0 py-2">

        <div class="container">
            <div class="row">           
            <div class="offset-md-0 col-md-12 offset-md-0">  
                <div class="card">  
                    <div class="card-header bg-primary text-white p-2"><p class="card-title text-size-1">ช่วงเวลาที่มีการจองแล้ว</p> <span class="float-right editby"></span></div>
                    <div class="card-body p-3"> 

                    <div class="text-center"> 
                        <img src="dist/img/SCGJWDLogo.png" class="w-50 p-2" id="img_tb" />
                    </div>
                    <table id="viewReservation_table"
                    class="table table-bordered table-hover dataTable dtr-inline table-responsive-xl">
                    <thead>
                      <tr class="bg-light text-center">
                        <!-- <th class="sorting_disabled" style="width:2%">No</th> -->
                        <th>ผู้จอง</th>
                        <th>ช่วงเวลา</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                    </div><!--card-body-->
                </div><!--card-->
            </div><!--offset-md-0-->

            </div><!--row-->
        </div><!--container-->

    </div><!--modal-body-->
    <div class="modal-footer justify-content-between text-right">
        <input type="button" class="btn btn-cancel btn-danger float-right" data-dismiss="modal" value="ปิด" />
    </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal-default -->

